<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'bobot',
        'keterangan'
    ];

    protected $casts = [
        'bobot' => 'decimal:4',
    ];

    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function perbandingan1()
    {
        return $this->hasMany(PerbandinganKriteria::class, 'kriteria_1');
    }

    public function perbandingan2()
    {
        return $this->hasMany(PerbandinganKriteria::class, 'kriteria_2');
    }
}
