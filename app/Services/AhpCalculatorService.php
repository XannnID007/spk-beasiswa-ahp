<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\AhpComparison;
use App\Models\AhpCalculation;
use Exception;

class AhpCalculatorService
{
     private $randomIndex = [
          1 => 0,
          2 => 0,
          3 => 0.58,
          4 => 0.90,
          5 => 1.12,
          6 => 1.24,
          7 => 1.32,
          8 => 1.41,
          9 => 1.45,
          10 => 1.49
     ];

     /**
      * Bangun matriks perbandingan dari data yang ada
      */
     public function buildComparisonMatrix()
     {
          $kriteria = Kriteria::orderBy('kode_kriteria')->get();
          $n = $kriteria->count();
          $matrix = [];

          // Inisialisasi matrix dengan 0
          for ($i = 0; $i < $n; $i++) {
               for ($j = 0; $j < $n; $j++) {
                    $matrix[$i][$j] = 0;
               }
          }

          // Isi diagonal dengan 1
          for ($i = 0; $i < $n; $i++) {
               $matrix[$i][$i] = 1;
          }

          // Isi dari data perbandingan
          $comparisons = AhpComparison::all();

          foreach ($comparisons as $comp) {
               $idx1 = $kriteria->search(function ($k) use ($comp) {
                    return $k->id == $comp->kriteria_1;
               });

               $idx2 = $kriteria->search(function ($k) use ($comp) {
                    return $k->id == $comp->kriteria_2;
               });

               if ($idx1 !== false && $idx2 !== false) {
                    $matrix[$idx1][$idx2] = $comp->nilai_perbandingan;
                    $matrix[$idx2][$idx1] = 1 / $comp->nilai_perbandingan;
               }
          }

          return [
               'matrix' => $matrix,
               'kriteria' => $kriteria
          ];
     }

     /**
      * Hitung bobot prioritas menggunakan geometric mean
      */
     public function calculatePriorityWeights($matrix)
     {
          $n = count($matrix);
          $weights = [];

          // Geometric mean method
          for ($i = 0; $i < $n; $i++) {
               $product = 1;
               for ($j = 0; $j < $n; $j++) {
                    $product *= $matrix[$i][$j];
               }
               $weights[$i] = pow($product, 1 / $n);
          }

          // Normalisasi
          $sum = array_sum($weights);
          for ($i = 0; $i < $n; $i++) {
               $weights[$i] = $weights[$i] / $sum;
          }

          return $weights;
     }

     /**
      * Hitung lambda max
      */
     public function calculateLambdaMax($matrix, $weights)
     {
          $n = count($matrix);
          $lambdaMax = 0;

          for ($i = 0; $i < $n; $i++) {
               $sum = 0;
               for ($j = 0; $j < $n; $j++) {
                    $sum += $matrix[$i][$j] * $weights[$j];
               }
               $lambdaMax += $sum / $weights[$i];
          }

          return $lambdaMax / $n;
     }

     /**
      * Hitung Consistency Index
      */
     public function calculateConsistencyIndex($lambdaMax, $n)
     {
          return ($lambdaMax - $n) / ($n - 1);
     }

     /**
      * Hitung Consistency Ratio
      */
     public function calculateConsistencyRatio($ci, $n)
     {
          if ($n <= 2) return 0;

          $ri = $this->randomIndex[$n] ?? 1.49;
          return $ci / $ri;
     }

     /**
      * Normalisasi matrix
      */
     public function normalizeMatrix($matrix)
     {
          $n = count($matrix);
          $normalized = [];

          // Hitung sum untuk setiap kolom
          $columnSums = [];
          for ($j = 0; $j < $n; $j++) {
               $sum = 0;
               for ($i = 0; $i < $n; $i++) {
                    $sum += $matrix[$i][$j];
               }
               $columnSums[$j] = $sum;
          }

          // Normalisasi
          for ($i = 0; $i < $n; $i++) {
               for ($j = 0; $j < $n; $j++) {
                    $normalized[$i][$j] = $matrix[$i][$j] / $columnSums[$j];
               }
          }

          return $normalized;
     }

