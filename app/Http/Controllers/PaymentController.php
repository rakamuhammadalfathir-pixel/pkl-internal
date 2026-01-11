<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Mengambil Snap Token untuk order ini (API Endpoint).
     * Dipanggil via AJAX dari frontend saat user klik "Bayar".
     */
    public function getSnapToken(Order $order, MidtransService $midtransService)
    {
        // 1. Authorization: Pastikan user adalah pemilik order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // 2. Cek apakah order sudah dibayar
        if ($order->payment_status === 'paid') {
            return response()->json(['error' => 'Pesanan sudah dibayar.'], 400);
        }

        try {
            // 3. Generate Snap Token dari Midtrans
            $snapToken = $midtransService->createSnapToken($order);

            // 4. Simpan token ke database untuk referensi
            $order->update(['snap_token' => $snapToken]);

            // 5. Kirim token ke frontend
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleNotification(Request $request)
{
    $payload = $request->all();
    $orderId = $payload['order_id']; // Ini berisi "ORD-JROI9JNTHE" dari Midtrans
    $statusCode = $payload['status_code'];
    $transactionStatus = $payload['transaction_status'];
    $signatureKey = $payload['signature_key'];

    // 1. Validasi Signature Key
    // Pastikan config path sesuai (config/services.php atau config/midtrans.php)
    $serverKey = config('services.midtrans.server_key') ?? config('midtrans.server_key'); 
    $validSignatureKey = hash("sha512", $orderId . $statusCode . $payload['gross_amount'] . $serverKey);

    if ($signatureKey !== $validSignatureKey) {
        return response()->json(['message' => 'Invalid Signature'], 403);
    }

    // 2. Cari order menggunakan 'order_number' (SESUAI DATABASE KAMU)
    $order = Order::where('order_number', $orderId)->first();

    if (!$order) {
        return response()->json(['message' => 'Order ' . $orderId . ' not found'], 404);
    }

    // 3. Logika Perubahan Status
    if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing' // Mengubah status order juga
        ]);
    } elseif ($transactionStatus == 'pending') {
        $order->update(['payment_status' => 'unpaid']);
    } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
        $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
    }

    return response()->json(['message' => 'OK']);
}

public function callback(Request $request)
{
    $serverKey = config('midtrans.server_key');
    $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

    if ($hashed == $request->signature_key) {
        if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
            // UPDATE DATABASE ANDA DI SINI
            $order = Order::where('reference', $request->order_id)->first();
            $order->update(['payment_status' => 'paid']);
        }
    }
}
}