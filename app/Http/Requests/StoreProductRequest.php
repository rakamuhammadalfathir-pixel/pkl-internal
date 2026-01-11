<?php
// app/Http/Requests/StoreProductRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        // Hanya user dengan role 'admin' yang boleh menambah produk.
        // auth()->check() memastikan user sudah login.
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Aturan validasi untuk data yang dikirim.
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            
            // UBAH: dari 'nullable' menjadi 'required' agar deskripsi wajib diisi
            'description' => ['required', 'string'], 

            // TAMBAH: Validasi untuk Berat (dalam gram)
            'weight' => ['required', 'numeric', 'min:1'], 

            'price' => ['required', 'numeric', 'min:1'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],

            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => [
                'image',
                'mimes:jpg,png,webp',
                'max:2048'
            ],
        ];
    }

    /**
     * Persiapkan data sebelum validasi dijalankan.
     * Berguna untuk normalisasi data.
     */
    protected function prepareForValidation(): void
    {
        // Checkbox di HTML kadang tidak mengirim value jika tidak dicentang (atau kirim string "on").
        // Kita paksa konversi jadi boolean true/false agar database menerima nilai yang benar (1/0).
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}