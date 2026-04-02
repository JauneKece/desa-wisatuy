@extends('layouts.app')

@section('title', 'Edit Reservasi - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        <h1 class="text-3xl md:text-4xl font-bold mb-6" style="color: #957C62;">✏️ Edit Reservasi</h1>

        <form action="{{ route('reservasi.update', $reservasi) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label for="paket_wisata_id" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Paket Wisata (Opsional)</label>
                <select class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="paket_wisata_id" name="paket_wisata_id">
                    <option value="">Pilih Paket Wisata</option>
                    @foreach ($paketWisata as $paket)
                        <option value="{{ $paket->id }}" {{ $reservasi->paket_wisata_id == $paket->id ? 'selected' : '' }}>
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
                        <option value="{{ $akomodasi->id }}" {{ $reservasi->penginapan_id == $akomodasi->id ? 'selected' : '' }}>
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
                    <input type="date" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ $reservasi->tanggal_kunjungan->format('Y-m-d') }}" required>
                    @error('tanggal_kunjungan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jumlah_peserta" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Jumlah Peserta</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="jumlah_peserta" name="jumlah_peserta" value="{{ $reservasi->jumlah_peserta }}" min="1" required>
                    @error('jumlah_peserta')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if (in_array(auth()->user()->role, ['admin', 'manager']))
                <div class="mb-5">
                    <label for="status" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Status</label>
                    <select class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="status" name="status" required>
                        <option value="pending" {{ $reservasi->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="confirmed" {{ $reservasi->status == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                        <option value="completed" {{ $reservasi->status == 'completed' ? 'selected' : '' }}>🎉 Completed</option>
                        <option value="cancelled" {{ $reservasi->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div class="mb-5">
                <label for="catatan" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Catatan (Opsional)</label>
                <textarea class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="catatan" name="catatan" rows="4">{{ $reservasi->catatan }}</textarea>
                @error('catatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    ✅ Perbarui
                </button>
                <a href="{{ route('reservasi.index') }}" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
