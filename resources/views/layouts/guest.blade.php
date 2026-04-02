<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background: linear-gradient(135deg, #957C62 0%, #B77466 50%, #8B6F5F 100%);
                background-attachment: fixed;
            }
            
            .glass-card {
                background: rgba(255, 225, 175, 0.95);
                backdrop-filter: blur(10px);
                border: 2px solid rgba(226, 181, 154, 0.5);
                box-shadow: 0 8px 32px rgba(183, 116, 102, 0.15);
                border-top: none;
            }
            
            .decorative-blob {
                transition: all 0.3s ease;
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="background: linear-gradient(135deg, #957C62 0%, #B77466 50%, #8B6F5F 100%); background-attachment: fixed;">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            
            <div class="relative z-10">
                <a href="/" class="inline-block">
                    <div class="text-4xl md:text-5xl font-black" style="color: #FFF8DC;">
                        🍄 DESMOK 🍄
                    </div>
                    <p class="text-center mt-2" style="color: #FFFAED;">Reservasi Wisata Desa Jomok</p>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 relative z-10">
                <div class="glass-card p-8 rounded-3xl">
                    {{ $slot }}
                </div>
                
                <!-- Footer Links -->
                <div class="text-center mt-6">
                    <p class="text-sm" style="color: #FFFAED;">
                        Kami menjamin pengalaman wisata yang tak terlupakan
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
