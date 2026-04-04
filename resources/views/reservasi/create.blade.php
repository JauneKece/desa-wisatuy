@extends('layouts.app')

@section('title', 'Buat Reservasi - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Progress Stepper -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full text-white font-bold" style="background-color: #B77466;">1</div>
                <p class="ml-3 text-sm md:text-base font-semibold" style="color: #B77466;">Buat Reservasi</p>
            </div>
            <div class="flex-1 mx-2 h-1" style="background-color: #E2B59A;"></div>
            <div class="flex items-center opacity-50">
                <div class="flex items-center justify-center w-10 h-10 rounded-full text-white font-bold" style="background-color: #957C62;">2</div>
                <p class="ml-3 text-sm md:text-base font-semibold" style="color: #957C62;">Review</p>
            </div>
            <div class="flex-1 mx-2 h-1" style="background-color: #E2B59A;"></div>
            <div class="flex items-center opacity-50">
                <div class="flex items-center justify-center w-10 h-10 rounded-full text-white font-bold" style="background-color: #957C62;">3</div>
                <p class="ml-3 text-sm md:text-base font-semibold" style="color: #957C62;">Pembayaran</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form Section -->
        <div class="lg:col-span-2">
            <div class="rounded-3xl p-6 md:p-8" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <h1 class="text-3xl md:text-4xl font-bold mb-2" style="color: #957C62;">📅 Buat Reservasi Baru</h1>
                <p class="text-sm md:text-base mb-6" style="color: #B77466;">Isi detail reservasi Anda dengan lengkap. Harga akan dihitung secara otomatis.</p>

                <form action="{{ route('reservasi.store') }}" method="POST" id="reservasiForm">
                    @csrf

                    <!-- Section 1: Pilih Paket & Akomodasi -->
                    <div class="mb-8 pb-8 border-b" style="border-color: #E2B59A;">
                        <h3 class="text-lg font-bold mb-4 flex items-center" style="color: #957C62;">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full text-white text-sm font-bold mr-3" style="background-color: #B77466;">A</span>
                            Pilih Paket & Akomodasi
                        </h3>

                        <!-- Paket Wisata -->
                        <div class="mb-6">
                            <label for="paket_wisata_id" class="block text-sm md:text-base font-bold mb-3" style="color: #957C62;">
                                🎒 Paket Wisata <span class="text-gray-500">(Opsional)</span>
                            </label>
                            <select class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="paket_wisata_id" name="paket_wisata_id" onchange="updatePrice()">
                                <option value="">-- Pilih Paket Wisata --</option>
                                @foreach ($paketWisata as $paket)
                                    <option value="{{ $paket->id }}" data-harga="{{ $paket->harga_paket }}" {{ old('paket_wisata_id') == $paket->id ? 'selected' : '' }}>
                                        {{ $paket->nama_paket }} - Rp{{ number_format($paket->harga_paket, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs mt-2" style="color: #B77466;">💡 Paket wisata mencakup aktivitas dan panduan wisata</p>
                            @error('paket_wisata_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penginapan -->
                        <div class="mb-6">
                            <label for="penginapan_id" class="block text-sm md:text-base font-bold mb-3" style="color: #957C62;">
                                🏨 Penginapan <span class="text-gray-500">(Opsional)</span>
                            </label>
                            <select class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="penginapan_id" name="penginapan_id" onchange="updatePrice()">
                                <option value="">-- Pilih Penginapan --</option>
                                @foreach ($penginapan as $akomodasi)
                                    <option value="{{ $akomodasi->id }}" data-harga="{{ $akomodasi->harga_penginapan }}" {{ old('penginapan_id') == $akomodasi->id ? 'selected' : '' }}>
                                        {{ $akomodasi->nama_penginapan }} - Rp{{ number_format($akomodasi->harga_penginapan, 0, ',', '.') }}/malam
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs mt-2" style="color: #B77466;">💡 Harga penginapan bergantung pada jumlah peserta dan malam menginap</p>
                            @error('penginapan_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 2: Detail Kunjungan -->
                    <div class="mb-8 pb-8 border-b" style="border-color: #E2B59A;">
                        <h3 class="text-lg font-bold mb-4 flex items-center" style="color: #957C62;">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg text-white text-sm font-bold mr-3" style="background-color: #B77466;">B</span>
                            Detail Kunjungan
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Tanggal Kunjungan -->
                            <div>
                                <label for="tanggal_kunjungan" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">📅 Tanggal Kunjungan</label>
                                <input type="date" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}" onchange="updatePrice()" required>
                                <p class="text-xs mt-2" style="color: #B77466;">Pilih tanggal mulai kunjungan Anda</p>
                                @error('tanggal_kunjungan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jumlah Peserta -->
                            <div>
                                <label for="jumlah_peserta" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">👥 Jumlah Pengunjung</label>
                                <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="jumlah_peserta" name="jumlah_peserta" value="{{ old('jumlah_peserta', 1) }}" min="1" max="100" onchange="updatePrice()" required>
                                <p class="text-xs mt-2" style="color: #B77466;">Minimal 1 orang, maksimal 100 orang</p>
                                @error('jumlah_peserta')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Catatan -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold mb-4 flex items-center" style="color: #957C62;">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg text-white text-sm font-bold mr-3" style="background-color: #B77466;">C</span>
                            Catatan Tambahan
                        </h3>

                        <label for="catatan" class="block text-sm md:text-base font-bold mb-3" style="color: #957C62;">
                            📝 Catatan <span class="text-gray-500">(Opsional)</span>
                        </label>
                        <textarea class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="catatan" name="catatan" rows="4" placeholder="Contoh: Kami memiliki kebutuhan khusus untuk pax yang alergi...">{{ old('catatan') }}</textarea>
                        <p class="text-xs mt-2" style="color: #B77466;">💡 Sampaikan kebutuhan khusus atau permintan khusus Anda di sini</p>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            ✅ Lanjutkan ke Pembayaran
                        </button>
                        <a href="{{ route('reservasi.index') }}" class="flex-1 px-6 py-3 text-white font-bold rounded-lg transition duration-150 text-center hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                            ← Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar: Price Calculation & Summary -->
        <div class="lg:col-span-1">
            <div class="rounded-3xl p-6" style="background-color: white; border: 3px solid #E2B59A; position: sticky; top: 100px;">
                <h3 class="text-lg md:text-xl font-bold mb-4" style="color: #957C62;">💰 Ringkasan Harga</h3>

                <!-- Price Breakdown -->
                <div class="space-y-3 pb-4 mb-4 border-b" style="border-color: #E2B59A;">
                    <!-- Paket Wisata -->
                    <div class="flex justify-between text-sm">
                        <span style="color: #B77466;">Paket Wisata</span>
                        <span id="hargaPaket" style="color: #957C62;">Rp0</span>
                    </div>

                    <!-- Penginapan -->
                    <div class="flex justify-between text-sm">
                        <span style="color: #B77466;">Penginapan</span>
                        <span id="hargaPenginapan" style="color: #957C62;">Rp0</span>
                    </div>

                    <!-- Details -->
                    <div class="text-xs" style="color: #B77466;">
                        <p id="detailText">Pilih paket dan akomodasi</p>
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-gradient-to-r p-4 rounded-lg mb-6 text-center" style="background: linear-gradient(135deg, #FFE1AF 0%, #E2B59A 100%);">
                    <p class="text-xs font-semibold" style="color: #957C62;">TOTAL HARGA</p>
                    <p class="text-2xl font-bold" style="color: #B77466;">
                        Rp<span id="totalHarga">0</span>
                    </p>
                </div>

                <!-- Helper Info -->
                <div class="space-y-3 text-xs" style="color: #B77466;">
                    <div class="p-3 rounded-lg" style="background-color: #FFF9F0;">
                        <p class="font-semibold mb-1" style="color: #957C62;">✓ Proses Aman</p>
                        <p>Data Anda dilindungi dengan enkripsi</p>
                    </div>
                    <div class="p-3 rounded-lg" style="background-color: #FFF9F0;">
                        <p class="font-semibold mb-1" style="color: #957C62;">✓ Konfirmasi Cepat</p>
                        <p>Verifikasi pembayaran dalam 1-2 jam</p>
                    </div>
                    <div class="p-3 rounded-lg" style="background-color: #FFF9F0;">
                        <p class="font-semibold mb-1" style="color: #957C62;">✓ Dukungan 24/7</p>
                        <p>Tim kami siap membantu kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Price Calculation
    const paketSelect = document.getElementById('paket_wisata_id');
    const penginapanSelect = document.getElementById('penginapan_id');
    const jumlahPesertaInput = document.getElementById('jumlah_peserta');
    const tanggalInput = document.getElementById('tanggal_kunjungan');

    function updatePrice() {
        let totalHarga = 0;
        let detailText = '';

        // Calculate paket wisata price
        const paketOption = paketSelect.options[paketSelect.selectedIndex];
        const hargaPaket = parseInt(paketOption.dataset.harga || 0);
        if (hargaPaket > 0) {
            totalHarga += hargaPaket;
            document.getElementById('hargaPaket').textContent = 'Rp' + hargaPaket.toLocaleString('id-ID');
        } else {
            document.getElementById('hargaPaket').textContent = 'Rp0';
        }

        // Calculate penginapan price
        const penginapanOption = penginapanSelect.options[penginapanSelect.selectedIndex];
        const hargaPenginapan = parseInt(penginapanOption.dataset.harga || 0);
        const jumlahPeserta = parseInt(jumlahPesertaInput.value || 1);
        
        if (hargaPenginapan > 0 && jumlahPeserta > 0) {
            const totalPenginapan = hargaPenginapan * jumlahPeserta;
            totalHarga += totalPenginapan;
            document.getElementById('hargaPenginapan').textContent = 'Rp' + totalPenginapan.toLocaleString('id-ID');
            detailText = `${jumlahPeserta} orang × Rp${hargaPenginapan.toLocaleString('id-ID')}`;
        } else {
            document.getElementById('hargaPenginapan').textContent = 'Rp0';
        }

        // Update summary
        document.getElementById('totalHarga').textContent = totalHarga.toLocaleString('id-ID');
        
        if (detailText) {
            document.getElementById('detailText').textContent = detailText + '/malam';
        } else if (hargaPaket > 0) {
            document.getElementById('detailText').textContent = '1 pakt wisata';
        } else {
            document.getElementById('detailText').textContent = 'Pilih paket dan akomodasi';
        }
    }

    // Trigger calculation on form load
    document.addEventListener('DOMContentLoaded', updatePrice);

    // Add event listeners
    paketSelect.addEventListener('change', updatePrice);
    penginapanSelect.addEventListener('change', updatePrice);
    jumlahPesertaInput.addEventListener('change', updatePrice);
</script>
@endsection
