<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_beasiswa';

    protected $fillable = [
        'siswa_id',
        'beasiswa_id',
        'status',
        'alasan_pengajuan',
        'berkas_pendukung',
        'tanggal_pengajuan'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDiverifikasi($query)
    {
        return $query->where('status', 'diverifikasi');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
}
