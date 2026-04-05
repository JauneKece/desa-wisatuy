@extends('layouts.app')

@section('title', 'Lihat Reservasi - Desmok')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <!-- Status Header -->
    <div class="mb-8 p-6 rounded-2xl text-center" style="background-color: white; border: 3px solid #E2B59A;">
        @switch($reservasi->status)
            @case('pending')
                <div class="inline-block p-3 rounded-full mb-3" style="background-color: #FFE1AF;">
                    <span class="text-4xl">⏳</span>
                </div>
                <h2 class="text-2xl font-bold mb-2" style="color: #957C62;">Menunggu Verifikasi Pembayaran</h2>
                <p class="text-sm" style="color: #B77466;">Silakan lakukan pengiriman bukti pembayaran untuk melanjutkan</p>
                @break

            @case('confirmed')
                <div class="inline-block p-3 rounded-full mb-3" style="background-color: #B77466;">
                    <span class="text-4xl text-white">✅</span>
                </div>
                <h2 class="text-2xl font-bold mb-2" style="color: #957C62;">Reservasi Disetujui</h2>
                <p class="text-sm" style="color: #B77466;">Pembayaran Anda sudah dikonfirmasi, bersiaplah untuk pengalaman wisata yang luar biasa!</p>
                @break

            @case('cancelled')
                <div class="inline-block p-3 rounded-full mb-3" style="background-color: #dc3545;">
                    <span class="text-4xl text-white">❌</span>
                </div>
                <h2 class="text-2xl font-bold mb-2" style="color: #957C62;">Dibatalkan</h2>
                <p class="text-sm" style="color: #B77466;">Reservasi ini telah dibatalkan</p>
                @break
        @endswitch
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Reservation Details -->
            <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <h3 class="text-2xl font-bold mb-6 flex items-center" style="color: #957C62;">
                    <span class="inline-block w-8 h-8 rounded-full text-white text-center mr-3 text-sm font-bold" style="background-color: #B77466;">1</span>
                    Paket & Akomodasi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Paket Wisata -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">🎒 Paket Wisata</p>
                        <p class="text-lg font-semibold mb-2" style="color: #B77466;">{{ $reservasi->paketWisata->nama_paket ?? '—' }}</p>
                        @if($reservasi->paketWisata)
                            <p class="text-sm" style="color: #B77466;">Harga: <span class="font-bold">Rp{{ number_format($reservasi->paketWisata->harga_paket, 0, ',', '.') }}</span></p>
                        @endif
                    </div>

                    <!-- Penginapan -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">🏨 Penginapan</p>
                        <p class="text-lg font-semibold mb-2" style="color: #B77466;">{{ $reservasi->penginapan->nama_penginapan ?? '—' }}</p>
                        @if($reservasi->penginapan)
                            <p class="text-sm" style="color: #B77466;">Harga: <span class="font-bold">Rp{{ number_format($reservasi->penginapan->harga_penginapan, 0, ',', '.') }}/malam</span></p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Visit Details -->
            <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <h3 class="text-2xl font-bold mb-6 flex items-center" style="color: #957C62;">
                    <span class="inline-block w-8 h-8 rounded-full text-white text-center mr-3 text-sm font-bold" style="background-color: #B77466;">2</span>
                    Detail Kunjungan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal Kunjungan -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">📅 Tanggal Kunjungan</p>
                        <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->tanggal_kunjungan->format('d M Y') }}</p>
                        <p class="text-sm" style="color: #B77466;">{{ $reservasi->tanggal_kunjungan->translatedFormat('l') }}</p>
                    </div>

                    <!-- Jumlah Peserta -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">👥 Jumlah Pengunjung</p>
                        <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->jumlah_peserta }} orang</p>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if ($reservasi->catatan)
                <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                    <p class="text-sm font-bold mb-3" style="color: #957C62;">📝 Catatan</p>
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p style="color: #957C62; white-space: pre-line;">{{ $reservasi->catatan }}</p>
                    </div>
                </div>
            @endif

            <!-- Customer Info -->
            <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <p class="text-sm font-bold mb-3" style="color: #957C62;">👤 Data Pelanggan</p>
                <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                    <p class="font-semibold" style="color: #957C62;">{{ $reservasi->pelanggan->user->name }}</p>
                        <p class="text-sm" style="color: #B77466;">{{ $reservasi->pelanggan->telepon ?? '—' }}</p>
                    <p class="text-sm" style="color: #B77466;">{{ $reservasi->pelanggan->user->email ?? '—' }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 mb-6">
                <a href="{{ route('reservasi.index') }}" 
                   class="px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" 
                   style="background-color: #957C62;"
                   onmouseover="this.style.backgroundColor='#7A5F4A'"
                   onmouseout="this.style.backgroundColor='#957C62'">
                    ← Kembali ke Daftar
                </a>

                @if ($reservasi->status === 'pending' && auth()->check())
                    @if (auth()->user()->role === 'customer' && $reservasi->pelanggan->user_id === auth()->user()->id)
                        <a href="{{ route('reservasi.edit', $reservasi) }}" 
                           class="px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" 
                           style="background-color: #B77466;"
                           onmouseover="this.style.backgroundColor='#957C62'"
                           onmouseout="this.style.backgroundColor='#B77466'">
                            ✏️ Edit
                        </a>
                    @elseif (in_array(auth()->user()->role, ['admin', 'manager']))
                        <a href="{{ route('reservasi.edit', $reservasi) }}" 
                           class="px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" 
                           style="background-color: #B77466;"
                           onmouseover="this.style.backgroundColor='#957C62'"
                           onmouseout="this.style.backgroundColor='#B77466'">
                            ✏️ Edit
                        </a>
                    @endif
                @elseif ($reservasi->status === 'pending' && in_array(auth()->user()->role, ['admin', 'manager']))
                    <a href="{{ route('reservasi.edit', $reservasi) }}" 
                       class="px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" 
                       style="background-color: #B77466;"
                       onmouseover="this.style.backgroundColor='#957C62'"
                       onmouseout="this.style.backgroundColor='#B77466'">
                        ✏️ Edit
                    </a>
                @endif

                @if ($reservasi->status === 'pending' && auth()->check() && (auth()->user()->role === 'customer' && $reservasi->pelanggan->user_id === auth()->user()->id))
                    <form action="{{ route('reservasi.destroy', $reservasi) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" 
                                style="background-color: #DC3545;"
                                onmouseover="this.style.backgroundColor='#C82333'"
                                onmouseout="this.style.backgroundColor='#DC3545'"
                                onclick="return confirm('Yakin ingin menghapus reservasi ini?')">
                            🗑️ Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Sidebar: Summary & Payment Info -->
        <div class="lg:col-span-1">
            <!-- Total Price & Status -->
            <div class="rounded-3xl p-6 mb-6" style="background-color: white; border: 3px solid #E2B59A; position: sticky; top: 100px;">
                <h3 class="text-lg font-bold mb-4" style="color: #957C62;">💰 Ringkasan & Pembayaran</h3>

                <!-- Total Price -->
                <div class="bg-gradient-to-r p-4 rounded-lg mb-6 text-center" style="background: linear-gradient(135deg, #FFE1AF 0%, #E2B59A 100%);">
                    <p class="text-xs font-semibold" style="color: #957C62;">TOTAL HARGA</p>
                    <p class="text-2xl font-bold" style="color: #B77466;">Rp{{ number_format($reservasi->total_harga, 0, ',', '.') }}</p>
                </div>

                <!-- Status Badge -->
                <div class="mb-4">
                    <p class="text-xs font-semibold mb-2" style="color: #B77466;">STATUS</p>
                    <div class="inline-block px-4 py-2 rounded-full text-white font-bold" style="@switch($reservasi->status) @case('pending') background-color: #FFC107; @break @case('confirmed') background-color: #28A745; @break @case('cancelled') background-color: #DC3545; @break @endswitch">
                        @switch($reservasi->status)
                            @case('pending')
                                ⏳ Pending
                                @break
                            @case('confirmed')
                                ✅ Disetujui
                                @break
                            @case('cancelled')
                                ❌ Dibatalkan
                                @break
                        @endswitch
                    </div>
                </div>

                <!-- Payment Info -->
                @if ($reservasi->status === 'pending')
                    <div class="p-4 rounded-lg" style="background-color: #FFF9F0; border-left: 4px solid #E2B59A;">
                        <p class="text-xs font-semibold mb-2" style="color: #957C62;">Langkah Selanjutnya</p>
                        <ol class="text-xs space-y-2" style="color: #B77466;">
                            <li>1️⃣ Lakukan pembayaran sesuai total harga</li>
                            <li>2️⃣ Unggah bukti pembayaran</li>
                            <li>3️⃣ Tim kami akan verifikasi dalam 1-2 jam</li>
                        </ol>
                    </div>

                    @if (auth()->check() && auth()->user()->role === 'customer')
                        <div class="mt-4">
                            <a href="{{ route('reservasi.show', $reservasi) }}/payment/manual" class="block w-full px-6 py-3 text-white font-bold rounded-lg text-center transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                                💳 Lanjut ke Pembayaran
                            </a>
                        </div>
                    @endif
                @elseif ($reservasi->status === 'confirmed')
                    <div class="p-4 rounded-lg" style="background-color: #f1f8e9; border-left: 4px solid #689F38;">
                        <p class="text-xs font-semibold mb-2" style="color: #33691e;">✅ Pembayaran Dikonfirmasi</p>
                        <p class="text-xs" style="color: #558b2f;">Terima kasih telah melakukan pembayaran. Tim kami siap melayani wisata Anda!</p>
                    </div>
                @endif

                <!-- Reservation ID -->
                <div class="mt-6 p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                    <p class="text-xs font-semibold mb-1" style="color: #B77466;">NO. RESERVASI</p>
                    <p class="text-sm font-bold" style="color: #957C62;">#{{ $reservasi->id }}</p>
                </div>

                <!-- Dates -->
                <div class="mt-3 p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                    <p class="text-xs font-semibold mb-1" style="color: #B77466;">DIBUAT</p>
                    <p class="text-sm" style="color: #957C62;">{{ $reservasi->tanggal_reservasi->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