     /**
      * Proses perhitungan AHP lengkap
      */
     public function calculateAHP()
     {
          $result = $this->buildComparisonMatrix();
          $matrix = $result['matrix'];
          $kriteria = $result['kriteria'];
          $n = count($matrix);

          // Validasi matrix tidak kosong
          if ($n == 0) {
               throw new Exception('Tidak ada data kriteria untuk perhitungan AHP');
          }

          // Validasi matrix sudah lengkap
          for ($i = 0; $i < $n; $i++) {
               for ($j = 0; $j < $n; $j++) {
                    if ($i != $j && $matrix[$i][$j] == 0) {
                         throw new Exception('Matriks perbandingan belum lengkap. Mohon lengkapi semua perbandingan kriteria.');
                    }
               }
          }

          // Hitung normalized matrix
          $normalizedMatrix = $this->normalizeMatrix($matrix);

          // Hitung priority weights
          $weights = $this->calculatePriorityWeights($matrix);

          // Hitung lambda max
          $lambdaMax = $this->calculateLambdaMax($matrix, $weights);

          // Hitung CI dan CR
          $ci = $this->calculateConsistencyIndex($lambdaMax, $n);
          $cr = $this->calculateConsistencyRatio($ci, $n);

          $isConsistent = $cr <= 0.1;

          // Simpan hasil perhitungan
          $calculation = AhpCalculation::create([
               'comparison_matrix' => $matrix,
               'normalized_matrix' => $normalizedMatrix,
               'priority_vector' => $weights,
               'lambda_max' => $lambdaMax,
               'consistency_index' => $ci,
               'consistency_ratio' => $cr,
               'is_consistent' => $isConsistent,
               'calculated_at' => now()
          ]);

          // Update bobot kriteria jika konsisten
          if ($isConsistent) {
               foreach ($kriteria as $index => $k) {
                    $k->update(['bobot' => $weights[$index]]);
               }
          }

          return [
               'matrix' => $matrix,
               'normalized_matrix' => $normalizedMatrix,
               'weights' => $weights,
               'lambda_max' => $lambdaMax,
               'ci' => $ci,
               'cr' => $cr,
               'is_consistent' => $isConsistent,
               'kriteria' => $kriteria,
               'calculation_id' => $calculation->id
          ];
     }

     /**
      * Dapatkan hasil perhitungan AHP terbaru
      */
     public function getLatestCalculation()
     {
          return AhpCalculation::latest()->first();
     }

     /**
      * Cek apakah matriks perbandingan sudah lengkap
      */
     public function isComparisonMatrixComplete()
     {
          $kriteria = Kriteria::count();
          $totalComparisons = ($kriteria * ($kriteria - 1)) / 2;
          $existingComparisons = AhpComparison::count();

          return $existingComparisons >= $totalComparisons;
     }

     /**
      * Generate pasangan kriteria yang belum dibandingkan
      */
     public function getMissingComparisons()
     {
          $kriteria = Kriteria::orderBy('kode_kriteria')->get();
          $existing = AhpComparison::all();
          $missing = [];

          for ($i = 0; $i < $kriteria->count(); $i++) {
               for ($j = $i + 1; $j < $kriteria->count(); $j++) {
                    $k1 = $kriteria[$i];
                    $k2 = $kriteria[$j];

                    $exists = $existing->contains(function ($comp) use ($k1, $k2) {
                         return ($comp->kriteria_1 == $k1->id && $comp->kriteria_2 == $k2->id) ||
                              ($comp->kriteria_1 == $k2->id && $comp->kriteria_2 == $k1->id);
                    });

                    if (!$exists) {
                         $missing[] = [
                              'kriteria_1' => $k1,
                              'kriteria_2' => $k2
                         ];
                    }
               }
          }

          return $missing;
     }
}
