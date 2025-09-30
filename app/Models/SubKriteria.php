<?php

namespace App\Models;

use App\Helpers\NumberHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubKriteria extends Model
{
    use HasFactory;

    protected $appends = ['formatted_nilai_sub'];
    protected $table = 'sub_kriteria';

    protected $fillable = [
        'kriteria_id',
        'nama_sub_kriteria',
        'nilai_sub',
        'range_min',
        'range_max',
        'kategori'
    ];

    protected $casts = [
        'nilai_sub' => 'decimal:6',
        'range_min' => 'decimal:2',
        'range_max' => 'decimal:2',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function getFormattedNilaiSubAttribute()
    {
        return NumberHelper::formatSubCriteria($this->nilai_sub);
    }
}
