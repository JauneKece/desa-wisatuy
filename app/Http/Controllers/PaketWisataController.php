<?php

namespace App\Http\Controllers;

use App\Models\PaketWisata;
use Illuminate\Http\Request;

class PaketWisataController extends Controller
{
    public function index()
    {
        $paketWisata = PaketWisata::paginate(9);
        return view('paket-wisata.index', compact('paketWisata'));
    }

    public function create()
    {
        return view('paket-wisata.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_paket' => 'required|numeric|min:0',
            'durasi_hari' => 'required|integer|min:1',
            'durasi_jam' => 'required|integer|min:0',
            'kuota_peserta' => 'required|integer|min:1',
            'itinerary' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('paket-wisata', 'public');
            $validated['foto'] = $path;
        }

        PaketWisata::create($validated);
        return redirect()->route('paket-wisata.index')->with('success', 'Paket wisata berhasil ditambahkan');
    }

    public function show(PaketWisata $paketWisata)
    {
        return view('paket-wisata.show', compact('paketWisata'));
    }

    public function edit(PaketWisata $paketWisata)
    {
        return view('paket-wisata.edit', compact('paketWisata'));
    }

    public function update(Request $request, PaketWisata $paketWisata)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_paket' => 'required|numeric|min:0',
            'durasi_hari' => 'required|integer|min:1',
            'durasi_jam' => 'required|integer|min:0',
            'kuota_peserta' => 'required|integer|min:1',
            'itinerary' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('paket-wisata', 'public');
            $validated['foto'] = $path;
        }

        $paketWisata->update($validated);
        return redirect()->route('paket-wisata.index')->with('success', 'Paket wisata berhasil diperbarui');
    }

    public function destroy(PaketWisata $paketWisata)
    {
        $paketWisata->delete();
        return redirect()->route('paket-wisata.index')->with('success', 'Paket wisata berhasil dihapus');
    }
}
