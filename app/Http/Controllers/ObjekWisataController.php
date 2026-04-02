<?php

namespace App\Http\Controllers;

use App\Models\ObjekWisata;
use App\Models\KategoriWisata;
use Illuminate\Http\Request;

class ObjekWisataController extends Controller
{
    public function index()
    {
        $objekWisata = ObjekWisata::with('kategoriWisata')->paginate(9);
        return view('objek-wisata.index', compact('objekWisata'));
    }

    public function create()
    {
        $kategoris = KategoriWisata::all();
        return view('objek-wisata.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_wisata_id' => 'required|exists:kategori_wisata,id',
            'nama_objek' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'harga_tiket' => 'required|numeric|min:0',
            'jam_buka' => 'required|string',
            'jam_tutup' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|integer|between:1,5',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('objek-wisata', 'public');
            $validated['foto'] = $path;
        }

        ObjekWisata::create($validated);
        return redirect()->route('objek-wisata.index')->with('success', 'Objek wisata berhasil ditambahkan');
    }

    public function show(ObjekWisata $objekWisata)
    {
        return view('objek-wisata.show', compact('objekWisata'));
    }

    public function edit(ObjekWisata $objekWisata)
    {
        $kategoris = KategoriWisata::all();
        return view('objek-wisata.edit', compact('objekWisata', 'kategoris'));
    }

    public function update(Request $request, ObjekWisata $objekWisata)
    {
        $validated = $request->validate([
            'kategori_wisata_id' => 'required|exists:kategori_wisata,id',
            'nama_objek' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'harga_tiket' => 'required|numeric|min:0',
            'jam_buka' => 'required|string',
            'jam_tutup' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|integer|between:1,5',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('objek-wisata', 'public');
            $validated['foto'] = $path;
        }

        $objekWisata->update($validated);
        return redirect()->route('objek-wisata.index')->with('success', 'Objek wisata berhasil diperbarui');
    }

    public function destroy(ObjekWisata $objekWisata)
    {
        $objekWisata->delete();
        return redirect()->route('objek-wisata.index')->with('success', 'Objek wisata berhasil dihapus');
    }
}
