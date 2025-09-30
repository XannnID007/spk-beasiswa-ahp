<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataSiswa = [
            [
                // User data
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@student.com',
                'password' => 'password123',
                // Siswa data
                'nis' => '2024001',
                'nama_lengkap' => 'Ahmad Fauzi',
                'kelas' => 'XII',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2007-05-15',
                'alamat' => 'Jl. Merdeka No. 123, Bandung',
                'no_telp' => '081234567890',
                'nama_ayah' => 'Budi Santoso',
                'nama_ibu' => 'Siti Nurhaliza',
                'pekerjaan_ayah' => 'Wiraswasta',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 2500000,
                'jumlah_tanggungan' => 4,
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@student.com',
                'password' => 'password123',
                'nis' => '2024002',
                'nama_lengkap' => 'Siti Aminah',
                'kelas' => 'XII',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2007-08-20',
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
                'no_telp' => '081234567891',
                'nama_ayah' => 'Asep Supriatna',
                'nama_ibu' => 'Rina Wati',
                'pekerjaan_ayah' => 'Buruh Pabrik',
                'pekerjaan_ibu' => 'Pedagang',
                'penghasilan_ortu' => 1800000,
                'jumlah_tanggungan' => 5,
            ],
            [
                'name' => 'Muhammad Rizki',
                'email' => 'muhammad.rizki@student.com',
                'password' => 'password123',
                'nis' => '2024003',
                'nama_lengkap' => 'Muhammad Rizki',
                'kelas' => 'XI',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Cimahi',
                'tanggal_lahir' => '2008-03-12',
                'alamat' => 'Jl. Ahmad Yani No. 67, Cimahi',
                'no_telp' => '081234567892',
                'nama_ayah' => 'Dedi Mulyadi',
                'nama_ibu' => 'Ani Suryani',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'pekerjaan_ibu' => 'Guru',
                'penghasilan_ortu' => 3500000,
                'jumlah_tanggungan' => 3,
            ],
            [
                'name' => 'Nurul Hidayah',
                'email' => 'nurul.hidayah@student.com',
                'password' => 'password123',
                'nis' => '2024004',
                'nama_lengkap' => 'Nurul Hidayah',
                'kelas' => 'XI',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2008-11-05',
                'alamat' => 'Jl. Gatot Subroto No. 89, Bandung',
                'no_telp' => '081234567893',
                'nama_ayah' => 'Hendra Gunawan',
                'nama_ibu' => 'Lia Amalia',
                'pekerjaan_ayah' => 'Petani',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ortu' => 1500000,
                'jumlah_tanggungan' => 6,
            ],
            [
                'name' => 'Aldi Firmansyah',
                'email' => 'aldi.firmansyah@student.com',
                'password' => 'password123',
                'nis' => '2024005',
                'nama_lengkap' => 'Aldi Firmansyah',
                'kelas' => 'X',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-07-25',
                'alamat' => 'Jl. Dipatiukur No. 34, Bandung',
                'no_telp' => '081234567894',
                'nama_ayah' => 'Firman Hidayat',
                'nama_ibu' => 'Dewi Sartika',
                'pekerjaan_ayah' => 'Ojek Online',
                'pekerjaan_ibu' => 'Penjahit',
                'penghasilan_ortu' => 2000000,
                'jumlah_tanggungan' => 4,
            ],
        ];

        foreach ($dataSiswa as $data) {
            // Create user account
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'siswa',
            ]);

            // Create siswa data
            Siswa::create([
                'user_id' => $user->id,
                'nis' => $data['nis'],
                'nama_lengkap' => $data['nama_lengkap'],
                'kelas' => $data['kelas'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'alamat' => $data['alamat'],
                'no_telp' => $data['no_telp'],
                'nama_ayah' => $data['nama_ayah'],
                'nama_ibu' => $data['nama_ibu'],
                'pekerjaan_ayah' => $data['pekerjaan_ayah'],
                'pekerjaan_ibu' => $data['pekerjaan_ibu'],
                'penghasilan_ortu' => $data['penghasilan_ortu'],
                'jumlah_tanggungan' => $data['jumlah_tanggungan'],
            ]);
        }

        echo "\n✅ 5 Data siswa berhasil ditambahkan!\n";
        echo "\n📝 Login credentials untuk siswa:\n";
        echo "================================\n";
        foreach ($dataSiswa as $data) {
            echo "NIS: {$data['nis']} | Email: {$data['email']} | Password: {$data['password']}\n";
        }
        echo "================================\n\n";
    }
}
