<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::withCount('subKriteria')->orderBy('kode_kriteria')->get();
        return view('admin.kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriteria,kode_kriteria|max:10',
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1',
            'keterangan' => 'nullable|string',
        ]);

        Kriteria::create($request->all());

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $request->validate([
            'kode_kriteria' => 'required|max:10|unique:kriteria,kode_kriteria,' . $id,
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1',
            'keterangan' => 'nullable|string',
        ]);

        $kriteria->update($request->all());

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus!');
    }
}
