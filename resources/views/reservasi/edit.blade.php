@extends('layouts.app')

@section('title', 'Edit Reservasi - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Progress Stepper -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center opacity-50">
                <div class="flex items-center justify-center w-10 h-10 rounded-full text-white font-bold" style="background-color: #957C62;">1</div>
                <p class="ml-3 text-sm md:text-base font-semibold" style="color: #957C62;">Buat Reservasi</p>
            </div>
            <div class="flex-1 mx-2 h-1" style="background-color: #E2B59A;"></div>
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full text-white font-bold" style="background-color: #B77466;">2</div>
                <p class="ml-3 text-sm md:text-base font-semibold" style="color: #B77466;">Edit</p>
            </div>
            <div class="flex-1 mx-2 h-1" style="background-color: #E2B59A;"></div>
            <div class="flex items-center opacity-50">
                <div class="flex items-center justify-center w-10 h-10 rounded-full text-white font-bold" style="background-color: #957C62;">3</div>
                <p class="ml-3 text-sm md:text-base font-semibold" style="color: #957C62;">Review</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form Section -->
        <div class="lg:col-span-2">
            <div class="rounded-3xl p-6 md:p-8" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
                <h1 class="text-3xl md:text-4xl font-bold mb-2" style="color: #957C62;">✏️ Edit Reservasi</h1>
                <p class="text-sm md:text-base mb-6" style="color: #B77466;">Update detail reservasi Anda. Harga akan dihitung ulang secara otomatis.</p>

                <form action="{{ route('reservasi.update', $reservasi) }}" method="POST" id="reservasiForm">
                    @csrf
                    @method('PATCH')

                    <!-- Section 1: Pilih Paket & Akomodasi -->
                    <div class="mb-8 pb-8 border-b" style="border-color: #E2B59A;">
                        <h3 class="text-lg font-bold mb-4 flex items-center" style="color: #957C62;">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full text-white text-sm font-bold mr-3" style="background-color: #B77466;">A</span>
                            Paket & Akomodasi
                        </h3>

                        <!-- Paket Wisata -->
                        <div class="mb-6">
                            <label for="paket_wisata_id" class="block text-sm md:text-base font-bold mb-3" style="color: #957C62;">
                                🎒 Paket Wisata <span class="text-gray-500">(Opsional)</span>
                            </label>
                            <select class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="paket_wisata_id" name="paket_wisata_id" onchange="updatePrice()">
                                <option value="">-- Pilih Paket Wisata --</option>
                                @foreach ($paketWisata as $paket)
                                    <option value="{{ $paket->id }}" data-harga="{{ $paket->harga_paket }}" {{ $reservasi->paket_wisata_id == $paket->id ? 'selected' : '' }}>
                                        {{ $paket->nama_paket }} - Rp{{ number_format($paket->harga_paket, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
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
                                    <option value="{{ $akomodasi->id }}" data-harga="{{ $akomodasi->harga_penginapan }}" {{ $reservasi->penginapan_id == $akomodasi->id ? 'selected' : '' }}>
                                        {{ $akomodasi->nama_penginapan }} - Rp{{ number_format($akomodasi->harga_penginapan, 0, ',', '.') }}/malam
                                    </option>
                                @endforeach
                            </select>
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
                                <input type="date" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ $reservasi->tanggal_kunjungan->format('Y-m-d') }}" onchange="updatePrice()" required>
                                @error('tanggal_kunjungan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jumlah Peserta -->
                            <div>
                                <label for="jumlah_peserta" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">👥 Jumlah Pengunjung</label>
                                <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="jumlah_peserta" name="jumlah_peserta" value="{{ $reservasi->jumlah_peserta }}" min="1" max="100" onchange="updatePrice()" required>
                                @error('jumlah_peserta')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Status & Catatan -->
                    <div class="mb-8">
                        @if (in_array(auth()->user()->role, ['admin', 'manager']))
                            <div class="mb-6 pb-6 border-b" style="border-color: #E2B59A;">
                                <h3 class="text-lg font-bold mb-4 flex items-center" style="color: #957C62;">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg text-white text-sm font-bold mr-3" style="background-color: #B77466;">⚙️</span>
                                    Kelola Status
                                </h3>

                                <label for="status" class="block text-sm md:text-base font-bold mb-3" style="color: #957C62;">📊 Status Reservasi</label>
                                <select class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="status" name="status" required>
                                    <option value="pending" {{ $reservasi->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="confirmed" {{ $reservasi->status == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                    <option value="cancelled" {{ $reservasi->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <h3 class="text-lg font-bold mb-4 flex items-center" style="color: #957C62;">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg text-white text-sm font-bold mr-3" style="background-color: #B77466;">C</span>
                            Catatan
                        </h3>

                        <label for="catatan" class="block text-sm md:text-base font-bold mb-3" style="color: #957C62;">
                            📝 Catatan <span class="text-gray-500">(Opsional)</span>
                        </label>
                        <textarea class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="catatan" name="catatan" rows="4">{{ $reservasi->catatan }}</textarea>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            ✅ Simpan Perubahan
                        </button>
                        <a href="{{ route('reservasi.show', $reservasi) }}" class="flex-1 px-6 py-3 text-white font-bold rounded-lg transition duration-150 text-center hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                            ← Batal
                        </a>
                        @if (in_array(auth()->user()->role, ['admin', 'manager']))
                            <form action="{{ route('reservasi.destroy', $reservasi) }}" method="POST" style="display: inline; flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-6 py-3 text-white font-bold rounded-lg transition duration-150 hover:scale-105" style="background-color: #d32f2f;" onmouseover="this.style.backgroundColor='#b71c1c'" onmouseout="this.style.backgroundColor='#d32f2f'" onclick="return confirm('Yakin ingin menghapus reservasi ini? Tindakan ini tidak dapat dibatalkan.')">
                                    🗑️ Hapus Reservasi
                                </button>
                            </form>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar: Price Summary -->
        <div class="lg:col-span-1">
            <div class="rounded-3xl p-6" style="background-color: white; border: 3px solid #E2B59A; position: sticky; top: 100px;">
                <h3 class="text-lg md:text-xl font-bold mb-4" style="color: #957C62;">💰 Ringkasan Harga Baru</h3>

                <!-- Price Breakdown -->
                <div class="space-y-3 pb-4 mb-4 border-b" style="border-color: #E2B59A;">
                    <div class="flex justify-between text-sm">
                        <span style="color: #B77466;">Paket Wisata</span>
                        <span id="hargaPaket" style="color: #957C62;">Rp0</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span style="color: #B77466;">Penginapan</span>
                        <span id="hargaPenginapan" style="color: #957C62;">Rp0</span>
                    </div>

                    <div class="text-xs" style="color: #B77466;">
                        <p id="detailText">Memperbarui harga...</p>
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-gradient-to-r p-4 rounded-lg mb-6 text-center" style="background: linear-gradient(135deg, #FFE1AF 0%, #E2B59A 100%);">
                    <p class="text-xs font-semibold" style="color: #957C62;">TOTAL BARU</p>
                    <p class="text-2xl font-bold" style="color: #B77466;">
                        Rp<span id="totalHarga">0</span>
                    </p>
                </div>

                <!-- Current Info -->
                <div class="space-y-2 text-xs" style="color: #B77466; border-t: 1px solid #E2B59A; padding-top: 12px;">
                    <p class="text-xs font-semibold" style="color: #957C62;">📋 Info Saat Ini</p>
                    <div class="p-3 rounded-lg" style="background-color: #FFF9F0;">
                        <p>Total: <span class="font-bold" style="color: #B77466;">Rp{{ number_format($reservasi->total_harga, 0, ',', '.') }}</span></p>
                        <p>Status: <span class="font-bold" style="color: #957C62;">{{ ucfirst($reservasi->status) }}</span></p>
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
            document.getElementById('detailText').textContent = '1 paket wisata';
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
