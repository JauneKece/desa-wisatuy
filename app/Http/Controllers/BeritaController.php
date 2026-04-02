<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with(['kategoriBerita', 'user'])->where('status', true)->paginate(9);
        return view('berita.index', compact('berita'));
    }

    public function create()
    {
        $kategoris = KategoriBerita::all();
        return view('berita.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'kategori_berita_id' => 'required|exists:kategori_berita,id',
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $validated['user_id'] = $user->id;
        $validated['status'] = true;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('berita', 'public');
            $validated['foto'] = $path;
        }

        Berita::create($validated);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function show(Berita $berita)
    {
        return view('berita.show', compact('berita'));
    }

    public function edit(Request $request, Berita $berita)
    {
        $user = $request->user();
        if (! $user || ($user->id !== $berita->user_id && !in_array($user->role, ['admin', 'manager']))) {
            abort(403, 'Unauthorized');
        }
        $kategoris = KategoriBerita::all();
        return view('berita.edit', compact('berita', 'kategoris'));
    }

    public function update(Request $request, Berita $berita)
    {
        $user = $request->user();
        if (! $user || ($user->id !== $berita->user_id && !in_array($user->role, ['admin', 'manager']))) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'kategori_berita_id' => 'required|exists:kategori_berita,id',
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('berita', 'public');
            $validated['foto'] = $path;
        }

        $berita->update($validated);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy(Request $request, Berita $berita)
    {
        $user = $request->user();
        if (! $user || ($user->id !== $berita->user_id && !in_array($user->role, ['admin', 'manager']))) {
            abort(403, 'Unauthorized');
        }
        $berita->delete();
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus');
    }
}
