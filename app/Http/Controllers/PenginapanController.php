<?php

namespace App\Http\Controllers;

use App\Models\Penginapan;
use Illuminate\Http\Request;

class PenginapanController extends Controller
{
    public function index()
    {
        $penginapan = Penginapan::paginate(9);
        return view('penginapan.index', compact('penginapan'));
    }

    public function create()
    {
        return view('penginapan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penginapan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'harga_penginapan' => 'required|numeric|min:0',
            'jumlah_kamar' => 'required|integer|min:1',
            'tipe_kamar' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|integer|between:1,5',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('penginapan', 'public');
            $validated['foto'] = $path;
        }

        Penginapan::create($validated);
        return redirect()->route('penginapan.index')->with('success', 'Penginapan berhasil ditambahkan');
    }

    public function show(Penginapan $penginapan)
    {
        return view('penginapan.show', compact('penginapan'));
    }

    public function edit(Penginapan $penginapan)
    {
        return view('penginapan.edit', compact('penginapan'));
    }

    public function update(Request $request, Penginapan $penginapan)
    {
        $validated = $request->validate([
            'nama_penginapan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'harga_penginapan' => 'required|numeric|min:0',
            'jumlah_kamar' => 'required|integer|min:1',
            'tipe_kamar' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|integer|between:1,5',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('penginapan', 'public');
            $validated['foto'] = $path;
        }

        $penginapan->update($validated);
        return redirect()->route('penginapan.index')->with('success', 'Penginapan berhasil diperbarui');
    }

    public function destroy(Penginapan $penginapan)
    {
        $penginapan->delete();
        return redirect()->route('penginapan.index')->with('success', 'Penginapan berhasil dihapus');
    }
}
