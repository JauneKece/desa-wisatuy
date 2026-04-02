@extends('layouts.app')

@section('title', 'Edit Objek Wisata - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        <h1 class="text-3xl md:text-4xl font-bold mb-6" style="color: #957C62;">✏️ Edit Objek Wisata</h1>

        <form action="{{ route('objek-wisata.update', $objekWisata) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label for="kategori_wisata_id" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Kategori Wisata</label>
                <select class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="kategori_wisata_id" name="kategori_wisata_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $objekWisata->kategori_wisata_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_wisata_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="nama_objek" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Nama Objek Wisata</label>
                <input type="text" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="nama_objek" name="nama_objek" value="{{ old('nama_objek', $objekWisata->nama_objek) }}" required>
                @error('nama_objek')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="deskripsi" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Deskripsi</label>
                <textarea class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $objekWisata->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="lokasi" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Lokasi</label>
                    <input type="text" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="lokasi" name="lokasi" value="{{ old('lokasi', $objekWisata->lokasi) }}" required>
                    @error('lokasi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga_tiket" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Harga Tiket (Rp)</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="harga_tiket" name="harga_tiket" value="{{ old('harga_tiket', $objekWisata->harga_tiket) }}" min="0" required>
                    @error('harga_tiket')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="jam_buka" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Jam Buka</label>
                    <input type="time" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="jam_buka" name="jam_buka" value="{{ old('jam_buka', $objekWisata->jam_buka) }}" required>
                    @error('jam_buka')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_tutup" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Jam Tutup</label>
                    <input type="time" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="jam_tutup" name="jam_tutup" value="{{ old('jam_tutup', $objekWisata->jam_tutup) }}" required>
                    @error('jam_tutup')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div>
                    <label for="rating" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Rating (1-5)</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="rating" name="rating" value="{{ old('rating', $objekWisata->rating) }}" min="1" max="5">
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="foto" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Foto (Biarkan kosong jika tidak ingin mengubah)</label>
                    @if ($objekWisata->foto)
                        <div class="mb-3 rounded-lg overflow-hidden" style="background-color: #FFE1AF;">
                            <img src="{{ asset('storage/' . $objekWisata->foto) }}" class="max-h-40 w-full object-cover">
                        </div>
                    @endif
                    <input type="file" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="foto" name="foto" accept="image/*">
                    @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    ✅ Perbarui
                </button>
                <a href="{{ route('objek-wisata.index') }}" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
