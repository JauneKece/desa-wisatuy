@extends('layouts.app')

@section('title', 'Kelola Pembayaran - Desmok')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold" style="color: #957C62;">💳 Kelola Pembayaran</h1>
                <p class="text-sm md:text-base mt-2" style="color: #B77466;">Verifikasi bukti pembayaran dari customer</p>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Total -->
            <div class="rounded-xl p-4" style="background-color: white; border: 2px solid #E2B59A; box-shadow: 0 2px 4px rgba(149, 124, 98, 0.1);">
                <p class="text-xs font-semibold" style="color: #B77466;">Total Pembayaran</p>
                <p class="text-2xl font-bold mt-1" style="color: #957C62;">{{ count($payments) }}</p>
            </div>

            <!-- Pending -->
            <div class="rounded-xl p-4" style="background-color: white; border: 2px solid #FFC107; box-shadow: 0 2px 4px rgba(255, 193, 7, 0.1);">
                <p class="text-xs font-semibold" style="color: #957C62;">⏳ Menunggu Verifikasi</p>
                <p class="text-2xl font-bold mt-1" style="color: #FFC107;">{{ count($payments->where('status', 'pending')) }}</p>
            </div>

            <!-- Paid -->
            <div class="rounded-xl p-4" style="background-color: white; border: 2px solid #28A745; box-shadow: 0 2px 4px rgba(40, 167, 69, 0.1);">
                <p class="text-xs font-semibold" style="color: #957C62;">✅ Dikonfirmasi</p>
                <p class="text-2xl font-bold mt-1" style="color: #28A745;">{{ count($payments->where('status', 'paid')) }}</p>
            </div>

            <!-- Rejected -->
            <div class="rounded-xl p-4" style="background-color: white; border: 2px solid #DC3545; box-shadow: 0 2px 4px rgba(220, 53, 69, 0.1);">
                <p class="text-xs font-semibold" style="color: #957C62;">❌ Ditolak</p>
                <p class="text-2xl font-bold mt-1" style="color: #DC3545;">{{ count($payments->where('status', 'failed')) }}</p>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="rounded-3xl overflow-hidden" style="background-color: white; border: 3px solid #E2B59A; box-shadow: 0 4px 6px rgba(149, 124, 98, 0.1);">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr style="background: linear-gradient(90deg, #FFE1AF 0%, #E2B59A 100%);">
                        <th class="px-4 py-4 text-left text-sm font-bold" style="color: #957C62;">ID</th>
                        <th class="px-4 py-4 text-left text-sm font-bold" style="color: #957C62;">Customer</th>
                        <th class="px-4 py-4 text-left text-sm font-bold" style="color: #957C62;">Jumlah</th>
                        <th class="px-4 py-4 text-left text-sm font-bold" style="color: #957C62;">Metode</th>
                        <th class="px-4 py-4 text-left text-sm font-bold" style="color: #957C62;">Status</th>
                        <th class="px-4 py-4 text-left text-sm font-bold" style="color: #957C62;">Waktu Upload</th>
                        <th class="px-4 py-4 text-center text-sm font-bold" style="color: #957C62;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: #E2B59A;">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50 transition {{ $loop->odd ? 'bg-custom-faf8' : 'bg-custom-white' }}">
                            <!-- ID -->
                            <td class="px-4 py-4 text-sm font-bold" style="color: #957C62;">#{{ $payment->id }}</td>

                            <!-- Customer -->
                            <td class="px-4 py-4 text-sm">
                                <div class="font-bold" style="color: #957C62;">{{ $payment->reservasi->pelanggan->user->name }}</div>
                                <div style="color: #B77466; font-size: 0.875rem;">{{ $payment->reservasi->id }}</div>
                            </td>

                            <!-- Amount -->
                            <td class="px-4 py-4 text-sm font-bold" style="color: #B77466;">
                                Rp{{ number_format($payment->amount, 0, ',', '.') }}
                            </td>

                            <!-- Method -->
                            <td class="px-4 py-4 text-sm">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold" 
                                    @switch($payment->method)
                                        @case('bank_transfer')
                                            style="background-color: #d4edff; color: #0066cc;"
                                            @break
                                        @case('qris')
                                            style="background-color: #e6f5ff; color: #1a7f9f;"
                                            @break
                                        @default
                                            style="background-color: #fff0e6; color: #cc6600;"
                                    @endswitch
                                >
                                    @if($payment->method === 'bank_transfer')
                                        🏦 Bank Transfer
                                    @elseif($payment->method === 'qris')
                                        📱 QRIS
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                                    @endif
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-4 text-sm">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold text-white"
                                    @switch($payment->status)
                                        @case('pending')
                                            style="background-color: #FFC107;"
                                            @break
                                        @case('paid')
                                            style="background-color: #28A745;"
                                            @break
                                        @case('failed')
                                            style="background-color: #DC3545;"
                                            @break
                                        @default
                                            style="background-color: #6C757D;"
                                    @endswitch
                                >
                                    @switch($payment->status)
                                        @case('pending')
                                            ⏳ Pending
                                            @break
                                        @case('paid')
                                            ✅ Dibayar
                                            @break
                                        @case('failed')
                                            ❌ Ditolak
                                            @break
                                        @default
                                            {{ ucfirst($payment->status) }}
                                    @endswitch
                                </span>
                            </td>

                            <!-- Created At -->
                            <td class="px-4 py-4 text-sm" style="color: #B77466;">
                                {{ $payment->created_at->format('d M Y') }}<br>
                                <span class="text-xs" style="color: #957C62;">{{ $payment->created_at->format('H:i') }} WIB</span>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-4 text-center">
                                <a href="{{ route('admin.payments.show', $payment) }}" 
                                    class="inline-block px-4 py-2 text-white font-bold rounded-lg transition duration-150 text-sm"
                                    style="background-color: #B77466;"
                                    onmouseover="this.style.backgroundColor='#957C62'"
                                    onmouseout="this.style.backgroundColor='#B77466'">
                                    👁️ Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <div style="color: #B77466;">
                                    <p class="text-lg font-semibold">📭 Tidak ada pembayaran</p>
                                    <p class="text-sm mt-1">Belum ada pembayaran yang perlu diverifikasi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($payments->hasPages())
            <div class="px-4 py-4 border-t flex justify-center" style="border-color: #E2B59A;">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
