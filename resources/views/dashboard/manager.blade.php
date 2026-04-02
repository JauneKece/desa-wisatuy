@extends('layouts.app')

@section('title', 'Dashboard Manager - Desmok')

@section('content')
<div class="container-responsive py-8 md:py-12">
    <!-- Header -->
    <div class="mb-12 animate-slide-in">
        <h1 class="text-5xl md:text-6xl font-outfit font-black mb-2" style="color: #957C62;">👨‍⚙️ Dashboard Manager</h1>
        <p class="text-xl" style="color: #B77466;">Kelola operasional wisata dan reservasi pelanggan</p>
    </div>

    <div class="w-20 h-1 mb-12" style="background-color: #E2B59A;"></div>

    <!-- Welcome Card -->
    <div class="p-8 mb-12 rounded-3xl border-3 overflow-hidden" style="background-color: #FFE1AF; border-color: #B77466;">
        <h2 class="text-3xl font-outfit font-bold mb-3" style="color: #957C62;">👋 Selamat Datang, Manager {{ auth()->user()->name }}!</h2>
        <p class="text-lg" style="color: #B77466;">Pantau operasional wisata, kelola reservasi, dan atur paket serta penginapan dengan mudah.</p>
    </div>

    <!-- Key Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">📅</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalReservasi }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Reservasi</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">⏳</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $pendingReservasi }}</h3>
            <p class="font-semibold" style="color: #B77466;">Pending</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">✅</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $confirmedReservasi }}</h3>
            <p class="font-semibold" style="color: #B77466;">Confirmed</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">💰</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Revenue</p>
        </div>
    </div>

    <!-- Monthly Revenue Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <div class="p-8 rounded-2xl border-3 overflow-hidden animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <h3 class="text-2xl font-outfit font-bold mb-2" style="color: #957C62;">💵 Revenue Bulan Ini</h3>
            <p class="text-3xl font-bold" style="color: #957C62;">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</p>
            <p class="mt-2" style="color: #B77466;">Pendapatan dari reservasi yang telah dikonfirmasi</p>
        </div>

        <div class="p-8 rounded-2xl border-3 overflow-hidden animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <h3 class="text-2xl font-outfit font-bold mb-2" style="color: #957C62;">📊 Rata-rata Tingkat Konversi</h3>
            <p class="text-3xl font-bold" style="color: #957C62;">{{ $totalReservasi > 0 ? intval((($confirmedReservasi + $pendingReservasi) / $totalReservasi) * 100) : 0 }}%</p>
            <p class="mt-2" style="color: #B77466;">Persentase reservasi yang aktif dibanding total</p>
        </div>
    </div>

    <!-- Management Sections -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">🛠️ Kelola Operasional</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <!-- Reservasi Management -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">📅</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Kelola Reservasi</h3>
            <p class="mb-3" style="color: #B77466;">🔴 {{ $pendingReservasi }} Pending | ✅ {{ $confirmedReservasi }} Confirmed</p>
            <p class="mb-6" style="color: #B77466;">Lihat, konfirmasi, dan kelola status reservasi pelanggan.</p>
            <a href="{{ route('reservasi.index') }}" class="inline-block w-full text-center py-3 px-6 text-white font-semibold rounded-lg transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Kelola Reservasi →
            </a>
        </div>

        <!-- Paket Wisata Management -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">🎒</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Paket Wisata</h3>
            <p class="mb-3" style="color: #B77466;">📦 {{ $totalPaketWisata }} Paket Tersedia</p>
            <p class="mb-6" style="color: #B77466;">Atur paket wisata dengan durasi, harga, dan kuota peserta.</p>
            <div class="flex gap-3">
                <a href="{{ route('paket-wisata.index') }}" class="flex-1 text-center py-3 px-4 text-white font-semibold rounded-lg transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Semua
                </a>
                <a href="{{ route('paket-wisata.create') }}" class="flex-1 text-center py-3 px-4 text-white font-semibold rounded-lg transition-all" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    Tambah Paket
                </a>
            </div>
        </div>

        <!-- Objek Wisata Management -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">🏞️</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Objek Wisata</h3>
            <p class="mb-3" style="color: #B77466;">🌍 {{ $totalObjekWisata }} Destinasi</p>
            <p class="mb-6" style="color: #B77466;">Tambah, edit, atau hapus objek wisata yang tersedia.</p>
            <div class="flex gap-3">
                <a href="{{ route('objek-wisata.index') }}" class="flex-1 text-center py-3 px-4 text-white font-semibold rounded-lg transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Semua
                </a>
                <a href="{{ route('objek-wisata.create') }}" class="flex-1 text-center py-3 px-4 text-white font-semibold rounded-lg transition-all" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    Tambah Objek
                </a>
            </div>
        </div>

        <!-- Penginapan Management -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">🏨</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Penginapan</h3>
            <p class="mb-3" style="color: #B77466;">🛏️ {{ $totalPenginapan }} Penginapan</p>
            <p class="mb-6" style="color: #B77466;">Kelola data penginapan, fasilitas, harga, dan ketersediaan.</p>
            <div class="flex gap-3">
                <a href="{{ route('penginapan.index') }}" class="flex-1 text-center py-3 px-4 text-white font-semibold rounded-lg transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Semua
                </a>
                <a href="{{ route('penginapan.create') }}" class="flex-1 text-center py-3 px-4 text-white font-semibold rounded-lg transition-all" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    Tambah
                </a>
            </div>
        </div>
    </div>

    <!-- Pending Reservasi Details -->
    @if($pendingReservasi > 0)
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">⏳ Reservasi Menunggu Persetujuan</h2>
    
    <div class="p-8 rounded-2xl border-3 mb-12 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2" style="border-color: #E2B59A;">
                        <th class="text-left py-3 px-4" style="color: #957C62;">No</th>
                        <th class="text-left py-3 px-4" style="color: #957C62;">Pelanggan</th>
                        <th class="text-left py-3 px-4" style="color: #957C62;">Paket</th>
                        <th class="text-left py-3 px-4" style="color: #957C62;">Tanggal Kunjung</th>
                        <th class="text-left py-3 px-4" style="color: #957C62;">Total Harga</th>
                        <th class="text-left py-3 px-4" style="color: #957C62;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingReservasiDetail as $key => $r)
                    <tr class="border-b" style="border-color: #FFE1AF;">
                        <td class="py-3 px-4" style="color: #957C62;">{{ $key + 1 }}</td>
                        <td class="py-3 px-4">
                            <div class="font-semibold" style="color: #957C62;">{{ $r->pelanggan->user->name ?? 'N/A' }}</div>
                            <small style="color: #B77466;">{{ $r->pelanggan->telepon ?? '' }}</small>
                        </td>
                        <td class="py-3 px-4" style="color: #957C62;">{{ $r->paketWisata?->nama_paket ?? 'N/A' }}</td>
                        <td class="py-3 px-4" style="color: #957C62;">{{ $r->tanggal_kunjungan->format('d M Y') }}</td>
                        <td class="py-3 px-4 font-semibold" style="color: #957C62;">Rp {{ number_format($r->total_harga, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('reservasi.show', $r->id) }}" class="inline-block px-3 py-1 text-white text-sm rounded transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-6" style="color: #B77466;">Tidak ada reservasi pending</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Recent Reservasi -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">📋 Reservasi Terbaru</h2>
    
    <div class="grid grid-cols-1 gap-6 animate-slide-in">
        @forelse($recentReservasi->take(5) as $r)
        <div class="p-6 hover:shadow-lg transition-all rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-2xl">👤</span>
                        <div>
                            <h4 class="font-semibold" style="color: #957C62;">{{ $r->pelanggan->user->name ?? 'N/A' }}</h4>
                            <small style="color: #B77466;">{{ $r->pelanggan->telepon ?? 'N/A' }}</small>
                        </div>
                    </div>
                    <p class="mb-2" style="color: #B77466;">📦 {{ $r->paketWisata?->nama_paket ?? 'N/A' }}</p>
                    <p style="color: #B77466;">📅 {{ $r->tanggal_kunjungan->format('d M Y') }} | 👥 {{ $r->jumlah_peserta }} peserta</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold mb-2" style="color: #957C62;">Rp {{ number_format($r->total_harga, 0, ',', '.') }}</p>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold text-white" style="background-color: #B77466;">
                        {{ ucfirst($r->status) }}
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8">
            <p style="color: #B77466;">Belum ada reservasi</p>
        </div>
        @endforelse
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
    }
</style>

@endsection
