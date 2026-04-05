@extends('layouts.app')

@section('title', 'Dashboard Bendahara - Desmok')

@section('content')
<div class="container-responsive py-8 md:py-12">
    <!-- Header -->
    <div class="mb-12 animate-slide-in">
        <h1 class="text-5xl md:text-6xl font-outfit font-black mb-2" style="color: #957C62;">💰 Dashboard Bendahara</h1>
        <p class="text-xl" style="color: #B77466;">Kelola pembayaran, reservasi, dan analisa revenue wisata</p>
    </div>

    <div class="w-20 h-1 mb-12" style="background-color: #E2B59A;"></div>

    <!-- Welcome Card -->
    <div class="p-8 mb-12 rounded-3xl border-3 overflow-hidden" style="background-color: #FFE1AF; border-color: #B77466;">
        <h2 class="text-3xl font-outfit font-bold mb-3" style="color: #957C62;">👋 Selamat Datang, Bendahara {{ auth()->user()->name }}!</h2>
        <p class="text-lg" style="color: #B77466;">Kelola pembayaran reservasi, verifikasi bukti transfer, pantau reservasi pelanggan, dan analisai revenue dari setiap transaksi wisata. Anda bertanggung jawab atas aspek keuangan dan pembayaran dalam sistem DESMOK.</p>
    </div>

    <!-- Payment Statistics -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">💳 Statistik Pembayaran</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">💳</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalPayments ?? 0 }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Pembayaran</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">⏳</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $pendingPayments ?? 0 }}</h3>
            <p class="font-semibold" style="color: #B77466;">Tertunda</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">✅</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $approvedPayments ?? 0 }}</h3>
            <p class="font-semibold" style="color: #B77466;">Dikonfirmasi</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">❌</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $rejectedPayments ?? 0 }}</h3>
            <p class="font-semibold" style="color: #B77466;">Ditolak</p>
        </div>
    </div>

    <!-- Reservation Statistics -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">📋 Statistik Reservasi</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">📋</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $totalReservasi ?? 0 }}</h3>
            <p class="font-semibold" style="color: #B77466;">Total Reservasi</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">🔄</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $pendingReservasi ?? 0 }}</h3>
            <p class="font-semibold" style="color: #B77466;">Pending</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">✔️</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $confirmedReservasi ?? 0 }}</h3>
            <p class="font-semibold" style="color: #B77466;">Terkonfirmasi</p>
        </div>

        <div class="p-6 text-center hover:scale-110 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="text-4xl mb-3">🚫</div>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">{{ $cancelledReservasi ?? 0 }}</h3>
            <p class="font-semibold" style="color: #B77466;">Dibatalkan</p>
        </div>
    </div>

    <!-- Revenue Analysis -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">💵 Analisa Revenue</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="text-4xl mb-3">📈</div>
            <p class="text-sm font-semibold mb-2" style="color: #B77466;">Total Revenue</p>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
            <p class="text-xs mt-2" style="color: #B77466;">Dari reservasi terkonfirmasi</p>
        </div>

        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="text-4xl mb-3">📅</div>
            <p class="text-sm font-semibold mb-2" style="color: #B77466;">Revenue Bulan Ini</p>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">Rp {{ number_format($revenueThisMonth ?? 0, 0, ',', '.') }}</h3>
            <p class="text-xs mt-2" style="color: #B77466;">{{ now()->format('F Y') }}</p>
        </div>

        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="text-4xl mb-3">⏱️</div>
            <p class="text-sm font-semibold mb-2" style="color: #B77466;">Revenue Tertunda</p>
            <h3 class="text-3xl font-outfit font-bold" style="color: #957C62;">Rp {{ number_format($pendingRevenue ?? 0, 0, ',', '.') }}</h3>
            <p class="text-xs mt-2" style="color: #B77466;">Menunggu dikonfirmasi</p>
        </div>
    </div>

    <!-- Main Functions -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">🛠️ Fungsi Utama</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <!-- Payment Management -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">💳</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Kelola Pembayaran</h3>
            <p class="mb-3" style="color: #B77466;">{{ $pendingPayments ?? 0 }} pembayaran menunggu verifikasi</p>
            <p class="mb-6" style="color: #B77466;">Verifikasi dan kelola pembayaran dari pelanggan untuk reservasi mereka.</p>
            <a href="{{ route('admin.payments.index') }}" class="inline-block w-full text-center py-3 px-6 text-white font-semibold rounded-lg transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Kelola Pembayaran →
            </a>
        </div>

        <!-- Reservation Management -->
        <div class="p-8 hover:scale-105 transition-transform duration-300 rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="flex items-center justify-center w-16 h-16 rounded-lg mb-4" style="background-color: #E2B59A;">
                <span class="text-3xl">📋</span>
            </div>
            <h3 class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">Kelola Reservasi</h3>
            <p class="mb-3" style="color: #B77466;">{{ $pendingReservasi ?? 0 }} reservasi menunggu konfirmasi</p>
            <p class="mb-6" style="color: #B77466;">Pantau dan kelola semua reservasi pelanggan untuk analisa revenue.</p>
            <a href="{{ route('admin.reservasi.index') }}" class="inline-block w-full text-center py-3 px-6 text-white font-semibold rounded-lg transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                Kelola Reservasi →
            </a>
        </div>
    </div>

    <!-- Recent Confirmed Reservasi -->
    @if($confirmedReservasiDetail && $confirmedReservasiDetail->count() > 0)
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">✅ Reservasi Terkonfirmasi Terbaru</h2>
    
    <div class="grid grid-cols-1 gap-6 mb-12">
        @foreach($confirmedReservasiDetail as $reservasi)
        <div class="p-6 hover:shadow-lg transition-all rounded-2xl border-3 animate-slide-in" style="background-color: #FFE1AF; border-color: #E2B59A;">
            <div class="flex flex-col md:flex-row gap-6 md:items-center">
                <div class="flex-1">
                    <div class="flex items-start gap-3 mb-3">
                        <span class="text-3xl">✅</span>
                        <div>
                            <h4 class="font-bold mb-1" style="color: #957C62;">
                                {{ $reservasi->pelanggan?->user->name ?? 'Customer' }} - 
                                {{ $reservasi->paketWisata?->nama_paket ?? 'Paket Custom' }}
                            </h4>
                            <div class="flex flex-wrap gap-2 items-center text-sm" style="color: #B77466;">
                                <span class="inline-block px-2 py-1 rounded" style="background-color: #E2B59A; color: #957C62;">
                                    {{ $reservasi->status }}
                                </span>
                                <span>•</span>
                                <span>{{ $reservasi->jumlah_peserta }} peserta</span>
                                <span>•</span>
                                <span>{{ \Carbon\Carbon::parse($reservasi->tanggal_kunjungan)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm mb-2" style="color: #B77466;">
                        <strong>Paket:</strong> {{ $reservasi->paketWisata?->nama_paket ?? '-' }}
                        {{ $reservasi->penginapan ? '+ ' . $reservasi->penginapan->nama_penginapan : '' }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-outfit font-bold mb-3" style="color: #957C62;">
                        Rp {{ number_format($reservasi->total_harga ?? 0, 0, ',', '.') }}
                    </p>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.reservasi.show', $reservasi->id) }}" class="px-4 py-2 text-white rounded transition-all text-sm font-semibold" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            Lihat Detail
                        </a>
                        @if($reservasi->payment)
                        <a href="{{ route('admin.payments.show', $reservasi->payment->id) }}" class="px-4 py-2 text-white rounded transition-all text-sm font-semibold" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                            Lihat Pembayaran
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Recent All Reservasi -->
    <h2 class="text-3xl font-outfit font-bold mb-8" style="color: #957C62;">📋 Semua Reservasi Terbaru</h2>
    
    <div class="overflow-x-auto mb-12">
        <table class="w-full border-collapse">
            <thead>
                <tr style="background-color: #FFE1AF; border-bottom: 3px solid #B77466;">
                    <th class="px-6 py-4 text-left" style="color: #957C62;">Pelanggan</th>
                    <th class="px-6 py-4 text-left" style="color: #957C62;">Paket</th>
                    <th class="px-6 py-4 text-center" style="color: #957C62;">Peserta</th>
                    <th class="px-6 py-4 text-left" style="color: #957C62;">Tanggal Kunjungan</th>
                    <th class="px-6 py-4 text-right" style="color: #957C62;">Total</th>
                    <th class="px-6 py-4 text-center" style="color: #957C62;">Status</th>
                    <th class="px-6 py-4 text-center" style="color: #957C62;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentReservasi as $reservasi)
                <tr style="border-bottom: 2px solid #E2B59A;">
                    <td class="px-6 py-4" style="color: #B77466;">{{ $reservasi->pelanggan?->user->name ?? 'Guest' }}</td>
                    <td class="px-6 py-4" style="color: #B77466;">{{ $reservasi->paketWisata?->nama_paket ?? 'Custom' }}</td>
                    <td class="px-6 py-4 text-center" style="color: #B77466;">{{ $reservasi->jumlah_peserta }}</td>
                    <td class="px-6 py-4" style="color: #B77466;">{{ \Carbon\Carbon::parse($reservasi->tanggal_kunjungan)->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right font-bold" style="color: #957C62;">Rp {{ number_format($reservasi->total_harga ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($reservasi->status === 'confirmed')
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold text-white" style="background-color: #25a561;">
                                {{ ucfirst($reservasi->status) }}
                            </span>
                        @elseif($reservasi->status === 'cancelled')
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold text-white" style="background-color: #dc3545;">
                                {{ ucfirst($reservasi->status) }}
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold text-white" style="background-color: #ffc107;">
                                {{ ucfirst($reservasi->status) }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.reservasi.show', $reservasi->id) }}" class="text-white text-sm font-semibold px-3 py-1 rounded transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            Lihat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center" style="color: #B77466;">Belum ada reservasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
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

    @media (max-width: 768px) {
        .text-5xl {
            font-size: 2.5rem;
        }
        
        .text-3xl {
            font-size: 1.875rem;
        }

        table {
            font-size: 0.875rem;
        }

        table th, table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

@endsection

