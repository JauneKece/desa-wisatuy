@extends('layouts.app')

@section('title', 'Reservasi Saya - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2" style="color: #957C62;">📅 Daftar Reservasi</h1>
                <p class="text-sm md:text-base" style="color: #B77466;">Kelola dan pantau semua reservasi wisata Anda</p>
            </div>
            @if (auth()->check() && auth()->user()->role === 'pelanggan')
                <a href="{{ route('reservasi.create') }}" class="inline-block w-full md:w-auto px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105 text-center" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">➕ Buat Reservasi Baru</a>
            @endif
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Total Reservasi -->
            <div class="group p-6 rounded-2xl text-center transition-all duration-300 hover:shadow-lg hover:scale-105" style="background: linear-gradient(135deg, #FFE1AF 0%, #FFF9F0 100%); border: 3px solid #E2B59A; box-shadow: 0 2px 8px rgba(183, 116, 102, 0.1);">
                <div class="text-4xl mb-3 transform transition-transform group-hover:scale-110">📋</div>
                <p class="text-4xl font-bold mb-2" style="color: #B77466;">{{ $reservasi->total() }}</p>
                <p class="text-base font-semibold" style="color: #957C62;">Total Reservasi</p>
                <div class="mt-3 h-1 bg-gradient-to-r" style="background: linear-gradient(90deg, #B77466, #E2B59A);"></div>
            </div>

            <!-- Pending -->
            <div class="group p-6 rounded-2xl text-center transition-all duration-300 hover:shadow-lg hover:scale-105" style="background: linear-gradient(135deg, #FFF8DC 0%, #FFFACD 100%); border: 3px solid #FFC107; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.2);">
                <div class="text-4xl mb-3 transform transition-transform group-hover:scale-110">⏳</div>
                <p class="text-4xl font-bold mb-2" style="color: #FFC107;">{{ $reservasi->where('status', 'pending')->count() }}</p>
                <p class="text-base font-semibold" style="color: #957C62;">Menunggu Verifikasi</p>
                <div class="mt-3 h-1 bg-gradient-to-r" style="background: linear-gradient(90deg, #FFC107, #FFB300);"></div>
            </div>

            <!-- Confirmed -->
            <div class="group p-6 rounded-2xl text-center transition-all duration-300 hover:shadow-lg hover:scale-105" style="background: linear-gradient(135deg, #E8F5E9 0%, #F1F8E9 100%); border: 3px solid #28A745; box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);">
                <div class="text-4xl mb-3 transform transition-transform group-hover:scale-110">✅</div>
                <p class="text-4xl font-bold mb-2" style="color: #28A745;">{{ $reservasi->where('status', 'confirmed')->count() }}</p>
                <p class="text-base font-semibold" style="color: #957C62;">Dikonfirmasi</p>
                <div class="mt-3 h-1 bg-gradient-to-r" style="background: linear-gradient(90deg, #28A745, #20C997);"></div>
            </div>
        </div>
    </div>

    <!-- Responsive Table Container -->
    <div class="rounded-3xl border-3 overflow-x-auto" style="border-color: #E2B59A; background-color: white; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        @if ($reservasi->count() > 0)
            <table class="w-full text-sm md:text-base">
                <thead>
                    <tr style="background-color: #FFE1AF; border-bottom: 3px solid #E2B59A;">
                        <th class="px-4 py-3 text-left font-bold" style="color: #957C62;">📅 Tanggal</th>
                        <th class="px-4 py-3 text-left font-bold" style="color: #957C62;">👥 Peserta</th>
                        <th class="px-4 py-3 text-left font-bold hidden md:table-cell" style="color: #957C62;">🎒 Paket</th>
                        <th class="px-4 py-3 text-left font-bold hidden lg:table-cell" style="color: #957C62;">🏨 Penginapan</th>
                        <th class="px-4 py-3 text-right font-bold" style="color: #957C62;">💰 Harga</th>
                        <th class="px-4 py-3 text-center font-bold" style="color: #957C62;">📊 Status</th>
                        <th class="px-4 py-3 text-center font-bold" style="color: #957C62;">⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservasi as $item)
                        <tr style="border-bottom: 1px solid #FFE1AF;" class="hover:bg-yellow-50 transition">
                            <td class="px-4 py-3" style="color: #B77466;">
                                <span class="font-semibold">{{ $item->tanggal_kunjungan->format('d M') }}</span>
                                <div class="text-xs" style="color: #B77466;">{{ $item->tanggal_kunjungan->format('Y') }}</div>
                            </td>
                            <td class="px-4 py-3" style="color: #B77466;">
                                <span class="font-semibold">{{ $item->jumlah_peserta }}</span> orang
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell" style="color: #B77466;">{{ $item->paketWisata->nama_paket ?? '—' }}</td>
                            <td class="px-4 py-3 hidden lg:table-cell" style="color: #B77466;">{{ $item->penginapan->nama_penginapan ?? '—' }}</td>
                            <td class="px-4 py-3 text-right font-bold" style="color: #957C62;">
                                Rp{{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold text-white"
                                    style="@switch($item->status)
                                        @case('pending') background-color: #FFC107; @break
                                        @case('confirmed') background-color: #28A745; @break
                                        @case('cancelled') background-color: #DC3545; @break
                                        @default background-color: #999;
                                    @endswitch">
                                    @switch($item->status)
                                        @case('pending')
                                            ⏳ Pending
                                            @break
                                        @case('confirmed')
                                            ✅ Confirmed
                                            @break
                                        @case('cancelled')
                                            ❌ Cancelled
                                            @break
                                    @endswitch
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col gap-2 justify-center items-center">
                                    <a href="{{ route('reservasi.show', $item) }}" class="px-3 py-1 text-white text-xs font-bold rounded transition-all w-full text-center" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                                        👁️ Lihat
                                    </a>
                                    @if (auth()->user()->role === 'pelanggan' && $item->status === 'pending' && $item->pelanggan->user_id === auth()->user()->id)
                                        <a href="{{ route('reservasi.edit', $item) }}" class="px-3 py-1 text-white text-xs font-bold rounded transition-all w-full text-center" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('reservasi.destroy', $item) }}" method="POST" style="width: 100%;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-3 py-1 text-white text-xs font-bold rounded transition-all" style="background-color: #d32f2f;" onmouseover="this.style.backgroundColor='#b71c1c'" onmouseout="this.style.backgroundColor='#d32f2f'" onclick="return confirm('Yakin ingin menghapus?')">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    @elseif (in_array(auth()->user()->role, ['admin', 'manager']))
                                        <a href="{{ route('reservasi.edit', $item) }}" class="px-3 py-1 text-white text-xs font-bold rounded transition-all w-full text-center" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                                            ✏️ Edit
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <div style="color: #B77466;">
                                    <p class="text-4xl mb-3">📭</p>
                                    <p class="text-lg font-semibold">Belum ada reservasi</p>
                                    <p class="text-sm mt-2">Mulai lakukan reservasi untuk menikmati pengalaman wisata yang luar biasa!</p>
                                    @if (auth()->check() && auth()->user()->role === 'pelanggan')
                                        <a href="{{ route('reservasi.create') }}" class="inline-block mt-4 px-6 py-2 text-white font-bold rounded-lg transition duration-150" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                                            ➕ Buat Reservasi Sekarang
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="p-4" style="background-color: white; border-top: 1px solid #E2B59A;">
                {{ $reservasi->links() }}
            </div>
        @else
            <div class="text-center py-12" style="background-color: white;">
                <div style="color: #B77466;">
                    <p class="text-4xl mb-3">📭</p>
                    <p class="text-lg font-semibold">Belum ada reservasi</p>
                    <p class="text-sm mt-2">Mulai lakukan reservasi untuk menikmati pengalaman wisata yang luar biasa!</p>
                    @if (auth()->check() && auth()->user()->role === 'pelanggan')
                        <a href="{{ route('reservasi.create') }}" class="inline-block mt-4 px-6 py-2 text-white font-bold rounded-lg transition duration-150" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            ➕ Buat Reservasi Sekarang
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Help Section -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="rounded-lg p-4" style="background-color: white; border-left: 4px solid #B77466;">
            <p class="font-bold mb-2" style="color: #957C62;">❓ Bagaimana cara membuat reservasi?</p>
            <p class="text-sm" style="color: #B77466;">Klik tombol "Buat Reservasi Baru", pilih paket dan tanggal yang Anda inginkan, lalu lanjutkan ke pembayaran.</p>
        </div>
        <div class="rounded-lg p-4" style="background-color: white; border-left: 4px solid #B77466;">
            <p class="font-bold mb-2" style="color: #957C62;">💳 Bagaimana cara membayar?</p>
            <p class="text-sm" style="color: #B77466;">Setelah membuat reservasi, Anda dapat mentransfer melalui bank atau QRIS. Upload bukti pembayaran untuk verifikasi.</p>
        </div>
        <div class="rounded-lg p-4" style="background-color: white; border-left: 4px solid #B77466;">
            <p class="font-bold mb-2" style="color: #957C62;">⏱️ Berapa lama verifikasi?</p>
            <p class="text-sm" style="color: #B77466;">Pembayaran Anda akan diverifikasi dalam 1-2 jam kerja. Anda akan menerima notifikasi via email.</p>
        </div>
    </div>
</div>
@endsection
