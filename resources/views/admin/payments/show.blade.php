@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Status Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold" style="color: #957C62;">🔍 Verifikasi Pembayaran</h1>
                <p class="text-sm md:text-base mt-2" style="color: #B77466;">Periksa dan verifikasi bukti pembayaran dari customer</p>
            </div>
            <div style="background-color: white; border: 3px solid #E2B59A; padding: 1rem; border-radius: 0.75rem;">
                <p class="text-xs font-semibold" style="color: #B77466;">ID PEMBAYARAN</p>
                <p class="text-2xl font-bold" style="color: #957C62;">#{{ $payment->id }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Payment Details -->
            <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <h2 class="text-2xl font-bold mb-6" style="color: #957C62;">💳 Detail Pembayaran</h2>

                <div class="space-y-4">
                    <!-- Amount -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-xs font-semibold" style="color: #B77466;">💰 Jumlah Pembayaran</p>
                        <p class="text-3xl font-bold" style="color: #B77466;">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                    </div>

                    <!-- Method -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-xs font-semibold" style="color: #B77466;">📤 Metode Pembayaran</p>
                        <p class="text-lg font-semibold" style="color: #957C62;">
                            @if($payment->method === 'bank_transfer')
                                🏦 Transfer Bank
                            @elseif($payment->method === 'qris')
                                📱 QRIS
                            @else
                                {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                            @endif
                        </p>
                    </div>

                    <!-- Status -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-xs font-semibold" style="color: #B77466;">📊 Status</p>
                        <div class="mt-2">
                            @switch($payment->status)
                                @case('pending')
                                    <span class="inline-block px-4 py-2 rounded-lg text-white font-bold" style="background-color: #FFC107;">⏳ Menunggu Verifikasi</span>
                                    @break
                                @case('paid')
                                    <span class="inline-block px-4 py-2 rounded-lg text-white font-bold" style="background-color: #28A745;">✅ Sudah Dikonfirmasi</span>
                                    @break
                                @case('failed')
                                    <span class="inline-block px-4 py-2 rounded-lg text-white font-bold" style="background-color: #DC3545;">❌ Ditolak</span>
                                    @break
                                @case('refunded')
                                    <span class="inline-block px-4 py-2 rounded-lg text-white font-bold" style="background-color: #6C757D;">🔄 Refunded</span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                            <p class="text-xs font-semibold" style="color: #B77466;">📅 Waktu Upload</p>
                            <p class="font-semibold" style="color: #957C62;">{{ $payment->created_at->format('d M Y H:i') }} WIB</p>
                        </div>

                        @if($payment->paid_at)
                            <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                                <p class="text-xs font-semibold" style="color: #B77466;">✅ Waktu Konfirmasi</p>
                                <p class="font-semibold" style="color: #957C62;">{{ $payment->paid_at->format('d M Y H:i') }} WIB</p>
                            </div>
                        @endif
                    </div>

                    <!-- Transaction ID -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-xs font-semibold" style="color: #B77466;">🔐 No. Transaksi</p>
                        <p class="font-semibold break-all" style="color: #957C62;">{{ $payment->transaction_id }}</p>
                    </div>
                </div>
            </div>

            <!-- Proof File -->
            @if($payment->proof_path)
                <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                    <h2 class="text-2xl font-bold mb-6" style="color: #957C62;">📸 Bukti Pembayaran</h2>
                    
                    <div class="rounded-lg overflow-hidden" style="background-color: #FFE1AF; padding: 1rem; text-align: center;">
                        @php
                            $ext = pathinfo($payment->proof_path, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <!-- Image Preview -->
                            <img src="{{ asset('storage/'.$payment->proof_path) }}" alt="Bukti Pembayaran" class="max-w-full h-auto rounded-lg" style="max-height: 400px; margin: 0 auto;">
                        @else
                            <!-- PDF or other files -->
                            <div style="padding: 2rem;">
                                <svg class="w-16 h-16 mx-auto mb-3" style="color: #B77466;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <p class="font-semibold" style="color: #957C62;">{{ ucfirst($ext) }} File</p>
                                <p class="text-sm" style="color: #B77466;">{{ basename($payment->proof_path) }}</p>
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ asset('storage/'.$payment->proof_path) }}" target="_blank" class="inline-block px-6 py-2 text-white font-bold rounded-lg transition duration-150" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                                👁️ Buka File Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Verification Actions (only if pending) -->
            @if($payment->status === 'pending')
                <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                    <h2 class="text-2xl font-bold mb-6" style="color: #957C62;">✅ Verifikasi Pembayaran</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Approve -->
                        <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="w-full px-6 py-4 text-white font-bold rounded-lg transition duration-150 hover:scale-105" style="background-color: #28A745;" onmouseover="this.style.backgroundColor='#218838'" onmouseout="this.style.backgroundColor='#28A745'" onclick="return confirm('Konfirmasi pembayaran ini?')">
                                ✅ Konfirmasi Pembayaran
                            </button>
                        </form>

                        <!-- Reject -->
                        <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="w-full px-6 py-4 text-white font-bold rounded-lg transition duration-150 hover:scale-105" style="background-color: #DC3545;" onmouseover="this.style.backgroundColor='#C82333'" onmouseout="this.style.backgroundColor='#DC3545'" onclick="return confirm('Tolak pembayaran ini?')">
                                ❌ Tolak Pembayaran
                            </button>
                        </form>
                    </div>

                    <div class="mt-4 p-4 rounded-lg" style="background-color: #fff5e6; border-left: 4px solid #E2B59A;">
                        <p class="text-xs font-semibold mb-2" style="color: #957C62;">⚠️ Perhatian</p>
                        <ul class="text-sm space-y-1" style="color: #B77466;">
                            <li>✓ Pastikan bukti pembayaran cocok dengan nominal dan metode</li>
                            <li>✓ Cek tanggal transfer sesuai dengan yang dikirim</li>
                            <li>✓ Verifikasi nama pengirim jika diperlukan</li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar - Reservation & Customer Info -->
        <div class="lg:col-span-1">
            <div class="rounded-3xl p-6" style="background-color: white; border: 3px solid #E2B59A; position: sticky; top: 100px;">
                <h3 class="text-lg font-bold mb-4" style="color: #957C62;">📋 Info Reservasi</h3>

                <div class="space-y-4 pb-4 border-b" style="border-color: #E2B59A;">
                    <div>
                        <p class="text-xs font-semibold" style="color: #B77466;">ID Reservasi</p>
                        <a href="{{ route('reservasi.show', $payment->reservasi) }}" class="font-semibold" style="color: #B77466; text-decoration: underline;">
                            #{{ $payment->reservasi->id }}
                        </a>
                    </div>
                    <div>
                        <p class="text-xs font-semibold" style="color: #B77466;">Status</p>
                        <p class="font-semibold" style="color: #957C62;">
                            @switch($payment->reservasi->status)
                                @case('pending')
                                    ⏳ Pending (Menunggu Verifikasi)
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
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold" style="color: #B77466;">Tanggal Kunjungan</p>
                        <p class="font-semibold" style="color: #957C62;">{{ $payment->reservasi->tanggal_kunjungan->format('d M Y') }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-bold mb-4 mt-6" style="color: #957C62;">👤 Info Customer</h3>

                <div class="space-y-4 pb-4 border-b" style="border-color: #E2B59A;">
                    <div>
                        <p class="text-xs font-semibold" style="color: #B77466;">Nama</p>
                        <p class="font-semibold" style="color: #957C62;">{{ $payment->reservasi->pelanggan->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold" style="color: #B77466;">Email</p>
                        <p class="font-semibold break-all" style="color: #957C62;">{{ $payment->reservasi->pelanggan->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold" style="color: #B77466;">No. Telepon</p>
                        <p class="font-semibold" style="color: #957C62;">{{ $payment->reservasi->pelanggan->telepon ?? '-' }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-bold mb-4 mt-6" style="color: #957C62;">💰 Ringkasan</h3>

                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span style="color: #B77466;">Total Pembayaran</span>
                        <span style="color: #957C62;" class="font-bold">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span style="color: #B77466;">Paket</span>
                        <span style="color: #957C62;" class="font-bold">{{ $payment->reservasi->paketWisata->nama_paket ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t" style="border-color: #E2B59A;">
                    <a href="{{ route('reservasi.show', $payment->reservasi) }}" class="block w-full px-4 py-2 text-white font-bold rounded-lg text-center transition duration-150" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                        👁️ Lihat Reservasi Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
