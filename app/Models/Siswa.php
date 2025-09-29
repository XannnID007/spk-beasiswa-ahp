<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'nama_lengkap',
        'kelas',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_telp',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'penghasilan_ortu',
        'jumlah_tanggungan',
        'foto'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'penghasilan_ortu' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuanBeasiswa()
    {
        return $this->hasMany(PengajuanBeasiswa::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasilPerhitungan()
    {
        return $this->hasOne(HasilPerhitungan::class);
    }
}
