<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPerhitungan extends Model
{
    use HasFactory;

    protected $table = 'hasil_perhitungan';

    protected $fillable = [
        'siswa_id',
        'skor_akhir',
        'ranking',
        'status_kelulusan',
        'tanggal_perhitungan',
        'catatan'
    ];

    protected $casts = [
        'tanggal_perhitungan' => 'date',
        'skor_akhir' => 'decimal:6',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function scopeLulus($query)
    {
        return $query->where('status_kelulusan', 'lulus');
    }

    public function scopeTidakLulus($query)
    {
        return $query->where('status_kelulusan', 'tidak_lulus');
    }
}
