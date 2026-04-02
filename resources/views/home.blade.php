@extends('layouts.app')

@section('title', 'Desmok - Reservasi Wisata Desa Jomok')

@section('content')
@php
    use Illuminate\Support\Str;

    $resolveImageUrl = function (?string $path): ?string {
        if (empty($path)) {
            return null;
        }
        $normalized = ltrim($path, '/');

        if (Str::startsWith($normalized, ['http://', 'https://', 'data:'])) {
            return $path;
        };
        if (Str::startsWith($normalized, ['storage/', 'images/'])) {
            return asset($normalized);
        }

        if (Str::startsWith($normalized, 'public/')) {
            $normalized = Str::after($normalized, 'public/');
        }

        return asset('storage/' . $normalized);
    };

    // Prefer a second hero background image if it exists in public/images
    $preferredHero = asset('images/desa-tradisional.jpg');
    $secondCandidate = public_path('images/desa-background-2.jpg');
    if (file_exists($secondCandidate)) {
        $preferredHero = asset('images/desa-background-2.jpg');
    }

@endphp

<!-- Hero Section with Professional Styling -->
<section class="relative min-h-fit md:min-h-screen flex items-center justify-center overflow-hidden pt-10 md:pt-10 pb-12 md:pb-16">
    <!-- Animated Background with Indonesian Village Image -->
    <div class="absolute inset-0 z-0">
        <!-- Full-bleed background image behind the hero card -->
        <div class="absolute inset-0 bg-hero-image" style="--hero-image: url('{{ $preferredHero }}');"></div>
        <!-- Enhanced Dark Gradient Overlay - Strong Bottom Transition -->
        <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(183,116,102,0.04) 0%, rgba(149,124,98,0.12) 35%, rgba(0,0,0,0.45) 70%, rgba(0,0,0,0.72) 100%);"></div>
        
        <!-- Warm Overlay for Text Readability -->
        <div class="absolute inset-0" style="background-color: rgba(183,116,102,0.06);"></div>
        
        <!-- Subtle Mountain Effect with Dark Transition -->
        <svg class="absolute bottom-0 w-full h-40 md:h-80 opacity-30" viewBox="0 0 1200 400" preserveAspectRatio="xMidYMid slice">
            <defs>
                <linearGradient id="darkTransitionGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#2a2a2a;stop-opacity:0.3" />
                    <stop offset="100%" style="stop-color:#000000;stop-opacity:0.9" />
                </linearGradient>
            </defs>
            <path d="M 0 200 Q 150 120 300 200 T 600 180 T 900 200 T 1200 190 L 1200 400 L 0 400 Z" fill="url(#darkTransitionGradient)" />
            <path d="M 0 280 Q 200 200 400 270 T 800 290 T 1200 270 L 1200 400 L 0 400 Z" fill="url(#darkTransitionGradient)" />
        </svg>

        <!-- Floating decorative elements (subtle) -->
        <div class="absolute top-20 left-1/4 w-20 md:w-48 h-20 md:h-48 rounded-full blur-3xl opacity-5" style="background-color: #B77466;"></div>
        <div class="absolute top-1/2 right-10 w-24 md:w-56 h-24 md:h-56 rounded-full blur-3xl opacity-5" style="background-color: #FFE1AF;"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 w-full px-3 md:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Hero content (no card) -->
            <div class="px-4 md:px-16 py-8 md:py-16 hero-content">
                <!-- Top accent bar with gradient (decorative) -->
                <!-- <div style="height: 4px; background: linear-gradient(90deg, #B77466, #E2B59A, #957C62); margin-bottom: 1rem; border-radius: 6px;"></div> -->
                    <!-- Header with animated elements -->
                    <div class="text-center mb-4 md:mb-8">
                        <div class="flex items-center justify-center gap-2 md:gap-4 mb-3 md:mb-6 animate-float-up">
                            <span class="text-2xl md:text-5xl animate-bounce" style="animation-delay: 0s;">🍄</span>
                            <h1 class="text-2xl md:text-6xl font-outfit font-black" style="color: #957C62;" >DESMOK</h1>
                            <span class="text-2xl md:text-5xl animate-bounce" style="animation-delay: 0.1s;">🍄</span>
                        </div>
                        
                        <div class="flex items-center justify-center gap-2 mb-4 md:mb-6">
                            <div class="h-0.5 md:h-1 w-8 md:w-12 rounded-full" style="background-color: #B77466;"></div>
                            <p class="text-xs md:text-base font-semibold tracking-widest uppercase" style="color: #B77466;">Desa Jomok</p>
                            <div class="h-0.5 md:h-1 w-8 md:w-12 rounded-full" style="background-color: #B77466;"></div>
                        </div>
                    </div>

                    <!-- Tagline Section -->
                    <div class="text-center mb-6 md:mb-10">
                        <h2 class="text-lg md:text-4xl font-outfit font-bold mb-2 md:mb-4" style="color: #957C62;">
                            Jelajahi Keindahan Desa Tradisional
                        </h2>
                        <p class="text-xs md:text-lg leading-relaxed max-w-2xl mx-auto" style="color: #B77466;">
                            Rasakan pengalaman wisata autentik di Desa Jomok dengan kebun jamur tiram, budaya lokal, dan keindahan alam.
                        </p>
                    </div>

                    <!-- Buttons with smooth animations -->
                    <div class="flex flex-col gap-3 md:gap-4 justify-center items-center">
                        @if (!auth()->check())
                            <a href="{{ route('register') }}" class="no-underline group relative px-6 md:px-10 py-2 md:py-4 text-white font-bold text-xs md:text-base uppercase tracking-wide rounded-lg md:rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg w-full md:w-auto flex items-center justify-center" style="background-color: #B77466;">
                                <span class="absolute inset-0 rounded-lg md:rounded-xl transition-all duration-300" style="background: rgba(149, 124, 98, 0.3);"></span>
                                <span class="absolute inset-0 rounded-lg md:rounded-xl transform scale-x-0 origin-left transition-transform duration-300 group-hover:scale-x-100" style="background-color: #957C62;"></span>
                                <span class="relative flex items-center gap-2">
                                    <span class="text-base md:text-lg">⭐</span>
                                    <span>Daftar</span>
                                </span>
                            </a>
                            <a href="{{ route('login') }}" class="no-underline group relative px-6 md:px-10 py-2 md:py-4 font-bold text-xs md:text-base uppercase tracking-wide rounded-lg md:rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg w-full md:w-auto flex items-center justify-center border-2" style="border-color: #B77466; color: #957C62;">
                                <span class="absolute inset-0 rounded-lg md:rounded-xl transition-all duration-300" style="background-color: rgba(226, 181, 154, 0.5);"></span>
                                <span class="absolute inset-0 rounded-lg md:rounded-xl transform scale-x-0 origin-left transition-transform duration-300 group-hover:scale-x-100" style="background-color: #B77466;"></span>
                                <span class="relative flex items-center gap-2 transition-colors group-hover:text-white duration-300">
                                    <span class="text-base md:text-lg">🔓</span>
                                    <span>Login</span>
                                </span>
                            </a>
                        @else
                            <a href="{{ route('reservasi.create') }}" class="no-underline group relative px-6 md:px-10 py-2 md:py-4 text-white font-bold text-xs md:text-base uppercase tracking-wide rounded-lg md:rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg w-full md:w-auto flex items-center justify-center" style="background-color: #B77466;">
                                <span class="absolute inset-0 rounded-lg md:rounded-xl transition-all duration-300" style="background: rgba(149, 124, 98, 0.3);"></span>
                                <span class="absolute inset-0 rounded-lg md:rounded-xl transform scale-x-0 origin-left transition-transform duration-300 group-hover:scale-x-100" style="background-color: #957C62;"></span>
                                <span class="relative flex items-center gap-2">
                                    <span class="text-base md:text-lg">📅</span>
                                    <span>Reservasi</span>
                                </span>
                            </a>
                            <a href="{{ route('dashboard') }}" class="no-underline group relative px-6 md:px-10 py-2 md:py-4 font-bold text-xs md:text-base uppercase tracking-wide rounded-lg md:rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg w-full md:w-auto flex items-center justify-center border-2" style="border-color: #B77466; color: #957C62;">
                                <span class="absolute inset-0 rounded-lg md:rounded-xl transition-all duration-300" style="background-color: rgba(226, 181, 154, 0.5);"></span>
                                <span class="absolute inset-0 rounded-lg md:rounded-xl transform scale-x-0 origin-left transition-transform duration-300 group-hover:scale-x-100" style="background-color: #B77466;"></span>
                                <span class="relative flex items-center gap-2 transition-colors group-hover:text-white duration-300">
                                    <span class="text-base md:text-lg">📊</span>
                                    <span>Dashboard</span>
                                </span>
                            </a>
                        @endif
                    </div>

                    <!-- Bottom decorative text -->
                    <div class="mt-6 md:mt-10 pt-4 md:pt-8 border-t-2 text-center" style="border-color: rgba(226, 181, 154, 0.3);">
                        <p class="text-xs md:text-sm font-semibold tracking-widest uppercase" style="color: #B77466;">
                            ✨ Percayakan liburan Anda pada kami ✨
                        </p>
                    </div>
                </div>

            <!-- Scroll indicator -->
            <div class="hidden md:flex justify-center mt-8 animate-bounce">
                <svg class="w-6 h-6 md:w-8 md:h-8" style="color: #B77466;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Objek Wisata Section -->
