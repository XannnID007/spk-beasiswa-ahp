@extends('layouts.admin')

@section('title', 'Detail Perhitungan')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Detail Perhitungan AHP</h1>
                <p class="page-subtitle">Detail lengkap proses perhitungan metode AHP</p>
            </div>
            <a href="{{ route('admin.perhitungan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="content-card mb-4">
        <h5 class="card-title mb-4">
            <i class="fas fa-weight text-primary"></i> Bobot Prioritas Kriteria
        </h5>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th width="100">Kode</th>
                        <th>Nama Kriteria</th>
                        <th width="150" class="text-center">Bobot</th>
                        <th width="150" class="text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kriteria as $k)
                        <tr>
                            <td><strong>{{ $k->kode_kriteria }}</strong></td>
                            <td>{{ $k->nama_kriteria }}</td>
                            <td class="text-center"><strong>{{ number_format($k->bobot, 4) }}</strong></td>
                            <td class="text-center">{{ number_format($k->bobot * 100, 2) }}%</td>
                        </tr>
                    @endforeach
                    <tr class="table-light">
                        <td colspan="2" class="text-end"><strong>TOTAL:</strong></td>
                        <td class="text-center"><strong>{{ number_format($kriteria->sum('bobot'), 4) }}</strong></td>
                        <td class="text-center"><strong>100.00%</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="content-card mb-4">
        <h5 class="card-title mb-4">
            <i class="fas fa-table text-primary"></i> Detail Perhitungan Per Siswa
        </h5>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="50">Rank</th>
                        <th width="100">NIS</th>
                        <th>Nama Siswa</th>
                        @foreach ($kriteria as $k)
                            <th width="100" class="text-center">{{ $k->kode_kriteria }}</th>
                        @endforeach
                        <th width="120" class="text-center">Total Skor</th>
                        <th width="100" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hasilPerhitungan as $hasil)
                        <tr>
                            <td class="text-center">
                                <span class="ranking-badge ranking-{{ $hasil->ranking }}">
                                    {{ $hasil->ranking }}
                                </span>
                            </td>
                            <td>{{ $hasil->siswa->nis }}</td>
                            <td><strong>{{ $hasil->siswa->nama_lengkap }}</strong></td>
                            @foreach ($kriteria as $k)
                                @php
                                    $penilaian = $hasil->siswa->penilaian->where('kriteria_id', $k->id)->first();
                                    $skor = 0;
                                    if ($penilaian && $penilaian->subKriteria) {
                                        $skor = $k->bobot * $penilaian->subKriteria->nilai_sub;
                                    }
                                @endphp
                                <td class="text-center">{{ number_format($skor, 6) }}</td>
                            @endforeach
                            <td class="text-center">
                                <strong style="color: #1e3a8a;">{{ number_format($hasil->skor_akhir, 6) }}</strong>
                            </td>
                            <td class="text-center">
                                @if ($hasil->status_kelulusan == 'lulus')
                                    <span class="badge bg-success">Lulus</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Lulus</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="content-card">
        <h5 class="card-title mb-4">
            <i class="fas fa-calculator text-primary"></i> Rumus Perhitungan
        </h5>

        <div class="formula-box">
            <h6>Metode Analytical Hierarchy Process (AHP)</h6>
            <p class="mb-3">Skor Akhir = Σ (Bobot Kriteria × Nilai Sub-Kriteria)</p>

            <div class="formula-detail">
                <p><strong>Dimana:</strong></p>
                <ul>
                    @foreach ($kriteria as $k)
                        <li>{{ $k->kode_kriteria }} = {{ $k->nama_kriteria }} (Bobot: {{ number_format($k->bobot, 4) }})
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i>
                <strong>Contoh Perhitungan:</strong><br>
                Jika siswa mendapat nilai sub-kriteria K1=1.0000, K2=0.443946, K3=1.0000, K4=0.213453, maka:<br>
                Skor = (0.468 × 1.0000) + (0.294 × 0.443946) + (0.160 × 1.0000) + (0.078 × 0.213453)<br>
                Skor = 0.468 + 0.130520 + 0.160 + 0.016649 = <strong>0.775169</strong>
            </div>
        </div>
    </div>

    <style>
        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }

        .table {
            font-size: 13px;
        }

        .table th {
            font-weight: 600;
            font-size: 12px;
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

        .formula-box {
            background: #f9fafb;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #1e3a8a;
        }

        .formula-box h6 {
            font-size: 16px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 15px;
        }

        .formula-box p {
            font-size: 14px;
            color: #111827;
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
    </style>
@endsection
