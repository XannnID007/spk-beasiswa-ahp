<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    use HasFactory;

    protected $table = 'beasiswa';

    protected $fillable = [
        'nama_beasiswa',
        'jenis_beasiswa',
        'deskripsi',
        'kuota',
        'nominal',
        'tanggal_buka',
        'tanggal_tutup',
        'status',
        'tahun_ajaran'
    ];

    protected $casts = [
        'tanggal_buka' => 'date',
        'tanggal_tutup' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function pengajuan()
    {
        return $this->hasMany(PengajuanBeasiswa::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')
            ->whereDate('tanggal_buka', '<=', now())
            ->whereDate('tanggal_tutup', '>=', now());
    }

    public function isAktif()
    {
        return $this->status === 'aktif'
            && $this->tanggal_buka <= now()
            && $this->tanggal_tutup >= now();
    }
}
