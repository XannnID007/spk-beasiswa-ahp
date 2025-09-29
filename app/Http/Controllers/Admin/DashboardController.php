<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\PengajuanBeasiswa;
use App\Models\HasilPerhitungan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total data
        $totalSiswa = Siswa::count();
        $pengajuanPending = PengajuanBeasiswa::where('status', 'pending')->count();
        $pengajuanDiverifikasi = PengajuanBeasiswa::where('status', 'diverifikasi')->count();
        $pengajuanDitolak = PengajuanBeasiswa::where('status', 'ditolak')->count();
        $totalLulus = HasilPerhitungan::where('status_kelulusan', 'lulus')->count();

        // Pengajuan terbaru
        $pengajuanTerbaru = PengajuanBeasiswa::with('siswa')
            ->latest()
            ->take(5)
            ->get();

        // Data chart pengajuan per bulan
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $count = PengajuanBeasiswa::whereYear('tanggal_pengajuan', date('Y'))
                ->whereMonth('tanggal_pengajuan', $i)
                ->count();
            $chartData[] = $count;
        }

        return view('admin.dashboard', compact(
            'totalSiswa',
            'pengajuanPending',
            'pengajuanDiverifikasi',
            'pengajuanDitolak',
            'totalLulus',
            'pengajuanTerbaru',
            'chartData'
        ));
    }
}
