@extends('layouts.app')

@section('title', 'Lihat Berita - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="rounded-3xl overflow-hidden mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        @if ($berita->foto)
            <img src="{{ asset('storage/' . $berita->foto) }}" class="w-full md:h-500" style="height: 300px; object-fit: cover;">
        @else
            <div class="flex items-center justify-center" style="height: 300px; background-color: #FFE1AF;">
                <span class="text-4xl" style="color: #B77466;">📷 Tidak ada foto</span>
            </div>
        @endif

        <div class="p-6 md:p-8">
            <h1 class="text-3xl md:text-5xl font-bold mb-4" style="color: #957C62;">{{ $berita->judul }}</h1>
            
            <div class="flex flex-wrap gap-3 mb-6 pb-6" style="border-bottom: 2px solid #E2B59A;">
                <div class="inline-flex items-center gap-1 text-sm md:text-base" style="color: #B77466;">
                    <span>📂</span>
                    <span>{{ $berita->kategoriBerita->nama_kategori }}</span>
                </div>
                <div class="inline-flex items-center gap-1 text-sm md:text-base" style="color: #B77466;">
                    <span>✍️</span>
                    <span>Oleh {{ $berita->user->name }}</span>
                </div>
                <div class="inline-flex items-center gap-1 text-sm md:text-base" style="color: #B77466;">
                    <span>📅</span>
                    <span>{{ $berita->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>

            <h3 class="text-lg md:text-2xl font-bold mb-4" style="color: #957C62;">📖 Konten</h3>
            <p class="text-sm md:text-base leading-relaxed mb-8" style="color: #B77466;">{{ nl2br($berita->konten) }}</p>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('berita.index') }}" class="inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    ← Kembali ke Daftar
                </a>
                @if (auth()->check() && (auth()->user()->id === $berita->user_id || in_array(auth()->user()->role, ['admin', 'manager'])))
                    <a href="{{ route('berita.edit', $berita) }}" class="inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('berita.destroy', $berita) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #E74C3C;" onmouseover="this.style.backgroundColor='#C0392B'" onmouseout="this.style.backgroundColor='#E74C3C'" onclick="return confirm('Yakin ingin menghapus?')">
                            🗑️ Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
