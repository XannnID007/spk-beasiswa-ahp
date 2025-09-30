<?php

namespace App\Models;

use App\Helpers\NumberHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $appends = ['formatted_bobot', 'formatted_percentage'];

    public function getFormattedBobotAttribute()
    {
        return NumberHelper::formatWeight($this->bobot);
    }

    public function getFormattedPercentageAttribute()
    {
        return NumberHelper::formatPercentage($this->bobot);
    }

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
