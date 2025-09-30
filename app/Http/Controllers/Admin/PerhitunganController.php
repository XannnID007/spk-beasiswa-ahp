<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Penilaian;
use App\Models\PengajuanBeasiswa;
use App\Models\HasilPerhitungan;
use App\Services\AhpCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerhitunganController extends Controller
{
    protected $ahpService;

    public function __construct(AhpCalculatorService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

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

        // Cek validitas AHP
        $ahpValidation = $this->validateAhpConsistency();
        $isAhpComplete = $this->ahpService->isComparisonMatrixComplete();

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
            'kriteria',
            'ahpValidation',
            'isAhpComplete'
        ));
    }

    public function proses()
    {
        try {
            // Tambahkan validasi lebih ketat
            $ahpValidation = $this->validateAhpConsistency();
            if (!$ahpValidation['is_valid']) {
                return back()->withErrors(['error' => $ahpValidation['message']]);
            }

            // Validasi data siswa
            $siswaIds = Penilaian::select('siswa_id')
                ->groupBy('siswa_id')
                ->havingRaw('COUNT(DISTINCT kriteria_id) = 4')
                ->pluck('siswa_id');

            if ($siswaIds->count() == 0) {
                return back()->withErrors(['error' => 'Tidak ada siswa dengan penilaian lengkap!']);
            }

            // Validasi total bobot kriteria = 1
            $kriteria = Kriteria::orderBy('kode_kriteria')->get();
            $totalBobot = $kriteria->sum('bobot');

            if (abs($totalBobot - 1.0) > 0.001) {
                return back()->withErrors([
                    'error' => 'Total bobot kriteria harus = 1.0000. Saat ini: ' . number_format($totalBobot, 4)
                ]);
            }

            DB::beginTransaction();

            // Reset hasil sebelumnya
            HasilPerhitungan::truncate();

            $hasilSiswa = [];

            foreach ($siswaIds as $siswaId) {
                $skorTotal = 0;
                $validPenilaian = true;

                foreach ($kriteria as $k) {
                    $penilaian = Penilaian::where('siswa_id', $siswaId)
                        ->where('kriteria_id', $k->id)
                        ->first();

                    if (!$penilaian || !$penilaian->sub_kriteria_id) {
                        $validPenilaian = false;
                        break;
                    }

                    $subKriteria = SubKriteria::find($penilaian->sub_kriteria_id);
                    if (!$subKriteria) {
                        $validPenilaian = false;
                        break;
                    }

                    $skorTotal += $k->bobot * $subKriteria->nilai_sub;
                }

                if ($validPenilaian) {
                    $hasilSiswa[] = [
                        'siswa_id' => $siswaId,
                        'skor_akhir' => $skorTotal
                    ];
                }
            }

            // Urutkan berdasarkan skor tertinggi
            usort($hasilSiswa, fn($a, $b) => $b['skor_akhir'] <=> $a['skor_akhir']);

            // Simpan hasil dengan ranking
            foreach ($hasilSiswa as $index => $hasil) {
                HasilPerhitungan::create([
                    'siswa_id' => $hasil['siswa_id'],
                    'skor_akhir' => $hasil['skor_akhir'],
                    'ranking' => $index + 1,
                    'status_kelulusan' => ($index + 1) <= 10 ? 'lulus' : 'tidak_lulus',
                    'tanggal_perhitungan' => now(),
                    'catatan' => 'Perhitungan AHP dengan CR = ' . number_format($ahpValidation['cr'], 4)
                ]);
            }

            DB::commit();

            return back()->with(
                'success',
                'Perhitungan berhasil! ' . count($hasilSiswa) . ' siswa telah dihitung dengan CR = ' .
                    number_format($ahpValidation['cr'], 4)
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Perhitungan Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal melakukan perhitungan: ' . $e->getMessage()]);
        }
    }

    /**
     * Validasi konsistensi AHP
     */
    private function validateAhpConsistency()
    {
        try {
            // Cek apakah matriks perbandingan lengkap
            if (!$this->ahpService->isComparisonMatrixComplete()) {
                return [
                    'is_valid' => false,
                    'message' => 'Matriks perbandingan AHP belum lengkap. Mohon lengkapi di menu AHP Management.',
                    'cr' => null
                ];
            }

            // Ambil hasil perhitungan AHP terbaru
            $calculation = $this->ahpService->getLatestCalculation();

            if (!$calculation) {
                return [
                    'is_valid' => false,
                    'message' => 'Bobot kriteria belum dihitung menggunakan AHP. Mohon hitung bobot di menu AHP Management.',
                    'cr' => null
                ];
            }

            // Cek konsistensi
            if (!$calculation->is_consistent) {
                return [
                    'is_valid' => false,
                    'message' => 'Matriks AHP tidak konsisten (CR = ' .
                        number_format($calculation->consistency_ratio, 4) . ' > 0.1). ' .
                        'Mohon perbaiki perbandingan kriteria.',
                    'cr' => $calculation->consistency_ratio
                ];
            }

            return [
                'is_valid' => true,
                'message' => 'Matriks AHP konsisten dan siap digunakan.',
                'cr' => $calculation->consistency_ratio,
                'lambda_max' => $calculation->lambda_max,
                'ci' => $calculation->consistency_index
            ];
        } catch (\Exception $e) {
            return [
                'is_valid' => false,
                'message' => 'Error validasi AHP: ' . $e->getMessage(),
                'cr' => null
            ];
        }
    }

    public function detail()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $hasilPerhitungan = HasilPerhitungan::with(['siswa', 'siswa.penilaian.subKriteria', 'siswa.penilaian.kriteria'])
            ->orderBy('ranking', 'asc')
            ->get();

        // Ambil detail perhitungan AHP
        $ahpCalculation = $this->ahpService->getLatestCalculation();

        return view('admin.perhitungan.detail', compact(
            'kriteria',
            'hasilPerhitungan',
            'ahpCalculation'
        ));
    }

    /**
     * Recalculate dengan validasi ulang
     */
    public function recalculate()
    {
        try {
            // Hitung ulang bobot AHP
            $ahpResult = $this->ahpService->calculateAHP();

            if (!$ahpResult['is_consistent']) {
                return back()->withErrors([
                    'error' => 'Tidak dapat menghitung ulang karena matriks AHP tidak konsisten (CR = ' .
                        number_format($ahpResult['cr'], 4) . ')'
                ]);
            }

            // Lanjutkan dengan perhitungan ranking
            return $this->proses();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error recalculate: ' . $e->getMessage()]);
        }
    }
}
