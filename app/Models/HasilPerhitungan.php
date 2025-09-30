<?php

namespace App\Models;

use App\Helpers\NumberHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilPerhitungan extends Model
{
    use HasFactory;

    protected $appends = ['formatted_skor'];

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

    public function getFormattedSkorAttribute()
    {
        return NumberHelper::formatScore($this->skor_akhir);
    }
}
