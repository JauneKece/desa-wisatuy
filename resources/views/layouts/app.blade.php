<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desmok - Reservasi Wisata Desa Jomok')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
        }
        
        body {
            background: linear-gradient(135deg, #e8dcc8 0%, #f5ead3 50%, #e8dcc8 100%);
            background-attachment: fixed;
            background-size: 400% 400%;
            min-height: 100vh;
            padding-top: 4.5rem;
            color: #957C62;
        }

        @media (max-width: 576px) {
            body {
                padding-top: 3.5rem;
            }
        }

        main {
            min-height: 70vh;
            padding: 0.5rem 0 3rem;
            overflow-x: hidden;
        }

        main > * + * {
            margin-top: 1.75rem;
        }

        @media (max-width: 768px) {
            main {
                padding: 0.25rem 0 2rem;
            }

            main > * + * {
                margin-top: 1.25rem;
            }
        }

        /* Container responsive */
        .container-responsive {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            box-sizing: border-box;
        }

        @media (max-width: 576px) {
            .container-responsive {
                padding: 0 0.75rem;
            }
        }

        /* Remove global transition to avoid lag */
        * {
            box-sizing: border-box;
        }

        /* Jamur Tiram Color Scheme */
        :root {
            --jamur-main: #B77466;
            --jamur-dark: #957C62;
            --jamur-light: #FFE1AF;
            --jamur-accent: #E2B59A;
        }
        body.is-home main {
            padding-top: 0;
        }

        @media (max-width: 768px) {
            body.is-home main {
                padding-top: 0;
            }
        }
    </style>
</head>
<body class="{{ request()->routeIs('home') ? 'is-home' : '' }}" style="background-color: #FFE1AF; color: #957C62;">
    @include('layouts.navbar')
    
    <main class="py-8 md:py-12">
        @if ($errors->any() || session('success'))
        <div class="container-responsive">
            @if ($errors->any())
                <div class="mb-6 animate-slide-in p-6 rounded-2xl border-2" style="background-color: #FFE1AF; border-color: #B77466;">
                    <h4 class="mb-3 flex items-center" style="color: #B77466;">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Kesalahan
                    </h4>
                    <ul class="mb-0 space-y-1" style="color: #B77466;">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center">
                                <span class="inline-block w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 animate-slide-in p-6 rounded-2xl border-2" style="background-color: #FFE1AF; border-color: #957C62;">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20" style="color: #957C62;">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-300 font-semibold">
                            {{ session('success') }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
        @endif
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enhanced smooth scroll with page transition
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth hash anchor scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (href !== '#') {
                        e.preventDefault();
                        const target = document.querySelector(href);
                        if (target) {
                            const offsetTop = target.getBoundingClientRect().top + window.scrollY - 100;
                            window.scrollTo({
                                top: offsetTop,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.15,
                rootMargin: '0px 0px -50px 0px'
            };

            const animationObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'slideInFromBottom 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards';
                        animationObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all cards and sections
            document.querySelectorAll('.animate-on-scroll, .card, section').forEach(el => {
                if (!el.classList.contains('no-animate')) {
                    animationObserver.observe(el);
                }
            });

            // Add keyboard navigation shortcut
            document.addEventListener('keydown', function(e) {
                // Press 'h' to go home
                if (e.key === 'h' && !e.ctrlKey && !e.metaKey) {
                    const homeLink = document.querySelector('a[href="' + '{{ route("home") }}' + '"]');
                    if (homeLink) homeLink.click();
                }
            });

            // Page transition on link click
            document.querySelectorAll('a:not([target="_blank"]):not([href^="javascript"])').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href && href !== '#' && !href.startsWith('#') && 
                        !href.includes('javascript') && !href.includes('mailto')) {
                        // Optional: Add page transition effect
                        const currentUrl = window.location.pathname;
                        if (!href.includes(currentUrl)) {
                            document.body.style.opacity = '0.95';
                        }
                    }
                });
            });

            // Reset opacity on page load
            window.addEventListener('load', function() {
                document.body.style.opacity = '1';
            });
        });

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInFromBottom {
                from {
                    opacity: 0;
                    transform: translateY(30px);
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

            body {
                animation: fadeIn 0.5s ease-out;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
