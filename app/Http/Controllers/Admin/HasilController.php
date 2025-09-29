<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilPerhitungan;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
    {
        $hasil = HasilPerhitungan::with('siswa')->orderBy('ranking', 'asc')->paginate(20);
        $totalLulus = HasilPerhitungan::where('status_kelulusan', 'lulus')->count();
        $totalTidakLulus = HasilPerhitungan::where('status_kelulusan', 'tidak_lulus')->count();

        return view('admin.hasil.index', compact('hasil', 'totalLulus', 'totalTidakLulus'));
    }

    public function show($id)
    {
        $hasil = HasilPerhitungan::with('siswa')->findOrFail($id);
        $penilaian = Penilaian::with(['kriteria', 'subKriteria'])
            ->where('siswa_id', $hasil->siswa_id)
            ->get();

        return view('admin.hasil.show', compact('hasil', 'penilaian'));
    }

    public function updateStatus(Request $request, $id)
    {
        $hasil = HasilPerhitungan::findOrFail($id);

        $request->validate([
            'status_kelulusan' => 'required|in:lulus,tidak_lulus',
            'catatan' => 'nullable|string',
        ]);

        $hasil->update([
            'status_kelulusan' => $request->status_kelulusan,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Status kelulusan berhasil diperbarui!');
    }
}
