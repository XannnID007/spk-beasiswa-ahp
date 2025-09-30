<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AhpComparison;
use App\Models\Kriteria;
use App\Services\AhpCalculatorService;

class AhpSeeder extends Seeder
{
     public function run()
     {
          // Ambil kriteria yang sudah ada
          $kriteria = Kriteria::orderBy('kode_kriteria')->get();

          if ($kriteria->count() < 4) {
               echo "Error: Kriteria belum lengkap. Pastikan ada 4 kriteria (K1, K2, K3, K4)\n";
               return;
          }

          // Menghasilkan bobot: K1=0.468, K2=0.294, K3=0.160, K4=0.078
          $comparisons = [
               // K1 vs K2: K1 sedikit lebih penting dari K2
               [$kriteria[0]->id, $kriteria[1]->id, 3],

               // K1 vs K3: K1 lebih penting dari K3  
               [$kriteria[0]->id, $kriteria[2]->id, 5],

               // K1 vs K4: K1 sangat lebih penting dari K4
               [$kriteria[0]->id, $kriteria[3]->id, 7],

               // K2 vs K3: K2 sedikit lebih penting dari K3
               [$kriteria[1]->id, $kriteria[2]->id, 2],

               // K2 vs K4: K2 lebih penting dari K4
               [$kriteria[1]->id, $kriteria[3]->id, 4],

               // K3 vs K4: K3 sedikit lebih penting dari K4
               [$kriteria[2]->id, $kriteria[3]->id, 2],
          ];

          echo "Menghapus data perbandingan lama...\n";
          AhpComparison::truncate();

          echo "Menambahkan perbandingan AHP default...\n";
          foreach ($comparisons as [$k1, $k2, $nilai]) {
               AhpComparison::create([
                    'kriteria_1' => $k1,
                    'kriteria_2' => $k2,
                    'nilai_perbandingan' => $nilai,
                    'keterangan' => 'Default seeder - sesuai penelitian BAB III'
               ]);

               $kode1 = $kriteria->find($k1)->kode_kriteria;
               $kode2 = $kriteria->find($k2)->kode_kriteria;
               echo "   ✓ $kode1 vs $kode2 = $nilai\n";
          }

          // Hitung bobot AHP secara otomatis
          echo "Menghitung bobot AHP...\n";
          $ahpService = new AhpCalculatorService();

          try {
               $result = $ahpService->calculateAHP();

               echo "Hasil perhitungan AHP:\n";
               echo "   • Lambda Max: " . number_format($result['lambda_max'], 4) . "\n";
               echo "   • Consistency Index: " . number_format($result['ci'], 4) . "\n";
               echo "   • Consistency Ratio: " . number_format($result['cr'], 4) . "\n";
               echo "   • Status: " . ($result['is_consistent'] ? 'KONSISTEN' : 'TIDAK KONSISTEN') . "\n";

               echo "\nBobot Kriteria Hasil AHP:\n";
               foreach ($kriteria as $index => $k) {
                    $bobot = $result['weights'][$index];
                    echo "   • {$k->kode_kriteria}: " . number_format($bobot, 4) . " (" . number_format($bobot * 100, 2) . "%)\n";
               }

               if ($result['is_consistent']) {
                    echo "\nAHP Seeder berhasil! Data siap digunakan untuk perhitungan.\n";
               } else {
                    echo "\nWarning: Matriks tidak konsisten, mohon periksa nilai perbandingan.\n";
               }
          } catch (\Exception $e) {
               echo "Error perhitungan AHP: " . $e->getMessage() . "\n";
          }
     }
}
