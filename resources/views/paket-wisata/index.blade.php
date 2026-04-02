@extends('layouts.app')

@section('title', 'Paket Wisata - Desmok')

@section('content')
<div class="container-responsive py-8 md:py-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div>
            <h1 class="text-5xl md:text-6xl font-outfit font-black mb-2" style="color: #957C62;">🎒 Paket Wisata</h1>
            <p class="text-lg" style="color: #B77466;">Pilih paket wisata yang sesuai untuk petualangan Anda</p>
        </div>
        @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'manager']))
            <a href="{{ route('paket-wisata.create') }}" class="px-6 py-3 whitespace-nowrap rounded-lg text-white font-semibold transition-all duration-300" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                <span class="text-xl mr-2">➕</span>
                <span>Tambah Paket</span>
            </a>
        @endif
    </div>

    <div class="w-20 h-1 mb-12" style="background-color: #E2B59A;"></div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @forelse ($paketWisata as $paket)
            <div class="group animate-slide-in" style="--animation-delay: {{ ($loop->index * 0.08) }}s">
                <div class="overflow-hidden h-full rounded-2xl border-3 transition-transform duration-300 hover:scale-105" style="background-color: #FFE1AF; border-color: #E2B59A;">
                    <div class="relative h-56 overflow-hidden">
                        @if ($paket->foto)
                            <img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background-color: #E2B59A;">
                                <span class="text-6xl">🎒</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    </div>

                    <div class="p-6 relative z-10">
                        <h3 class="text-2xl font-outfit font-bold mb-2 line-clamp-2" style="color: #957C62;">{{ $paket->nama_paket }}</h3>
                        <p class="text-sm mb-4 line-clamp-3" style="color: #B77466;">{{ $paket->deskripsi }}</p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="badge text-white text-xs rounded-lg px-3 py-1" style="background-color: #B77466;">
                                ⏱️ {{ $paket->durasi_hari }} hari
                            </span>
                            <span class="badge text-white text-xs rounded-lg px-3 py-1" style="background-color: #E2B59A;">
                                👥 {{ $paket->kuota_peserta }} orang
                            </span>
                        </div>

                        <div class="rounded-lg p-3 mb-4 text-center border-2" style="background-color: rgba(178, 116, 102, 0.1); border-color: #E2B59A;">
                            <p class="text-xs mb-1" style="color: #B77466;">Harga Paket</p>
                            <p class="text-2xl font-outfit font-bold" style="color: #957C62;">
                                Rp{{ number_format($paket->harga_paket, 0, ',', '.') }}
                            </p>
                        </div>

                        <a href="{{ route('paket-wisata.show', $paket) }}" class="block w-full text-center py-3 px-4 text-white font-semibold rounded-lg transition-all duration-300 mb-3" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            Lihat Detail →
                        </a>
                        
                        @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'manager']))
                            <div class="flex gap-2">
                                <a href="{{ route('paket-wisata.edit', $paket) }}" class="flex-1 text-center py-2 px-4 text-white font-semibold rounded-lg transition-all text-sm" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('paket-wisata.destroy', $paket) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full py-2 px-4 text-white font-semibold rounded-lg transition-all text-sm" style="background-color: #957C62;" onmouseover="this.style.backgroundColor='#7a6351'" onmouseout="this.style.backgroundColor='#957C62'" onclick="return confirm('Yakin ingin menghapus?')">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="p-12 text-center rounded-3xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
                    <div class="text-6xl mb-4">🎒</div>
                    <h3 class="text-2xl font-outfit font-bold mb-2" style="color: #957C62;">Belum Ada Data</h3>
                    <p class="mb-6" style="color: #B77466;">Paket wisata belum ditambahkan. Cek kembali nanti atau hubungi admin.</p>
                    @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'manager']))
                        <a href="{{ route('paket-wisata.create') }}" class="inline-block px-6 py-3 text-white font-semibold rounded-lg transition-all duration-300" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                            ➕ Tambah Paket Pertama
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    @if ($paketWisata->hasPages())
        <div class="flex justify-center py-8">
            <div style="color: #957C62;">
                {{ $paketWisata->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
