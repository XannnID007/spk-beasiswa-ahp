<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

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
}
