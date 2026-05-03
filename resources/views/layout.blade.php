<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '7ETTA - T4LIFE')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @vite('resources/css/layout.css')
    @stack('styles')
</head>

<body>

    <div class="top-bar">
        Livraison gratuite pour les commandes de 50 € et plus
    </div>

    <header>
        <div class="container">
            <div class="d-flex align-items-center justify-content-between position-relative">

                <div>
                    <button class="nav-icon-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                        <i class="bi bi-list fs-3"></i>
                    </button>
                </div>

                <div class="position-absolute start-50 translate-middle-x">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="logo" style="height:100px;">
                    </a>
                </div>

                <div class="icon-group">
                    <button class="nav-icon-btn d-none d-md-block" id="searchToggle">
                        <i class="bi bi-search fs-5"></i>
                    </button>

                    @auth
                        {{-- Admin Store Manager Button --}}
                        @if((isset(Auth::user()->user_role) && Auth::user()->user_role === 'Admin') || (isset(Auth::user()->role) && Auth::user()->role === 'admin') || (isset(Auth::user()->is_admin) && Auth::user()->is_admin) || Auth::user()->email === 'admin@admin.com')
                            <a href="{{ url('/admin/dashboard') }}" class="nav-icon-btn custom-tooltip d-none d-md-block" data-tooltip="Store Manager">
                                <i class="bi bi-shop fs-5"></i>
                            </a>
                        @endif

                        <div class="dropdown d-none d-md-block">
                            <button class="nav-icon-btn dropdown-toggle d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: none; border: none; color: #fff;">
                                <i class="bi bi-person fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end mt-2">
                                <li>
                                    <div class="px-3 py-2">
                                        <span class="d-block fw-bold text-dark" style="font-size: 14px;">{{ Auth::user()->name ?? 'User' }}</span>
                                        <span class="text-muted small">{{ Auth::user()->email ?? '' }}</span>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="bi bi-person me-2"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="{{ url('/orders') }}"><i class="bi bi-box-seam me-2"></i> My Orders</a></li>
                                
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') ?? url('/logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ url('/login') }}" class="nav-icon-btn custom-tooltip d-none d-md-block" data-tooltip="Sign In">
                            <i class="bi bi-person fs-5"></i>
                        </a>
                    @endauth

                    <a href="#" class="nav-icon-btn custom-tooltip" data-tooltip="Favorites">
                        <i class="bi bi-heart fs-5"></i>
                    </a>

                    <a href="#" class="nav-icon-btn custom-tooltip" data-tooltip="Cart">
                        <i class="bi bi-cart3 fs-5"></i>
                    </a>

                </div>

            </div>
        </div>
    </header>

    <div class="search-container" id="searchBar">
        <div class="container">
            <div class="search-box">
                <select class="search-category">
                    <option>Toutes les Collections</option>
                    <option>Caps</option>
                    <option>T-shirts</option>
                    <option>Hoodies</option>
                    <option>Pants</option>
                    <option>Shoes</option>
                </select>
                <input type="text" class="search-input" placeholder="Search for a product">
                <button class="search-submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu  -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu">
        <div class="offcanvas-header">
            <div class="sidebar-logo">7ETTA</div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="sidebar-search">
            <div class="search-wrapper">
                <input type="text" placeholder="Rechercher un produit">
                <i class="bi bi-search"></i>
            </div>
        </div>

        <div class="offcanvas-body p-0">
            <nav class="menu-list">
                <a href="/">HOME <i class="bi bi-chevron-right chevron"></i></a>
                <a href="/caps">Caps <i class="bi bi-chevron-right chevron"></i></a>
                <a href="/t-shirts">T-shirts <i class="bi bi-chevron-right chevron"></i></a>
                <a href="/hoodies">Hoodies <i class="bi bi-chevron-right chevron"></i></a>
                <a href="/pants">Pants <i class="bi bi-chevron-right chevron"></i></a>
                <a href="/shoes">Shoes <i class="bi bi-chevron-right chevron"></i></a>
            </nav>
        </div>


    </div>


    <main>
        @yield('content')
    </main>

    <footer>
        
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 mb-4">
                        <div class="">
                    <a href="/">
                        <img src="{{ asset('images/7etta.png') }}" alt="logo" style="height:100px;">
                    </a>
                </div>
                        <p>7etta is your go-to destination for premium T-shirts combining comfort quality and modern
                            style</p>
                        <div class="social-icons">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 text-center mb-4">
                        <h5 class="information-title">Information</h5>
                        <ul class="information list-unstyled">
                            <li><a href="{{ url('/contact') }}">Contact</a></li>
                            <li><a href="{{ url('/about-us') }}">About Us</a></li>
                            <li><a href="{{ url('/FAQ') }}">FAQ</a></li>
                            <li><a href="{{ url('/retour') }}">PORTAIL DE RETOUR ET D'ECHANGE</a></li>
                            <li><a href="{{ url('/politique') }}">POLITIQUE DE CONFIDENTIALITE</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 text-center">
                        <h5 class="contact-title">Contact Us</h5>
                        <p>Have a question or need help? Our team is here for you</p>
                        <a href="mailto:contact@T4life.co" class="contact-btn">
                            <i class="bi bi-envelope"></i> 7etta.com
                        </a>
                    </div>

                </div>
            </div>

            <div class="copyright">
                © 2026 7etta. All rights reserved.
            </div>
    </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
    let btn = document.getElementById("searchToggle");
    let bar = document.getElementById("searchBar");

    if (btn && bar) {
        btn.addEventListener("click", function () {
            bar.style.display = (bar.style.display === "block") ? "none" : "block";
        });
    }
});
        </script>

    @stack('scripts')

</body>

</html>
