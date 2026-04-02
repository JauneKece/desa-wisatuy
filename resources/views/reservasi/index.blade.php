@extends('layouts.app')

@section('title', 'Reservasi Saya - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
        <h1 class="text-3xl md:text-4xl font-bold" style="color: #957C62;">📅 Daftar Reservasi</h1>
        @if (auth()->check() && auth()->user()->role === 'customer')
            <a href="{{ route('reservasi.create') }}" class="inline-block px-6 py-2 md:py-3 text-white font-bold text-sm md:text-base rounded-lg transition duration-150 hover:scale-105" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">➕ Buat Reservasi Baru</a>
        @endif
    </div>

    <div class="rounded-3xl border-3 overflow-hidden" style="border-color: #E2B59A; background-color: white;">
        <table class="w-full text-sm md:text-base">
            <thead>
                <tr style="background-color: #FFE1AF; border-bottom: 3px solid #E2B59A;">
                    <th class="px-4 py-3 text-left font-bold" style="color: #957C62;">📅 Tanggal Kunjungan</th>
                    <th class="px-4 py-3 text-left font-bold" style="color: #957C62;">👥 Peserta</th>
                    <th class="px-4 py-3 text-left font-bold" style="color: #957C62;">🎒 Paket</th>
                    <th class="px-4 py-3 text-left font-bold" style="color: #957C62;">🏨 Penginapan</th>
                    <th class="px-4 py-3 text-right font-bold" style="color: #957C62;">💰 Total Harga</th>
                    <th class="px-4 py-3 text-center font-bold" style="color: #957C62;">📊 Status</th>
                    <th class="px-4 py-3 text-center font-bold" style="color: #957C62;">⚙️ Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservasi as $item)
                    <tr style="border-bottom: 1px solid #FFE1AF;">
                        <td class="px-4 py-3" style="color: #B77466;">{{ $item->tanggal_kunjungan->format('d M Y') }}</td>
                        <td class="px-4 py-3" style="color: #B77466;">{{ $item->jumlah_peserta }} orang</td>
                        <td class="px-4 py-3" style="color: #B77466;">{{ $item->paketWisata->nama_paket ?? '-' }}</td>
                        <td class="px-4 py-3" style="color: #B77466;">{{ $item->penginapan->nama_penginapan ?? '-' }}</td>
                        <td class="px-4 py-3 text-right font-bold" style="color: #957C62;">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold text-white"
                                style="@switch($item->status)
                                    @case('pending') background-color: #E2B59A; @break
                                    @case('confirmed') background-color: #B77466; @break
                                    @case('completed') background-color: #957C62; @break  
                                    @default background-color: #999;
                                @endswitch">
                                @switch($item->status)
                                    @case('pending')
                                        ⏳ Pending
                                        @break
                                    @case('confirmed')
                                        ✅ Confirmed
                                        @break
                                    @case('completed')
                                        🎉 Completed
                                        @break
                                    @case('cancelled')
                                        ❌ Cancelled
                                        @break
                                @endswitch
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col gap-2 justify-center items-center">
                                <a href="{{ route('reservasi.show', $item) }}" class="px-3 py-1 text-white text-xs font-bold rounded transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">👁️ Lihat</a>
                                @if (auth()->user()->role === 'customer' && $item->status === 'pending')
                                    <a href="{{ route('reservasi.edit', $item) }}" class="px-3 py-1 text-white text-xs font-bold rounded transition-all" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">✏️ Edit</a>
                                    <form action="{{ route('reservasi.destroy', $item) }}" method="POST" style="width: 100%;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-3 py-1 text-white text-xs font-bold rounded transition-all" style="background-color: #d32f2f;" onmouseover="this.style.backgroundColor='#b71c1c'" onmouseout="this.style.backgroundColor='#d32f2f'" onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</button>
                                    </form>
                                @elseif (in_array(auth()->user()->role, ['admin', 'manager']))
                                    <a href="{{ route('reservasi.edit', $item) }}" class="px-3 py-1 text-white text-xs font-bold rounded transition-all" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">✏️ Edit</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8">
                            <p style="color: #B77466; font-size: 1.1rem;">Belum ada reservasi</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $reservasi->links() }}
    </div>
</div>
@endsection
