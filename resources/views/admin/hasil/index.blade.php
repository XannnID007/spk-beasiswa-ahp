@php
    use App\Helpers\NumberHelper;
@endphp
@extends('layouts.admin')

@section('title', 'Hasil & Ranking')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Hasil & Ranking Penerima Beasiswa</h1>
        <p class="page-subtitle">Daftar ranking siswa hasil perhitungan AHP</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card bg-success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalLulus }}</div>
                    <div class="stat-label">Siswa Lulus</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-secondary">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalTidakLulus }}</div>
                    <div class="stat-label">Siswa Tidak Lulus</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalLulus + $totalTidakLulus }}</div>
                    <div class="stat-label">Total Peserta</div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header-custom">
            <h5 class="card-title mb-0">
                <i class="fas fa-trophy text-primary"></i> Ranking Siswa
            </h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="80" class="text-center">Ranking</th>
                        <th width="100">NIS</th>
                        <th>Nama Siswa</th>
                        <th width="80" class="text-center">Kelas</th>
                        <th width="150" class="text-center">Skor Akhir</th>
                        <th width="120" class="text-center">Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasil as $h)
                        <tr>
                            <td class="text-center">
                                <div class="ranking-badge ranking-{{ $h->ranking }}">
                                    @if ($h->ranking == 1)
                                        <i class="fas fa-crown"></i>
                                    @endif
                                    {{ $h->ranking }}
                                </div>
                            </td>
                            <td><strong>{{ $h->siswa->nis }}</strong></td>
                            <td>{{ $h->siswa->nama_lengkap }}</td>
                            <td class="text-center"><span class="badge bg-info">{{ $h->siswa->kelas }}</span></td>
                            <td class="text-center">
                                <strong>{{ NumberHelper::formatScore($h->skor_akhir) }}</strong>
                            </td>
                            <td class="text-center">
                                @if ($h->status_kelulusan == 'lulus')
                                    <span class="badge bg-success">Lulus</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Lulus</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.hasil.show', $h->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada hasil perhitungan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $hasil->links() }}
        </div>
    </div>

    <style>
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .bg-success .stat-icon {
            background: linear-gradient(135deg, #065f46 0%, #10b981 100%);
        }

        .bg-secondary .stat-icon {
            background: linear-gradient(135deg, #4b5563 0%, #6b7280 100%);
        }

        .bg-primary .stat-icon {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            margin-top: 2px;
        }

        .ranking-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
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

        .card-header-custom {
            padding: 20px 25px;
            border-bottom: 2px solid #e5e7eb;
        }

        .table {
            font-size: 14px;
        }

        .table thead th {
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            border: none;
            padding: 12px 15px;
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
        }
    </style>
@endsection
