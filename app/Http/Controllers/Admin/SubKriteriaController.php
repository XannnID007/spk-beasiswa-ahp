<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $subKriteria = SubKriteria::with('kriteria')->orderBy('kriteria_id')->orderBy('range_min')->get();
        $validation = $this->validateSubKriteriaRanges();

        return view('admin.sub-kriteria.index', compact('subKriteria', 'validation'));
    }

    public function create()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        return view('admin.sub-kriteria.create', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriteria,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai_sub' => 'required|numeric|min:0|max:1',
            'range_min' => 'nullable|numeric',
            'range_max' => 'nullable|numeric|gte:range_min',
            'kategori' => 'nullable|string',
        ]);

        // Validasi overlap range
        if ($request->range_min !== null && $request->range_max !== null) {
            $overlap = $this->checkRangeOverlap(
                $request->kriteria_id,
                $request->range_min,
                $request->range_max
            );

            if ($overlap) {
                return back()->withErrors([
                    'range_min' => 'Range bertumpang tindih dengan sub-kriteria: ' . $overlap->nama_sub_kriteria
                ])->withInput();
            }
        }

        SubKriteria::create($request->all());

        return redirect()->route('admin.sub-kriteria.index')
            ->with('success', 'Sub-kriteria berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        return view('admin.sub-kriteria.edit', compact('subKriteria', 'kriteria'));
    }

    public function update(Request $request, $id)
    {
        $subKriteria = SubKriteria::findOrFail($id);

        $request->validate([
            'kriteria_id' => 'required|exists:kriteria,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai_sub' => 'required|numeric|min:0|max:1',
            'range_min' => 'nullable|numeric',
            'range_max' => 'nullable|numeric|gte:range_min',
            'kategori' => 'nullable|string',
        ]);

        // Validasi overlap range (kecuali dengan dirinya sendiri)
        if ($request->range_min !== null && $request->range_max !== null) {
            $overlap = $this->checkRangeOverlap(
                $request->kriteria_id,
                $request->range_min,
                $request->range_max,
                $id // exclude current record
            );

            if ($overlap) {
                return back()->withErrors([
                    'range_min' => 'Range bertumpang tindih dengan sub-kriteria: ' . $overlap->nama_sub_kriteria
                ])->withInput();
            }
        }

        $subKriteria->update($request->all());

        return redirect()->route('admin.sub-kriteria.index')
            ->with('success', 'Sub-kriteria berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);

        // Cek apakah ada penilaian yang menggunakan sub-kriteria ini
        $usedInPenilaian = \App\Models\Penilaian::where('sub_kriteria_id', $id)->exists();

        if ($usedInPenilaian) {
            return back()->withErrors([
                'error' => 'Sub-kriteria ini tidak dapat dihapus karena sudah digunakan dalam penilaian siswa.'
            ]);
        }

        $subKriteria->delete();

        return redirect()->route('admin.sub-kriteria.index')
            ->with('success', 'Sub-kriteria berhasil dihapus!');
    }

    public function getByKriteria($kriteria_id)
    {
        $subKriteria = SubKriteria::where('kriteria_id', $kriteria_id)
            ->orderBy('range_min')
            ->get();
        return response()->json($subKriteria);
    }

    /**
     * Validasi range sub-kriteria untuk semua kriteria
     */
    private function validateSubKriteriaRanges()
    {
        $kriteria = Kriteria::with('subKriteria')->get();
        $validation = [];

        foreach ($kriteria as $k) {
            $subKriteria = $k->subKriteria->sortBy('range_min');
            $issues = [];

            if ($subKriteria->count() == 0) {
                $issues[] = 'Belum ada sub-kriteria';
            } else {
                // Cek gap dan overlap
                $previous = null;
                foreach ($subKriteria as $current) {
                    if ($previous !== null) {
                        // Cek gap
                        if ($previous->range_max < $current->range_min - 0.01) {
                            $issues[] = "Gap antara {$previous->nama_sub_kriteria} dan {$current->nama_sub_kriteria}";
                        }

                        // Cek overlap
                        if ($previous->range_max >= $current->range_min) {
                            $issues[] = "Overlap antara {$previous->nama_sub_kriteria} dan {$current->nama_sub_kriteria}";
                        }
                    }
                    $previous = $current;
                }
            }

            $validation[$k->id] = [
                'kriteria' => $k,
                'issues' => $issues,
                'is_valid' => empty($issues)
            ];
        }

        return $validation;
    }

    /**
     * Cek overlap range untuk kriteria tertentu
     */
    private function checkRangeOverlap($kriteria_id, $range_min, $range_max, $exclude_id = null)
    {
        $query = SubKriteria::where('kriteria_id', $kriteria_id)
            ->where(function ($q) use ($range_min, $range_max) {
                $q->whereBetween('range_min', [$range_min, $range_max])
                    ->orWhereBetween('range_max', [$range_min, $range_max])
                    ->orWhere(function ($q2) use ($range_min, $range_max) {
                        $q2->where('range_min', '<=', $range_min)
                            ->where('range_max', '>=', $range_max);
                    });
            });

        if ($exclude_id) {
            $query->where('id', '!=', $exclude_id);
        }

        return $query->first();
    }

    /**
     * Perbaiki otomatis range sub-kriteria
     */
    public function autoFixRanges()
    {
        try {
            DB::beginTransaction();

            $kriteria = Kriteria::all();
            $fixed = [];

            foreach ($kriteria as $k) {
                $subKriteria = SubKriteria::where('kriteria_id', $k->id)
                    ->orderBy('nilai_sub', 'desc') // Urutkan dari nilai tertinggi
                    ->get();

                if ($subKriteria->count() > 0) {
                    // Auto-assign ranges berdasarkan nilai sub
                    $this->assignOptimalRanges($k, $subKriteria);
                    $fixed[] = $k->kode_kriteria;
                }
            }

            DB::commit();

            return redirect()->route('admin.sub-kriteria.index')
                ->with('success', 'Range sub-kriteria berhasil diperbaiki untuk: ' . implode(', ', $fixed));
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbaiki ranges: ' . $e->getMessage()]);
        }
    }

    /**
     * Assign range optimal berdasarkan jenis kriteria
     */
    private function assignOptimalRanges($kriteria, $subKriteria)
    {
        switch ($kriteria->kode_kriteria) {
            case 'K1': // Nilai Raport
                $ranges = [
                    ['min' => 91, 'max' => 100],    // Sangat Penting
                    ['min' => 83, 'max' => 90.99],  // Penting  
                    ['min' => 75, 'max' => 82.99],  // Cukup Penting
                    ['min' => 0, 'max' => 74.99],   // Sama Penting
                ];
                break;

            case 'K2': // Jumlah Tanggungan
                $ranges = [
                    ['min' => 5, 'max' => 999],     // Sangat Penting (≥5)
                    ['min' => 4, 'max' => 4],       // Penting (4)
                    ['min' => 3, 'max' => 3],       // Cukup Penting (3)
                    ['min' => 1, 'max' => 2],       // Sama Penting (≤2)
                ];
                break;

            case 'K3': // Penghasilan Orang Tua
                $ranges = [
                    ['min' => 0, 'max' => 999999],        // Sangat Penting (<1jt)
                    ['min' => 1000000, 'max' => 2000000], // Penting (1-2jt)
                    ['min' => 2000001, 'max' => 3000000], // Cukup Penting (2-3jt)
                    ['min' => 3000001, 'max' => 999999999], // Sama Penting (>3jt)
                ];
                break;

            case 'K4': // Keaktifan
                $ranges = [
                    ['min' => 4, 'max' => 999],     // Sangat Penting (≥4)
                    ['min' => 3, 'max' => 3],       // Penting (3)
                    ['min' => 2, 'max' => 2],       // Cukup Penting (2)
                    ['min' => 1, 'max' => 1],       // Sama Penting (1)
                ];
                break;

            default:
                return; // Skip jika kriteria tidak dikenal
        }

        // Update ranges
        foreach ($subKriteria as $index => $sub) {
            if (isset($ranges[$index])) {
                $sub->update([
                    'range_min' => $ranges[$index]['min'],
                    'range_max' => $ranges[$index]['max']
                ]);
            }
        }
    }
}
