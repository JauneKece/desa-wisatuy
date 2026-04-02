@extends('layouts.app')

@section('title', 'Edit Berita - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        <h1 class="text-3xl md:text-4xl font-bold mb-6" style="color: #957C62;">✏️ Edit Berita</h1>

        <form action="{{ route('berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label for="kategori_berita_id" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Kategori Berita</label>
                <select class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="kategori_berita_id" name="kategori_berita_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $berita->kategori_berita_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_berita_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="judul" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Judul Berita</label>
                <input type="text" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required>
                @error('judul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="konten" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Konten</label>
                <textarea class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" id="konten" name="konten" rows="8" required>{{ old('konten', $berita->konten) }}</textarea>
                @error('konten')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="foto" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Foto (Biarkan kosong jika tidak ingin mengubah)</label>
                @if ($berita->foto)
                    <div class="mb-3 rounded-lg overflow-hidden" style="background-color: #FFE1AF;">
                        <img src="{{ asset('storage/' . $berita->foto) }}" class="max-h-40 w-full object-cover">
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
                <a href="{{ route('berita.index') }}" class="inline-flex items-center justify-center px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
