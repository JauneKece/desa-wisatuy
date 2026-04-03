@extends('layouts.app')

@section('title', 'Buat Reservasi - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        <h1 class="text-3xl md:text-4xl font-bold mb-6" style="color: #957C62;">📅 Buat Reservasi Baru</h1>

        <form action="{{ route('reservasi.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="paket_wisata_id" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Paket Wisata (Opsional)</label>
                <select class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="paket_wisata_id" name="paket_wisata_id">
                    <option value="">Pilih Paket Wisata</option>
                    @foreach ($paketWisata as $paket)
                        <option value="{{ $paket->id }}" {{ old('paket_wisata_id') == $paket->id ? 'selected' : '' }}>
                            {{ $paket->nama_paket }} - Rp{{ number_format($paket->harga_paket, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('paket_wisata_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="penginapan_id" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Penginapan (Opsional)</label>
                <select class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="penginapan_id" name="penginapan_id">
                    <option value="">Pilih Penginapan</option>
                    @foreach ($penginapan as $akomodasi)
                        <option value="{{ $akomodasi->id }}" {{ old('penginapan_id') == $akomodasi->id ? 'selected' : '' }}>
                            {{ $akomodasi->nama_penginapan }} - Rp{{ number_format($akomodasi->harga_penginapan, 0, ',', '.') }}/malam
                        </option>
                    @endforeach
                </select>
                @error('penginapan_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="tanggal_kunjungan" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Tanggal Kunjungan</label>
                    <input type="date" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}" required>
                    @error('tanggal_kunjungan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jumlah_peserta" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Jumlah Pengunjung</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="jumlah_peserta" name="jumlah_peserta" value="{{ old('jumlah_peserta', 1) }}" min="1" required>
                    @error('jumlah_peserta')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-5">
                <label for="catatan" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Catatan (Opsional)</label>
                <textarea class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="catatan" name="catatan" rows="4">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    ✅ Buat Reservasi
                </button>
                <a href="{{ route('reservasi.index') }}" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
