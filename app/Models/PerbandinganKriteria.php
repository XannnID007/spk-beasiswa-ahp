<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbandinganKriteria extends Model
{
    use HasFactory;

    protected $table = 'perbandingan_kriteria';

    protected $fillable = [
        'kriteria_1',
        'kriteria_2',
        'nilai_perbandingan'
    ];

    protected $casts = [
        'nilai_perbandingan' => 'decimal:2',
    ];

    public function kriteriaFirst()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_1');
    }

    public function kriteriaSecond()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_2');
    }
}
