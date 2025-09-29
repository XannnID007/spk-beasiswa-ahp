<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBeasiswa;
use App\Models\HasilPerhitungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        // Ambil pengajuan beasiswa siswa
        $pengajuan = PengajuanBeasiswa::where('siswa_id', $siswa->id)->latest()->first();

        // Ambil hasil perhitungan jika ada
        $hasilPerhitungan = HasilPerhitungan::where('siswa_id', $siswa->id)->first();

        return view('siswa.dashboard', compact('siswa', 'pengajuan', 'hasilPerhitungan'));
    }
}
