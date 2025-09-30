<?php

// 1. PERBAIKAN SERVICE AHPCALCULATORSERVICE
namespace App\Services;

use App\Models\Kriteria;
use App\Models\AhpComparison;
use App\Models\AhpCalculation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AhpCalculatorService
{
     // Tambahkan Random Index untuk AHP
     private const RANDOM_INDEX = [
          1 => 0.00,
          2 => 0.00,
          3 => 0.58,
          4 => 0.90,
          5 => 1.12,
          6 => 1.24,
          7 => 1.32,
          8 => 1.41,
          9 => 1.45,
          10 => 1.49
     ];

     public function calculateAHP()
     {
          try {
               DB::beginTransaction();

               $kriteria = Kriteria::orderBy('kode_kriteria')->get();
               $n = $kriteria->count();

               if ($n < 2) {
                    throw new \Exception('Minimal 2 kriteria diperlukan');
               }

               // 1. Buat matriks perbandingan
               $matrix = $this->buildComparisonMatrix($kriteria);

               // 2. Normalisasi matriks
               $normalizedMatrix = $this->normalizeMatrix($matrix);

               // 3. Hitung priority vector (bobot)
               $priorityVector = $this->calculatePriorityVector($normalizedMatrix);

               // 4. Hitung consistency
               $lambdaMax = $this->calculateLambdaMax($matrix, $priorityVector);
               $ci = ($lambdaMax - $n) / ($n - 1);
               $cr = $n > 2 ? $ci / self::RANDOM_INDEX[$n] : 0;

               $isConsistent = $cr <= 0.1;

               // 5. Update bobot kriteria jika konsisten
               if ($isConsistent) {
                    foreach ($kriteria as $index => $k) {
                         $k->update(['bobot' => $priorityVector[$index]]);
                    }
               }

               // 6. Simpan hasil perhitungan
               AhpCalculation::create([
                    'comparison_matrix' => $matrix,
                    'normalized_matrix' => $normalizedMatrix,
                    'priority_vector' => $priorityVector,
                    'lambda_max' => $lambdaMax,
                    'consistency_index' => $ci,
                    'consistency_ratio' => $cr,
                    'is_consistent' => $isConsistent,
                    'calculated_at' => now()
               ]);

               DB::commit();

               return [
                    'weights' => $priorityVector,
                    'lambda_max' => $lambdaMax,
                    'ci' => $ci,
                    'cr' => $cr,
                    'is_consistent' => $isConsistent
               ];
          } catch (\Exception $e) {
               DB::rollBack();
               Log::error('AHP Calculation Error: ' . $e->getMessage());
               throw $e;
          }
     }

     private function buildComparisonMatrix($kriteria)
     {
          $n = $kriteria->count();
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
                    $normalized[$i][$j] = $matrix[$i][$j] / $columnSums[$j];
               }
          }

          return $normalized;
     }

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

     private function calculateLambdaMax($matrix, $priorityVector)
     {
          $n = count($matrix);
          $weightedSum = array_fill(0, $n, 0);

          for ($i = 0; $i < $n; $i++) {
               for ($j = 0; $j < $n; $j++) {
                    $weightedSum[$i] += $matrix[$i][$j] * $priorityVector[$j];
               }
          }

          $lambdaMax = 0;
          for ($i = 0; $i < $n; $i++) {
               if ($priorityVector[$i] != 0) {
                    $lambdaMax += $weightedSum[$i] / $priorityVector[$i];
               }
          }

          return $lambdaMax / $n;
     }

     public function isComparisonMatrixComplete()
     {
          $kriteriaCount = Kriteria::count();
          $requiredComparisons = ($kriteriaCount * ($kriteriaCount - 1)) / 2;
          $existingComparisons = AhpComparison::count();

          return $existingComparisons >= $requiredComparisons;
     }

     public function getMissingComparisons()
     {
          $kriteria = Kriteria::orderBy('kode_kriteria')->get();
          $existing = AhpComparison::all();
          $missing = [];

          for ($i = 0; $i < $kriteria->count(); $i++) {
               for ($j = $i + 1; $j < $kriteria->count(); $j++) {
                    $exists = $existing->contains(function ($comp) use ($kriteria, $i, $j) {
                         return ($comp->kriteria_1 == $kriteria[$i]->id && $comp->kriteria_2 == $kriteria[$j]->id) ||
                              ($comp->kriteria_1 == $kriteria[$j]->id && $comp->kriteria_2 == $kriteria[$i]->id);
                    });

                    if (!$exists) {
                         $missing[] = [
                              'kriteria_1' => $kriteria[$i],
                              'kriteria_2' => $kriteria[$j]
                         ];
                    }
               }
          }

          return $missing;
     }

     public function getLatestCalculation()
     {
          return AhpCalculation::latest('calculated_at')->first();
     }
}
