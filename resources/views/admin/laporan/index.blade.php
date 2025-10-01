@extends('layouts.admin')

@section('title', 'Cetak Laporan')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Cetak Laporan</h1>
        <p class="page-subtitle">Ekspor laporan hasil seleksi beasiswa</p>
    </div>

    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stat-card bg-primary">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalSiswa }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stat-card bg-success">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalLulus }}</div>
                    <div class="stat-label">Lulus Seleksi</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stat-card bg-danger">
                <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalTidakLulus }}</div>
                    <div class="stat-label">Tidak Lulus</div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header-modern">
            <h5 class="card-title">
                <i class="fas fa-file-export text-primary"></i> Opsi Ekspor Laporan
            </h5>
        </div>

        <form action="#" method="GET" id="laporanForm">
            <div class="row p-4">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Filter Status Kelulusan</label>
                    <select class="form-select" id="status" name="status">
                        <option value="all">Semua Status</option>
                        <option value="lulus">Hanya yang Lulus</option>
                        <option value="tidak_lulus">Hanya yang Tidak Lulus</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Format Laporan</label>
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="button" class="btn btn-danger flex-fill"
                            onclick="submitForm('{{ route('admin.laporan.cetak-pdf') }}')">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </button>
                        <button type="button" class="btn btn-success flex-fill"
                            onclick="submitForm('{{ route('admin.laporan.export-excel') }}')">
                            <i class="fas fa-file-excel"></i> Download Excel
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="px-4 pb-4">
            <div class="alert alert-info mb-0">
                <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Informasi Laporan</h6>
                <p class="mb-1">Laporan akan berisi daftar siswa yang telah diseleksi, lengkap dengan skor akhir, ranking,
                    dan status kelulusan. Pastikan proses perhitungan telah dijalankan sebelum mencetak laporan.</p>
                <ul class="mb-0 small">
                    <li>Kop surat resmi sekolah.</li>
                    <li>Informasi kriteria dan bobot penilaian yang digunakan.</li>
                </ul>
            </div>
        </div>
    </div>

    <style>
        /* Menggunakan gaya dari halaman lain untuk konsistensi */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.3s ease;
            color: white;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            background: rgba(255, 255, 255, 0.2);
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
        }

        .stat-label {
            font-size: 13px;
            opacity: 0.9;
            margin-top: 2px;
        }

        .card-header-modern {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            font-size: 14px;
            margin-bottom: 8px;
        }
    </style>

    <script>
        function submitForm(action) {
            const form = document.getElementById('laporanForm');
            form.action = action;
            form.submit();
        }
    </script>
@endsection
