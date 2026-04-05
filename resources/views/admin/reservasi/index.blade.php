@extends('layouts.app')

@section('title', 'Kelola Reservasi - Admin - Desmok')

@section('content')
<div class="container-responsive py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl md:text-5xl font-outfit font-black mb-2" style="color: #957C62;">📋 Kelola Reservasi</h1>
        <p class="text-lg" style="color: #B77466;">Lihat dan kelola semua reservasi pelanggan secara terpusat</p>
    </div>

    <!-- Filter Section -->
    <div class="mb-6 p-6 rounded-2xl" style="background-color: #FFE1AF; border: 2px solid #B77466;">
        <form method="GET" action="{{ route('admin.reservasi.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-2" style="color: #957C62;">Status</label>
                <select name="status" class="w-full px-4 py-2 rounded-lg border-2" style="border-color: #B77466;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2" style="color: #957C62;">Cari</label>
                <input type="text" name="search" placeholder="Nama pelanggan..." class="w-full px-4 py-2 rounded-lg border-2" style="border-color: #B77466;" value="{{ request('search') }}">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 text-white font-semibold rounded-lg transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                    Cari
                </button>
                <a href="{{ route('admin.reservasi.index') }}" class="flex-1 text-center px-4 py-2 text-white font-semibold rounded-lg transition-all" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border-3 overflow-hidden" style="border-color: #B77466;">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr style="background-color: #FFE1AF; border-bottom: 3px solid #B77466;">
                        <th class="px-6 py-4 text-left" style="color: #957C62;">Pelanggan</th>
                        <th class="px-6 py-4 text-left" style="color: #957C62;">Paket / Akomodasi</th>
                        <th class="px-6 py-4 text-center" style="color: #957C62;">Peserta</th>
                        <th class="px-6 py-4 text-left" style="color: #957C62;">Tanggal Kunjungan</th>
                        <th class="px-6 py-4 text-right" style="color: #957C62;">Total</th>
                        <th class="px-6 py-4 text-left" style="color: #957C62;">Pembayaran</th>
                        <th class="px-6 py-4 text-center" style="color: #957C62;">Status</th>
                        <th class="px-6 py-4 text-center" style="color: #957C62;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservasi as $res)
                    <tr style="border-bottom: 2px solid #E2B59A;">
                        <td class="px-6 py-4" style="color: #B77466;">
                            <div class="font-semibold" style="color: #957C62;">{{ $res->pelanggan?->user->name ?? 'Guest' }}</div>
                            <div class="text-xs" style="color: #B77466;">{{ $res->pelanggan?->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4" style="color: #B77466;">
                            <div class="font-semibold">{{ $res->paketWisata?->nama_paket ?? 'Custom' }}</div>
                            @if($res->penginapan)
                            <div class="text-xs">+ {{ $res->penginapan->nama_penginapan }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center" style="color: #B77466;">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-bold text-white" style="background-color: #E2B59A;">
                                {{ $res->jumlah_peserta }}
                            </span>
                        </td>
                        <td class="px-6 py-4" style="color: #B77466;">
                            {{ \Carbon\Carbon::parse($res->tanggal_kunjungan)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right font-bold" style="color: #957C62;">
                            Rp {{ number_format($res->total_harga ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($res->payment)
                            @php
                                $paymentStatusColor = $res->payment->status === 'paid'
                                    ? '#25a561'
                                    : ($res->payment->status === 'failed' ? '#dc3545' : '#ffc107');
                            @endphp
                            <span class="inline-block px-3 py-1 rounded text-xs font-bold text-white" 
                                style="background-color: <?php echo e($paymentStatusColor); ?>;">
                                {{ ucfirst($res->payment->status) }}
                            </span>
                            @else
                            <span class="text-xs" style="color: #B77466;">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $reservasiStatusColor = $res->status === 'confirmed'
                                    ? '#25a561'
                                    : ($res->status === 'cancelled' ? '#dc3545' : '#ffc107');
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-bold text-white" 
                                style="background-color: <?php echo e($reservasiStatusColor); ?>;">
                                {{ ucfirst($res->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('admin.reservasi.show', $res->id) }}" class="px-4 py-2 text-white text-sm font-semibold rounded transition-all" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
                                    Lihat
                                </a>
                                @if($res->payment)
                                <a href="{{ route('admin.payments.show', $res->payment->id) }}" class="px-3 py-2 text-white text-sm font-semibold rounded transition-all" style="background-color: #E2B59A;" onmouseover="this.style.backgroundColor='#B77466'" onmouseout="this.style.backgroundColor='#E2B59A'">
                                    💳
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center" style="color: #B77466;">
                            <div class="text-5xl mb-3">📋</div>
                            <div class="font-semibold">Belum ada reservasi</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reservasi->hasPages())
        <div class="px-6 py-4 border-t-2" style="border-color: #E2B59A;">
            {{ $reservasi->links() }}
        </div>
        @endif
    </div>

    <!-- Summary Cards -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="p-6 rounded-2xl text-center border-3" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="text-3xl mb-2">📋</div>
            <div class="text-2xl font-bold" style="color: #957C62;">{{ $reservasi->total() }}</div>
            <div style="color: #B77466;">Total Reservasi</div>
        </div>

        <div class="p-6 rounded-2xl text-center border-3" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="text-3xl mb-2">🔄</div>
            <div class="text-2xl font-bold" style="color: #957C62;">
                {{ \App\Models\Reservasi::where('status', 'pending')->count() }}
            </div>
            <div style="color: #B77466;">Pending</div>
        </div>

        <div class="p-6 rounded-2xl text-center border-3" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="text-3xl mb-2">✅</div>
            <div class="text-2xl font-bold" style="color: #957C62;">
                {{ \App\Models\Reservasi::where('status', 'confirmed')->count() }}
            </div>
            <div style="color: #B77466;">Confirmed</div>
        </div>

        <div class="p-6 rounded-2xl text-center border-3" style="background-color: #FFE1AF; border-color: #B77466;">
            <div class="text-3xl mb-2">🚫</div>
            <div class="text-2xl font-bold" style="color: #957C62;">
                {{ \App\Models\Reservasi::where('status', 'cancelled')->count() }}
            </div>
            <div style="color: #B77466;">Cancelled</div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        table {
            font-size: 0.875rem;
        }

        table th, table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

@endsection
