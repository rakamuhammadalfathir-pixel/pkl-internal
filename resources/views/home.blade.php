@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* 1. Animasi Floating untuk Gambar Hero */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }

    /* Hero Section Styling */
    .hero-gradient {
        background: linear-gradient(135deg, #0052D4 0%, #4364F7 50%, #6FB1FC 100%); /* Gradasi Biru yang lebih dalam */
        min-height: 600px;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-gradient::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png'); /* Pola Karbon Fiber */
        opacity: 0.1;
        z-index: 0;
    }

    .hero-gradient .container {
        position: relative;
        z-index: 1; /* Pastikan konten di atas overlay */
    }

    .floating-img {
        animation: float 6s ease-in-out infinite; /* Lebih lambat agar lebih elegan */
    }
    
    .fw-black {
        font-weight: 900 !important;
    }

    /* Efek bayangan teks agar lebih dramatis */
    .hero-gradient h1 {
        text-shadow: 2px 4px 10px rgba(0,0,0,0.2);
    }

    .image-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .image-wrapper .circle-bg {
        width: 500px; 
        height: 500px; 
        background-color: rgba(255, 255, 255, 0.1); /* Lingkaran putih transparan */
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 0 50px rgba(255,255,255,0.2);
    }

    .image-wrapper .floating-img {
        position: relative;
        z-index: 2; /* Pastikan gambar atlet di atas lingkaran */
        border-radius: 20px;
    }


    /* 2. Efek Hover Card yang Lebih Halus */
    .category-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border-radius: 15px;
        background-color: #fff; /* Pastikan background putih */
    }

    .category-card:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 30px rgba(13, 110, 253, 0.15) !important;
    }

    .promo-card {
        transition: all 0.3s ease;
        border-radius: 20px;
        overflow: hidden;
    }

    .promo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1); /* Tambah shadow pada hover */
    }

    /* 3. Button Shine Effect */
    .btn-shine {
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-shine::after {
        content: "";
        position: absolute;
        top: -50%;
        left: -60%;
        width: 20%;
        height: 200%;
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(30deg);
        transition: all 0.5s;
        z-index: -1;
    }

    .btn-shine:hover::after {
        left: 120%;
    }

    .section-title {
        position: relative;
        padding-bottom: 10px; /* Ruang untuk underline */
    }

    .section-title::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background-color: #ffc107; /* Warna kuning dari badge */
        border-radius: 2px;
    }

    /* Styling untuk Product Card agar konsisten */
    .product-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .product-card .card-img-top {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .product-card .card-body {
        padding: 1rem;
    }
    .product-card .product-title {
        font-weight: 600;
        color: #333;
        font-size: 1.1rem;
        min-height: 50px; /* Agar tinggi card konsisten */
    }
    .product-card .product-price {
        font-weight: 700;
        color: #0d6efd; /* Warna biru utama */
        font-size: 1.2rem;
    }
    .product-card .btn-add-to-cart {
        border-radius: 10px;
        font-weight: 600;
    }
</style>

    {{-- Hero Section --}}
    <section class="hero-gradient text-white py-5 mb-5">
        {{-- Pola Carbon Fibre --}}
        {{-- <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" 
             style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div> --}}
             
        <div class="container py-lg-5 position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 fw-bold text-uppercase shadow-sm">
                        <i class="bi bi-lightning-fill me-1"></i> Sport SMK Juara
                    </span>
                    <h1 class="display-3 fw-black mb-3 text-uppercase" style="font-style: italic; letter-spacing: -2px; line-height: 0.9;">
                        Tingkatkan <br><span class="text-warning">Performa</span> SMK <br>Tanpa Batas
                    </h1>
                    <p class="lead mb-4 opacity-75 fw-medium">
                        Koleksi Jersey Authentic dan Pakaian Olahraga SMK Teknologi Dry-Fit terbaru. 
                        Ringan, menyerap keringat, dan didesain untuk para juara.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('catalog.index') }}" class="btn btn-light btn-lg rounded-pill fw-bold shadow-lg btn-shine px-4">
                            <i class="bi bi-cart-plus me-2"></i>Mulai Belanja
                        </a>
                        <a href="#kategori" class="btn btn-outline-light btn-lg rounded-pill fw-bold px-4">
                            Lihat Katalog
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-6 d-none d-lg-block text-center position-relative" data-aos="fade-left" data-aos-duration="1200">
                    <div class="image-wrapper">
                        <div class="circle-bg"></div>
                        
                        {{-- Ganti URL gambar dengan gambar atlet pilihan Anda --}}
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop" 
                             alt="Sport SMK" 
                             class="img-fluid floating-img" 
                             style="max-height: 550px; filter: drop-shadow(0 30px 50px rgba(0,0,0,0.5));">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Kategori --}}
    <section class="py-5" id="kategori">
        <div class="container">
            <h2 class="fw-bold section-title mb-2 position-relative" data-aos="fade-up">PILIH CABANG OLAHRAGA</h2>
            <p class="lead text-muted mb-4" data-aos="fade-up" data-aos-delay="100">Temukan perlengkapan yang sesuai dengan passion Anda.</p>
            <div class="row g-4 justify-content-center mt-4">
                @foreach($categories as $category)
                    <div class="col-6 col-md-4 col-lg-2" data-aos="zoom-in" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm text-center h-100 category-card">
                                <div class="card-body">
                                    <div class="bg-light rounded-circle d-inline-block p-2 mb-3">
                                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="rounded-circle" width="80" height="80" style="object-fit: cover;">
                                    </div>
                                    <h6 class="card-title mb-1 text-dark fw-bold">{{ $category->name }}</h6>
                                    <small class="text-primary fw-semibold">{{ $category->products_count }} Produk</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Promo Banner --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6" data-aos="flip-up" data-aos-duration="800">
                    <div class="card bg-warning text-dark border-0 promo-card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="fw-bold">Flash Sale SMK!</h3>
                            <p>Dapatkan diskon khusus pelajar SMK hingga 50%.</p>
                            <a href="#" class="btn btn-dark rounded-pill fw-bold">Ambil Promo</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" data-aos="flip-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="card bg-info text-white border-0 promo-card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="fw-bold">Gratis Ongkir</h3>
                            <p>Khusus pengiriman ke sekolah SMK seluruh Indonesia.</p>
                            <a href="#" class="btn btn-light rounded-pill fw-bold text-info">Cek Syarat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Produk Unggulan --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-right">
                <h2 class="fw-bold section-title mb-0 position-relative pb-3">Rekomendasi Terbaik</h2>
                <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary rounded-pill fw-bold">Lihat Semua <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
            <div class="row g-4" data-aos="fade-up">
                @foreach($featuredProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        {{-- Pastikan ada file partial 'profile.partials.product-card' atau sesuaikan isinya di sini --}}
                        <div class="card product-card h-100">
                            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/200' }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title product-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted mb-2"><small>{{ $product->category->name ?? 'Uncategorized' }}</small></p>
                                <h4 class="product-price mb-3">Rp{{ number_format($product->price, 0, ',', '.') }}</h4>
                                <div class="mt-auto">
                                    <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-primary btn-sm w-100 btn-add-to-cart">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true, // Animasi hanya berjalan sekali saat di-scroll
        offset: 100,
        duration: 800, // Durasi default untuk semua animasi
        easing: 'ease-in-out' // Jenis easing default
    });
</script>
@endsection