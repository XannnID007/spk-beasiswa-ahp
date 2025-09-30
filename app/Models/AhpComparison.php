<?php

namespace App\Models;

use App\Helpers\NumberHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $appends = ['formatted_nilai'];

    public function getFormattedNilaiAttribute()
    {
        return NumberHelper::formatComparison($this->nilai_perbandingan);
    }

    public function kriteriaFirst()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_1');
    }

    public function kriteriaSecond()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_2');
    }
}
