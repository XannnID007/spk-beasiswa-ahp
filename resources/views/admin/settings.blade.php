@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Pengaturan Sistem</h1>
        <p class="page-subtitle">Kelola pengaturan aplikasi SPK Beasiswa</p>
    </div>

    <div class="content-card mb-4">
        <h5 class="card-title mb-4">
            <i class="fas fa-school text-primary"></i> Informasi Sekolah
        </h5>

        <div class="info-box">
            <div class="info-row">
                <span class="label">Nama Sekolah</span>
                <span class="value">MA Muhammadiyah 1 Bandung</span>
            </div>
            <div class="info-row">
                <span class="label">Alamat</span>
                <span class="value">Jl. Otto Iskandar Dinata No.77B-95, Pelindung Hewan, Kec. Astanaanyar, Kota
                    Bandung</span>
            </div>
            <div class="info-row">
                <span class="label">Telepon</span>
                <span class="value">(022) 4262873</span>
            </div>
            <div class="info-row">
                <span class="label">Email</span>
                <span class="value">ma.muh1bandung@gmail.com</span>
            </div>
        </div>
    </div>

    <div class="content-card mb-4">
        <h5 class="card-title mb-4">
            <i class="fas fa-calculator text-primary"></i> Pengaturan Metode AHP
        </h5>

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            Metode AHP menggunakan 4 kriteria dengan bobot yang telah ditetapkan sesuai BAB III skripsi.
        </div>

        <div class="method-info">
            <h6>Kriteria Penilaian:</h6>
            <ul>
                <li><strong>K1:</strong> Nilai Rata-rata Raport (Bobot: 0.468 / 46.8%)</li>
                <li><strong>K2:</strong> Jumlah Tanggungan Keluarga (Bobot: 0.294 / 29.4%)</li>
                <li><strong>K3:</strong> Penghasilan Orang Tua (Bobot: 0.160 / 16.0%)</li>
                <li><strong>K4:</strong> Keaktifan Siswa (Bobot: 0.078 / 7.8%)</li>
            </ul>

            <h6 class="mt-3">Consistency Ratio:</h6>
            <p>CR = 0.0786 < 0.1 (Konsisten)</p>
        </div>
    </div>

    <div class="content-card mb-4">
        <h5 class="card-title mb-4">
            <i class="fas fa-trophy text-primary"></i> Pengaturan Kelulusan
        </h5>

        <div class="setting-box">
            <div class="setting-item">
                <div class="setting-label">
                    <i class="fas fa-users"></i>
                    <span>Kuota Penerima Beasiswa</span>
                </div>
                <div class="setting-value">
                    <span class="badge bg-primary">Top 10 Ranking</span>
                </div>
            </div>

            <div class="setting-item">
                <div class="setting-label">
                    <i class="fas fa-chart-line"></i>
                    <span>Metode Perhitungan</span>
                </div>
                <div class="setting-value">
                    <span class="badge bg-success">AHP (Analytical Hierarchy Process)</span>
                </div>
            </div>

            <div class="setting-item">
                <div class="setting-label">
                    <i class="fas fa-sort-numeric-down"></i>
                    <span>Urutan Ranking</span>
                </div>
                <div class="setting-value">
                    <span class="badge bg-info">Skor Tertinggi → Terendah</span>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card">
        <h5 class="card-title mb-4">
            <i class="fas fa-info-circle text-primary"></i> Informasi Aplikasi
        </h5>

        <div class="info-box">
            <div class="info-row">
                <span class="label">Nama Aplikasi</span>
                <span class="value">SPK Beasiswa MA Muhammadiyah 1 Bandung</span>
            </div>
            <div class="info-row">
                <span class="label">Versi</span>
                <span class="value">1.0.0</span>
            </div>
            <div class="info-row">
                <span class="label">Framework</span>
                <span class="value">Laravel {{ app()->version() }}</span>
            </div>
            <div class="info-row">
                <span class="label">Metode</span>
                <span class="value">Analytical Hierarchy Process (AHP)</span>
            </div>
        </div>
    </div>

    <style>
        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }

        .info-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
        }

        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row .label {
            font-size: 14px;
            color: #6b7280;
            min-width: 180px;
            font-weight: 500;
        }

        .info-row .value {
            font-size: 14px;
            color: #111827;
            flex: 1;
        }

        .method-info {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
        }

        .method-info h6 {
            font-size: 14px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        .method-info ul {
            margin: 0;
            padding-left: 25px;
        }

        .method-info li {
            margin-bottom: 8px;
            font-size: 14px;
            color: #374151;
        }

        .method-info p {
            font-size: 14px;
            color: #374151;
            margin: 0;
        }

        .setting-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .setting-item:last-child {
            margin-bottom: 0;
        }

        .setting-label {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #374151;
            font-weight: 500;
        }

        .setting-label i {
            font-size: 18px;
            color: #3b82f6;
        }

        .setting-value .badge {
            font-size: 13px;
            padding: 8px 15px;
        }
    </style>
@endsection
