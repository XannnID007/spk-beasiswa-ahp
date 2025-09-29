@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Detail Siswa</h1>
                <p class="page-subtitle">Informasi lengkap data siswa</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="content-card text-center">
                <div class="student-avatar">
                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 2)) }}
                </div>
                <h5 class="mt-3 mb-2">{{ $siswa->nama_lengkap }}</h5>
                <p class="text-muted mb-0">{{ $siswa->nis }}</p>
                <span class="badge bg-info mt-2">{{ $siswa->kelas }}</span>

                <div class="student-stats mt-4">
                    <div class="stat-item">
                        <i class="fas fa-file-alt"></i>
                        <div>
                            <div class="stat-label">Pengajuan</div>
                            <div class="stat-value">{{ $siswa->pengajuanBeasiswa->count() }}</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-clipboard-check"></i>
                        <div>
                            <div class="stat-label">Penilaian</div>
                            <div class="stat-value">{{ $siswa->penilaian->count() }}/4</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="content-card mb-4">
                <h5 class="card-title mb-4">
                    <i class="fas fa-user text-primary"></i> Data Pribadi
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">NIS</span>
                            <span class="detail-value">{{ $siswa->nis }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Nama Lengkap</span>
                            <span class="detail-value">{{ $siswa->nama_lengkap }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Jenis Kelamin</span>
                            <span
                                class="detail-value">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Kelas</span>
                            <span class="detail-value">{{ $siswa->kelas }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Tempat Lahir</span>
                            <span class="detail-value">{{ $siswa->tempat_lahir }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tanggal Lahir</span>
                            <span class="detail-value">{{ $siswa->tanggal_lahir->format('d F Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">No. Telepon</span>
                            <span class="detail-value">{{ $siswa->no_telp }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Alamat</span>
                            <span class="detail-value">{{ $siswa->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card mb-4">
                <h5 class="card-title mb-4">
                    <i class="fas fa-users text-primary"></i> Data Orang Tua
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Nama Ayah</span>
                            <span class="detail-value">{{ $siswa->nama_ayah }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Pekerjaan Ayah</span>
                            <span class="detail-value">{{ $siswa->pekerjaan_ayah ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Nama Ibu</span>
                            <span class="detail-value">{{ $siswa->nama_ibu }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Pekerjaan Ibu</span>
                            <span class="detail-value">{{ $siswa->pekerjaan_ibu ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Penghasilan Orang Tua</span>
                            <span
                                class="detail-value">{{ $siswa->penghasilan_ortu ? 'Rp ' . number_format($siswa->penghasilan_ortu, 0, ',', '.') : '-' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Jumlah Tanggungan</span>
                            <span class="detail-value">{{ $siswa->jumlah_tanggungan ?? '-' }} orang</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($siswa->hasilPerhitungan)
                <div class="content-card">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-trophy text-primary"></i> Hasil Seleksi
                    </h5>

                    <div class="result-box">
                        <div class="result-item">
                            <span class="result-label">Ranking</span>
                            <span class="result-value">{{ $siswa->hasilPerhitungan->ranking }}</span>
                        </div>
                        <div class="result-item">
                            <span class="result-label">Skor Akhir</span>
                            <span class="result-value">{{ number_format($siswa->hasilPerhitungan->skor_akhir, 6) }}</span>
                        </div>
                        <div class="result-item">
                            <span class="result-label">Status</span>
                            <span class="result-value">
                                @if ($siswa->hasilPerhitungan->status_kelulusan == 'lulus')
                                    <span class="badge bg-success">Lulus</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Lulus</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .student-avatar {
            width: 120px;
            height: 120px;
            margin: 20px auto;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: 700;
        }

        .student-stats {
            display: flex;
            gap: 20px;
            justify-content: center;
            padding: 20px 0;
            border-top: 2px solid #e5e7eb;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-item i {
            font-size: 24px;
            color: #3b82f6;
        }

        .stat-label {
            font-size: 12px;
            color: #6b7280;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }

        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 14px;
            color: #6b7280;
            min-width: 150px;
            font-weight: 500;
        }

        .detail-value {
            font-size: 14px;
            color: #111827;
            flex: 1;
        }

        .result-box {
            display: flex;
            gap: 20px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .result-item {
            flex: 1;
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
        }

        .result-label {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .result-value {
            display: block;
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }
    </style>
@endsection
