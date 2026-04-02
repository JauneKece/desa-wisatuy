@extends('layouts.app')

@section('title', 'Edit Paket Wisata - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        <h1 class="text-3xl md:text-4xl font-bold mb-6" style="color: #957C62;">✏️ Edit Paket Wisata</h1>

        <form action="{{ route('paket-wisata.update', $paketWisata) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label for="nama_paket" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Nama Paket</label>
                <input type="text" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="nama_paket" name="nama_paket" value="{{ old('nama_paket', $paketWisata->nama_paket) }}" required>
                @error('nama_paket')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="deskripsi" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Deskripsi</label>
                <textarea class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $paketWisata->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="harga_paket" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Harga Paket (Rp)</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="harga_paket" name="harga_paket" value="{{ old('harga_paket', $paketWisata->harga_paket) }}" min="0" required>
                    @error('harga_paket')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="durasi_hari" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Durasi (Hari)</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="durasi_hari" name="durasi_hari" value="{{ old('durasi_hari', $paketWisata->durasi_hari) }}" min="1" required>
                    @error('durasi_hari')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="durasi_jam" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Durasi (Jam)</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="durasi_jam" name="durasi_jam" value="{{ old('durasi_jam', $paketWisata->durasi_jam) }}" min="0">
                    @error('durasi_jam')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kuota_peserta" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Kuota Peserta</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="kuota_peserta" name="kuota_peserta" value="{{ old('kuota_peserta', $paketWisata->kuota_peserta) }}" min="1" required>
                    @error('kuota_peserta')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-5">
                <label for="itinerary" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Itinerary</label>
                <textarea class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="itinerary" name="itinerary" rows="5">{{ old('itinerary', $paketWisata->itinerary) }}</textarea>
                @error('itinerary')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="foto" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Foto (Biarkan kosong jika tidak ingin mengubah)</label>
                @if ($paketWisata->foto)
                    <div class="mb-3 rounded-lg overflow-hidden" style="background-color: #FFE1AF;">
                        <img src="{{ asset('storage/' . $paketWisata->foto) }}" class="max-h-40 w-full object-cover">
                    </div>
                @endif
                <input type="file" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="foto" name="foto" accept="image/*">
                @error('foto')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    ✅ Perbarui
                </button>
                <a href="{{ route('paket-wisata.index') }}" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
