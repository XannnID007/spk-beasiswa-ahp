<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilPerhitungan;
use App\Models\Penilaian;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        // Ambil hasil perhitungan
        $hasil = HasilPerhitungan::where('siswa_id', $siswa->id)->first();

        // Ambil detail penilaian
        $penilaian = [];
        if ($hasil) {
            $penilaian = Penilaian::with(['kriteria', 'subKriteria'])
                ->where('siswa_id', $siswa->id)
                ->get();
        }

        return view('siswa.hasil.index', compact('hasil', 'penilaian'));
    }

    public function cetakPDF()
    {
        $siswa = Auth::user()->siswa;
        $hasil = HasilPerhitungan::where('siswa_id', $siswa->id)->first();

        if (!$hasil) {
            return back()->with('error', 'Hasil perhitungan belum tersedia!');
        }

        $penilaian = Penilaian::with(['kriteria', 'subKriteria'])
            ->where('siswa_id', $siswa->id)
            ->get();

        $kriteria = Kriteria::orderBy('kode_kriteria')->get();

        $pdf = PDF::loadView('siswa.hasil.pdf', compact('siswa', 'hasil', 'penilaian', 'kriteria'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Hasil_Seleksi_Beasiswa_' . $siswa->nis . '.pdf');
    }
}
