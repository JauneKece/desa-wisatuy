<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Payment;
use App\Models\Pelanggan;
use App\Models\PaketWisata;
use App\Models\Penginapan;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $reservasi = $user->role === 'customer'
            ? Reservasi::whereHas('pelanggan', function($q) use ($user) { $q->where('user_id', $user->id); })->paginate(10)
            : Reservasi::paginate(10);

        return view('reservasi.index', compact('reservasi'));
    }

    public function create()
    {
        $paketWisata = PaketWisata::all();
        $penginapan = Penginapan::all();
        return view('reservasi.create', compact('paketWisata', 'penginapan'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $pelanggan = Pelanggan::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'paket_wisata_id' => 'nullable|exists:paket_wisata,id',
            'penginapan_id' => 'nullable|exists:penginapan,id',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jumlah_peserta' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        $validated['pelanggan_id'] = $pelanggan->id;
        $validated['tanggal_reservasi'] = now()->toDateString();
        $validated['status'] = 'pending';
        $validated['total_harga'] = $this->calculateTotal($validated);

        $reservasi = Reservasi::create($validated);

        // Create pending payment record (customer will upload proof or use gateway)
        Payment::create([
            'reservasi_id' => $reservasi->id,
            'amount' => $validated['total_harga'] ?? 0,
            'method' => 'manual',
            'status' => 'pending',
            'transaction_id' => \Illuminate\Support\Str::uuid(),
        ]);

        // Use direct URL redirect to avoid missing named-route issues
        return redirect()->to('/reservasi/'.$reservasi->id.'/payment/manual')->with('success', 'Reservasi berhasil dibuat. Silakan upload bukti pembayaran.');
    }

    public function show(Reservasi $reservasi, Request $request)
    {
        $user = $request->user();
        
        // Admin/Manager get a different view with combined details
        if ($user && in_array($user->role, ['admin', 'manager'])) {
            return view('admin.reservasi.show', compact('reservasi'));
        }
        
        // Customers get the regular view
        return view('reservasi.show', compact('reservasi'));
    }

    public function edit(Request $request, Reservasi $reservasi)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->role === 'customer' && (! $reservasi->pelanggan || $reservasi->pelanggan->user_id !== $user->id)) {
            abort(403, 'Unauthorized');
        }

        $paketWisata = PaketWisata::all();
        $penginapan = Penginapan::all();
        return view('reservasi.edit', compact('reservasi', 'paketWisata', 'penginapan'));
    }

    public function update(Request $request, Reservasi $reservasi)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->role === 'customer' && (! $reservasi->pelanggan || $reservasi->pelanggan->user_id !== $user->id)) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'paket_wisata_id' => 'nullable|exists:paket_wisata,id',
            'penginapan_id' => 'nullable|exists:penginapan,id',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jumlah_peserta' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        // Only admin/manager can change status (confirm, cancel).
        if (in_array($user->role, ['admin', 'manager'])) {
            $validated['status'] = $request->validate([
                'status' => 'required|in:pending,confirmed,cancelled',
            ])['status'];
        }

        $validated['total_harga'] = $this->calculateTotal($validated);
        $reservasi->update($validated);
        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil diperbarui');
    }

    public function destroy(Request $request, Reservasi $reservasi)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        // Customer can only delete their own reservasi
        if ($user->role === 'customer' && (! $reservasi->pelanggan || $reservasi->pelanggan->user_id !== $user->id)) {
            abort(403, 'Unauthorized');
        }

        // Admin & Manager can delete any reservasi

        $reservasi->delete();
        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dihapus');
    }

    private function calculateTotal($data)
    {
        $total = 0;
        if ($data['paket_wisata_id'] ?? null) {
            $paket = PaketWisata::find($data['paket_wisata_id']);
            $total += ($paket->harga_paket ?? 0) * ($data['jumlah_peserta'] ?? 1);
        }
        if ($data['penginapan_id'] ?? null) {
            $penginapan = Penginapan::find($data['penginapan_id']);
            $total += ($penginapan->harga_penginapan ?? 0) * ($data['jumlah_peserta'] ?? 1);
        }
        return $total;
    }
}
