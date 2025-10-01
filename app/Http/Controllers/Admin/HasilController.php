<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilPerhitungan;
use App\Models\Penilaian;
use App\Models\Kriteria;
use App\Models\AhpComparison;
use App\Services\AhpCalculatorService;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    protected $ahpService;

    public function __construct(AhpCalculatorService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

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

        return view('admin.hasil.show', compact(
            'hasil',
            'penilaian',
            'kriteria',
            'comparisonMatrix',
            'normalizedMatrix',
            'priorityVector',
            'ahpCalculation'
        ));
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
