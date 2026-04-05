@extends('layouts.app')

@section('title', 'Dashboard Admin - Desmok')

@section('content')
<div class="container-responsive py-8 md:py-12">
    <!-- Header -->
    <div class="mb-12 animate-slide-in">
        <h1 class="text-5xl md:text-6xl font-outfit font-black mb-2" style="color: #957C62;">👨‍💼 Dashboard Admin</h1>
        <p class="text-xl" style="color: #B77466;">Kelola semua aspek sistem DESMOK dari sini</p>
    </div>

    <div class="w-20 h-1 mb-12" style="background-color: #E2B59A;"></div>

    <!-- Welcome Card -->
    <div class="p-8 mb-12 rounded-3xl border-3 overflow-hidden" style="background-color: #FFE1AF; border-color: #B77466;">
        <h2 class="text-3xl font-outfit font-bold mb-3" style="color: #957C62;">👋 Selamat Datang, Admin {{ auth()->user()->name }}!</h2>
        <p class="text-lg" style="color: #B77466;">Anda memiliki akses penuh untuk mengelola semua aspek sistem DESMOK. Pantau statistik, kelola konten, dan atur pengguna.</p>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">👥</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalUsers }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Users</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">📅</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalReservasi }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Reservasi</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">🏞️</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalObjekWisata }}</h3>
            <p class="font-semibold" style="color: #B77466;">Objek Wisata</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">🎒</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalPaketWisata }}</h3>
            <p class="font-semibold" style="color: #B77466;">Paket Wisata</p>
        </div>
    </div>

    <!-- Management Sections -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">🛠️ Kelola Konten</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <!-- Objek Wisata Management -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">🏞️</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Objek Wisata</h3>
            <p class="mb-6" style="color: #B77466;">Tambah, edit, atau hapus objek wisata untuk memperkaya destinasi wisata kami.</p>
            <div class="flex gap-3">
                <a href="{{ route('objek-wisata.index') }}" class="flex-1 text-center py-2 px-4 text-white font-semibold rounded-lg transition-all text-sm" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Semua
                </a>
                <a href="{{ route('objek-wisata.create') }}" class="flex-1 text-center py-2 px-4 text-white font-semibold rounded-lg transition-all text-sm" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    Tambah Baru
                </a>
            </div>
        </div>

        <!-- Paket Wisata Management -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">🎒</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Paket Wisata</h3>
            <p class="mb-6" style="color: #B77466;">Atur paket wisata dengan durasi, harga, dan kuota peserta yang sesuai.</p>
            <div class="flex gap-3">
                <a href="{{ route('paket-wisata.index') }}" class="flex-1 text-center py-2 px-4 text-white font-semibold rounded-lg transition-all text-sm" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Semua
                </a>
                <a href="{{ route('paket-wisata.create') }}" class="flex-1 text-center py-2 px-4 text-white font-semibold rounded-lg transition-all text-sm" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    Tambah Baru
                </a>
            </div>
        </div>

        <!-- Penginapan Management -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">🏨</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Penginapan</h3>
            <p class="mb-6" style="color: #B77466;">Kelola data penginapan, fasilitas, harga, dan ketersediaan kamar.</p>
            <div class="flex gap-3">
                <a href="{{ route('penginapan.index') }}" class="flex-1 text-center py-2 px-4 text-white font-semibold rounded-lg transition-all text-sm" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Semua
                </a>
                <a href="{{ route('penginapan.create') }}" class="flex-1 text-center py-2 px-4 text-white font-semibold rounded-lg transition-all text-sm" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    Tambah Baru
                </a>
            </div>
        </div>

        <!-- Berita Management -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">📰</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Berita</h3>
            <p class="mb-6" style="color: #B77466;">Kelola berita, update informasi, dan komunikasi dengan pengunjung.</p>
            <div class="flex gap-3">
                <a href="{{ route('berita.index') }}" class="flex-1 text-center py-2 px-4 text-white font-semibold rounded-lg transition-all text-sm" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Semua
                </a>
                <a href="{{ route('berita.create') }}" class="flex-1 text-center py-2 px-4 text-white font-semibold rounded-lg transition-all text-sm" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    Buat Berita
                </a>
            </div>
        </div>
    </div>

    <!-- Additional Admin Actions -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">📊 Kelola Sistem</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <!-- Reservasi Management -->
        <div class="p-8 rounded-2xl hover:scale-105 transition-transform duration-300 border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">📅 Kelola Reservasi</h3>
            <p class="mb-6" style="color: #B77466;">Pantau, ubah, atau batalkan reservasi dari pelanggan.</p>
            <a href="{{ route('reservasi.index') }}" class="inline-block px-6 py-3 text-white font-semibold rounded-lg transition-all duration-300" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Kelola Reservasi →
            </a>
        </div>

        <!-- Profile Management -->
        <div class="p-8 rounded-2xl hover:scale-105 transition-transform duration-300 border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">👤 Profil Admin</h3>
            <p class="mb-6" style="color: #B77466;">Update informasi profil dan pengaturan akun Anda.</p>
            <a href="{{ route('profile.edit') }}" class="inline-block px-6 py-3 text-white font-semibold rounded-lg transition-all duration-300" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Edit Profil →
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    @if($recentReservasi->count() > 0)
    <h2 class="text-3xl font-outfit font-bold mb-8 mt-16" style="color: #957C62;">📋 Aktivitas Terbaru</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
        <!-- Recent Reservasi -->
        <div class="p-8 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <h3 class="text-2xl font-outfit font-bold mb-6" style="color: #957C62;">🎒 Reservasi Terbaru</h3>
            <div class="space-y-4">
                @foreach($recentReservasi->take(5) as $r)
                <div class="border-b pb-4" style="border-color: #E2B59A;">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-semibold" style="color: #957C62;">{{ $r->pelanggan->user->name ?? 'N/A' }}</p>
                            <small style="color: #B77466;">{{ $r->paketWisata?->nama_paket ?? 'Paket Wisata' }}</small>
                        </div>
                        <span class="px-2 py-1 text-xs rounded font-semibold text-white" style="background-color: #B77466;">
                            {{ ucfirst($r->status) }}
                        </span>
                    </div>
                    <p class="text-sm font-semibold" style="color: #957C62;">Rp {{ number_format($r->total_harga, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
            <a href="{{ route('reservasi.index') }}" class="inline-block mt-4 text-sm font-semibold transition-all" style="color: #B77466;" onmouseover="this.style.color='#957C62'" onmouseout="this.style.color='#B77466'">
                Lihat Semua Reservasi →
            </a>
        </div>

        <!-- Recent Berita -->
        <div class="p-8 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <h3 class="text-2xl font-outfit font-bold mb-6" style="color: #957C62;">📰 Berita Terbaru</h3>
            <div class="space-y-4">
                @foreach($recentBerita->take(5) as $berita)
                <div class="border-b pb-4" style="border-color: #E2B59A;">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-semibold line-clamp-1" style="color: #957C62;">{{ $berita->judul }}</p>
                            <small style="color: #B77466;">{{ $berita->user->name ?? 'Staff' }}</small>
                        </div>
                    </div>
                    <p class="text-xs" style="color: #B77466;">{{ $berita->created_at->format('d M Y H:i') }}</p>
                </div>
                @endforeach
            </div>
            <a href="{{ route('berita.index') }}" class="inline-block mt-4 text-sm font-semibold transition-all" style="color: #B77466;" onmouseover="this.style.color='#957C62'" onmouseout="this.style.color='#B77466'">
                Lihat Semua Berita →
            </a>
        </div>
    </div>
    @endif

    <!-- User Breakdown -->
    <h2 class="text-3xl font-outfit font-bold mb-8 mt-16" style="color: #957C62;">👥 Breakdown User</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">👤</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalCustomers }}</h3>
            <p class="font-semibold" style="color: #B77466;">Pelanggan</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">👨‍💼</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalManagers }}</h3>
            <p class="font-semibold" style="color: #B77466;">Manager</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">👨‍💻</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalStaff }}</h3>
            <p class="font-semibold" style="color: #B77466;">Staff</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">📊</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalBerita }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Berita</p>
        </div>
    </div>

    <!-- Reservation Status -->
    <h2 class="text-3xl font-outfit font-bold mb-8 mt-16" style="color: #957C62;">📊 Status Reservasi</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">⏳</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $pendingReservasi }}</h3>
            <p class="font-semibold" style="color: #B77466;">Pending</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">✅</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $confirmedReservasi }}</h3>
            <p class="font-semibold" style="color: #B77466;">Confirmed</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">💰</div>
            <h3 class="text-2xl font-outfit font-bold" style="color: #957C62;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Revenue</p>
        </div>
    </div>
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

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

    @media (max-width: 768px) {
        .text-6xl {
            font-size: 2.5rem;
        }
        
        .text-5xl {
            font-size: 2rem;
        }
        
        .text-3xl {
            font-size: 1.875rem;
        }

        .text-2xl {
            font-size: 1.5rem;
        }
    }
</style>

@endsection
