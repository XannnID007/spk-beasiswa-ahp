<?php

// app/Http/Controllers/Admin/AhpController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\AhpComparison;
use App\Services\AhpCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AhpController extends Controller
{
    protected $ahpService;

    public function __construct(AhpCalculatorService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

    /**
     * Tampilkan halaman utama AHP
     */
    public function index()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $comparisons = AhpComparison::with(['kriteriaFirst', 'kriteriaSecond'])->get();
        $missingComparisons = $this->ahpService->getMissingComparisons();
        $isComplete = $this->ahpService->isComparisonMatrixComplete();
        $latestCalculation = $this->ahpService->getLatestCalculation();

        return view('admin.ahp.index', compact(
            'kriteria',
            'comparisons',
            'missingComparisons',
            'isComplete',
            'latestCalculation'
        ));
    }

    /**
     * Form input perbandingan kriteria
     */
    public function createComparison()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $missingComparisons = $this->ahpService->getMissingComparisons();

        if (empty($missingComparisons)) {
            return redirect()->route('admin.ahp.index')
                ->with('info', 'Semua perbandingan kriteria sudah lengkap!');
        }

        return view('admin.ahp.create-comparison', compact('kriteria', 'missingComparisons'));
    }

    /**
     * Simpan perbandingan kriteria
     */
    public function storeComparison(Request $request)
    {
        $request->validate([
            'kriteria_1' => 'required|exists:kriteria,id',
            'kriteria_2' => 'required|exists:kriteria,id|different:kriteria_1',
            'nilai_perbandingan' => 'required|numeric|min:0.111|max:9', // Batasi range AHP
            'keterangan' => 'nullable|string|max:255'
        ], [
            'nilai_perbandingan.min' => 'Nilai perbandingan minimal 1/9 (0.111)',
            'nilai_perbandingan.max' => 'Nilai perbandingan maksimal 9',
            'nilai_perbandingan.numeric' => 'Nilai perbandingan harus berupa angka'
        ]);

        // Cek duplikasi
        $exists = AhpComparison::where(function ($query) use ($request) {
            $query->where('kriteria_1', $request->kriteria_1)
                ->where('kriteria_2', $request->kriteria_2);
        })->orWhere(function ($query) use ($request) {
            $query->where('kriteria_1', $request->kriteria_2)
                ->where('kriteria_2', $request->kriteria_1);
        })->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Perbandingan kriteria ini sudah ada!']);
        }

        // Simpan perbandingan
        AhpComparison::create($request->all());

        // Auto-check konsistensi jika matriks sudah lengkap
        if ($this->ahpService->isComparisonMatrixComplete()) {
            try {
                $result = $this->ahpService->calculateAHP();

                if (!$result['is_consistent']) {
                    return redirect()->route('admin.ahp.index')
                        ->with('warning', 'Perbandingan ditambahkan, namun matriks tidak konsisten (CR = ' .
                            number_format($result['cr'], 4) . '). Silakan perbaiki nilai perbandingan.');
                }
            } catch (\Exception $e) {
                // Tetap simpan, tapi beri peringatan
                return redirect()->route('admin.ahp.index')
                    ->with('warning', 'Perbandingan ditambahkan, namun ada error dalam validasi konsistensi.');
            }
        }

        return redirect()->route('admin.ahp.index')
            ->with('success', 'Perbandingan kriteria berhasil ditambahkan!');
    }

    public function bulkComparison(Request $request)
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $totalPairs = ($kriteria->count() * ($kriteria->count() - 1)) / 2;

        $request->validate([
            'comparisons' => 'required|array|size:' . $totalPairs,
            'comparisons.*' => 'required|numeric|min:0.111|max:9' // Validasi range AHP
        ], [
            'comparisons.*.min' => 'Nilai perbandingan minimal 1/9 (0.111)',
            'comparisons.*.max' => 'Nilai perbandingan maksimal 9',
        ]);

        DB::beginTransaction();
        try {
            // Hapus perbandingan lama
            AhpComparison::truncate();

            $pairIndex = 0;
            for ($i = 0; $i < $kriteria->count(); $i++) {
                for ($j = $i + 1; $j < $kriteria->count(); $j++) {
                    AhpComparison::create([
                        'kriteria_1' => $kriteria[$i]->id,
                        'kriteria_2' => $kriteria[$j]->id,
                        'nilai_perbandingan' => $request->comparisons[$pairIndex],
                        'keterangan' => 'Bulk input'
                    ]);
                    $pairIndex++;
                }
            }

            // Validasi konsistensi langsung
            $result = $this->ahpService->calculateAHP();

            if (!$result['is_consistent']) {
                DB::rollback();
                return back()->withErrors([
                    'error' => 'Matriks tidak konsisten! CR = ' . number_format($result['cr'], 4) .
                        ' > 0.1. Silakan perbaiki nilai perbandingan.'
                ]);
            }

            DB::commit();
            return redirect()->route('admin.ahp.index')
                ->with('success', 'Semua perbandingan berhasil disimpan dan matriks konsisten! CR = ' .
                    number_format($result['cr'], 4));
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Hitung bobot AHP
     */
    public function calculate()
    {
        try {
            if (!$this->ahpService->isComparisonMatrixComplete()) {
                return back()->withErrors(['error' => 'Matriks perbandingan belum lengkap! Mohon lengkapi semua perbandingan kriteria terlebih dahulu.']);
            }

            $result = $this->ahpService->calculateAHP();

            if (!$result['is_consistent']) {
                return back()->withErrors([
                    'error' => 'Matriks tidak konsisten! Consistency Ratio = ' .
                        number_format($result['cr'], 4) . ' > 0.1. ' .
                        'Mohon perbaiki nilai perbandingan kriteria.'
                ]);
            }

            return redirect()->route('admin.ahp.index')
                ->with('success', 'Perhitungan AHP berhasil! Bobot kriteria telah diperbarui. CR = ' .
                    number_format($result['cr'], 4));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Lihat detail perhitungan AHP
     */
    public function detail()
    {
        $calculation = $this->ahpService->getLatestCalculation();

        if (!$calculation) {
            return redirect()->route('admin.ahp.index')
                ->with('error', 'Belum ada hasil perhitungan AHP');
        }

        $kriteria = Kriteria::orderBy('kode_kriteria')->get();

        return view('admin.ahp.detail', compact('calculation', 'kriteria'));
    }

    /**
     * Edit perbandingan kriteria
     */
    public function editComparison($id)
    {
        $comparison = AhpComparison::with(['kriteriaFirst', 'kriteriaSecond'])->findOrFail($id);

        return view('admin.ahp.edit-comparison', compact('comparison'));
    }

    /**
     * Update perbandingan kriteria
     */
    public function updateComparison(Request $request, $id)
    {
        $comparison = AhpComparison::findOrFail($id);

        $request->validate([
            'nilai_perbandingan' => 'required|numeric|min:0.111|max:9',
            'keterangan' => 'nullable|string|max:255'
        ]);

        $comparison->update($request->only(['nilai_perbandingan', 'keterangan']));

        return redirect()->route('admin.ahp.index')
            ->with('success', 'Perbandingan kriteria berhasil diperbarui!');
    }

    /**
     * Hapus perbandingan kriteria
     */
    public function deleteComparison($id)
    {
        $comparison = AhpComparison::findOrFail($id);
        $comparison->delete();

        return redirect()->route('admin.ahp.index')
            ->with('success', 'Perbandingan kriteria berhasil dihapus!');
    }

    /**
     * Reset semua perbandingan
     */
    public function resetComparisons()
    {
        AhpComparison::truncate();

        return redirect()->route('admin.ahp.index')
            ->with('success', 'Semua perbandingan kriteria berhasil direset!');
    }
}
