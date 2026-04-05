@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - Desmok')

@section('content')
<div class="container-responsive py-8 md:py-12">
    <!-- Welcome Section -->
    <div class="mb-12 animate-slide-in">
        <h1 class="text-5xl md:text-6xl font-outfit font-black mb-2" style="color: #957C62;">👤 Dashboard Pelanggan</h1>
        <p class="text-xl" style="color: #B77466;">Kelola reservasi dan jelajahi paket wisata Anda</p>
    </div>

    <div class="w-20 h-1 mb-12" style="background-color: #E2B59A;"></div>

    <!-- Welcome Card -->
    <div class="p-8 mb-12 rounded-3xl border-3 overflow-hidden" style="background-color: #FFE1AF; border-color: #B77466;">
        <h2 class="text-3xl font-outfit font-bold mb-3" style="color: #957C62;">👋 Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="text-lg" style="color: #B77466; line-height: 1.6;">
            Nikmati pengalaman wisata yang tak terlupakan bersama kami di Desa Jomok. Jelajahi destinasi menakjubkan, pesan paket wisata favorit Anda, dan ciptakan kenangan indah bersama keluarga dan teman-teman.
        </p>
    </div>

    <!-- Reservation Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">📅</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalReservasi }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Reservasi</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">⏳</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $pendingReservasi }}</h3>
            <p class="font-semibold" style="color: #B77466;">Menunggu Konfirmasi</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">✅</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $confirmedReservasi }}</h3>
            <p class="font-semibold" style="color: #B77466;">Dikonfirmasi</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">💰</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Pengeluaran</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Status Reservasi -->
        <div class="group animate-slide-in">
            <div class="p-6 text-center hover:scale-110 transition-transform duration-300 h-full rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #B77466;">
                <div class="text-5xl mb-3 inline-block">📝</div>
                <h3 class="text-2xl font-outfit font-bold mb-1" style="color: #957C62;">Reservasi Pending</h3>
                <p class="font-semibold" style="color: #957C62;">{{ $pendingReservasi }}</p>
                <p class="text-sm mt-2" style="color: #B77466;">Reservasi menunggu konfirmasi</p>
                <a href="{{ route('reservasi.index') }}" class="inline-block mt-4 px-4 py-2 text-white rounded-lg transition-all text-sm font-semibold" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Detail →
                </a>
            </div>
        </div>

        <!-- Profil Saya -->
        <div class="group animate-slide-in">
            <div class="p-6 text-center hover:scale-110 transition-transform duration-300 h-full rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #B77466;">
                <div class="text-5xl mb-3 inline-block">👤</div>
                <h3 class="text-2xl font-outfit font-bold mb-1" style="color: #957C62;">Profil Saya</h3>
                <p class="font-semibold" style="color: #957C62;">{{ auth()->user()->email }}</p>
                <p class="text-sm mt-2" style="color: #B77466;">Kelola informasi pribadi Anda</p>
                <a href="{{ route('profile.edit') }}" class="inline-block mt-4 px-4 py-2 text-white rounded-lg transition-all text-sm font-semibold" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Edit Profil →
                </a>
            </div>
        </div>

        <!-- Paket Unggulan -->
        <div class="group animate-slide-in">
            <div class="p-6 text-center hover:scale-110 transition-transform duration-300 h-full rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #B77466;">
                <div class="text-5xl mb-3 inline-block">🎒</div>
                <h3 class="text-2xl font-outfit font-bold mb-1" style="color: #957C62;">Paket Unggulan</h3>
                <p class="font-semibold" style="color: #957C62;">Pilihan Terbaik</p>
                <p class="text-sm mt-2" style="color: #B77466;">Temukan paket wisata impian Anda</p>
                <a href="{{ route('paket-wisata.index') }}" class="inline-block mt-4 px-4 py-2 text-white rounded-lg transition-all text-sm font-semibold" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Jelajahi →
                </a>
            </div>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <!-- Buat Reservasi Baru -->
        <div class="group animate-slide-in">
            <div class="p-8 h-full hover:scale-105 transition-transform duration-300 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #B77466;">
                <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                    <span class="text-3xl">📅</span>
                </div>
                <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Buat Reservasi Baru</h3>
                <p class="mb-6" style="color: #B77466;">
                    Pesan paket wisata dan penginapan favorit Anda dengan mudah. Lihat ketersediaan, harga, dan fasilitas lengkap untuk pengalaman terbaik.
                </p>
                <a href="{{ route('reservasi.create') }}" class="inline-block px-6 py-3 text-white font-semibold rounded-lg transition-all duration-300 w-full text-center" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Buat Sekarang →
                </a>
            </div>
        </div>

        <!-- Kelola Reservasi -->
        <div class="group animate-slide-in">
            <div class="p-8 h-full hover:scale-105 transition-transform duration-300 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #B77466;">
                <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                    <span class="text-3xl">📋</span>
                </div>
                <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Kelola Reservasi</h3>
                <p class="mb-6" style="color: #B77466;">
                    Lihat status reservasi Anda, ubah jadwal, tambah aktivitas, atau batalkan sesuai kebutuhan Anda dengan mudah.
                </p>
                <a href="{{ route('reservasi.index') }}" class="inline-block px-6 py-3 text-white font-semibold rounded-lg transition-all duration-300 w-full text-center" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Lihat Semua Reservasi →
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Reservasi -->
    @if($recentReservasi->count() > 0)
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">📋 Reservasi Terakhir Anda</h2>
    
    <div class="grid grid-cols-1 gap-6 mb-12">
        @foreach($recentReservasi as $r)
        <div class="p-6 hover:shadow-lg transition-all rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-start gap-3 mb-3">
                        <span class="text-3xl">🎒</span>
                        <div>
                            <h4 class="font-semibold mb-1" style="color: #957C62;">{{ $r->paketWisata?->nama_paket ?? 'Paket Wisata' }}</h4>
                            <small style="color: #B77466;">
                                Penginapan: {{ $r->penginapan?->nama_penginapan ?? '-' }}
                            </small>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <div>
                            <span style="color: #B77466;">📅 Tanggal Kunjung: </span>
                            <span class="font-semibold" style="color: #957C62;">{{ $r->tanggal_kunjungan->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span style="color: #B77466;">👥 Peserta: </span>
                            <span class="font-semibold" style="color: #957C62;">{{ $r->jumlah_peserta }} orang</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold mb-2" style="color: #957C62;">Rp {{ number_format($r->total_harga, 0, ',', '.') }}</p>
                    @php
                        $statusBg = match($r->status) {
                            'pending' => 'bg-[#E2B59A]',
                            'confirmed' => 'bg-[#B77466]',
                            'completed' => 'bg-[#957C62]',
                            default => 'bg-[#B77466]',
                        };
                    @endphp
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold text-white {{ $statusBg }}">
                        {{ ucfirst($r->status) }}
                    </span>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('reservasi.show', $r->id) }}" class="inline-block px-3 py-1 text-white text-xs rounded transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            Lihat
                        </a>
                        @if($r->status === 'pending')
                        <a href="{{ route('reservasi.edit', $r->id) }}" class="inline-block px-3 py-1 text-white text-xs rounded transition-all" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                            Edit
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="p-12 text-center mb-12 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
        <p class="text-lg mb-4" style="color: #B77466;">Anda belum memiliki reservasi</p>
        <a href="{{ route('reservasi.create') }}" class="inline-block px-6 py-3 text-white font-semibold rounded-lg transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
            Buat Reservasi Pertama Anda →
        </a>
    </div>
    @endif

    <!-- Featured Packages -->
    @if($featuredPaket->count() > 0)
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">🎒 Paket Wisata Unggulan</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        @foreach($featuredPaket as $paket)
        <div class="p-6 hover:shadow-lg transition-all hover:scale-105 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">🎒</div>
            <h4 class="font-bold mb-2 line-clamp-2" style="color: #957C62;">{{ $paket->nama_paket }}</h4>
            <p class="text-sm mb-3" style="color: #B77466;">{{ Str::limit($paket->deskripsi, 60) }}</p>
            <div class="mb-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span style="color: #B77466;">⏱️ Durasi:</span>
                    <span class="font-semibold" style="color: #957C62;">{{ $paket->durasi_hari }} hari</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span style="color: #B77466;">💰 Harga:</span>
                    <span class="font-bold" style="color: #957C62;">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</span>
                </div>
            </div>
            <a href="{{ route('paket-wisata.show', $paket->id) }}" class="inline-block w-full text-center px-4 py-2 text-white rounded transition-all text-sm font-semibold" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Lihat Detail →
            </a>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Featured Accommodations -->
    @if($featuredPenginapan->count() > 0)
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">🏨 Penginapan Pilihan</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($featuredPenginapan as $penginapan)
        <div class="p-6 hover:shadow-lg transition-all hover:scale-105 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">🏨</div>
            <h4 class="font-bold mb-2 line-clamp-2" style="color: #957C62;">{{ $penginapan->nama_penginapan }}</h4>
            <p class="text-sm mb-3" style="color: #B77466;">{{ Str::limit($penginapan->deskripsi, 60) }}</p>
            <div class="mb-4 space-y-2">
                <div class="flex justify-between text-sm overflow-hidden">
                    <span style="color: #B77466;">📍 Lokasi:</span>
                    <span class="font-semibold text-right" style="color: #957C62;">{{ Str::limit($penginapan->alamat, 15) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span style="color: #B77466;">💰 Tarif:</span>
                    <span class="font-bold" style="color: #957C62;">Rp {{ number_format($penginapan->harga_penginapan, 0, ',', '.') }}/malam</span>
                </div>
            </div>
            <a href="{{ route('penginapan.show', $penginapan->id) }}" class="inline-block w-full text-center px-4 py-2 text-white rounded transition-all text-sm font-semibold" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Lihat Detail →
            </a>
        </div>
        @endforeach
    </div>
    @endif
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
