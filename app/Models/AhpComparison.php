<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AhpComparison extends Model
{
    use HasFactory;

    protected $fillable = [
        'kriteria_1',
        'kriteria_2',
        'nilai_perbandingan',
        'keterangan'
    ];

    protected $casts = [
        'nilai_perbandingan' => 'decimal:6',
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
