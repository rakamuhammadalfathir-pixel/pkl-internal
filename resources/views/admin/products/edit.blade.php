@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary fw-bold">Edit Produk: {{ $product->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Berat (gram)</label>
                        <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" 
                            value="{{ old('weight', $product->weight) }}">
                        @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Produk</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                rows="4">{{ old('description', $product->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Produk (Kosongkan jika tidak diubah)</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($product->image) }}" width="100" class="img-thumbnail">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                            <label class="form-check-label">Produk Aktif</label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 