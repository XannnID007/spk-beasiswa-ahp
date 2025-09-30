@extends('layouts.admin')

@section('title', 'Perhitungan AHP')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Proses Perhitungan AHP</h1>
        <p class="page-subtitle">Analytical Hierarchy Process - Perhitungan Calon Penerima Beasiswa</p>
    </div>

    {{-- Validasi AHP --}}
    <div class="content-card mb-4">
        <h5 class="card-title mb-4">
            <i class="fas fa-shield-check text-primary"></i> Validasi Metode AHP
        </h5>

        @if (!$isAhpComplete)
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Matriks Perbandingan Belum Lengkap!</strong>
                Mohon lengkapi perbandingan kriteria di menu AHP Management sebelum melakukan perhitungan.
                <div class="mt-2">
                    <a href="{{ route('admin.ahp.index') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-arrow-right"></i> Ke AHP Management
                    </a>
                </div>
            </div>
        @elseif(!$ahpValidation['is_valid'])
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i>
                <strong>Validasi AHP Gagal!</strong> {{ $ahpValidation['message'] }}
                <div class="mt-2">
                    <a href="{{ route('admin.ahp.index') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-tools"></i> Perbaiki AHP
                    </a>
                </div>
            </div>
        @else
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <strong>Validasi AHP Berhasil!</strong> {{ $ahpValidation['message'] }}
                <div class="row mt-3">
                    <div class="col-md-4">
                        <small class="text-muted">Consistency Ratio:</small>
                        <div class="fw-bold">{{ number_format($ahpValidation['cr'], 4) }} ≤ 0.1</div>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Lambda Max:</small>
                        <div class="fw-bold">{{ number_format($ahpValidation['lambda_max'], 4) }}</div>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Consistency Index:</small>
                        <div class="fw-bold">{{ number_format($ahpValidation['ci'], 4) }}</div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="content-card mb-4">
        <h5 class="card-title mb-4">
            <i class="fas fa-info-circle text-primary"></i> Informasi Perhitungan
        </h5>

        <div class="row">
            <div class="col-md-3">
                <div class="info-box">
                    <div class="info-label">Total Siswa Terverifikasi</div>
                    <div class="info-value">{{ $totalSiswaVerifikasi }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <div class="info-label">Siswa dengan Nilai Lengkap</div>
                    <div class="info-value">{{ $siswaLengkap }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <div class="info-label">Sudah Dihitung</div>
                    <div class="info-value">{{ $sudahDihitung }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <div class="info-label">Belum Dihitung</div>
                    <div class="info-value">{{ $belumDihitung }}</div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            @if ($ahpValidation['is_valid'] && $siswaLengkap > 0)
                <form action="{{ route('admin.perhitungan.proses') }}" method="POST"
                    onsubmit="return confirm('Yakin ingin memulai proses perhitungan? Hasil perhitungan sebelumnya akan diganti.')">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-calculator"></i> Mulai Proses Perhitungan AHP
                    </button>
                </form>

                @if ($sudahDihitung > 0)
                    <a href="{{ route('admin.perhitungan.recalculate') }}" class="btn btn-warning btn-lg ms-2"
                        onclick="return confirm('Hitung ulang dengan bobot AHP terbaru?')">
                        <i class="fas fa-redo"></i> Hitung Ulang
                    </a>
                @endif
            @else
                <button type="button" class="btn btn-primary btn-lg" disabled>
                    <i class="fas fa-calculator"></i> Mulai Proses Perhitungan AHP
                </button>
                <small class="text-muted d-block mt-2">
                    Proses perhitungan tidak dapat dilakukan karena validasi AHP belum berhasil atau belum ada data siswa.
                </small>
            @endif
        </div>
    </div>

    @if ($hasilPerhitungan && count($hasilPerhitungan) > 0)
        <div class="content-card mb-4">
            <h5 class="card-title mb-4">
                <i class="fas fa-list-ol text-primary"></i> Hasil Ranking Penerima Beasiswa
            </h5>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center" width="80">Ranking</th>
                            <th width="120">NIS</th>
                            <th>Nama Siswa</th>
                            <th width="80" class="text-center">Kelas</th>
                            <th width="120" class="text-center">Skor Akhir</th>
                            <th width="100" class="text-center">Status</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilPerhitungan as $hasil)
                            <tr>
                                <td class="text-center">
                                    <span class="ranking-badge ranking-{{ $hasil->ranking }}">{{ $hasil->ranking }}</span>
                                </td>
                                <td>{{ $hasil->siswa->nis }}</td>
                                <td><strong>{{ $hasil->siswa->nama_lengkap }}</strong></td>
                                <td class="text-center">{{ $hasil->siswa->kelas }}</td>
                                <td class="text-center"><strong>{{ number_format($hasil->skor_akhir, 6) }}</strong></td>
                                <td class="text-center">
                                    @if ($hasil->status_kelulusan == 'lulus')
                                        <span class="badge bg-success">Lulus</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Lulus</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.hasil.show', $hasil->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detail Perhitungan AHP -->
        <div class="content-card">
            <h5 class="card-title mb-4">
                <i class="fas fa-calculator text-primary"></i> Detail Metode AHP
            </h5>

            <!-- Bobot Kriteria -->
            <div class="calculation-section">
                <h6 class="section-subtitle">1. Bobot Prioritas Kriteria (Hasil AHP)</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Kriteria</th>
                                <th class="text-center">Bobot</th>
                                <th class="text-center">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria as $k)
                                <tr>
                                    <td><strong>{{ $k->kode_kriteria }}</strong></td>
                                    <td>{{ $k->nama_kriteria }}</td>
                                    <td class="text-center">{{ number_format($k->bobot, 4) }}</td>
                                    <td class="text-center">{{ number_format($k->bobot * 100, 2) }}%</td>
                                </tr>
                            @endforeach
                            <tr class="table-info">
                                <td colspan="2" class="text-end"><strong>TOTAL:</strong></td>
                                <td class="text-center"><strong>{{ number_format($kriteria->sum('bobot'), 4) }}</strong>
                                </td>
                                <td class="text-center"><strong>100.00%</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rumus Perhitungan -->
            <div class="calculation-section">
                <h6 class="section-subtitle">2. Formula Perhitungan Skor Akhir</h6>
                <div class="formula-box">
                    <div class="formula-title">Metode Analytical Hierarchy Process (AHP)</div>
                    <div class="formula-main">
                        <strong>Skor Akhir = Σ (Bobot Kriteria × Nilai Sub-Kriteria)</strong>
                    </div>
                    <div class="formula-detail">
                        <p><strong>Dimana:</strong></p>
                        <ul>
                            @foreach ($kriteria as $k)
                                <li>{{ $k->kode_kriteria }} = {{ $k->nama_kriteria }} (Bobot:
                                    {{ number_format($k->bobot, 4) }})</li>
                            @endforeach
                        </ul>
                    </div>

                    @if ($ahpValidation['is_valid'])
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle"></i>
                            <strong>Validasi AHP:</strong><br>
                            • Consistency Ratio = {{ number_format($ahpValidation['cr'], 4) }} ≤ 0.1 ✓<br>
                            • Matriks perbandingan konsisten dan valid untuk perhitungan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <style>
        .info-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #e5e7eb;
        }

        .info-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 28px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .ranking-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
        }

        .ranking-1 {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
        }

        .ranking-2 {
            background: linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);
            color: white;
        }

        .ranking-3 {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
        }

        .ranking-badge:not(.ranking-1):not(.ranking-2):not(.ranking-3) {
            background: #e5e7eb;
            color: #374151;
        }

        .calculation-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
        }

        .calculation-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-subtitle {
            font-size: 16px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 15px;
        }

        .formula-box {
            background: #f0f9ff;
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid #1e3a8a;
        }

        .formula-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        .formula-main {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            font-size: 16px;
            text-align: center;
            border: 2px solid #1e3a8a;
        }

        .formula-detail {
            background: white;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
        }

        .formula-detail ul {
            margin: 10px 0 0 0;
            padding-left: 25px;
        }

        .formula-detail li {
            margin-bottom: 5px;
            font-size: 13px;
        }

        .table-bordered th,
        .table-bordered td {
            border-color: #d1d5db;
        }

        .table thead th {
            font-weight: 600;
            font-size: 13px;
        }
    </style>
@endsection
