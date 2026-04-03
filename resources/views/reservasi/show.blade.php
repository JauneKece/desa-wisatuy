@extends('layouts.app')

@section('title', 'Lihat Reservasi - Desmok')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="rounded-3xl p-6 md:p-8 mb-6" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        <h1 class="text-3xl md:text-4xl font-bold mb-6" style="color: #957C62;">📋 Detail Reservasi</h1>

        <!-- Detail Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Paket Wisata -->
            <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                <p class="text-sm font-bold mb-2" style="color: #957C62;">🎒 Paket Wisata</p>
                <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->paketWisata->nama_paket ?? 'Tidak dipilih' }}</p>
            </div>

            <!-- Penginapan -->
            <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                <p class="text-sm font-bold mb-2" style="color: #957C62;">🏨 Penginapan</p>
                <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->penginapan->nama_penginapan ?? 'Tidak dipilih' }}</p>
            </div>

            <!-- Tanggal Kunjungan -->
            <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                <p class="text-sm font-bold mb-2" style="color: #957C62;">📅 Tanggal Kunjungan</p>
                <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->tanggal_kunjungan->format('d M Y') }}</p>
            </div>

            <!-- Jumlah Peserta -->
            <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                <p class="text-sm font-bold mb-2" style="color: #957C62;">👥 Jumlah Pengunjung</p>
                <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->jumlah_peserta }} orang</p>
            </div>
        </div>

        <!-- Total Harga & Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Total Harga -->
            <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                <p class="text-sm font-bold mb-2" style="color: #957C62;">💰 Total Harga</p>
                <p class="text-2xl font-bold" style="color: #B77466;">Rp{{ number_format($reservasi->total_harga, 0, ',', '.') }}</p>
            </div>

            <!-- Status -->
            <div class="p-4 rounded-lg" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                <p class="text-sm font-bold mb-2" style="color: #957C62;">📊 Status</p>
                <p>
                    @switch($reservasi->status)
                        @case('pending')
                            <span class="inline-block px-3 py-1 text-white font-bold rounded-lg" style="background-color: #FFC107;">⏳ Pending</span>
                        @break
                        @case('confirmed')
                            <span class="inline-block px-3 py-1 text-white font-bold rounded-lg" style="background-color: #28A745;">✅ Confirmed</span>
                        @break
                        @case('completed')
                            <span class="inline-block px-3 py-1 text-white font-bold rounded-lg" style="background-color: #007BFF;">🎉 Completed</span>
                        @break
                        @case('cancelled')
                            <span class="inline-block px-3 py-1 text-white font-bold rounded-lg" style="background-color: #DC3545;">❌ Cancelled</span>
                        @break
                    @endswitch
                </p>
            </div>
        </div>

        <!-- Catatan -->
        @if ($reservasi->catatan)
            <div class="p-4 rounded-lg mb-6" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
                <p class="text-sm font-bold mb-2" style="color: #957C62;">📝 Catatan</p>
                <p style="color: #957C62;">{{ $reservasi->catatan }}</p>
            </div>
        @endif

        <!-- Nama Pelanggan -->
        <div class="p-4 rounded-lg mb-6" style="background-color: #FFE1AF; border-left: 4px solid #B77466;">
            <p class="text-sm font-bold mb-2" style="color: #957C62;">👤 Nama Pelanggan</p>
            <p class="text-lg font-semibold" style="color: #B77466;">{{ $reservasi->pelanggan->user->name }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3 mt-6">
            <a href="{{ route('reservasi.index') }}" 
               class="px-6 py-3 text-white font-bold rounded-lg transition duration-150" 
               style="background-color: #957C62;"
               onmouseover="this.style.backgroundColor='#7A5F4A'"
               onmouseout="this.style.backgroundColor='#957C62'">
                ← Kembali ke Daftar
            </a>

            @if (auth()->user()->role === 'customer' && $reservasi->status === 'pending')
                <a href="{{ route('reservasi.edit', $reservasi) }}" 
                   class="px-6 py-3 text-white font-bold rounded-lg transition duration-150" 
                   style="background-color: #B77466;"
                   onmouseover="this.style.backgroundColor='#957C62'"
                   onmouseout="this.style.backgroundColor='#B77466'">
                    ✏️ Edit
                </a>
                <form action="{{ route('reservasi.destroy', $reservasi) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-6 py-3 text-white font-bold rounded-lg transition duration-150" 
                            style="background-color: #DC3545;"
                            onmouseover="this.style.backgroundColor='#C82333'"
                            onmouseout="this.style.backgroundColor='#DC3545'"
                            onclick="return confirm('Yakin ingin menghapus reservasi ini?')">
                        🗑️ Hapus
                    </button>
                </form>
            @elseif (in_array(auth()->user()->role, ['admin', 'manager']))
                <a href="{{ route('reservasi.edit', $reservasi) }}" 
                   class="px-6 py-3 text-white font-bold rounded-lg transition duration-150" 
                   style="background-color: #B77466;"
                   onmouseover="this.style.backgroundColor='#957C62'"
                   onmouseout="this.style.backgroundColor='#B77466'">
                    ✏️ Edit
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
