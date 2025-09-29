<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $subKriteria = SubKriteria::with('kriteria')->orderBy('kriteria_id')->get();
        return view('admin.sub-kriteria.index', compact('subKriteria'));
    }

    public function create()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        return view('admin.sub-kriteria.create', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriteria,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai_sub' => 'required|numeric',
            'range_min' => 'nullable|numeric',
            'range_max' => 'nullable|numeric',
            'kategori' => 'nullable|string',
        ]);

        SubKriteria::create($request->all());

        return redirect()->route('admin.sub-kriteria.index')
            ->with('success', 'Sub-kriteria berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        return view('admin.sub-kriteria.edit', compact('subKriteria', 'kriteria'));
    }

    public function update(Request $request, $id)
    {
        $subKriteria = SubKriteria::findOrFail($id);

        $request->validate([
            'kriteria_id' => 'required|exists:kriteria,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai_sub' => 'required|numeric',
            'range_min' => 'nullable|numeric',
            'range_max' => 'nullable|numeric',
            'kategori' => 'nullable|string',
        ]);

        $subKriteria->update($request->all());

        return redirect()->route('admin.sub-kriteria.index')
            ->with('success', 'Sub-kriteria berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $subKriteria->delete();

        return redirect()->route('admin.sub-kriteria.index')
            ->with('success', 'Sub-kriteria berhasil dihapus!');
    }

    public function getByKriteria($kriteria_id)
    {
        $subKriteria = SubKriteria::where('kriteria_id', $kriteria_id)->get();
        return response()->json($subKriteria);
    }
}
