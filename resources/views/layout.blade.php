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

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .top-bar {
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 12px;
            padding: 8px 0;
            text-align: center;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        header {
            background-color: #000;
            color: #fff;
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        header img {
            object-fit: contain;
        }

        .nav-icon-btn {
            color: #fff;
            background: transparent;
            border: none;
            padding: 8px;
            transition: all 0.2s;
            border-radius: 4px;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .nav-icon-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .nav-icon-btn:active {
            background-color: #e9ecef;
            color: #000;
        }

        .icon-group {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .sign-in-btn {
            font-size: 14px;
            font-weight: 500;
            margin-right: 10px;
        }

        /* Tooltip container */
        .custom-tooltip {
            position: relative;
        }

        /* Tooltip text */
        .custom-tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: #767171;
            color: #fff;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: 0.2s;
            z-index: 999;
        }

        /* arrow صغير */
        .custom-tooltip::before {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            border-width: 5px;
            border-style: solid;
            border-color: transparent transparent #000 transparent;
            opacity: 0;
            visibility: hidden;
            transition: 0.2s;
        }

        /* show on hover */
        .custom-tooltip:hover::after,
        .custom-tooltip:hover::before {
            opacity: 1;
            visibility: visible;
        }

        .search-container {
            background-color: #f5f5f5;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            display: none;
            padding: 10px 20px;
            color: #000;
        }

        .search-input::placeholder {
            color: #aaa;
        }

        .search-container {
            background-color: #f2f2f2 !important;
            padding: 15px 0;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #eaeaea;
            border-radius: 6px;
            overflow: hidden;
        }

        .search-category {
            background: #a8a8a8;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 14px;
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 10px 15px;
            background: #eaeaea;
            outline: none;
        }

        .search-input::placeholder {
            color: #999;
        }

        .search-submit {
            background: #a8a8a8;
            border: none;
            padding: 10px 15px;
            color: #000;
        }

        /* Sidebar Styling  */
        .offcanvas {
            width: 320px !important;
            border: none !important;
        }

        .offcanvas-header {
            padding: 30px 20px;
            border-bottom: 1px solid #f0f0f0;
            justify-content: center;
            position: relative;
        }

        .offcanvas-header .btn-close {
            position: absolute;
            right: 20px;
            top: 35px;
            font-size: 12px;
        }

        .sidebar-logo {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            color: #000000;
            letter-spacing: -2px;
            font-weight: 700;
        }

        .sidebar-search {
            padding: 20px;
        }

        .sidebar-search .search-wrapper {
            position: relative;
        }

        .sidebar-search input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 14px;
            background: #fafafa;
        }

        .sidebar-search i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .menu-list {
            padding: 0;
        }

        .menu-list a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 25px;
            text-decoration: none;
            color: #000;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px solid #d9d9d9;
            transition: 0.3s;
        }

        .menu-list a:hover {
            background-color: #efeeee;
        }

        .menu-list i.chevron {
            font-size: 12px;
            color: #070707;
        }

footer {
    background-color: #f4f4f7;
    padding: 70px 0 30px;
    border-top: 1px solid #e5e5e5;
    color: #000;
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden;
}

/* ===== TITLES LINE (9ad kalma mashi l7ad center) ===== */
.information-title,
.contact-title {
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 25px;
    font-size: 17px;
    position: relative;
    display: inline-block;
}

.information-title::after,
.contact-title::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 100%;
    height: 2px;
    background: #000;
    opacity: 0.15;
}

/* ===== CONTACT BOX (paragrap + button alignment) ===== */
.col-lg-4.text-center p {
    margin-bottom: 15px;
    margin-top: -5px;
    color: #666;
    line-height: 1.6;
}

/* ===== EMAIL BUTTON PRO ===== */
.contact-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: #000;
    color: #fff;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: 0.3s ease;
}

.contact-btn:hover {
    background: #333;
    transform: translateY(-2px);
}

/* ===== CENTER CONTACT BLOCK CLEAN ===== */
.col-lg-4.text-center {
    display: flex;
    flex-direction: column;
    align-items: center;
}



/* LOGO */
footer img {
    height: 90px;
    margin-top: -30px;
    margin-bottom: 10px;
    transition: 0.3s ease;
}

footer img:hover {
    transform: scale(1.05);
}

/* TEXT */
footer p {
    color: #545353;
    line-height: 1.7;
    font-size: 16px;
    margin-top: -20px;
    max-width: 300px;
}

/* TITLES */
.information-title,
.contact-title {
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 25px;
    font-size: 18px;
    position: relative;
    
}

/* underline subtle */
.information-title::after,
.contact-title::after {
    content: "";
    width: 30px;
    height: 2px;
    background: #000;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: -8px;
}

/* LINKS */
.information li {
    margin-bottom: 12px;
}

.information a {
    color: #545353;
    text-decoration: none;
    font-size: 16px;
    transition: 0.3s ease;
    position: relative;
}

/* hover animation */
.information a::after {
    content: "";
    position: absolute;
    width: 0%;
    height: 1px;
    background: #000;
    left: 0;
    bottom: -2px;
    transition: 0.3s;
}

.information a:hover {
    color: #000;
}

.information a:hover::after {
    width: 100%;
}

/* SOCIAL ICONS */
.social-icons {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.social-icons a {
    width: 40px;
    height: 40px;
    border: 1px solid #000000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000000;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-icons a:hover {
    background-color: #000;
    color: #fff;
    transform: translateY(-3px);
}

/* CONTACT */
.contact-email {
    color: #000;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
    transition: 0.3s;
}

.contact-email:hover {
    text-decoration: underline;
    transform: translateX(5px);
}

/* COPYRIGHT */
.copyright {
    background: #000;
    text-align: center;
    padding: 15px;
    margin-top: 0; /* مهم */
    font-size: 13px;
    color: #fff;
    letter-spacing: 0.5px;
}



    </style>
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
                    <a href="#" class="nav-icon-btn d-none d-md-block sign-in-btn">Sign in</a>
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
                            <li><a href="">Contact</a></li>
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
        document.addEventListener("DOMContentLoaded", () => {
            const btn = document.getElementById("searchToggle");
            const bar = document.getElementById("searchBar");

            btn?.addEventListener("click", () => {
                bar.classList.toggle("d-none");
            });
        });
    </script>

    @stack('scripts')

</body>

</html>