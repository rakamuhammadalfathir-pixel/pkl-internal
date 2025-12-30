<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function dashboard()
{ 
    // 1. Ambil Statistik
    $stats = [
        'users'          => User::count(),
        'total_products' => Product::count(), // Diubah dari 'products' agar sesuai Blade
        'categories'     => Category::count(),
        'total_orders'   => Order::count(),
        'total_revenue'  => Order::whereIn('status', ['processing', 'completed', 'shipped'])->sum('total_amount'),
        'pending_orders' => Order::where('status', 'pending')->count(),
        'low_stock'      => Product::where('stock', '<', 5)->count(),
    ];

    // 2. Ambil Data Penjualan 7 Hari Terakhir (Untuk Chart.js)
    $revenueChart = Order::whereIn('status', ['processing', 'completed', 'shipped'])
        ->where('created_at', '>=', now()->subDays(7))
        ->select(
            \DB::raw('DATE(created_at) as date'),
            \DB::raw('SUM(total_amount) as total')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // 3. Ambil 5 order terbaru dengan data user (Eager Loading)
    $recentOrders = Order::with('user')->latest()->take(5)->get();

    // 4. Ambil Produk Terlaris (Untuk section bawah)
    // Asumsi ada kolom 'sold' atau relasi orderItems
    $topProducts = Product::latest()->take(5)->get();

    return view('admin.dashboard', compact('stats', 'recentOrders', 'revenueChart', 'topProducts'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
