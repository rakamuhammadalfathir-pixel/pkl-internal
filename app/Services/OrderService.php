<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrder(User $user, array $shippingData): Order
    {
        $cart = $user->cart()->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            throw new \Exception('Keranjang belanja kosong.');
        }

        return DB::transaction(function () use ($user, $cart, $shippingData) {

            // ==================== 1. VALIDASI & HITUNG ====================
            $subtotalProduk = 0;
            $totalWeight    = 0;

            foreach ($cart->items as $item) {
                $product = $item->product;

                if (! $product) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                if ($item->quantity > $product->stock) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi.");
                }

                // Harga final (diskon kepake)
                $subtotalProduk += $product->display_price * $item->quantity;

                // Berat aman walau null
                $weight = $product->weight ?? 0;
                $totalWeight += $weight * $item->quantity;
            }

            // ==================== 2. HITUNG ONGKIR ====================
            if ($totalWeight <= 1000) {
                $shippingCost = 15000;
            } else {
                $extraKg = ceil(($totalWeight - 1000) / 1000);
                $shippingCost = 15000 + ($extraKg * 5000);
            }

            // ==================== 3. TOTAL FINAL ====================
            $totalAmount = $subtotalProduk + $shippingCost;

            // ==================== 4. BUAT ORDER ====================
            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => 'ORD-' . strtoupper(Str::random(10)),
                'status'           => 'pending',
                'payment_status'   => 'unpaid',

                'subtotal'         => $subtotalProduk,
                'shipping_cost'    => $shippingCost,
                'total_amount'     => $totalAmount,

                'shipping_name'    => $shippingData['name'],
                'shipping_address' => $shippingData['address'],
                'shipping_phone'   => $shippingData['phone'],
            ]);

            // ==================== 5. PINDAHKAN ITEMS ====================
            foreach ($cart->items as $item) {
                $product = $item->product;

                $order->items()->create([
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'price'        => $product->display_price,
                    'quantity'     => $item->quantity,
                    'subtotal'     => $product->display_price * $item->quantity,
                ]);

                // Kurangi stok (atomic)
                $product->decrement('stock', $item->quantity);
            }

            // ==================== 6. MIDTRANS SNAP ====================
            try {
                $order->load('user');

                $midtransService = new \App\Services\MidtransService();
                $snapToken = $midtransService->createSnapToken($order);

                $order->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                // Snap gagal = order tetap valid
            }

            // ==================== 7. BERSIHKAN KERANJANG ====================
            $cart->items()->delete();

            return $order;
        });
    }
}
