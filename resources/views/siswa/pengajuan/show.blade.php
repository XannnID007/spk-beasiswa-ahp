@extends('layouts.siswa')

@section('title', 'Detail Pengajuan')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Detail Pengajuan Beasiswa</h1>
                <p class="page-subtitle">Informasi pengajuan beasiswa Anda</p>
            </div>
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="content-card">
                <div
                    class="status-banner {{ $pengajuan->status == 'diverifikasi' ? 'bg-success' : ($pengajuan->status == 'ditolak' ? 'bg-danger' : 'bg-warning') }}">
                    <div class="status-icon">
                        <i
                            class="fas {{ $pengajuan->status == 'diverifikasi' ? 'fa-check-circle' : ($pengajuan->status == 'ditolak' ? 'fa-times-circle' : 'fa-clock') }}"></i>
                    </div>
                    <div class="status-text">
                        @if ($pengajuan->status == 'pending')
                            Pengajuan Anda Sedang Diproses
                        @elseif($pengajuan->status == 'diverifikasi')
                            Pengajuan Anda Telah Diverifikasi
                        @else
                            Pengajuan Anda Ditolak
                        @endif
                    </div>
                </div>

                <h5 class="section-title">Informasi Pengajuan</h5>

                <div class="detail-box">
                    <div class="detail-item">
                        <span class="label">Tanggal Pengajuan</span>
                        <span class="value">{{ $pengajuan->tanggal_pengajuan->format('d F Y') }}</span>
                    </div>

                    @if ($pengajuan->beasiswa)
                        <div class="detail-item">
                            <span class="label">Program Beasiswa</span>
                            <span class="value">
                                <strong>{{ $pengajuan->beasiswa->nama_beasiswa }}</strong>
                                <span class="badge bg-info ms-2">{{ ucfirst($pengajuan->beasiswa->jenis_beasiswa) }}</span>
                            </span>
                        </div>
                    @endif

                    <div class="detail-item">
                        <span class="label">Status</span>
                        <span class="value">
                            @if ($pengajuan->status == 'pending')
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            @elseif($pengajuan->status == 'diverifikasi')
                                <span class="badge bg-success">Diverifikasi</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="label">Alasan Pengajuan</span>
                        <span class="value">{{ $pengajuan->alasan_pengajuan }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="label">Berkas Pendukung</span>
                        <span class="value">
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

                @if ($pengajuan->status == 'pending')
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle"></i>
                        Pengajuan Anda sedang dalam proses verifikasi oleh admin. Harap menunggu konfirmasi lebih lanjut.
                    </div>
                @elseif($pengajuan->status == 'diverifikasi')
                    <div class="alert alert-success mt-4">
                        <i class="fas fa-check-circle"></i>
                        Pengajuan Anda telah diverifikasi. Silakan tunggu hasil seleksi beasiswa.
                    </div>
                @else
                    <div class="alert alert-danger mt-4">
                        <i class="fas fa-exclamation-circle"></i>
                        Mohon maaf, pengajuan Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="content-card">
                <h5 class="section-title">Data Anda</h5>

                <div class="info-list">
                    <div class="info-item">
                        <i class="fas fa-id-card"></i>
                        <div>
                            <div class="info-label">NIS</div>
                            <div class="info-value">{{ $pengajuan->siswa->nis }}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-user"></i>
                        <div>
                            <div class="info-label">Nama</div>
                            <div class="info-value">{{ $pengajuan->siswa->nama_lengkap }}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-school"></i>
                        <div>
                            <div class="info-label">Kelas</div>
                            <div class="info-value">{{ $pengajuan->siswa->kelas }}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <div class="info-label">No. Telepon</div>
                            <div class="info-value">{{ $pengajuan->siswa->no_telp }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .status-banner {
            padding: 25px;
            border-radius: 12px;
            color: white;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .status-icon {
            font-size: 48px;
        }

        .status-text {
            font-size: 20px;
            font-weight: 600;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .detail-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
        }

        .detail-item {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-item .label {
            font-size: 14px;
            color: #6b7280;
            min-width: 180px;
            font-weight: 500;
        }

        .detail-item .value {
            font-size: 14px;
            color: #111827;
            flex: 1;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .info-item i {
            font-size: 20px;
            color: #3b82f6;
            width: 30px;
            text-align: center;
        }

        .info-label {
            font-size: 12px;
            color: #6b7280;
        }

        .info-value {
            font-size: 14px;
            color: #111827;
            font-weight: 600;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }

        .timeline-dot {
            position: absolute;
            left: -26px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #e5e7eb;
            border: 3px solid white;
        }

        .timeline-item.active .timeline-dot {
            background: #3b82f6;
        }

        .timeline-title {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .timeline-date {
            font-size: 12px;
            color: #6b7280;
        }
    </style>
@endsection
