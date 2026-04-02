@extends('layouts.app')

@section('title', 'Lihat Penginapan - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="rounded-3xl overflow-hidden mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        @if ($penginapan->foto)
            <img src="{{ asset('storage/' . $penginapan->foto) }}" class="w-full h-80 md:h-96 object-cover">
        @else
            <div class="flex items-center justify-center" style="height: 300px; background-color: #FFE1AF;">
                <span class="text-4xl" style="color: #B77466;">📷 Tidak ada foto</span>
            </div>
        @endif

        <div class="p-6 md:p-8">
            <h1 class="text-3xl md:text-5xl font-bold mb-6" style="color: #957C62;">{{ $penginapan->nama_penginapan }}</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="rounded-2xl p-4" style="background-color: #FFE1AF; border: 2px solid #E2B59A;">
                    <h5 class="text-sm md:text-base font-bold mb-2" style="color: #957C62;">⭐ Rating</h5>
                    <p class="text-2xl md:text-3xl font-bold" style="color: #B77466;">{{ $penginapan->rating }}/5</p>
                </div>
                <div class="rounded-2xl p-4" style="background-color: #FFE1AF; border: 2px solid #E2B59A;">
                    <h5 class="text-sm md:text-base font-bold mb-2" style="color: #957C62;">💰 Harga per Malam</h5>
                    <p class="text-2xl md:text-3xl font-bold" style="color: #B77466;">Rp{{ number_format($penginapan->harga_penginapan, 0, ',', '.') }}</p>
                </div>

                <div class="rounded-2xl p-4" style="background-color: #FFE1AF; border: 2px solid #E2B59A;">
                    <h5 class="text-sm md:text-base font-bold mb-2" style="color: #957C62;">🛏️ Jumlah Kamar</h5>
                    <p class="text-base md:text-lg" style="color: #B77466;">{{ $penginapan->jumlah_kamar }} kamar</p>
                </div>

                <div class="rounded-2xl p-4" style="background-color: #FFE1AF; border: 2px solid #E2B59A;">
                    <h5 class="text-sm md:text-base font-bold mb-2" style="color: #957C62;">📝 Tipe Kamar</h5>
                    <p class="text-base md:text-lg" style="color: #B77466;">{{ $penginapan->tipe_kamar }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="rounded-2xl p-4" style="background-color: #FFE1AF; border: 2px solid #E2B59A;">
                    <h5 class="text-sm md:text-base font-bold mb-2" style="color: #957C62;">📍 Lokasi</h5>
                    <p class="text-sm md:text-base" style="color: #B77466;">{{ $penginapan->alamat }}</p>
                </div>
                <div class="rounded-2xl p-4" style="background-color: #FFE1AF; border: 2px solid #E2B59A;">
                    <h5 class="text-sm md:text-base font-bold mb-2" style="color: #957C62;">📞 Telepon</h5>
                    <p class="text-sm md:text-base" style="color: #B77466;">{{ $penginapan->telepon }}</p>
                </div>
            </div>

            <h3 class="text-lg md:text-2xl font-bold mb-3" style="color: #957C62;">📖 Deskripsi</h3>
            <p class="text-sm md:text-base leading-relaxed mb-8" style="color: #B77466;">{{ $penginapan->deskripsi }}</p>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('penginapan.index') }}" class="inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    ← Kembali ke Daftar
                </a>
                @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'manager']))
                    <a href="{{ route('penginapan.edit', $penginapan) }}" class="inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('penginapan.destroy', $penginapan) }}" method="POST" style="display: inline;">
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
