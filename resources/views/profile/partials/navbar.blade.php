{{-- FILE: resources/views/partials/navbar.blade.php --}}

<style>
    /* Custom CSS Khusus Navbar */
    .custom-nav {
        transition: all 0.3s ease;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    
    /* Membuat Search Bar Oval & Seamless */
    .search-wrapper {
        background-color: #f1f3f5;
        border-radius: 50px;
        padding: 2px 15px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .search-wrapper:focus-within {
        background-color: #fff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25 text-primary;
    }

    .search-wrapper input {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    /* Efek Hover Link Ikon */
    .nav-icon-link {
        color: #495057;
        padding: 8px 12px !important;
        border-radius: 10px;
        transition: all 0.2s;
    }

    .nav-icon-link:hover {
        color: #0d6efd;
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }

    /* Profil User ala Aplikasi Modern */
    .user-profile-pill {
        background: #f8f9fa;
        border-radius: 50px;
        padding: 4px 12px 4px 4px !important;
        border: 1px solid #eee;
    }

    .user-profile-pill:hover {
        background: #e9ecef;
    }

    /* Badge Notifikasi */
    .badge-notif {
        font-size: 0.65rem;
        padding: 0.35em 0.5em;
        border: 2px solid #fff;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top custom-nav">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('home') }}">
            <i class="bi bi-lightning-charge-fill me-1"></i>Jeyt<span class="text-dark">Sport</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Search Bar Tengah --}}
            <form class="d-flex mx-lg-auto my-3 my-lg-0 w-100 justify-content-center" style="max-width: 500px;" action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group search-wrapper">
                    <input type="text" name="q" class="form-control" placeholder="Cari produk olahraga..." value="{{ request('q') }}">
                    <button class="btn text-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link fw-medium px-3" href="{{ route('catalog.index') }}">Katalog</a>
                </li>

                @auth
                    {{-- Wishlist --}}
                    <li class="nav-item">
                        <a class="nav-link nav-icon-link position-relative" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart fs-5"></i>
                            @php $wCount = auth()->user()->wishlists()->count(); @endphp
                            @if($wCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger badge-notif">
                                    {{ $wCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Cart --}}
                    <li class="nav-item me-2">
                        <a class="nav-link nav-icon-link position-relative" href="{{ route('cart.index') }}">
                            <i class="bi bi-bag fs-5"></i>
                            @php $cartCount = auth()->user()->cart?->items()->count() ?? 0; @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary badge-notif">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- User Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-profile-pill d-flex align-items-center" href="#" id="userDropdown" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle me-2" width="30" height="30" style="object-fit: cover;">
                            <span class="d-none d-lg-inline small fw-bold text-dark">{{ explode(' ', auth()->user()->name)[0] }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}"><i class="bi bi-box-seam me-2"></i>Pesanan</a></li>
                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-primary" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                    <li class="nav-item"><a class="btn btn-primary btn-sm px-4 rounded-pill ms-lg-2" href="{{ route('register') }}">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>