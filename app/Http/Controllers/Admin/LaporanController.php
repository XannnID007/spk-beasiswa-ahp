<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilPerhitungan;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $totalSiswa = HasilPerhitungan::count();
        $totalLulus = HasilPerhitungan::where('status_kelulusan', 'lulus')->count();
        $totalTidakLulus = HasilPerhitungan::where('status_kelulusan', 'tidak_lulus')->count();

        return view('admin.laporan.index', compact('totalSiswa', 'totalLulus', 'totalTidakLulus'));
    }

    public function cetakPDF(Request $request)
    {
        $statusFilter = $request->get('status', 'all');

        $query = HasilPerhitungan::with(['siswa', 'siswa.penilaian.kriteria', 'siswa.penilaian.subKriteria'])
            ->orderBy('ranking', 'asc');

        if ($statusFilter !== 'all') {
            $query->where('status_kelulusan', $statusFilter);
        }

        $hasil = $query->get();
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();

        $pdf = PDF::loadView('admin.laporan.pdf', compact('hasil', 'kriteria'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Hasil_Seleksi_Beasiswa_' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $status = $request->input('status', 'all');
        $fileName = 'laporan-hasil-seleksi-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new LaporanExport($status), $fileName);
    }
}
