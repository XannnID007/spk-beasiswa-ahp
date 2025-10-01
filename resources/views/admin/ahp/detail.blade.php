@extends('layouts.admin')

@section('title', 'Detail Perhitungan AHP')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Perhitungan AHP</h1>
            <p class="page-subtitle">Rincian langkah-langkah perhitungan bobot kriteria</p>
        </div>
    </div>

    @if ($calculation)
        @php
            // PERBAIKAN: Langsung gunakan variabel karena sudah di-cast menjadi array oleh Model
            $matrix = $calculation->comparison_matrix;
            $normalizedMatrix = $calculation->normalized_matrix;
            $priorityVector = $calculation->priority_vector;
            $n = count($kriteria);
        @endphp

        {{-- Matriks Perbandingan Berpasangan --}}
        <div class="content-card mb-4">
            <div class="card-header-modern">
                <h5 class="card-title">1. Matriks Perbandingan Berpasangan</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-matrix">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            @foreach ($kriteria as $k)
                                <th>{{ $k->kode_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kriteria as $i => $k)
                            <tr>
                                <th>{{ $k->kode_kriteria }}</th>
                                @for ($j = 0; $j < $n; $j++)
                                    <td>{{ number_format($matrix[$i][$j] ?? 0, 4) }}</td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Matriks Normalisasi & Bobot Prioritas --}}
        <div class="content-card mb-4">
            <div class="card-header-modern">
                <h5 class="card-title">2. Matriks Normalisasi & Bobot Prioritas</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-matrix">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            @foreach ($kriteria as $k)
                                <th>{{ $k->kode_kriteria }}</th>
                            @endforeach
                            <th class="bg-primary-light">Jumlah Baris</th>
                            <th class="bg-success-light">Bobot Prioritas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kriteria as $i => $k)
                            <tr>
                                <th>{{ $k->kode_kriteria }}</th>
                                @for ($j = 0; $j < $n; $j++)
                                    <td>{{ number_format($normalizedMatrix[$i][$j] ?? 0, 4) }}</td>
                                @endfor
                                <td class="bg-primary-light">
                                    {{ number_format(array_sum($normalizedMatrix[$i] ?? []), 4) }}
                                </td>
                                <td class="bg-success-light">
                                    <strong>{{ number_format($priorityVector[$i] ?? 0, 4) }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Perhitungan Konsistensi --}}
        <div class="content-card mb-4">
            <div class="card-header-modern">
                <h5 class="card-title">3. Uji Konsistensi</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Nilai Lambda Max (λmax)</span>
                    <span class="badge bg-primary rounded-pill fs-6">{{ number_format($calculation->lambda_max, 4) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Consistency Index (CI)</span>
                    <span
                        class="badge bg-info rounded-pill fs-6">{{ number_format($calculation->consistency_index, 4) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Random Index (RI) untuk n={{ $n }}</span>
                    <span
                        class="badge bg-secondary rounded-pill fs-6">{{ \App\Services\AhpCalculatorService::RANDOM_INDEX[$n] ?? 'N/A' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Consistency Ratio (CR = CI / RI)</span>
                    <span class="badge bg-{{ $calculation->is_consistent ? 'success' : 'danger' }} rounded-pill fs-6">
                        {{ number_format($calculation->consistency_ratio, 4) }}
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Status Konsistensi (CR ≤ 0.1)</span>
                    @if ($calculation->is_consistent)
                        <span class="badge bg-success rounded-pill">Konsisten</span>
                    @else
                        <span class="badge bg-danger rounded-pill">Tidak Konsisten</span>
                    @endif
                </li>
            </ul>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.ahp.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke AHP Management
            </a>
        </div>
    @else
        <div class="alert alert-danger">Belum ada data perhitungan yang tersimpan.</div>
    @endif

    <style>
        .table-matrix th,
        .table-matrix td {
            text-align: center;
            vertical-align: middle;
        }

        .bg-primary-light {
            background-color: #dbeafe;
        }

        .bg-success-light {
            background-color: #d1fae5;
        }
    </style>
@endsection
