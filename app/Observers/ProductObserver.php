<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        // Clear cache
        Cache::forget('featured_products');
        Cache::forget('category_' . $product->category_id . '_products');

        // ⛔ Jangan log activity saat seeding / artisan
        if (app()->runningInConsole() || ! function_exists('activity') || ! auth()->check()) {
            return;
        }

        activity()
            ->performedOn($product)
            ->causedBy(auth()->user())
            ->log('Produk baru dibuat: ' . $product->name);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        Cache::forget('product_' . $product->id);
        Cache::forget('featured_products');

        if ($product->isDirty('category_id')) {
            Cache::forget('category_' . $product->getOriginal('category_id') . '_products');
            Cache::forget('category_' . $product->category_id . '_products');
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        Cache::forget('product_' . $product->id);
        Cache::forget('featured_products');
        Cache::forget('category_' . $product->category_id . '_products');
    }
}
