@extends('layouts.admin')

@section('title', 'Cetak Laporan')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Cetak Laporan</h1>
        <p class="page-subtitle">Export laporan hasil seleksi beasiswa</p>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="stat-box">
                <i class="fas fa-users"></i>
                <div class="stat-number">{{ $totalSiswa }}</div>
                <div class="stat-text">Total Siswa</div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="stat-box">
                <i class="fas fa-check-circle text-success"></i>
                <div class="stat-number">{{ $totalLulus }}</div>
                <div class="stat-text">Lulus Seleksi</div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="stat-box">
                <i class="fas fa-times-circle text-danger"></i>
                <div class="stat-number">{{ $totalTidakLulus }}</div>
                <div class="stat-text">Tidak Lulus</div>
            </div>
        </div>
    </div>

    <div class="content-card">
        <h5 class="card-title mb-4">
            <i class="fas fa-file-export text-primary"></i> Export Laporan
        </h5>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="export-card">
                    <div class="export-icon">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div class="export-content">
                        <h6>Laporan PDF</h6>
                        <p>Export laporan lengkap dalam format PDF</p>

                        <form action="{{ route('admin.laporan.cetak-pdf') }}" method="GET" class="mt-3">
                            <div class="mb-3">
                                <label class="form-label">Filter Status</label>
                                <select class="form-select" name="status">
                                    <option value="all">Semua Status</option>
                                    <option value="lulus">Hanya yang Lulus</option>
                                    <option value="tidak_lulus">Hanya yang Tidak Lulus</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-download"></i> Download PDF
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="export-card">
                    <div class="export-icon">
                        <i class="fas fa-file-excel"></i>
                    </div>
                    <div class="export-content">
                        <h6>Laporan Excel</h6>
                        <p>Export laporan lengkap dalam format Excel</p>

                        <form action="{{ route('admin.laporan.export-excel') }}" method="GET" class="mt-3">
                            <div class="mb-3">
                                <label class="form-label">Filter Status</label>
                                <select class="form-select" name="status">
                                    <option value="all">Semua Status</option>
                                    <option value="lulus">Hanya yang Lulus</option>
                                    <option value="tidak_lulus">Hanya yang Tidak Lulus</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-download"></i> Download Excel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card mt-4">
        <h5 class="card-title mb-4">
            <i class="fas fa-info-circle text-primary"></i> Informasi Laporan
        </h5>

        <div class="alert alert-info">
            <h6><i class="fas fa-lightbulb"></i> Isi Laporan:</h6>
            <ul class="mb-0">
                <li>Daftar lengkap siswa dengan ranking</li>
                <li>Skor akhir hasil perhitungan AHP</li>
                <li>Status kelulusan setiap siswa</li>
                <li>Informasi kriteria dan bobot penilaian</li>
                <li>Kop surat resmi sekolah</li>
            </ul>
        </div>

        <div class="alert alert-warning">
            <h6><i class="fas fa-exclamation-triangle"></i> Catatan:</h6>
            <p class="mb-0">Pastikan data hasil perhitungan sudah tersedia sebelum mencetak laporan. Jika belum ada hasil,
                silakan lakukan proses perhitungan terlebih dahulu di menu <strong>Proses Perhitungan</strong>.</p>
        </div>
    </div>

    <style>
        .stat-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stat-box i {
            font-size: 48px;
            color: #3b82f6;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 5px;
        }

        .stat-text {
            font-size: 14px;
            color: #6b7280;
        }

        .export-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 25px;
            height: 100%;
            transition: all 0.3s ease;
        }

        .export-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .export-icon {
            text-align: center;
            margin-bottom: 20px;
        }

        .export-icon i {
            font-size: 64px;
            color: #3b82f6;
        }

        .export-content h6 {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 10px;
        }

        .export-content p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 0;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }

        .alert h6 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .alert ul {
            padding-left: 25px;
            font-size: 14px;
        }
    </style>
@endsection
