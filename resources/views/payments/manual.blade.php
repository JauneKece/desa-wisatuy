@extends('layouts.app')

@section('title', 'Pembayaran - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Progress Stepper -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full text-white font-bold" style="background-color: #957C62;">1</div>
                <p class="ml-3 text-sm md:text-base font-semibold" style="color: #957C62;">Buat Reservasi</p>
            </div>
            <div class="flex-1 mx-2 h-1" style="background-color: #E2B59A;"></div>
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full text-white font-bold" style="background-color: #957C62;">2</div>
                <p class="ml-3 text-sm md:text-base font-semibold" style="color: #957C62;">Review</p>
            </div>
            <div class="flex-1 mx-2 h-1" style="background-color: #E2B59A;"></div>
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full text-white font-bold" style="background-color: #B77466;">3</div>
                <p class="ml-3 text-sm md:text-base font-semibold" style="color: #B77466;">Pembayaran</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form Section -->
        <div class="lg:col-span-2">
            <div class="rounded-3xl p-6 md:p-8" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <h1 class="text-3xl md:text-4xl font-bold mb-2" style="color: #957C62;">💳 Pembayaran</h1>
                <p class="text-sm md:text-base mb-6" style="color: #B77466;">Upload bukti pembayaran Anda untuk menyelesaikan reservasi</p>

                <form action="{{ route('payments.manual') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                    @csrf
                    <!-- Hidden Required Fields -->
                    <input type="hidden" name="reservasi_id" value="{{ $reservasi->id ?? '' }}">
                    <input type="hidden" name="amount" value="{{ $reservasi->total_harga ?? 0 }}">
                    <input type="hidden" name="method" id="hiddenMethod" value="">

                    <!-- Amount Info -->
                    <div class="mb-6 p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-2" style="color: #957C62;">💰 Total Pembayaran</p>
                        <p class="text-2xl md:text-3xl font-bold" style="color: #B77466;">Rp{{ number_format($reservasi->total_harga ?? 0, 0, ',', '.') }}</p>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-6">
                        <label class="block text-sm md:text-base font-bold mb-3" style="color: #957C62;">📤 Metode Pembayaran</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <label class="flex items-center p-4 rounded-lg cursor-pointer border-2 transition" style="background-color: #FFE1AF; border-color: #E2B59A;" id="bankLabel">
                                <input type="radio" name="method_display" value="bank_transfer" class="w-5 h-5" style="accent-color: #B77466;" required onchange="updatePaymentInfo(); setMethod('bank_transfer')">
                                <span class="ml-3 font-semibold" style="color: #957C62;">🏦 Transfer Bank</span>
                            </label>
                            <label class="flex items-center p-4 rounded-lg cursor-pointer border-2 transition" style="background-color: #FFE1AF; border-color: #E2B59A;" id="qrisLabel">
                                <input type="radio" name="method_display" value="qris" class="w-5 h-5" style="accent-color: #B77466;" onchange="updatePaymentInfo(); setMethod('qris')">
                                <span class="ml-3 font-semibold" style="color: #957C62;">📱 QRIS</span>
                            </label>
                        </div>
                        @error('method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bank Details Info -->
                    <div id="bankDetails" class="mb-6 p-4 rounded-lg hidden" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-3" style="color: #957C62;">📝 Data Transfer Bank</p>
                        <div class="space-y-2 text-sm" style="color: #957C62;">
                            <p><strong>Bank:</strong> BCA</p>
                            <p><strong>Nama Rekening:</strong> Desa Wisata Jomok</p>
                            <p><strong>Nomor Rekening:</strong> 1234567890</p>
                            <p class="text-xs italic mt-3">Mohon upload bukti transfer dalam 15 menit setelah melakukan transfer</p>
                        </div>
                    </div>

                    <!-- QRIS Details Info -->
                    <div id="qrisDetails" class="mb-6 p-6 rounded-lg hidden" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                        <p class="text-sm font-bold mb-4" style="color: #957C62;">📱 Pembayaran QRIS</p>
                        <div class="space-y-4 text-sm" style="color: #957C62;">
                            <p class="text-xs italic font-semibold">Scan QR Code di bawah menggunakan aplikasi e-wallet Anda (GCash, GCash, OVO, DANA, dll)</p>
                            
                            <!-- QR Code Display Container -->
                            <div class="flex flex-col items-center justify-center p-6 rounded-xl" style="background-color: white; border: 2px solid #B77466;">
                                <div id="qrCodeContainer" class="text-center">
                                    <img id="qrCodeImage" src="" alt="QRIS QR Code untuk pembayaran" class="w-72 h-72" style="border: 3px solid #957C62; padding: 8px; background-color: white;">
                                    <p id="qrLoadingText" class="mt-3 text-xs" style="color: #B77466;">Loading QR Code...</p>
                                </div>
                                <p id="qrErrorText" class="mt-3 text-xs text-red-600 hidden">Gagal generate QR Code. Silakan refresh halaman.</p>
                            </div>

                            <div class="rounded-lg p-3" style="background-color: white; border-left: 4px solid #B77466;">
                                <p class="text-sm font-semibold mb-2" style="color: #957C62;">💰 Nominal Pembayaran:</p>
                                <p class="text-lg font-bold" style="color: #B77466;">Rp{{ number_format($reservasi->total_harga ?? 0, 0, ',', '.') }}</p>
                            </div>

                            <div class="text-xs space-y-1" style="color: #957C62; background-color: white; border-left: 4px solid #E2B59A; padding: 10px;">
                                <p>✓ Scan dengan app e-wallet pilihan Anda</p>
                                <p>✓ Konfirmasi pembayaran akan langsung terproses</p>
                                <p>✓ Setelah transfer, upload bukti pembayaran di bawah</p>
                            </div>
                        </div>
                    </div>

                    <!-- Proof Upload -->
                    <div class="mb-6">
                        <label class="block text-sm md:text-base font-bold mb-3" style="color: #957C62;">📸 Unggah Bukti Pembayaran</label>
                        <div class="relative border-2 border-dashed rounded-lg p-6 text-center cursor-pointer transition" style="border-color: #E2B59A; background-color: #FFF9F0;" id="uploadArea" onmouseover="this.style.borderColor='#B77466'; this.style.backgroundColor='#FFE1AF'" onmouseout="this.style.borderColor='#E2B59A'; this.style.backgroundColor='#FFF9F0'">
                            <input type="file" name="proof" class="hidden" id="proofInput" accept=".jpg,.jpeg,.png,.pdf" required onchange="displayFileName(this)">
                            <div id="uploadContent">
                                <svg class="w-12 h-12 mx-auto mb-2" style="color: #B77466;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="font-semibold" style="color: #957C62;">Klik atau seret file ke sini</p>
                                <p class="text-xs" style="color: #B77466;">JPG, PNG, atau PDF (max 5MB)</p>
                            </div>
                        </div>
                        <p id="fileName" class="text-sm mt-2" style="color: #B77466; display: none;"></p>
                        @error('proof')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Important Notice -->
                    <div class="mb-6 p-4 rounded-lg" style="background-color: #fff5e6; border-left: 4px solid #E2B59A;">
                        <p class="text-xs md:text-sm font-semibold mb-2" style="color: #957C62;">⚠️ Catatan Penting</p>
                        <ul class="text-xs md:text-sm space-y-1" style="color: #B77466;">
                            <li>✓ Pastikan bukti pembayaran jelas dan terbaca</li>
                            <li>✓ Termasuk nominal dan tanggal transfer</li>
                            <li>✓ Tim kami akan verifikasi dalam 1-2 jam kerja</li>
                            <li>✓ Anda akan menerima notifikasi via email</li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            ✅ Kirim Bukti Pembayaran
                        </button>
                        <a href="{{ route('reservasi.show', $reservasi) }}" class="flex-1 px-6 py-3 text-white font-bold rounded-lg transition duration-150 text-center hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                            ← Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Order Summary -->
        <div class="lg:col-span-1">
            <div class="rounded-3xl p-6" style="background-color: white; border: 3px solid #E2B59A; position: sticky; top: 100px;">
                <h3 class="text-lg md:text-xl font-bold mb-4" style="color: #957C62;">📋 Ringkasan Order</h3>
                
                <!-- Reservation Details -->
                <div class="space-y-4 border-b pb-4" style="border-color: #E2B59A;">
                    <div>
                        <p class="text-xs font-semibold" style="color: #B77466;">Paket Wisata</p>
                        <p class="font-semibold" style="color: #957C62;">{{ $reservasi->paketWisata->nama_paket ?? 'Tidak dipilih' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold" style="color: #B77466;">Penginapan</p>
                        <p class="font-semibold" style="color: #957C62;">{{ $reservasi->penginapan->nama_penginapan ?? 'Tidak dipilih' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold" style="color: #B77466;">Tanggal Kunjungan</p>
                        <p class="font-semibold" style="color: #957C62;">{{ $reservasi->tanggal_kunjungan->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold" style="color: #B77466;">Jumlah Peserta</p>
                        <p class="font-semibold" style="color: #957C62;">{{ $reservasi->jumlah_peserta }} orang</p>
                    </div>
                </div>

                <!-- Price Breakdown -->
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span style="color: #B77466;">Paket Wisata</span>
                        <span style="color: #957C62;">Rp{{ number_format($reservasi->paketWisata->harga_paket ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span style="color: #B77466;">Penginapan</span>
                        <span style="color: #957C62;">Rp{{ number_format(($reservasi->penginapan->harga_penginapan ?? 0) * $reservasi->jumlah_peserta, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t pt-2 mt-2 flex justify-between font-bold" style="border-color: #E2B59A;">
                        <span style="color: #957C62;">Total</span>
                        <span style="color: #B77466;">Rp{{ number_format($reservasi->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const uploadArea = document.getElementById('uploadArea');
    const proofInput = document.getElementById('proofInput');
    const fileName = document.getElementById('fileName');
    const bankDetails = document.getElementById('bankDetails');
    const qrisDetails = document.getElementById('qrisDetails');
    const paymentForm = document.getElementById('paymentForm');

    // Generate QRIS QR Code on page load
    function generateQRCode() {
        try {
            const amountInput = document.querySelector('input[name="amount"]');
            const reservasiIdInput = document.querySelector('input[name="reservasi_id"]');
            const amount = amountInput ? Number(amountInput.value || 0) : 0;
            const orderId = reservasiIdInput ? String(reservasiIdInput.value || '') : '';
            
            // Rickroll QR Code
            const qrisData = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
            
            const qrImage = document.getElementById('qrCodeImage');
            const qrLoadingText = document.getElementById('qrLoadingText');
            const qrErrorText = document.getElementById('qrErrorText');
            
            // Generate QR code dengan size lebih besar (400x400)
            const qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=" + encodeURIComponent(qrisData);
            
            // Set image dengan fallback
            if (qrImage) {
                qrImage.onload = function() {
                    // Hide loading text ketika QR code berhasil di-load
                    if (qrLoadingText) {
                        qrLoadingText.style.display = 'none';
                    }
                    if (qrErrorText) {
                        qrErrorText.style.display = 'none';
                    }
                    console.log('QR Code berhasil di-generate');
                };
                
                qrImage.onerror = function() {
                    // Show error jika generate gagal
                    if (qrLoadingText) {
                        qrLoadingText.style.display = 'none';
                    }
                    if (qrErrorText) {
                        qrErrorText.style.display = 'block';
                    }
                    console.error('Gagal generate QR Code');
                };
                
                qrImage.src = qrCodeUrl;
            }
        } catch (error) {
            console.error('Error generating QR Code:', error);
            const qrErrorText = document.getElementById('qrErrorText');
            if (qrErrorText) {
                qrErrorText.style.display = 'block';
            }
        }
    }

    // Initialize QR code when page loads
    generateQRCode();

    // File upload handling
    uploadArea.addEventListener('click', () => proofInput.click());
    
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = '#B77466';
        uploadArea.style.backgroundColor = '#FFE1AF';
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.style.borderColor = '#E2B59A';
        uploadArea.style.backgroundColor = '#FFF9F0';
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            proofInput.files = files;
            displayFileName(proofInput);
        }
    });

    function displayFileName(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileName.textContent = '✓ File dipilih: ' + file.name;
            fileName.style.display = 'block';
            fileName.style.color = '#957C62';
        }
    }

    function setMethod(value) {
        document.getElementById('hiddenMethod').value = value;
    }

    function updatePaymentInfo() {
        const selectedMethod = document.querySelector('input[name="method_display"]:checked');
        const method = selectedMethod ? selectedMethod.value : null;
        const qrLoadingText = document.getElementById('qrLoadingText');
        
        if (method === 'bank_transfer') {
            bankDetails.classList.remove('hidden');
            qrisDetails.classList.add('hidden');
        } else if (method === 'qris') {
            bankDetails.classList.add('hidden');
            qrisDetails.classList.remove('hidden');
            
            // Show loading text when showing QRIS section
            if (qrLoadingText) {
                qrLoadingText.style.display = 'block';
            }
        } else {
            bankDetails.classList.add('hidden');
            qrisDetails.classList.add('hidden');
        }
    }

    // Validate method is selected before submit
    paymentForm.addEventListener('submit', (e) => {
        const method = document.querySelector('input[name="method_display"]:checked');
        const hiddenMethod = document.getElementById('hiddenMethod').value;
        
        if (!method || !hiddenMethod) {
            e.preventDefault();
            alert('Pilih metode pembayaran terlebih dahulu');
            return;
        }

        // Extra validation: ensure proof file is selected
        const proofInput = document.getElementById('proofInput');
        if (!proofInput.files || proofInput.files.length === 0) {
            e.preventDefault();
            alert('Pilih file bukti pembayaran terlebih dahulu');
            return;
        }
    });
</script>
@endsection
