<?php

// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        User::create([
            'name' => 'Admin SPK Beasiswa',
            'email' => 'admin@beasiswa.sch.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Kriteria berdasarkan BAB III
        $kriteria1 = Kriteria::create([
            'kode_kriteria' => 'K1',
            'nama_kriteria' => 'Nilai Rata-rata Raport',
            'bobot' => 0.468,
            'keterangan' => 'Prestasi akademik siswa berdasarkan nilai rata-rata raport'
        ]);

        $kriteria2 = Kriteria::create([
            'kode_kriteria' => 'K2',
            'nama_kriteria' => 'Jumlah Tanggungan Keluarga',
            'bobot' => 0.294,
            'keterangan' => 'Jumlah anggota keluarga yang ditanggung orang tua'
        ]);

        $kriteria3 = Kriteria::create([
            'kode_kriteria' => 'K3',
            'nama_kriteria' => 'Penghasilan Orang Tua',
            'bobot' => 0.160,
            'keterangan' => 'Penghasilan bulanan orang tua siswa'
        ]);

        $kriteria4 = Kriteria::create([
            'kode_kriteria' => 'K4',
            'nama_kriteria' => 'Keaktifan Siswa',
            'bobot' => 0.078,
            'keterangan' => 'Keaktifan siswa dalam organisasi dan ekstrakurikuler'
        ]);

        // Sub-Kriteria untuk K1 (Nilai Raport) - Berdasarkan BAB III
        SubKriteria::create([
            'kriteria_id' => $kriteria1->id,
            'nama_sub_kriteria' => 'Sangat Penting',
            'nilai_sub' => 1.0000,
            'range_min' => 91,
            'range_max' => 100,
            'kategori' => 'Predikat A (Nilai ≥91)'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria1->id,
            'nama_sub_kriteria' => 'Penting',
            'nilai_sub' => 0.443946,
            'range_min' => 83,
            'range_max' => 90.99,
            'kategori' => 'Predikat B (83 ≤ Nilai <91)'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria1->id,
            'nama_sub_kriteria' => 'Cukup Penting',
            'nilai_sub' => 0.213453,
            'range_min' => 75,
            'range_max' => 82.99,
            'kategori' => 'Predikat C (75 ≤ Nilai <83)'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria1->id,
            'nama_sub_kriteria' => 'Sama Penting',
            'nilai_sub' => 0.09417,
            'range_min' => 0,
            'range_max' => 74.99,
            'kategori' => 'Predikat D (Nilai <75)'
        ]);

        // Sub-Kriteria untuk K2 (Tanggungan Keluarga)
        SubKriteria::create([
            'kriteria_id' => $kriteria2->id,
            'nama_sub_kriteria' => 'Sangat Penting',
            'nilai_sub' => 1.0000,
            'range_min' => 5,
            'range_max' => 999,
            'kategori' => 'Memiliki ≥5 Tanggungan'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria2->id,
            'nama_sub_kriteria' => 'Penting',
            'nilai_sub' => 0.443946,
            'range_min' => 4,
            'range_max' => 4,
            'kategori' => 'Memiliki 4 Tanggungan'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria2->id,
            'nama_sub_kriteria' => 'Cukup Penting',
            'nilai_sub' => 0.213453,
            'range_min' => 3,
            'range_max' => 3,
            'kategori' => 'Memiliki 3 Tanggungan'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria2->id,
            'nama_sub_kriteria' => 'Sama Penting',
            'nilai_sub' => 0.09417,
            'range_min' => 1,
            'range_max' => 2,
            'kategori' => 'Memiliki ≤2 Tanggungan'
        ]);

        // Sub-Kriteria untuk K3 (Penghasilan Orang Tua)
        SubKriteria::create([
            'kriteria_id' => $kriteria3->id,
            'nama_sub_kriteria' => 'Sangat Penting',
            'nilai_sub' => 1.0000,
            'range_min' => 0,
            'range_max' => 999999,
            'kategori' => 'Penghasilan <Rp 1.000.000'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria3->id,
            'nama_sub_kriteria' => 'Penting',
            'nilai_sub' => 0.443946,
            'range_min' => 1000000,
            'range_max' => 2000000,
            'kategori' => 'Penghasilan Rp 1.000.000 - Rp 2.000.000'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria3->id,
            'nama_sub_kriteria' => 'Cukup Penting',
            'nilai_sub' => 0.213453,
            'range_min' => 2000001,
            'range_max' => 3000000,
            'kategori' => 'Penghasilan Rp 2.000.000 - Rp 3.000.000'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria3->id,
            'nama_sub_kriteria' => 'Sama Penting',
            'nilai_sub' => 0.09417,
            'range_min' => 3000001,
            'range_max' => 999999999,
            'kategori' => 'Penghasilan >Rp 3.000.000'
        ]);

        // Sub-Kriteria untuk K4 (Keaktifan)
        SubKriteria::create([
            'kriteria_id' => $kriteria4->id,
            'nama_sub_kriteria' => 'Sangat Penting',
            'nilai_sub' => 1.0000,
            'range_min' => 4,
            'range_max' => 999,
            'kategori' => 'IPM + 3 Ekskul (Total ≥4)'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria4->id,
            'nama_sub_kriteria' => 'Penting',
            'nilai_sub' => 0.443946,
            'range_min' => 3,
            'range_max' => 3,
            'kategori' => 'IPM + 2 Ekskul (Total 3)'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria4->id,
            'nama_sub_kriteria' => 'Cukup Penting',
            'nilai_sub' => 0.213453,
            'range_min' => 2,
            'range_max' => 2,
            'kategori' => 'IPM + 1 Ekskul (Total 2)'
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria4->id,
            'nama_sub_kriteria' => 'Sama Penting',
            'nilai_sub' => 0.09417,
            'range_min' => 1,
            'range_max' => 1,
            'kategori' => 'Hanya IPM (Total 1)'
        ]);

        echo "Seeder berhasil dijalankan!\n";
        echo "Admin Email: admin@ma-muh1bandung.sch.id\n";
        echo "Admin Password: admin123\n";

        // Tambahkan data beasiswa default
        \App\Models\Beasiswa::create([
            'nama_beasiswa' => 'Beasiswa Prestasi Akademik 2025',
            'jenis_beasiswa' => 'prestasi',
            'deskripsi' => 'Program beasiswa untuk siswa berprestasi dengan nilai akademik tinggi',
            'kuota' => 10,
            'nominal' => 1000000,
            'tanggal_buka' => now(),
            'tanggal_tutup' => now()->addMonths(3),
            'status' => 'aktif',
            'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1)
        ]);

        \App\Models\Beasiswa::create([
            'nama_beasiswa' => 'Beasiswa Siswa Kurang Mampu 2025',
            'jenis_beasiswa' => 'tidak mampu',
            'deskripsi' => 'Program beasiswa untuk siswa kurang mampu berdasarkan kondisi ekonomi keluarga',
            'kuota' => 15,
            'nominal' => 750000,
            'tanggal_buka' => now(),
            'tanggal_tutup' => now()->addMonths(3),
            'status' => 'aktif',
            'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1)
        ]);

        echo "\n2 Program Beasiswa default berhasil ditambahkan!\n";

        $this->call(SiswaSeeder::class);
    }
}
