@extends('layouts.app')

@section('title', 'Status Pembayaran - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Status Header -->
    <div class="text-center mb-8 animate-fade-in">
        @switch($payment->status)
            @case('pending')
                <div class="inline-block p-4 rounded-full mb-4" style="background-color: #FFE1AF;">
                    <svg class="w-16 h-16" style="color: #E2B59A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-lg font-bold mb-2" style="color: #957C62;">⏳ Pembayaran Menunggu Verifikasi</p>
                <p class="text-sm" style="color: #B77466;">Kami sedang memverifikasi bukti pembayaran Anda</p>
                @break

            @case('paid')
                <div class="inline-block p-4 rounded-full mb-4" style="background-color: #B77466;">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-lg font-bold mb-2" style="color: #957C62;">✅ Pembayaran Berhasil</p>
                <p class="text-sm" style="color: #B77466;">Pembayaran Anda telah dikonfirmasi oleh admin</p>
                @break

            @case('failed')
                <div class="inline-block p-4 rounded-full mb-4" style="background-color: #dc3545;">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-lg font-bold mb-2" style="color: #957C62;">❌ Pembayaran Ditolak</p>
                <p class="text-sm" style="color: #B77466;">Mohon lakukan pembayaran ulang dengan bukti yang jelas</p>
                @break
        @endswitch
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Payment Details -->
            <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <h2 class="text-2xl font-bold mb-6" style="color: #957C62;">💳 Detail Pembayaran</h2>

                <div class="space-y-4">
                    <!-- Payment ID -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-xs font-semibold" style="color: #B77466;">ID Pembayaran</p>
                        <p class="text-lg font-semibold" style="color: #957C62;">#{{ $payment->id }}</p>
                    </div>

                    <!-- Amount -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-xs font-semibold" style="color: #B77466;">💰 Jumlah Pembayaran</p>
                        <p class="text-2xl font-bold" style="color: #B77466;">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                    </div>

                    <!-- Method & QRIS -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-xs font-semibold" style="color: #B77466;">📤 Metode Pembayaran</p>
                        <p class="text-lg font-semibold mb-3" style="color: #957C62;">
                            @if($payment->method === 'bank_transfer')
                                🏦 Transfer Bank Langsung
                            @elseif($payment->method === 'qris')
                                📱 QRIS
                            @else
                                {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                            @endif
                        </p>

                        @if($payment->method === 'bank_transfer')
                            <div class="mt-3 pt-3 border-t" style="border-color: #E2B59A;">
                                <p class="text-xs font-semibold mb-2" style="color: #B77466;">📋 Data Rekening Bank</p>
                                <div class="text-sm" style="color: #957C62;">
                                    <p><strong>Bank:</strong> BCA</p>
                                    <p><strong>Nama:</strong> Desa Wisata Jomok</p>
                                    <p><strong>No. Rekening:</strong> 1234567890</p>
                                </div>
                            </div>
                        @elseif($payment->method === 'qris')
                            <div class="mt-3 pt-3 border-t text-center" style="border-color: #E2B59A;">
                                <p class="text-xs font-semibold mb-3" style="color: #B77466;">📱 QRIS Code</p>
                                <div style="background: white; padding: 1rem; border-radius: 0.5rem;">
                                    {{-- Generate simple QRIS placeholder --}}
                                    <div class="inline-block p-4" style="background-color: #f0f0f0; border: 2px solid #ddd; border-radius: 0.5rem;">
                                        <svg width="150" height="150" style="display: inline-block;" viewBox="0 0 150 150">
                                            <!-- Placeholder QRIS pattern -->
                                            <rect x="10" y="10" width="130" height="130" fill="white" stroke="#333" stroke-width="2"/>
                                            <!-- Top-left position marker -->
                                            <rect x="20" y="20" width="30" height="30" fill="none" stroke="#333" stroke-width="2"/>
                                            <rect x="25" y="25" width="20" height="20" fill="#333"/>
                                            <!-- Top-right position marker -->
                                            <rect x="100" y="20" width="30" height="30" fill="none" stroke="#333" stroke-width="2"/>
                                            <rect x="105" y="25" width="20" height="20" fill="#333"/>
                                            <!-- Bottom-left position marker -->
                                            <rect x="20" y="100" width="30" height="30" fill="none" stroke="#333" stroke-width="2"/>
                                            <rect x="25" y="105" width="20" height="20" fill="#333"/>
                                            <!-- Random pattern in center -->
                                            <g fill="#333" opacity="0.7">
                                                <rect x="50" y="50" width="5" height="5"/>
                                                <rect x="60" y="55" width="5" height="5"/>
                                                <rect x="70" y="50" width="5" height="5"/>
                                                <rect x="55" y="70" width="5" height="5"/>
                                                <rect x="75" y="65" width="5" height="5"/>
                                                <rect x="65" y="85" width="5" height="5"/>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-xs mt-3" style="color: #B77466;">Scan QR code di atas untuk melakukan pembayaran</p>
                            </div>
                        @endif
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
                                    <span class="inline-block px-4 py-2 rounded-lg text-white font-bold" style="background-color: #28A745;">✅ Berhasil</span>
                                    @break
                                @case('failed')
                                    <span class="inline-block px-4 py-2 rounded-lg text-white font-bold" style="background-color: #DC3545;">❌ Ditolak</span>
                                    @break
                                @default
                                    <span class="inline-block px-4 py-2 rounded-lg text-white font-bold" style="background-color: #999;">{{ ucfirst($payment->status) }}</span>
                            @endswitch
                        </div>
                    </div>

                    <!-- Uploaded At -->
                    <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-xs font-semibold" style="color: #B77466;">🕐 Waktu Upload</p>
                        <p class="font-semibold" style="color: #957C62;">{{ $payment->created_at->format('d M Y H:i') }} WIB</p>
                    </div>

                    <!-- Proof File (only for customer - don't show to others) -->
                    @if($payment->proof_path && auth()->check() && (auth()->user()->role === 'customer' || auth()->user()->pelanggan?->reservasi?->first()?->id === $payment->reservasi_id || in_array(auth()->user()->role, ['admin', 'manager'])))
                        <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                            <p class="text-xs font-semibold mb-3" style="color: #B77466;">📸 Bukti Pembayaran</p>
                            <a href="{{ asset('storage/'.$payment->proof_path) }}" target="_blank" class="inline-block px-4 py-2 text-white font-bold rounded-lg transition duration-150" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                                👁️ Lihat Bukti
                            </a>
                        </div>
                    @endif

                    <!-- Transaction ID -->
                    @if($payment->transaction_id)
                        <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                            <p class="text-xs font-semibold" style="color: #B77466;">🔐 No. Transaksi</p>
                            <p class="font-semibold break-all" style="color: #957C62;">{{ $payment->transaction_id }}</p>
                        </div>
                    @endif
                </div>

                <!-- Status Messages -->
                @if($payment->status === 'pending')
                    <div class="mt-6 p-4 rounded-lg" style="background-color: #fff5e6; border-left: 4px solid #E2B59A;">
                        <p class="font-bold mb-2" style="color: #957C62;">⏱️ Waktu Verifikasi</p>
                        <p class="text-sm" style="color: #B77466;">Verifikasi biasanya memakan waktu 1-2 jam kerja. Anda akan menerima notifikasi email setelah pembayaran dikonfirmasi.</p>
                    </div>
                @elseif($payment->status === 'failed')
                    <div class="mt-6 p-4 rounded-lg" style="background-color: #ffebee; border-left: 4px solid #DC3545;">
                        <p class="font-bold mb-2" style="color: #c62828;">⚠️ Pembayaran Ditolak</p>
                        <p class="text-sm mb-3" style="color: #d32f2f;">Ada masalah dengan bukti pembayaran Anda. Mohon lakukan pembayaran ulang dengan bukti yang jelas dan terbaca.</p>
                    </div>

                    <!-- Re-upload form for failed payments -->
                    @if(auth()->check() && (auth()->user()->role === 'customer' || (auth()->user()->pelanggan && $payment->reservasi->id && $payment->reservasi->pelanggan->user_id === auth()->user()->id)))
                        <div class="mt-6 p-6 rounded-2xl" style="background-color: white; border: 3px solid #DC3545;">
                            <h3 class="text-xl font-bold mb-4" style="color: #957C62;">🔄 Unggah Ulang Bukti Pembayaran</h3>
                            
                            <form action="{{ route('payments.reupload', $payment) }}" method="POST" enctype="multipart/form-data" id="reuploadForm">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="block text-sm font-semibold mb-3" style="color: #B77466;">
                                        📸 Pilih Bukti Pembayaran Baru
                                    </label>
                                    
                                    <div class="border-2 border-dashed rounded-lg p-6 text-center transition cursor-pointer" 
                                        style="border-color: #DC3545; background-color: #fff5f5;"
                                        id="dropZone"
                                        onmouseover="this.style.backgroundColor='#ffebee'"
                                        onmouseout="this.style.backgroundColor='#fff5f5'">
                                        
                                        <input type="file" name="proof" id="proofInput" class="hidden" accept="image/*,.pdf" required>
                                        
                                        <div style="color: #DC3545;">
                                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            <p class="font-bold mb-1">Drag & drop bukti pembayaran di sini</p>
                                            <p class="text-sm">atau klik untuk memilih file (JPG, PNG, PDF - max 5MB)</p>
                                        </div>
                                        
                                        <p class="text-xs mt-3" style="color: #B77466;">
                                            💡 Pastikan bukti jelas terlihat, mencakup: tanggal, jumlah, jam transfer, nama bank
                                        </p>
                                    </div>
                                    
                                    <p class="text-xs mt-2" id="fileName" style="color: #957C62;"></p>
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit" 
                                        class="flex-1 px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105"
                                        style="background-color: #DC3545;"
                                        onmouseover="this.style.backgroundColor='#c82333'"
                                        onmouseout="this.style.backgroundColor='#DC3545'">
                                        ✅ Unggah Ulang
                                    </button>
                                    <button type="button"
                                        class="flex-1 px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105"
                                        style="background-color: #6C757D;"
                                        onmouseover="this.style.backgroundColor='#5a6268'"
                                        onmouseout="this.style.backgroundColor='#6C757D'"
                                        onclick="document.getElementById('reuploadForm').style.display='none'">
                                        ❌ Batal
                                    </button>
                                </div>
                            </form>
                        </div>

                        <script>
                            const dropZone = document.getElementById('dropZone');
                            const proofInput = document.getElementById('proofInput');
                            const fileName = document.getElementById('fileName');

                            // Click to select
                            dropZone.addEventListener('click', () => proofInput.click());

                            // Drag and drop
                            dropZone.addEventListener('dragover', (e) => {
                                e.preventDefault();
                                dropZone.style.backgroundColor = '#ffcccb';
                            });

                            dropZone.addEventListener('dragleave', () => {
                                dropZone.style.backgroundColor = '#fff5f5';
                            });

                            dropZone.addEventListener('drop', (e) => {
                                e.preventDefault();
                                const files = e.dataTransfer.files;
                                if (files.length > 0) {
                                    proofInput.files = files;
                                    updateFileName();
                                }
                                dropZone.style.backgroundColor = '#fff5f5';
                            });

                            // Update filename display
                            proofInput.addEventListener('change', updateFileName);

                            function updateFileName() {
                                if (proofInput.files.length > 0) {
                                    const file = proofInput.files[0];
                                    fileName.textContent = '✅ File dipilih: ' + file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)';
                                } else {
                                    fileName.textContent = '';
                                }
                            }

                            // Form validation
                            document.getElementById('reuploadForm').addEventListener('submit', function(e) {
                                if (!proofInput.files.length) {
                                    e.preventDefault();
                                    alert('Mohon pilih file bukti pembayaran terlebih dahulu');
                                    return;
                                }

                                const file = proofInput.files[0];
                                const maxSize = 5 * 1024 * 1024; // 5MB
                                
                                if (file.size > maxSize) {
                                    e.preventDefault();
                                    alert('Ukuran file terlalu besar. Maksimal 5MB.');
                                    return;
                                }

                                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'];
                                if (!allowedTypes.includes(file.type)) {
                                    e.preventDefault();
                                    alert('Tipe file tidak didukung. Gunakan JPG, PNG, GIF, WebP, atau PDF.');
                                    return;
                                }
                            });
                        </script>
                    @endif
                @elseif($payment->status === 'paid')
                    <div class="mt-6 p-4 rounded-lg" style="background-color: #f1f8e9; border-left: 4px solid #689F38;">
                        <p class="font-bold mb-2" style="color: #33691e;">✅ Pembayaran Dikonfirmasi</p>
                        <p class="text-sm" style="color: #558b2f;">Terima kasih telah melakukan pembayaran. Reservasi Anda telah dikonfirmasi dan siap diproses.</p>
                    </div>
                @endif
            </div>

            <!-- Action Buttons (Customer only) -->
            @if(auth()->check() && (auth()->user()->role === 'customer' || (auth()->user()->pelanggan && auth()->user()->pelanggan->reservasi->first()?->id === $payment->reservasi_id)))
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('reservasi.show', $payment->reservasi) }}" class="flex-1 px-6 py-3 text-white font-bold rounded-lg transition duration-150 text-center hover:scale-105" style="background-color: #957C62;" onmouseover="this.style.backgroundColor='#7A5F4A'" onmouseout="this.style.backgroundColor='#957C62'">
                        ← Lihat Reservasi
                    </a>
                    <a href="{{ route('reservasi.index') }}" class="flex-1 px-6 py-3 text-white font-bold rounded-lg transition duration-150 text-center hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                        📅 Daftar Reservasi
                    </a>
                </div>
            @endif
        </div>

        <!-- Sidebar Reservation Summary (Customer view only) -->
        @if(auth()->check() && (auth()->user()->role === 'customer' || (auth()->user()->pelanggan && auth()->user()->pelanggan->reservasi->first()?->id === $payment->reservasi_id)))
            <div class="lg:col-span-1">
                <div class="rounded-3xl p-6" style="background-color: white; border: 3px solid #E2B59A; position: sticky; top: 100px;">
                    <h3 class="text-lg md:text-xl font-bold mb-4" style="color: #957C62;">📋 Info Reservasi</h3>

                    <div class="space-y-4 border-b pb-4" style="border-color: #E2B59A;">
                        <div>
                            <p class="text-xs font-semibold" style="color: #B77466;">ID Reservasi</p>
                            <p class="font-semibold" style="color: #957C62;">#{{ $payment->reservasi->id }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold" style="color: #B77466;">Tanggal Kunjungan</p>
                            <p class="font-semibold" style="color: #957C62;">{{ $payment->reservasi->tanggal_kunjungan->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold" style="color: #B77466;">Paket Wisata</p>
                            <p class="font-semibold" style="color: #957C62;">{{ $payment->reservasi->paketWisata->nama_paket ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold" style="color: #B77466;">Jumlah Peserta</p>
                            <p class="font-semibold" style="color: #957C62;">{{ $payment->reservasi->jumlah_peserta }} orang</p>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t" style="border-color: #E2B59A;">
                        <div class="flex justify-between font-bold mb-3">
                            <span style="color: #957C62;">Total</span>
                            <span style="color: #B77466;">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
                        </div>

                        @if($payment->status === 'paid')
                            <div class="p-3 rounded-lg text-center" style="background-color: #f1f8e9; border-left: 4px solid #689F38;">
                                <p class="text-xs font-semibold" style="color: #33691e;">✅ Pembayaran Dikonfirmasi</p>
                                <p class="text-xs mt-1" style="color: #558b2f;">Reservasi Anda siap diproses</p>
                            </div>
                        @elseif($payment->status === 'pending')
                            <div class="p-3 rounded-lg text-center" style="background-color: #fff5e6; border-left: 4px solid #E2B59A;">
                                <p class="text-xs font-semibold" style="color: #957C62;">⏳ Verifikasi Admin</p>
                                <p class="text-xs mt-1" style="color: #B77466;">Tunggu notifikasi email</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }
</style>
@endsection
