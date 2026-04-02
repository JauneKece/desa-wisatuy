@extends('layouts.app')

@section('title', 'Dashboard Staff - Desmok')

@section('content')
<div class="container-responsive py-8 md:py-12">
    <!-- Header -->
    <div class="mb-12 animate-slide-in">
        <h1 class="text-5xl md:text-6xl font-outfit font-black mb-2" style="color: #957C62;">👨‍💼 Dashboard Staff</h1>
        <p class="text-xl" style="color: #B77466;">Kelola konten berita dan informasi wisata</p>
    </div>

    <div class="w-20 h-1 mb-12" style="background-color: #E2B59A;"></div>

    <!-- Welcome Card -->
    <div class="p-8 mb-12 rounded-3xl border-3 overflow-hidden" style="background-color: #FFE1AF; border-color: #B77466;">
        <h2 class="text-3xl font-outfit font-bold mb-3" style="color: #957C62;">👋 Selamat Datang, Staff {{ auth()->user()->name }}!</h2>
        <p class="text-lg" style="color: #B77466;">Bantu kami menyajikan informasi terbaik kepada pengunjung dan calon pelanggan melalui konten berita yang menarik dan berkualitas.</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">📰</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalBerita }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Berita</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">✍️</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $beritaByUser }}</h3>
            <p class="font-semibold" style="color: #B77466;">Berita Saya</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">🏞️</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalObjekWisata }}</h3>
            <p class="font-semibold" style="color: #B77466;">Objek Wisata</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">🏨</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalPenginapan }}</h3>
            <p class="font-semibold" style="color: #B77466;">Penginapan</p>
        </div>
    </div>

    <!-- Main Features -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">🛠️ Kelola Konten</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <!-- Manage Berita -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">📰</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Kelola Berita</h3>
            <p class="mb-3" style="color: #B77466;">✍️ {{ $beritaByUser }} berita telah Anda buat</p>
            <p class="mb-6" style="color: #B77466;">Buat, edit, dan publikasi berita informasi terbaru untuk pengunjung kami.</p>
            <div class="flex gap-3">
                <a href="{{ route('berita.index') }}" class="flex-1 text-center py-3 px-4 text-white font-semibold rounded-lg transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Semua
                </a>
                <a href="{{ route('berita.create') }}" class="flex-1 text-center py-3 px-4 text-white font-semibold rounded-lg transition-all" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    Buat Baru
                </a>
            </div>
        </div>

        <!-- Eksplorasi Destinasi -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">🗺️</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Eksplorasi Destinasi</h3>
            <p class="mb-3" style="color: #B77466;">🌍 Pelajari semua destinasi yang tersedia</p>
            <p class="mb-6" style="color: #B77466;">Jelajahi informasi lengkap tentang objek wisata, paket, dan penginapan untuk konten Anda.</p>
            <a href="{{ route('objek-wisata.index') }}" class="inline-block w-full text-center py-3 px-6 text-white font-semibold rounded-lg transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Jelajahi Destinasi →
            </a>
        </div>
    </div>

    <!-- My Recent Berita -->
    @if($myBerita->count() > 0)
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">✍️ Berita Terbaru Saya</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        @foreach($myBerita as $berita)
        <div class="p-6 hover:shadow-lg transition-all rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="flex items-start gap-4 mb-4">
                <span class="text-3xl">📄</span>
                <div class="flex-1">
                    <h4 class="font-semibold line-clamp-2" style="color: #957C62;">{{ $berita->judul }}</h4>
                    <small class="inline-block px-2 py-1 rounded mt-2" style="background-color: #E2B59A; color: #957C62;">
                        {{ $berita->kategoriBerita?->nama_kategori ?? 'Umum' }}
                    </small>
                </div>
            </div>
            <p class="text-sm line-clamp-3 mb-4" style="color: #B77466;">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
            <div class="flex items-center justify-between">
                <small style="color: #B77466;">
                    {{ $berita->created_at->format('d M Y H:i') }}
                </small>
                <div class="flex gap-2">
                    <a href="{{ route('berita.show', $berita->id) }}" class="px-3 py-1 text-sm text-white rounded transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                        Lihat
                    </a>
                    <a href="{{ route('berita.edit', $berita->id) }}" class="px-3 py-1 text-sm text-white rounded transition-all" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                        Edit
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- All Recent Berita -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">📰 Berita Terbaru Sistem</h2>
    
    <div class="grid grid-cols-1 gap-6">
        @forelse($recentBerita as $berita)
        <div class="p-6 hover:shadow-lg transition-all rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="flex flex-col md:flex-row gap-6 md:items-center">
                <div class="flex-1">
                    <div class="flex items-start gap-3 mb-3">
                        <span class="text-3xl">📰</span>
                        <div>
                            <h4 class="font-bold mb-1" style="color: #957C62;">{{ $berita->judul }}</h4>
                            <div class="flex flex-wrap gap-2 items-center text-sm" style="color: #B77466;">
                                <span class="inline-block px-2 py-1 rounded" style="background-color: #E2B59A; color: #957C62;">
                                    {{ $berita->kategoriBerita?->nama_kategori ?? 'Umum' }}
                                </span>
                                <span>•</span>
                                <span>{{ $berita->user->name ?? 'Staff' }}</span>
                                <span>•</span>
                                <span>{{ $berita->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="line-clamp-2" style="color: #B77466;">{{ Str::limit(strip_tags($berita->konten), 200) }}</p>
                </div>
                <div class="text-right">
                    <a href="{{ route('berita.show', $berita->id) }}" class="inline-block px-4 py-2 text-white rounded transition-all text-sm font-semibold" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                        Selengkapnya →
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <p style="color: #B77466;">Belum ada berita</p>
        </div>
        @endforelse
    </div>

    <!-- Resources Section -->
    <div class="mt-16">
        <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">📚 Referensi Destinasi</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="p-6 text-center hover:scale-105 transition-transform rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
                <div class="text-4xl mb-3">🏞️</div>
                <h4 class="text-xl font-outfit font-bold mb-2" style="color: #957C62;">Objek Wisata</h4>
                <p class="mb-4" style="color: #B77466;">{{ $totalObjekWisata }} destinasi wisata</p>
                <a href="{{ route('objek-wisata.index') }}" class="inline-block px-4 py-2 text-white rounded transition-all text-sm font-semibold" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Detail →
                </a>
            </div>

            <div class="p-6 text-center hover:scale-105 transition-transform rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
                <div class="text-4xl mb-3">🎒</div>
                <h4 class="text-xl font-outfit font-bold mb-2" style="color: #957C62;">Paket Wisata</h4>
                <p class="mb-4" style="color: #B77466;">{{ $totalPaketWisata }} paket tersedia</p>
                <a href="{{ route('paket-wisata.index') }}" class="inline-block px-4 py-2 text-white rounded transition-all text-sm font-semibold" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Detail →
                </a>
            </div>

            <div class="p-6 text-center hover:scale-105 transition-transform rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
                <div class="text-4xl mb-3">🏨</div>
                <h4 class="text-xl font-outfit font-bold mb-2" style="color: #957C62;">Penginapan</h4>
                <p class="mb-4" style="color: #B77466;">{{ $totalPenginapan }} penginapan pilihan</p>
                <a href="{{ route('penginapan.index') }}" class="inline-block px-4 py-2 text-white rounded transition-all text-sm font-semibold" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Detail →
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-slide-in {
        animation: slideIn 0.6s ease-out forwards;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .text-5xl {
            font-size: 2.5rem;
        }
        
        .text-3xl {
            font-size: 1.875rem;
        }
    }
</style>

@endsection