<section class="container-responsive content-section">
    <div class="mb-6 md:mb-10">
        <div class="flex flex-col gap-3 md:gap-0 md:flex-row md:justify-between md:items-center">
            <div>
                <h2 class="text-lg md:text-5xl font-outfit font-black mb-1 md:mb-2" style="color: #957C62;">🏞️ Objek Wisata</h2>
                <p class="text-xs md:text-base" style="color: #B77466;">Temukan destinasi wisata terbaik</p>
            </div>
            <a href="{{ route('objek-wisata.index') }}" class="no-underline inline-block px-3 md:px-6 py-1.5 md:py-3 text-white font-semibold rounded text-xs md:text-base transition-all duration-300 whitespace-nowrap w-full md:w-auto text-center" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Semua →
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 home-grid-cards">
        @forelse ($objekWisata as $objek)
            <div class="group animate-slide-in" style="--animation-delay: {{ ($loop->index * 0.1) }}s">
                <div class="overflow-hidden h-full rounded-lg md:rounded-2xl border-2 hover:scale-105 transition-transform duration-300" style="background-color: #FFE1AF; border-color: #E2B59A;">
                    <div class="relative h-32 md:h-48 overflow-hidden">
                        @if ($objek->foto)
                            <img src="{{ $resolveImageUrl($objek->foto) }}" alt="{{ $objek->nama_objek }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background-color: #E2B59A;">
                                <span class="text-3xl md:text-5xl">📷</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    
                    <div class="p-3 md:p-4 relative z-10">
                        <h3 class="text-xs md:text-lg font-outfit font-bold mb-1 line-clamp-2" style="color: #957C62;">{{ $objek->nama_objek }}</h3>
                        <p class="text-xs line-clamp-2 mb-2 md:mb-3" style="color: #B77466;">{{ $objek->deskripsi }}</p>
                        
                        <div class="flex flex-wrap gap-1 md:gap-2 mb-2 md:mb-3">
                            <span class="badge text-white text-xs rounded px-2 py-0.5" style="background-color: #B77466;">
                                ⭐ {{ $objek->rating ?? 'N/A' }}
                            </span>
                            <span class="badge text-white text-xs rounded px-2 py-0.5" style="background-color: #E2B59A;">
                                💰 Rp{{ number_format($objek->harga_tiket, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <a href="{{ route('objek-wisata.show', $objek) }}" class="no-underline block w-full text-center py-1.5 md:py-2 px-3 text-white font-semibold rounded transition-all duration-300 text-xs" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            Detail →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-sm md:text-lg" style="color: #B77466;">Belum ada objek wisata</p>
            </div>
        @endforelse
    </div>
</section>

<!-- Paket Wisata Section -->
<section class="container-responsive content-section">
    <div class="mb-6 md:mb-10">
        <div class="flex flex-col gap-3 md:gap-0 md:flex-row md:justify-between md:items-center">
            <div>
                <h2 class="text-lg md:text-5xl font-outfit font-black mb-1 md:mb-2" style="color: #957C62;">🎒 Paket Wisata</h2>
                <p class="text-xs md:text-base" style="color: #B77466;">Pilih paket sesuai kebutuhan Anda</p>
            </div>
            <a href="{{ route('paket-wisata.index') }}" class="no-underline inline-block px-3 md:px-6 py-1.5 md:py-3 text-white font-semibold rounded transition-all duration-300 text-xs md:text-base whitespace-nowrap w-full md:w-auto text-center" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Semua →
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 home-grid-cards">
        @forelse ($paketWisata as $paket)
            <div class="group animate-slide-in" style="--animation-delay: {{ ($loop->index * 0.1) }}s">
                <div class="overflow-hidden h-full rounded-lg md:rounded-2xl border-2 hover:scale-105 transition-transform duration-300" style="background-color: #FFE1AF; border-color: #E2B59A;">
                    <div class="relative h-32 md:h-48 overflow-hidden">
                        @if ($paket->foto)
                            <img src="{{ $resolveImageUrl($paket->foto) }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background-color: #E2B59A;">
                                <span class="text-3xl md:text-5xl">📷</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    
                    <div class="p-3 md:p-4 relative z-10">
                        <h3 class="text-xs md:text-lg font-outfit font-bold mb-1 line-clamp-2" style="color: #957C62;">{{ $paket->nama_paket }}</h3>
                        <p class="text-xs line-clamp-2 mb-2 md:mb-3" style="color: #B77466;">{{ $paket->deskripsi }}</p>
                        
                        <div class="flex flex-wrap gap-1 md:gap-2 mb-2 md:mb-3">
                            <span class="badge text-white text-xs rounded px-2 py-0.5" style="background-color: #B77466;">
                                ⏱️ {{ $paket->durasi_hari }}h
                            </span>
                            <span class="badge text-white text-xs rounded px-2 py-0.5" style="background-color: #E2B59A;">
                                👥 {{ $paket->kuota_peserta }}
                            </span>
                        </div>
                        
                        <div class="mb-2 md:mb-3 text-center">
                            <p class="text-sm md:text-lg font-outfit font-bold" style="color: #957C62;">
                                Rp{{ number_format($paket->harga_paket, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <a href="{{ route('paket-wisata.show', $paket) }}" class="no-underline block w-full text-center py-1.5 md:py-2 px-3 text-white font-semibold rounded transition-all duration-300 text-xs" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            Detail →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-sm md:text-lg" style="color: #B77466;">Belum ada paket wisata</p>
            </div>
        @endforelse
    </div>
</section>

<!-- Penginapan Section -->
<section class="container-responsive content-section">
    <div class="mb-6 md:mb-10">
        <div class="flex flex-col gap-3 md:gap-0 md:flex-row md:justify-between md:items-center">
            <div>
                <h2 class="text-lg md:text-5xl font-outfit font-black mb-1 md:mb-2" style="color: #957C62;">🏨 Penginapan</h2>
                <p class="text-xs md:text-base" style="color: #B77466;">Menginap nyaman selama liburan</p>
            </div>
            <a href="{{ route('penginapan.index') }}" class="no-underline inline-block px-3 md:px-6 py-1.5 md:py-3 text-white font-semibold rounded transition-all duration-300 text-xs md:text-base whitespace-nowrap w-full md:w-auto text-center" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Semua →
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 home-grid-cards">
        @forelse ($penginapan as $akomodasi)
            <div class="group animate-slide-in" style="--animation-delay: {{ ($loop->index * 0.1) }}s">
                <div class="overflow-hidden h-full rounded-lg md:rounded-2xl border-2 hover:scale-105 transition-transform duration-300" style="background-color: #FFE1AF; border-color: #E2B59A;">
                    <div class="relative h-32 md:h-48 overflow-hidden">
                        @if ($akomodasi->foto)
                            <img src="{{ $resolveImageUrl($akomodasi->foto) }}" alt="{{ $akomodasi->nama_penginapan }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background-color: #E2B59A;">
                                <span class="text-3xl md:text-5xl">📷</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    
                    <div class="p-3 md:p-4 relative z-10">
                        <h3 class="text-xs md:text-lg font-outfit font-bold mb-1 line-clamp-2" style="color: #957C62;">{{ $akomodasi->nama_penginapan }}</h3>
                        <p class="text-xs line-clamp-2 mb-2 md:mb-3" style="color: #B77466;">{{ $akomodasi->deskripsi }}</p>
                        
                        <div class="flex flex-wrap gap-1 md:gap-2 mb-2 md:mb-3">
                            <span class="badge text-white text-xs rounded px-2 py-0.5" style="background-color: #B77466;">
                                ⭐ {{ $akomodasi->rating ?? 'N/A' }}
                            </span>
                            <span class="badge text-white text-xs rounded px-2 py-0.5" style="background-color: #E2B59A;">
                                🛏️ {{ $akomodasi->jumlah_kamar }}
                            </span>
                        </div>
                        
                        <div class="mb-2 md:mb-3 text-center">
                            <p class="text-sm md:text-lg font-outfit font-bold" style="color: #957C62;">
                                Rp{{ number_format($akomodasi->harga_penginapan, 0, ',', '.') }}<span class="text-xs" style="color: #B77466;">/ml</span>
                            </p>
                        </div>
                        
                        <a href="{{ route('penginapan.show', $akomodasi) }}" class="no-underline block w-full text-center py-1.5 md:py-2 px-3 text-white font-semibold rounded transition-all duration-300 text-xs" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            Detail →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-sm md:text-lg" style="color: #B77466;">Belum ada penginapan</p>
            </div>
        @endforelse
    </div>
</section>

<!-- Berita Section -->
<section class="container-responsive content-section">
    <div class="mb-6 md:mb-10">
        <div class="flex flex-col gap-3 md:gap-0 md:flex-row md:justify-between md:items-center">
            <div>
                <h2 class="text-lg md:text-5xl font-outfit font-black mb-1 md:mb-2" style="color: #957C62;">📰 Berita & Info</h2>
                <p class="text-xs md:text-base" style="color: #B77466;">Informasi terbaru Desa Jomok</p>
            </div>
            <a href="{{ route('berita.index') }}" class="no-underline inline-block px-3 md:px-6 py-1.5 md:py-3 text-white font-semibold rounded transition-all duration-300 text-xs md:text-base whitespace-nowrap w-full md:w-auto text-center" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Semua →
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 home-grid-cards">
        @forelse ($berita as $item)
            <div class="group animate-slide-in" style="--animation-delay: {{ ($loop->index * 0.1) }}s">
                <div class="overflow-hidden h-full rounded-lg md:rounded-2xl border-2 hover:scale-105 transition-transform duration-300" style="background-color: #FFE1AF; border-color: #E2B59A;">
                    <div class="relative h-32 md:h-48 overflow-hidden">
                        @if ($item->foto)
                            <img src="{{ $resolveImageUrl($item->foto) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background-color: #E2B59A;">
                                <span class="text-3xl md:text-5xl">📷</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    
                    <div class="p-3 md:p-4 relative z-10">
                        <div class="flex flex-wrap gap-1 mb-1 text-xs">
                            <span style="color: #B77466;">📅 {{ $item->created_at->format('d M') }}</span>
                            <span style="color: #B77466;">✍️ {{ substr($item->user->name, 0, 10) }}</span>
                        </div>
                        
                        <h3 class="text-xs md:text-lg font-outfit font-bold mb-1 line-clamp-2" style="color: #957C62;">{{ $item->judul }}</h3>
                        <p class="text-xs line-clamp-2 md:line-clamp-3 mb-2 md:mb-3" style="color: #B77466;">{{ strip_tags($item->konten) }}</p>
                        
                        <a href="{{ route('berita.show', $item) }}" class="no-underline block w-full text-center py-1.5 md:py-2 px-3 text-white font-semibold rounded transition-all duration-300 text-xs" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-sm md:text-lg" style="color: #B77466;">Belum ada berita</p>
            </div>
        @endforelse
    </div>
</section>

<!-- CTA Section -->
<section class="container-responsive content-section content-section-compact">
    <div class="relative rounded-2xl md:rounded-3xl overflow-hidden p-6 md:p-12" style="background-color: #FFE1AF; border: 2px solid #E2B59A;">
        <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(183, 116, 102, 0.05), rgba(226, 181, 154, 0.05));"></div>
        <div class="hidden md:block absolute -top-40 -right-40 w-96 h-96 rounded-full blur-3xl" style="background-color: rgba(183, 116, 102, 0.1);"></div>
        
        <div class="relative z-10 text-center max-w-2xl mx-auto">
            <h2 class="text-xl md:text-5xl font-outfit font-black mb-3 md:mb-4" style="color: #957C62;">✨ Siap Berkunjung?</h2>
            <p class="text-xs md:text-base mb-6 md:mb-8" style="color: #B77466;">
                Pesan paket wisata Anda sekarang dan dapatkan pengalaman tak terlupakan!
            </p>
            
            <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
                @if (!auth()->check())
                    <a href="{{ route('register') }}" class="no-underline inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 text-white font-bold text-xs md:text-base uppercase tracking-wide rounded-lg transition duration-150 hover:scale-105 active:scale-95" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                        <span class="text-lg md:text-xl mr-1 md:mr-2">⭐</span>
                        <span>Daftar</span>
                    </a>
                    <a href="{{ route('login') }}" class="no-underline inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 text-white font-bold text-xs md:text-base uppercase tracking-wide rounded-lg transition duration-150 hover:scale-105 active:scale-95" style="background-color: #E2B59A; border: 2px solid #B77466;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                        <span>Login</span>
                    </a>
                @else
                    <a href="{{ route('reservasi.create') }}" class="no-underline inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 text-white font-bold text-xs md:text-base uppercase tracking-wide rounded-lg transition duration-150 hover:scale-105 active:scale-95" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                        <span class="text-lg md:text-xl mr-1 md:mr-2">📅</span>
                        <span>Reservasi</span>
                    </a>
                    <a href="{{ route('dashboard') }}" class="no-underline inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 text-white font-bold text-xs md:text-base uppercase tracking-wide rounded-lg transition duration-150 hover:scale-105 active:scale-95" style="background-color: #E2B59A; border: 2px solid #B77466;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                        <span class="text-lg md:text-xl mr-1 md:mr-2">📊</span>
                        <span>Dashboard</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes float-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .bg-hero-image {
        background-image: linear-gradient(135deg, rgba(232,220,200,0.36) 0%, rgba(245,234,211,0.36) 50%, rgba(232,220,200,0.36) 100%), var(--hero-image);
        background-color: #e8dcc8;
        background-blend-mode: normal;
        background-size: cover;
        background-position: center 20%;
        background-attachment: fixed;
        background-repeat: no-repeat;
    }

    /* Hero content styles when using full-bleed background */
    .hero-content h1,
    .hero-content h2,
    .hero-content p,
    .hero-content .text-xs,
    .hero-content .text-sm {
        color: rgba(255,255,255,0.95) !important;
        text-shadow: 0 6px 18px rgba(0,0,0,0.6);
    }

    .hero-content .group[style] {
        color: #fff !important;
    }

    .hero-content a.group {
        box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    }

    @media (max-width: 768px) {
        .bg-hero-image {
            background-attachment: scroll;
            background-position: center;
        }
    }
    
    .animate-float-up {
        animation: float-up 0.8s ease-out;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .content-section {
        padding-top: 2.75rem;
        padding-bottom: 2.75rem;
    }

    .content-section + .content-section {
        padding-top: 1.5rem;
    }

    .content-section > div:first-child {
        margin-bottom: 2rem;
    }

    .content-section-compact {
        padding-top: 2rem;
        padding-bottom: 2.5rem;
    }

    .home-grid-cards {
        gap: 1.5rem;
    }

    @media (max-width: 768px) {
        .content-section {
            padding-top: 1.75rem;
            padding-bottom: 1.75rem;
        }

        .content-section + .content-section {
            padding-top: 1rem;
        }

        .content-section > div:first-child {
            margin-bottom: 1.25rem;
        }

        .home-grid-cards {
            gap: 1rem;
        }
    }
</style>
@endsection
