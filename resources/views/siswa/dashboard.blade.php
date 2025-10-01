@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Selamat Datang, {{ Auth::user()->siswa->nama_lengkap }}</h1>
        <p class="page-subtitle">Dashboard Pengajuan Beasiswa MA Muhammadiyah 1 Bandung</p>
    </div>

    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="info-card bg-primary">
                <div class="info-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">NIS</div>
                    <div class="info-value">{{ Auth::user()->siswa->nis }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="info-card bg-success">
                <div class="info-icon">
                    <i class="fas fa-school"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Kelas</div>
                    <div class="info-value">{{ Auth::user()->siswa->kelas }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="info-card bg-info">
                <div class="info-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Status Pengajuan</div>
                    <div class="info-value">
                        @if ($pengajuan)
                            @if ($pengajuan->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($pengajuan->status == 'diverifikasi')
                                <span class="badge bg-success">Diverifikasi</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        @else
                            <span class="badge bg-secondary">Belum Mengajukan</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-info-circle text-primary"></i> Informasi Pengajuan Beasiswa
                </h5>

                @if ($pengajuan)
                    <div class="alert alert-info">
                        <i class="fas fa-check-circle"></i> Anda telah mengajukan beasiswa pada tanggal
                        <strong>{{ $pengajuan->tanggal_pengajuan->format('d F Y') }}</strong>
                    </div>

                    <div class="timeline">
                        <div
                            class="timeline-item {{ $pengajuan->status == 'pending' || $pengajuan->status == 'diverifikasi' || $pengajuan->status == 'ditolak' ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Pengajuan Diterima</h6>
                                <p>{{ $pengajuan->tanggal_pengajuan->format('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="timeline-item {{ $pengajuan->status == 'diverifikasi' ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Verifikasi Data</h6>
                                <p>{{ $pengajuan->status == 'diverifikasi' ? 'Telah diverifikasi' : 'Menunggu verifikasi' }}
                                </p>
                            </div>
                        </div>

                        <div class="timeline-item {{ $hasilPerhitungan ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Proses Seleksi</h6>
                                <p>{{ $hasilPerhitungan ? 'Seleksi selesai' : 'Menunggu proses seleksi' }}</p>
                            </div>
                        </div>

                        <div
                            class="timeline-item {{ $hasilPerhitungan && $hasilPerhitungan->status_kelulusan == 'lulus' ? 'active' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Pengumuman Hasil</h6>
                                <p>{{ $hasilPerhitungan ? 'Hasil tersedia' : 'Menunggu pengumuman' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Anda belum mengajukan beasiswa. Silakan ajukan beasiswa
                        melalui menu <strong>Pengajuan Beasiswa</strong>.
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('siswa.pengajuan.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Ajukan Beasiswa Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-trophy text-primary"></i> Hasil Seleksi
                </h5>

                @if ($hasilPerhitungan)
                    <div
                        class="result-box {{ $hasilPerhitungan->status_kelulusan == 'lulus' ? 'bg-success' : 'bg-danger' }}">
                        <div class="result-icon">
                            <i
                                class="fas {{ $hasilPerhitungan->status_kelulusan == 'lulus' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                        </div>
                        <div class="result-text">
                            {{ $hasilPerhitungan->status_kelulusan == 'lulus' ? 'Selamat! Anda Lulus' : 'Mohon Maaf, Anda Tidak Lulus' }}
                        </div>
                        <div class="result-detail">
                            <div class="detail-row">
                                <span>Skor Akhir:</span>
                                <strong>{{ number_format($hasilPerhitungan->skor_akhir, 4) }}</strong>
                            </div>
                            <div class="detail-row">
                                <span>Ranking:</span>
                                <strong>{{ $hasilPerhitungan->ranking }}</strong>
                            </div>
                        </div>
                        <a href="{{ route('siswa.hasil') }}" class="btn btn-light btn-sm mt-3 w-100">
                            <i class="fas fa-file-pdf"></i> Cetak Hasil
                        </a>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-hourglass-half"></i>
                        <p>Hasil seleksi belum tersedia</p>
                    </div>
                @endif
            </div>

            <div class="content-card mt-3">
                <h5 class="card-title mb-3">
                    <i class="fas fa-bell text-primary"></i> Pengumuman
                </h5>
                <div class="announcement-box">
                    <p><i class="fas fa-info-circle text-info"></i> Pastikan data yang Anda masukkan sudah benar dan
                        lengkap.</p>
                    <p><i class="fas fa-clock text-warning"></i> Proses verifikasi membutuhkan waktu 3-5 hari kerja.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .info-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
        }

        .bg-primary .info-icon {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .bg-success .info-icon {
            background: linear-gradient(135deg, #065f46 0%, #10b981 100%);
        }

        .bg-info .info-icon {
            background: linear-gradient(135deg, #0c4a6e 0%, #06b6d4 100%);
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 13px;
            color: #111827;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
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

        .timeline-marker {
            position: absolute;
            left: -26px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #e5e7eb;
            border: 3px solid white;
        }

        .timeline-item.active .timeline-marker {
            background: #3b82f6;
        }

        .timeline-content h6 {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 4px;
        }

        .timeline-content p {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
        }

        .result-box {
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            color: white;
        }

        .result-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .result-text {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .result-detail {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 8px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
        }

        .announcement-box p {
            font-size: 13px;
            padding: 10px;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .announcement-box p:last-child {
            margin-bottom: 0;
        }
    </style>
@endsection
