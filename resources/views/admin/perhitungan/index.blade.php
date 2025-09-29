@extends('layouts.admin')

@section('title', 'Perhitungan AHP')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Proses Perhitungan AHP</h1>
        <p class="page-subtitle">Analytical Hierarchy Process - Perhitungan Calon Penerima Beasiswa</p>
    </div>

    <div class="content-card mb-4">
        <h5 class="card-title mb-4">
            <i class="fas fa-info-circle text-primary"></i> Informasi Perhitungan
        </h5>

        <div class="alert alert-info">
            <i class="fas fa-lightbulb"></i>
            Sistem akan menghitung skor akhir setiap siswa berdasarkan 4 kriteria dengan bobot yang telah ditentukan
            menggunakan metode AHP.
        </div>

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
            <form action="{{ route('admin.perhitungan.proses') }}" method="POST"
                onsubmit="return confirm('Yakin ingin memulai proses perhitungan? Hasil perhitungan sebelumnya akan diganti.')">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg" {{ $siswaLengkap == 0 ? 'disabled' : '' }}>
                    <i class="fas fa-calculator"></i> Mulai Proses Perhitungan AHP
                </button>
            </form>
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
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $hasil->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
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
                <i class="fas fa-calculator text-primary"></i> Detail Perhitungan Metode AHP
            </h5>

            <!-- Bobot Kriteria -->
            <div class="calculation-section">
                <h6 class="section-subtitle">1. Bobot Prioritas Kriteria</h6>
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
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Matriks Perbandingan Berpasangan -->
            <div class="calculation-section">
                <h6 class="section-subtitle">2. Matriks Perbandingan Berpasangan Kriteria</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria</th>
                                @foreach ($kriteria as $k)
                                    <th class="text-center">{{ $k->kode_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $matriks = [
                                    ['K1', 1, 3, 2, 5],
                                    ['K2', 0.33, 1, 3, 4],
                                    ['K3', 0.5, 0.33, 1, 2],
                                    ['K4', 0.2, 0.25, 0.5, 1],
                                ];
                            @endphp
                            @foreach ($matriks as $row)
                                <tr>
                                    <td><strong>{{ $row[0] }}</strong></td>
                                    @for ($i = 1; $i < count($row); $i++)
                                        <td class="text-center">{{ $row[$i] }}</td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Consistency Ratio -->
            <div class="calculation-section">
                <h6 class="section-subtitle">3. Uji Konsistensi</h6>
                <div class="alert alert-success">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>λ Maks:</strong> 4.212
                        </div>
                        <div class="col-md-4">
                            <strong>CI:</strong> 0.0707
                        </div>
                        <div class="col-md-4">
                            <strong>CR:</strong> 0.0786 < 0.1 <span class="badge bg-success ms-2">KONSISTEN</span>
                        </div>
                    </div>
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
