<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Penilaian;
use App\Models\PengajuanBeasiswa;
use App\Models\HasilPerhitungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerhitunganController extends Controller
{
    public function index()
    {
        // Ambil data untuk info
        $totalSiswaVerifikasi = PengajuanBeasiswa::where('status', 'diverifikasi')->count();
        $siswaLengkap = Penilaian::select('siswa_id')
            ->groupBy('siswa_id')
            ->havingRaw('COUNT(DISTINCT kriteria_id) = 4')
            ->count();
        $sudahDihitung = HasilPerhitungan::count();
        $belumDihitung = $siswaLengkap - $sudahDihitung;

        // Ambil hasil perhitungan jika ada
        $hasilPerhitungan = HasilPerhitungan::with('siswa')
            ->orderBy('ranking', 'asc')
            ->get();

        // Ambil kriteria
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();

        return view('admin.perhitungan.index', compact(
            'totalSiswaVerifikasi',
            'siswaLengkap',
            'sudahDihitung',
            'belumDihitung',
            'hasilPerhitungan',
            'kriteria'
        ));
    }

    public function proses()
    {
        try {
            // Ambil kriteria dengan bobotnya
            $kriteria = Kriteria::orderBy('kode_kriteria')->get();

            // Ambil siswa yang sudah dinilai lengkap (semua 4 kriteria)
            $siswaIds = Penilaian::select('siswa_id')
                ->groupBy('siswa_id')
                ->havingRaw('COUNT(DISTINCT kriteria_id) = 4')
                ->pluck('siswa_id');

            if ($siswaIds->count() == 0) {
                return back()->with('error', 'Tidak ada siswa dengan penilaian lengkap!');
            }

            // Mulai transaction
            DB::beginTransaction();

            // Hapus hasil perhitungan sebelumnya
            HasilPerhitungan::truncate();

            $hasilSiswa = [];

            foreach ($siswaIds as $siswaId) {
                $skorTotal = 0;

                foreach ($kriteria as $k) {
                    // Ambil penilaian siswa untuk kriteria ini
                    $penilaian = Penilaian::where('siswa_id', $siswaId)
                        ->where('kriteria_id', $k->id)
                        ->first();

                    if ($penilaian && $penilaian->sub_kriteria_id) {
                        $subKriteria = SubKriteria::find($penilaian->sub_kriteria_id);
                        if ($subKriteria) {
                            // Hitung: Bobot Kriteria × Nilai Sub-Kriteria
                            $skorKriteria = $k->bobot * $subKriteria->nilai_sub;
                            $skorTotal += $skorKriteria;
                        }
                    }
                }

                $hasilSiswa[] = [
                    'siswa_id' => $siswaId,
                    'skor_akhir' => $skorTotal
                ];
            }

            // Sorting berdasarkan skor tertinggi
            usort($hasilSiswa, function ($a, $b) {
                return $b['skor_akhir'] <=> $a['skor_akhir'];
            });

            // Simpan hasil dengan ranking
            $ranking = 1;
            foreach ($hasilSiswa as $hasil) {
                HasilPerhitungan::create([
                    'siswa_id' => $hasil['siswa_id'],
                    'skor_akhir' => $hasil['skor_akhir'],
                    'ranking' => $ranking,
                    'status_kelulusan' => $ranking <= 10 ? 'lulus' : 'tidak_lulus', // Top 10 lulus
                    'tanggal_perhitungan' => now(),
                    'catatan' => 'Perhitungan menggunakan metode AHP'
                ]);
                $ranking++;
            }

            // Commit transaction
            DB::commit();

            return back()->with('success', 'Perhitungan AHP berhasil! Total ' . count($hasilSiswa) . ' siswa telah dihitung.');
        } catch (\Exception $e) {
            // Rollback hanya jika transaction masih aktif
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            // Log error untuk debugging
            Log::error('Error pada proses perhitungan AHP: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat perhitungan: ' . $e->getMessage());
        }
    }

    public function detail()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $hasilPerhitungan = HasilPerhitungan::with(['siswa', 'siswa.penilaian.subKriteria', 'siswa.penilaian.kriteria'])
            ->orderBy('ranking', 'asc')
            ->get();

        return view('admin.perhitungan.detail', compact('kriteria', 'hasilPerhitungan'));
    }
}
