@extends('layouts.app')

@section('title', 'Detail Reservasi - Admin - Desmok')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <!-- Status Header -->
    <div class="mb-8 p-6 rounded-2xl text-center" style="background-color: white; border: 3px solid #E2B59A;">
        @switch($reservasi->status)
            @case('pending')
                <div class="inline-block p-3 rounded-full mb-3" style="background-color: #FFE1AF;">
                    <span class="text-4xl">⏳</span>
                </div>
                <h2 class="text-2xl font-bold mb-2" style="color: #957C62;">Menunggu Verifikasi Pembayaran</h2>
                <p class="text-sm" style="color: #B77466;">Pelanggan sudah mengirimkan bukti pembayaran namun belum diverifikasi</p>
                @break

            @case('confirmed')
                <div class="inline-block p-3 rounded-full mb-3" style="background-color: #B77466;">
                    <span class="text-4xl text-white">✅</span>
                </div>
                <h2 class="text-2xl font-bold mb-2" style="color: #957C62;">Reservasi Disetujui</h2>
                <p class="text-sm" style="color: #B77466;">Pembayaran sudah diverifikasi dan reservasi dikonfirmasi</p>
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
            
            <!-- Reservation Details Section -->
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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

                    <!-- Tanggal Reservasi -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">📅 Tanggal Reservasi</p>
                        <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->tanggal_reservasi->format('d M Y') }}</p>
                    </div>

                    <!-- Nomor Reservasi -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">🔢 ID Reservasi</p>
                        <p class="text-lg font-semibold" style="color: #B77466;">#{{ $reservasi->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if ($reservasi->catatan)
                <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                    <p class="text-sm font-bold mb-3" style="color: #957C62;">📝 Catatan Pelanggan</p>
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p style="color: #957C62; white-space: pre-line;">{{ $reservasi->catatan }}</p>
                    </div>
                </div>
            @endif

            <!-- Customer Information -->
            <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <h3 class="text-2xl font-bold mb-6 flex items-center" style="color: #957C62;">
                    <span class="inline-block w-8 h-8 rounded-full text-white text-center mr-3 text-sm font-bold" style="background-color: #B77466;">3</span>
                    👤 Data Pelanggan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">Nama</p>
                        <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->pelanggan->user->name }}</p>
                    </div>
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">Email</p>
                        <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->pelanggan->user->email }}</p>
                    </div>
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">Nomor Telepon</p>
                        <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->pelanggan->nomor_telepon ?? '—' }}</p>
                    </div>
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">Alamat</p>
                        <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->pelanggan->alamat ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment & Pricing Section -->
            <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <h3 class="text-2xl font-bold mb-6 flex items-center" style="color: #957C62;">
                    <span class="inline-block w-8 h-8 rounded-full text-white text-center mr-3 text-sm font-bold" style="background-color: #B77466;">4</span>
                    💰 Detail Pembayaran
                </h3>

                <!-- Price Breakdown -->
                <div class="mb-6 p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                    <h4 class="font-bold mb-4" style="color: #957C62;">Rincian Harga:</h4>
                    <div class="space-y-2">
                        @if($reservasi->paketWisata)
                            <div class="flex justify-between" style="color: #B77466;">
                                <span>{{ $reservasi->paketWisata->nama_paket }} ({{ $reservasi->jumlah_peserta }} × Rp{{ number_format($reservasi->paketWisata->harga_paket, 0, ',', '.') }})</span>
                                <span class="font-bold">Rp{{ number_format($reservasi->paketWisata->harga_paket * $reservasi->jumlah_peserta, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        @if($reservasi->penginapan)
                            <div class="flex justify-between" style="color: #B77466;">
                                <span>{{ $reservasi->penginapan->nama_penginapan }} ({{ $reservasi->jumlah_peserta }} × Rp{{ number_format($reservasi->penginapan->harga_penginapan, 0, ',', '.') }})</span>
                                <span class="font-bold">Rp{{ number_format($reservasi->penginapan->harga_penginapan * $reservasi->jumlah_peserta, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="border-t-2 pt-2 mt-2 flex justify-between font-bold" style="color: #957C62; border-color: #E2B59A;">
                            <span>TOTAL</span>
                            <span style="color: #B77466;">Rp{{ number_format($reservasi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                @php
                    $latestPayment = $reservasi->payments()->latest()->first();
                @endphp
                @if($latestPayment)
                    <div class="mb-6">
                        <h4 class="font-bold mb-3" style="color: #957C62;">Status Pembayaran:</h4>
                        <div class="p-4 rounded-lg" style="background-color: #FFF9F0; border-left: 4px solid #E2B59A;">
                            <div class="flex justify-between items-center mb-3">
                                <span style="color: #B77466;">Metode:</span>
                                <span class="font-bold" style="color: #957C62;">{{ ucfirst($latestPayment->method) }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <span style="color: #B77466;">Jumlah:</span>
                                <span class="font-bold" style="color: #957C62;">Rp{{ number_format($latestPayment->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span style="color: #B77466;">Status Pembayaran:</span>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold text-white"
                                    style="@switch($latestPayment->status)
                                        @case('pending') background-color: #FFC107; @break
                                        @case('paid') background-color: #28A745; @break
                                        @case('failed') background-color: #DC3545; @break
                                        @default background-color: #999;
                                    @endswitch">
                                    @switch($latestPayment->status)
                                        @case('pending')
                                            ⏳ Pending
                                            @break
                                        @case('paid')
                                            ✅ Paid
                                            @break
                                        @case('failed')
                                            ❌ Failed
                                            @break
                                    @endswitch
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Proof (if uploaded) -->
                    @if($latestPayment->proof_path)
                        <div class="mb-6">
                            <h4 class="font-bold mb-3" style="color: #957C62;">Bukti Pembayaran:</h4>
                            <div class="p-4 rounded-lg" style="background-color: white; border: 2px solid #E2B59A;">
                                @php
                                    $ext = pathinfo($latestPayment->proof_path, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <img src="{{ asset('storage/'.$latestPayment->proof_path) }}" alt="Bukti Pembayaran" class="max-w-full h-auto rounded-lg" style="max-height: 400px;">
                                @else
                                    <div class="p-4 rounded-lg text-center" style="background-color: #FFE1AF;">
                                        <p class="mb-2">📄 File: {{ basename($latestPayment->proof_path) }}</p>
                                        <a href="{{ asset('storage/'.$latestPayment->proof_path) }}" target="_blank" class="inline-block px-4 py-2 text-white font-bold rounded-lg transition duration-150" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                                            📥 Download File
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Admin Verification Actions -->
                        @if($latestPayment->status === 'pending')
                            <div class="p-4 rounded-lg" style="background-color: #FFF3E0; border-left: 4px solid #FF9800;">
                                <p class="text-sm font-bold mb-3" style="color: #957C62;">⚠️ Tindakan Admin Diperlukan</p>
                                <p class="text-sm mb-4" style="color: #B77466;">Verifikasi bukti pembayaran dan pilih tindakan:</p>
                                <div class="flex gap-2 flex-wrap">
                                    <form action="{{ route('admin.payments.verify', $latestPayment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="px-4 py-2 text-white font-bold rounded-lg transition duration-150" style="background-color: #28A745;" onmouseover="this.style.backgroundColor='#218838'" onmouseout="this.style.backgroundColor='#28A745'" onclick="return confirm('Terima pembayaran ini dan konfirmasi reservasi?')">
                                            ✅ Terima Pembayaran
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.payments.verify', $latestPayment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="px-4 py-2 text-white font-bold rounded-lg transition duration-150" style="background-color: #dc3545;" onmouseover="this.style.backgroundColor='#c82333'" onmouseout="this.style.backgroundColor='#dc3545'" onclick="return confirm('Tolak pembayaran ini? Status akan kembali ke pending.')">
                                            ❌ Tolak Pembayaran
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @elseif($latestPayment->status === 'paid')
                            <div class="p-4 rounded-lg" style="background-color: #E8F5E9; border-left: 4px solid #4CAF50;">
                                <p class="text-sm font-bold" style="color: #2E7D32;">✅ Pembayaran Sudah Diverifikasi</p>
                                <p class="text-xs mt-2" style="color: #558B2F;">Tanggal Verifikasi: {{ $latestPayment->paid_at?->format('d M Y H:i') ?? '—' }}</p>
                            </div>
                        @elseif($latestPayment->status === 'failed')
                            <div class="p-4 rounded-lg" style="background-color: #FFEBEE; border-left: 4px solid #f44336;">
                                <p class="text-sm font-bold" style="color: #c62828;">❌ Pembayaran Ditolak</p>
                                <p class="text-xs mt-2" style="color: #b71c1c;">Pelanggan perlu mengunggah ulang bukti pembayaran</p>
                            </div>
                        @endif
                    @endif
                @endif
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

                @if ($reservasi->status !== 'cancelled')
                    <a href="{{ route('reservasi.edit', $reservasi) }}" 
                       class="px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" 
                       style="background-color: #B77466;"
                       onmouseover="this.style.backgroundColor='#957C62'"
                       onmouseout="this.style.backgroundColor='#B77466'">
                        ✏️ Edit
                    </a>
                @endif

                <form action="{{ route('reservasi.destroy', $reservasi) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" 
                            style="background-color: #d32f2f;"
                            onmouseover="this.style.backgroundColor='#b71c1c'"
                            onmouseout="this.style.backgroundColor='#d32f2f'"
                            onclick="return confirm('Yakin ingin menghapus reservasi ini? Tindakan ini tidak dapat dibatalkan.')">
                        🗑️ Hapus Reservasi
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar: Summary Card -->
        <div class="lg:col-span-1">
            <div class="rounded-3xl p-6 mb-6" style="background-color: white; border: 3px solid #E2B59A; position: sticky; top: 100px; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <h3 class="text-lg font-bold mb-4" style="color: #957C62;">📊 Ringkasan</h3>

                <!-- Total Price -->
                <div class="bg-gradient-to-r p-4 rounded-lg mb-6 text-center" style="background: linear-gradient(135deg, #FFE1AF 0%, #E2B59A 100%);">
                    <p class="text-xs font-semibold" style="color: #957C62;">TOTAL HARGA</p>
                    <p class="text-2xl font-bold" style="color: #B77466;">Rp{{ number_format($reservasi->total_harga, 0, ',', '.') }}</p>
                </div>

                <!-- Status Badge -->
                <div class="mb-4">
                    <p class="text-xs font-semibold mb-2" style="color: #B77466;">STATUS RESERVASI</p>
                    <div class="inline-block px-4 py-2 rounded-full text-white font-bold" style="@switch($reservasi->status) @case('pending') background-color: #FFC107; @break @case('confirmed') background-color: #28A745; @break @case('completed') background-color: #007BFF; @break @case('cancelled') background-color: #DC3545; @break @endswitch">
                        @switch($reservasi->status)
                            @case('pending')
                                ⏳ Pending
                                @break
                            @case('confirmed')
                                ✅ Disetujui
                                @break
                            @case('completed')
                                🎉 Selesai
                                @break
                            @case('cancelled')
                                ❌ Dibatalkan
                                @break
                        @endswitch
                    </div>
                </div>

                <!-- Payment Status -->
                @php
                    $latestPayment = $reservasi->payments()->latest()->first();
                @endphp
                @if($latestPayment)
                    <div>
                        <p class="text-xs font-semibold mb-2" style="color: #B77466;">STATUS PEMBAYARAN</p>
                        <div class="inline-block px-4 py-2 rounded-full text-white font-bold text-sm" style="@switch($latestPayment->status) @case('pending') background-color: #FFC107; @break @case('paid') background-color: #28A745; @break @case('failed') background-color: #DC3545; @break @endswitch">
                            @switch($latestPayment->status)
                                @case('pending')
                                    ⏳ Pending
                                    @break
                                @case('paid')
                                    ✅ Paid
                                    @break
                                @case('failed')
                                    ❌ Failed
                                    @break
                            @endswitch
                        </div>
                    </div>
                @endif

                <!-- Info Box -->
                <div class="mt-6 p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                    <p class="text-xs font-bold mb-3" style="color: #957C62;">ℹ️ Informasi</p>
                    <div class="text-xs space-y-2" style="color: #B77466;">
                        <div>
                            <p class="font-semibold" style="color: #957C62;">Peserta:</p>
                            <p>{{ $reservasi->jumlah_peserta }} orang</p>
                        </div>
                        <div>
                            <p class="font-semibold" style="color: #957C62;">Kunjungan:</p>
                            <p>{{ $reservasi->tanggal_kunjungan->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
