<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $products = auth()->user()->wishlists()
            ->with(['category', 'primaryImage']) // Eager load
            ->latest('wishlists.created_at') // Urutkan dari yang baru di-wishlist
            ->paginate(12);

        return view('wishlist.index', compact('products'));
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

    public function toggle(Product $product)
    {
        $user = auth()->user();

        // 1. Cek apakah produk ini ada di daftar wishlist user?
        if ($user->hasInWishlist($product)) {
            // Skenario: User mau UNLIKE
            // detach() menghapus record di tabel pivot (wishlists)
            // berdasarkan user_id dan product_id.
            $user->wishlists()->detach($product->id);

            $added = false; // Indikator untuk frontend: "Hapus warna merah"
            $message = 'Produk dihapus dari wishlist.';
        } else {
            // Skenario: User mau LIKE
            // attach() menambahkan record baru di tabel pivot.
            // Tidak perlu set user_id manual, Laravel otomatis tahu dari $user->wishlists()
            $user->wishlists()->attach($product->id);

            $added = true; // Indikator untuk frontend: "Ubah jadi merah"
            $message = 'Produk ditambahkan ke wishlist!';
        }

        // Return JSON response yang ringan untuk JavaScript
        // Kita kirim status "added" agar JS tahu harus ganti ikon love jadi merah atau abu-abu.
        return response()->json([
            'status' => 'success',
            'added' => $added,
            'message' => $message,
            'count' => $user->wishlists()->count() // Kirim jumlah terbaru untuk update badge header
        ]);
    }
}
