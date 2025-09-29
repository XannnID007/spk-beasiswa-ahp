@extends('layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Detail Pengajuan Beasiswa</h1>
                <p class="page-subtitle">Informasi lengkap pengajuan dari siswa</p>
            </div>
            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="content-card">
                <div class="text-center mb-4">
                    <div class="student-avatar">
                        {{ strtoupper(substr($pengajuan->siswa->nama_lengkap, 0, 2)) }}
                    </div>
                    <h5 class="mt-3 mb-2">{{ $pengajuan->siswa->nama_lengkap }}</h5>
                    <p class="text-muted mb-0">{{ $pengajuan->siswa->nis }}</p>
                    <span class="badge bg-info mt-2">{{ $pengajuan->siswa->kelas }}</span>
                </div>

                <div class="status-box">
                    <div class="status-label">Status Pengajuan</div>
                    <div class="status-value">
                        @if ($pengajuan->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($pengajuan->status == 'diverifikasi')
                            <span class="badge bg-success">Diverifikasi</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </div>
                </div>

                @if ($pengajuan->status == 'pending')
                    <div class="action-buttons">
                        <form action="{{ route('admin.pengajuan.verifikasi', $pengajuan->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 mb-2"
                                onclick="return confirm('Verifikasi pengajuan ini?')">
                                <i class="fas fa-check"></i> Verifikasi
                            </button>
                        </form>
                        <form action="{{ route('admin.pengajuan.tolak', $pengajuan->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Tolak pengajuan ini?')">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="content-card mb-4">
                <h5 class="card-title mb-4">
                    <i class="fas fa-info-circle text-primary"></i> Informasi Pengajuan
                </h5>

                <div class="detail-row">
                    <span class="detail-label">Tanggal Pengajuan</span>
                    <span class="detail-value">{{ $pengajuan->tanggal_pengajuan->format('d F Y') }}</span>
                </div>

                @if ($pengajuan->beasiswa)
                    <div class="detail-row">
                        <span class="detail-label">Program Beasiswa</span>
                        <span class="detail-value">
                            <strong>{{ $pengajuan->beasiswa->nama_beasiswa }}</strong>
                            <span class="badge bg-info ms-2">{{ $pengajuan->beasiswa->jenis_beasiswa }}</span>
                        </span>
                    </div>
                @endif

                <div class="detail-row">
                    <span class="detail-label">Alasan Pengajuan</span>
                    <span class="detail-value">{{ $pengajuan->alasan_pengajuan }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Berkas Pendukung</span>
                    <span class="detail-value">
                        @if ($pengajuan->berkas_pendukung)
                            <a href="{{ asset($pengajuan->berkas_pendukung) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Unduh Berkas
                            </a>
                        @else
                            <span class="text-muted">Tidak ada berkas</span>
                        @endif
                    </span>
                </div>
            </div>

            <div class="content-card mb-4">
                <h5 class="card-title mb-4">
                    <i class="fas fa-user text-primary"></i> Data Pribadi Siswa
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">NIS</span>
                            <span class="detail-value">{{ $pengajuan->siswa->nis }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Nama Lengkap</span>
                            <span class="detail-value">{{ $pengajuan->siswa->nama_lengkap }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Jenis Kelamin</span>
                            <span
                                class="detail-value">{{ $pengajuan->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tempat, Tanggal Lahir</span>
                            <span class="detail-value">{{ $pengajuan->siswa->tempat_lahir }},
                                {{ $pengajuan->siswa->tanggal_lahir->format('d F Y') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Kelas</span>
                            <span class="detail-value">{{ $pengajuan->siswa->kelas }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">No. Telepon</span>
                            <span class="detail-value">{{ $pengajuan->siswa->no_telp }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Alamat</span>
                            <span class="detail-value">{{ $pengajuan->siswa->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-users text-primary"></i> Data Orang Tua
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Nama Ayah</span>
                            <span class="detail-value">{{ $pengajuan->siswa->nama_ayah }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Pekerjaan Ayah</span>
                            <span class="detail-value">{{ $pengajuan->siswa->pekerjaan_ayah ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Nama Ibu</span>
                            <span class="detail-value">{{ $pengajuan->siswa->nama_ibu }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Pekerjaan Ibu</span>
                            <span class="detail-value">{{ $pengajuan->siswa->pekerjaan_ibu ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Penghasilan Orang Tua</span>
                            <span class="detail-value">Rp
                                {{ number_format($pengajuan->siswa->penghasilan_ortu, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Jumlah Tanggungan</span>
                            <span class="detail-value">{{ $pengajuan->siswa->jumlah_tanggungan }} orang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .student-avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            font-weight: 700;
        }

        .status-box {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }

        .status-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .status-value {
            font-size: 16px;
        }

        .action-buttons {
            margin-top: 20px;
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
            min-width: 180px;
            font-weight: 500;
        }

        .detail-value {
            font-size: 14px;
            color: #111827;
            flex: 1;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }
    </style>
@endsection
