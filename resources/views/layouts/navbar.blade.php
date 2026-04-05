<nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar" style="background: rgba(255, 225, 175, 0.95); backdrop-filter: blur(10px); border-bottom: 2px solid #E2B59A; box-shadow: 0 4px 12px rgba(149, 124, 98, 0.1); padding: 0.75rem 0; z-index: 1030;">
    <style>
        nav {
            width: 100%;
            box-sizing: border-box;
        }

        nav.navbar-scrolled {
            background: rgba(255, 225, 175, 0.98) !important;
            box-shadow: 0 8px 24px rgba(149, 124, 98, 0.15) !important;
            padding: 0.5rem 0 !important;
        }

        #mainNavbar .navbar-collapse {
            visibility: visible !important;
            opacity: 1;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: 900;
            letter-spacing: -1px;
            color: #957C62 !important;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .navbar-brand:hover {
            transform: scale(1.05) translateY(-2px);
            filter: drop-shadow(0 4px 8px rgba(183, 116, 102, 0.2));
        }

        .nav-item {
            position: relative;
        }

        .nav-item.dropdown .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
        }

        @media (max-width: 991px) {
            .nav-item.dropdown .dropdown-menu {
                position: static;
                background-color: rgba(226, 181, 154, 0.5);
                border: none;
                box-shadow: none;
                border-radius: 0;
                margin-top: 0.5rem;
                transform: none;
                left: auto;
            }

            .nav-item.dropdown .dropdown-menu .dropdown-item {
                padding-left: 2rem;
                font-size: 0.85rem;
            }
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 0.75rem !important;
            font-size: 0.95rem;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #B77466, #E2B59A);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-link:hover {
            color: #B77466 !important;
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: #B77466 !important;
            font-weight: 600;
        }

        .navbar-toggler {
            border: 2px solid #B77466;
            padding: 0.35rem 0.65rem;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            flex-shrink: 0;
            background-color: transparent;
        }

        .navbar-toggler:focus {
            outline: 2px solid #B77466;
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(183, 116, 102, 0.2);
        }

        .navbar-toggler svg {
            transition: transform 0.3s ease;
        }

        .navbar-toggler.is-open svg,
        .navbar-toggler:not(.collapsed) svg {
            transform: rotate(90deg);
        }

        @media (min-width: 992px) {
            .navbar-toggler {
                display: none !important;
            }

            .navbar-collapse {
                display: flex !important;
                flex-basis: auto;
            }
        }

        @media (max-width: 991px) {
            .navbar-toggler {
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
            }

            .navbar-collapse {
                display: none;
            }

            .navbar-collapse {
                background: rgba(255, 225, 175, 0.98);
                border-radius: 0 0 1.5rem 1.5rem;
                padding: 0.75rem 0;
                margin-top: 0.5rem;
                box-shadow: 0 4px 12px rgba(149, 124, 98, 0.1);
                animation: slideDown 0.3s ease forwards;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 1029;
            }

            .navbar-collapse.show {
                display: flex !important;
                flex-direction: column;
            }

            .navbar-nav {
                width: 100%;
                text-align: center;
                flex-direction: column;
                gap: 0 !important;
            }

            .nav-link {
                padding: 0.65rem 1rem !important;
                font-size: 0.9rem;
                border-radius: 0;
                width: 100%;
                justify-content: center;
            }

            .nav-link::after {
                display: none;
            }

            .nav-link:hover::after {
                display: none;
            }

            .btn-auth {
                width: calc(100% - 2rem);
                margin: 0.5rem auto;
                text-align: center;
            }

            .navbar-brand {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.1rem;
                gap: 0.25rem;
            }

            .nav-link {
                padding: 0.6rem 0.75rem !important;
                font-size: 0.85rem;
            }

            .btn-auth {
                width: calc(100% - 1.5rem);
                margin: 0.4rem auto;
                font-size: 0.85rem;
                padding: 0.4rem 0.75rem !important;
            }

            .navbar-nav {
                gap: 0 !important;
            }
        }

        @media (max-width: 480px) {
            nav.navbar {
                padding: 0.5rem 0 !important;
            }

            .navbar-brand {
                font-size: 1rem;
            }

            .navbar-brand span.text-2xl {
                font-size: 1.25rem;
            }

            nav .container-fluid {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }

            .nav-link {
                padding: 0.6rem 0.5rem !important;
                font-size: 0.8rem;
            }

            .nav-link span:last-child {
                font-size: 0.75rem;
            }

            .navbar-toggler {
                padding: 0.3rem 0.5rem !important;
            }

            .navbar-toggler svg {
                width: 20px !important;
                height: 20px !important;
            }

            .btn-auth {
                width: calc(100% - 1rem);
                margin: 0.35rem auto;
                font-size: 0.8rem;
                padding: 0.35rem 0.5rem !important;
            }

            .dropdown-menu {
                font-size: 0.85rem;
            }

            .dropdown-item {
                padding: 0.6rem 0.75rem;
            }
        }

        .btn-auth {
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            text-decoration: none !important;
            white-space: nowrap;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            justify-content: center;
        }

        .btn-auth::after {
            display: none !important;
        }

        .btn-auth:hover,
        .btn-auth:focus,
        .btn-auth:active {
            color: #FFFDF5 !important;
            text-decoration: none !important;
        }

        .btn-primary-auth {
            background-color: #B77466;
            color: #FFFDF5 !important;
        }

        .btn-primary-auth:hover,
        .btn-primary-auth:focus,
        .btn-primary-auth:active {
            background-color: #957C62;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(183, 116, 102, 0.3);
            color: #FFFDF5 !important;
        }

        .btn-secondary-auth {
            background-color: transparent;
            color: #957C62;
            border: 2px solid #B77466;
        }

        .btn-secondary-auth:hover {
            background-color: #B77466;
            color: #FFFDF5 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(183, 116, 102, 0.3);
        }

        .dropdown-menu {
            background-color: #FFE1AF;
            border: 2px solid #E2B59A;
            border-radius: 0.75rem;
            animation: fadeIn 0.2s ease;
            min-width: 200px;
        }

        .dropdown-item {
            color: #957C62 !important;
            transition: all 0.2s ease;
            padding: 0.75rem 1rem;
        }

        .dropdown-item:hover {
            background-color: rgba(183, 116, 102, 0.1);
            color: #B77466 !important;
            transform: translateX(2px);
        }

        .dropdown-divider {
            border-color: #E2B59A;
        }

        @media (max-width: 576px) {
            .dropdown-menu {
                min-width: 150px;
                font-size: 0.9rem;
            }

            .dropdown-item {
                padding: 0.6rem 0.75rem;
            }

            .navbar-nav .dropdown-menu-end {
                right: 0 !important;
                left: auto !important;
                position: absolute;
                top: 100%;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>

    <div class="container-fluid ps-2 ps-sm-3 ps-md-4 pe-2 pe-sm-3 pe-md-4 d-flex align-items-center justify-content-between">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="text-2xl">🍄</span>
            <span class="d-none d-sm-inline">DESMOK</span>
            <span class="d-sm-none">DES</span>
        </a>

        <button class="navbar-toggler collapsed" type="button" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="z-index: 10; position: relative;">
            <svg class="w-6 h-6" style="color: #957C62; width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'objek-wisata.index' ? 'active' : '' }}" href="{{ route('objek-wisata.index') }}">
                        <span>📍</span>
                        <span class="d-none d-sm-inline">Objek</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'paket-wisata.index' ? 'active' : '' }}" href="{{ route('paket-wisata.index') }}">
                        <span>📦</span>
                        <span class="d-none d-sm-inline">Paket</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'penginapan.index' ? 'active' : '' }}" href="{{ route('penginapan.index') }}">
                        <span>🏨</span>
                        <span class="d-none d-sm-inline">Penginapan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'berita.index' ? 'active' : '' }}" href="{{ route('berita.index') }}">
                        <span>📰</span>
                        <span class="d-none d-sm-inline">Berita</span>
                    </a>
                </li>

                @if (auth()->check())
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'reservasi.index' ? 'active' : '' }}" href="{{ route('reservasi.index') }}">
                            <span>🗳️</span>
                            <span class="d-none d-md-inline">Reservasi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <span>📊</span>
                            <span class="d-none d-md-inline">Dashboard</span>
                        </a>
                    </li>
                    

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>👤</span>
                            <span class="d-none d-md-inline">{{ substr(auth()->user()->name, 0, 10) }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    ⚙️ Profil Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button class="dropdown-item w-100 text-start" type="submit">
                                        🚪 Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link btn-auth btn-secondary-auth" href="{{ route('login') }}">
                            <span>🔓</span>
                            <span>Login</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-auth btn-primary-auth" href="{{ route('register') }}">
                            <span>✨</span>
                            <span>Daftar</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNavbar');
            const scrollThreshold = 50;
            const navbarCollapse = document.getElementById('navbarNav');
            const toggle = document.querySelector('.navbar-toggler');

            const openMobileMenu = () => {
                navbarCollapse.classList.add('show');
                toggle.classList.add('is-open');
                toggle.classList.remove('collapsed');
                toggle.setAttribute('aria-expanded', 'true');
                // Prevent body scroll when menu is open
                document.body.style.overflow = 'hidden';
            };

            const closeMobileMenu = () => {
                navbarCollapse.classList.remove('show');
                toggle.classList.remove('is-open');
                toggle.classList.add('collapsed');
                toggle.setAttribute('aria-expanded', 'false');
                // Restore body scroll when menu is closed
                document.body.style.overflow = 'auto';
            };

            if (toggle && navbarCollapse) {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (window.innerWidth >= 992) return;

                    if (navbarCollapse.classList.contains('show')) {
                        closeMobileMenu();
                    } else {
                        openMobileMenu();
                    }
                });
            }

            window.addEventListener('scroll', () => {
                if (window.scrollY > scrollThreshold) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });

            const navLinks = document.querySelectorAll('.navbar-collapse .nav-link:not(.dropdown-toggle)');
            
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992 && navbarCollapse && navbarCollapse.classList.contains('show')) {
                        closeMobileMenu();
                    }
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!navbar.contains(event.target) && navbarCollapse && navbarCollapse.classList.contains('show')) {
                    if (window.innerWidth < 992) {
                        closeMobileMenu();
                    }
                }
            });

            // Close menu on resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992 && navbarCollapse) {
                    closeMobileMenu();
                    document.body.style.overflow = 'auto';
                }
            });

            // Handle dropdown toggle on mobile
            const dropdownToggles = document.querySelectorAll('.navbar-collapse .dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    if (window.innerWidth < 992) {
                        e.preventDefault();
                        const menu = this.nextElementSibling;
                        if (menu && menu.classList.contains('dropdown-menu')) {
                            menu.classList.toggle('show');
                        }
                    }
                });
            });
        });
    </script>
</nav>
