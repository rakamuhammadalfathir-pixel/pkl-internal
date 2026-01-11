{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{-- Flash Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold">Daftar Produk</h5>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Baru
            </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Produk</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Berat</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Stok</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($product->primaryImage)
                                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                                    alt="{{ $product->name }}" 
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" 
                                                    alt="No Image" 
                                                    style="width: 50px; height: 50px;">
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $product->name }}</div>
                                                <small class="text-muted">{{ $product->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark">{{ $product->category->name }}</span>
                                    </td>

                                    {{-- TAMBAHKAN DATA BERAT --}}
                                    <td class="text-center">
                                        <span class="text-muted small">{{ number_format($product->weight, 0, ',', '.') }} g</span>
                                    </td>

                                    <td class="text-center">
                                        @if($product->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $product->stock < 10 ? 'bg-danger' : 'bg-primary' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin hapus Produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>    
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>


@endsection