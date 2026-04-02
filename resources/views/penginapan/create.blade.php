@extends('layouts.app')

@section('title', 'Tambah Penginapan - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        <h1 class="text-3xl md:text-4xl font-bold mb-6" style="color: #957C62;">➕ Tambah Penginapan Baru</h1>

        <form action="{{ route('penginapan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <label for="nama_penginapan" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Nama Penginapan</label>
                <input type="text" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="nama_penginapan" name="nama_penginapan" value="{{ old('nama_penginapan') }}" required>
                @error('nama_penginapan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="deskripsi" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Deskripsi</label>
                <textarea class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="alamat" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Alamat</label>
                <textarea class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="telepon" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Telepon</label>
                    <input type="text" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                    @error('telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga_penginapan" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Harga per Malam (Rp)</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="harga_penginapan" name="harga_penginapan" value="{{ old('harga_penginapan') }}" min="0" required>
                    @error('harga_penginapan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="jumlah_kamar" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Jumlah Kamar</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="jumlah_kamar" name="jumlah_kamar" value="{{ old('jumlah_kamar') }}" min="1" required>
                    @error('jumlah_kamar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tipe_kamar" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Tipe Kamar</label>
                    <input type="text" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="tipe_kamar" name="tipe_kamar" value="{{ old('tipe_kamar') }}" required>
                    @error('tipe_kamar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div>
                    <label for="rating" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Rating (1-5)</label>
                    <input type="number" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="rating" name="rating" value="{{ old('rating', 5) }}" min="1" max="5">
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="foto" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Foto</label>
                    <input type="file" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="foto" name="foto" accept="image/*">
                    @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    ✅ Simpan
                </button>
                <a href="{{ route('penginapan.index') }}" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
