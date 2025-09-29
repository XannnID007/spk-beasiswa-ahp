<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    public function index()
    {
        $beasiswa = Beasiswa::latest()->paginate(10);
        return view('admin.beasiswa.index', compact('beasiswa'));
    }

    public function create()
    {
        return view('admin.beasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_beasiswa' => 'required|string|max:255',
            'jenis_beasiswa' => 'required|string',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
            'nominal' => 'nullable|numeric|min:0',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after:tanggal_buka',
            'status' => 'required|in:aktif,nonaktif',
            'tahun_ajaran' => 'required|string',
        ]);

        Beasiswa::create($request->all());

        return redirect()->route('admin.beasiswa.index')
            ->with('success', 'Data beasiswa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $beasiswa = Beasiswa::with('pengajuan.siswa')->findOrFail($id);
        return view('admin.beasiswa.show', compact('beasiswa'));
    }

    public function edit($id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        return view('admin.beasiswa.edit', compact('beasiswa'));
    }

    public function update(Request $request, $id)
    {
        $beasiswa = Beasiswa::findOrFail($id);

        $request->validate([
            'nama_beasiswa' => 'required|string|max:255',
            'jenis_beasiswa' => 'required|string',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
            'nominal' => 'nullable|numeric|min:0',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after:tanggal_buka',
            'status' => 'required|in:aktif,nonaktif',
            'tahun_ajaran' => 'required|string',
        ]);

        $beasiswa->update($request->all());

        return redirect()->route('admin.beasiswa.index')
            ->with('success', 'Data beasiswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $beasiswa = Beasiswa::findOrFail($id);

        // Cek apakah ada pengajuan
        if ($beasiswa->pengajuan()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus beasiswa yang sudah memiliki pengajuan!');
        }

        $beasiswa->delete();

        return redirect()->route('admin.beasiswa.index')
            ->with('success', 'Data beasiswa berhasil dihapus!');
    }
}
