<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilPerhitungan;
use App\Models\Penilaian;
use App\Models\Kriteria;
use App\Models\AhpComparison;
use App\Services\AhpCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilController extends Controller
{
    protected $ahpService;

    public function __construct(AhpCalculatorService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

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

        // Ambil data AHP untuk matrix perbandingan dan normalisasi
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $ahpCalculation = $this->ahpService->getLatestCalculation();

        // Bangun matrix perbandingan dari data AhpComparison
        $comparisonMatrix = null;
        $normalizedMatrix = null;
        $priorityVector = null;

        if ($ahpCalculation) {
            $comparisonMatrix = $ahpCalculation->comparison_matrix;
            $normalizedMatrix = $ahpCalculation->normalized_matrix;
            $priorityVector = $ahpCalculation->priority_vector;
        } else {
            // Jika tidak ada calculation tersimpan, build matrix dari comparison data
            $comparisonMatrix = $this->buildComparisonMatrix($kriteria);
            if ($comparisonMatrix) {
                $normalizedMatrix = $this->normalizeMatrix($comparisonMatrix);
                $priorityVector = $this->calculatePriorityVector($normalizedMatrix);
            }
        }

        // Ambil ranking siswa lain untuk perbandingan (opsional, hanya top 10)
        $rankingSiswa = HasilPerhitungan::with('siswa')
            ->orderBy('ranking', 'asc')
            ->limit(10)
            ->get();

        return view('siswa.hasil.index', compact(
            'hasil',
            'penilaian',
            'kriteria',
            'comparisonMatrix',
            'normalizedMatrix',
            'priorityVector',
            'ahpCalculation',
            'rankingSiswa'
        ));
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
        $ahpCalculation = $this->ahpService->getLatestCalculation();

        $pdf = PDF::loadView('siswa.hasil.pdf', compact(
            'siswa',
            'hasil',
            'penilaian',
            'kriteria',
            'ahpCalculation'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Hasil_Seleksi_Beasiswa_' . $siswa->nis . '.pdf');
    }

    /**
     * Build comparison matrix from AhpComparison data
     */
    private function buildComparisonMatrix($kriteria)
    {
        $n = $kriteria->count();
        if ($n == 0) return null;

        $matrix = array_fill(0, $n, array_fill(0, $n, 1));
        $comparisons = AhpComparison::with(['kriteriaFirst', 'kriteriaSecond'])->get();

        foreach ($comparisons as $comp) {
            $i = $kriteria->search(fn($k) => $k->id == $comp->kriteria_1);
            $j = $kriteria->search(fn($k) => $k->id == $comp->kriteria_2);

            if ($i !== false && $j !== false) {
                $matrix[$i][$j] = $comp->nilai_perbandingan;
                $matrix[$j][$i] = 1 / $comp->nilai_perbandingan;
            }
        }

        return $matrix;
    }

    /**
     * Normalize matrix
     */
    private function normalizeMatrix($matrix)
    {
        $n = count($matrix);
        $normalized = array_fill(0, $n, array_fill(0, $n, 0));

        // Hitung total setiap kolom
        $columnSums = array_fill(0, $n, 0);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $columnSums[$j] += $matrix[$i][$j];
            }
        }

        // Normalisasi
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalized[$i][$j] = $columnSums[$j] > 0 ? $matrix[$i][$j] / $columnSums[$j] : 0;
            }
        }

        return $normalized;
    }

    /**
     * Calculate priority vector
     */
    private function calculatePriorityVector($normalizedMatrix)
    {
        $n = count($normalizedMatrix);
        $priorityVector = [];

        for ($i = 0; $i < $n; $i++) {
            $sum = array_sum($normalizedMatrix[$i]);
            $priorityVector[$i] = $sum / $n;
        }

        return $priorityVector;
    }
}
