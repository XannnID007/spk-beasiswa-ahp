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

    <!-- Summary Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-value">{{ $totalLulus }}</div>
                    <div class="stat-label">Lulus</div>
                </div>
                <div class="stat-badge">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-secondary">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-value">{{ $totalTidakLulus }}</div>
                    <div class="stat-label">Tidak Lulus</div>
                </div>
                <div class="stat-badge">
                    <i class="fas fa-arrow-down"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-value">{{ $totalLulus + $totalTidakLulus }}</div>
                    <div class="stat-label">Total Peserta</div>
                </div>
                <div class="stat-badge">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-info">
                <div class="stat-icon">
                    <i class="fas fa-percent"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-value">
                        {{ $totalLulus + $totalTidakLulus > 0 ? number_format(($totalLulus / ($totalLulus + $totalTidakLulus)) * 100, 1) : 0 }}%
                    </div>
                    <div class="stat-label">Kelulusan</div>
                </div>
                <div class="stat-badge">
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="content-card">
        <!-- Card Header with Filters -->
        <div class="card-header-modern">
            <div class="header-left">
                <h5 class="card-title">
                    <i class="fas fa-trophy"></i>
                    Ranking Siswa Penerima Beasiswa
                </h5>
                <p class="card-subtitle">Hasil perhitungan metode AHP - Analytical Hierarchy Process</p>
            </div>
            <div class="header-right">
                <div class="filter-group">
                    <select class="form-select form-select-sm" id="filterStatus" onchange="filterTable()">
                        <option value="all">Semua Status</option>
                        <option value="lulus">Lulus Saja</option>
                        <option value="tidak_lulus">Tidak Lulus Saja</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Responsive -->
        <div class="table-responsive">
            <table class="table table-modern" id="hasilTable">
                <thead>
                    <tr>
                        <th width="100" class="text-center">
                            <i class="fas fa-trophy"></i> Ranking
                        </th>
                        <th width="120">
                            <i class="fas fa-id-card"></i> NIS
                        </th>
                        <th>
                            <i class="fas fa-user"></i> Nama Siswa
                        </th>
                        <th width="100" class="text-center">
                            <i class="fas fa-school"></i> Kelas
                        </th>
                        <th width="150" class="text-center">
                            <i class="fas fa-calculator"></i> Skor Akhir
                        </th>
                        <th width="140" class="text-center">
                            <i class="fas fa-flag-checkered"></i> Status
                        </th>
                        <th width="140" class="text-center">
                            <i class="fas fa-cog"></i> Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasil as $h)
                        <tr class="table-row" data-status="{{ $h->status_kelulusan }}">
                            <td class="text-center">
                                <div class="ranking-wrapper">
                                    @if ($h->ranking <= 3)
                                        <div class="medal-badge medal-{{ $h->ranking }}">
                                            @if ($h->ranking == 1)
                                                <i class="fas fa-crown"></i>
                                            @elseif($h->ranking == 2)
                                                <i class="fas fa-medal"></i>
                                            @else
                                                <i class="fas fa-award"></i>
                                            @endif
                                            <span>{{ $h->ranking }}</span>
                                        </div>
                                    @else
                                        <div class="ranking-number">
                                            <span>{{ $h->ranking }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="nis-badge">{{ $h->siswa->nis }}</span>
                            </td>
                            <td>
                                <div class="student-info">
                                    <div class="student-details">
                                        <div class="student-name">{{ $h->siswa->nama_lengkap }}</div>
                                        <div class="student-meta">
                                            <i class="fas fa-phone"></i> {{ $h->siswa->no_telp }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge-kelas">{{ $h->siswa->kelas }}</span>
                            </td>
                            <td class="text-center">
                                <div class="score-display">
                                    <div class="score-value">{{ NumberHelper::formatScore($h->skor_akhir) }}</div>
                                    <div class="score-progress">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $h->skor_akhir * 100 }}%"
                                                aria-valuenow="{{ $h->skor_akhir }}" aria-valuemin="0"
                                                aria-valuemax="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($h->status_kelulusan == 'lulus')
                                    <span class="status-badge status-lulus">
                                        <i class="fas fa-check-circle"></i>
                                        Lulus
                                    </span>
                                @else
                                    <span class="status-badge status-tidak-lulus">
                                        <i class="fas fa-times-circle"></i>
                                        Tidak Lulus
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.hasil.show', $h->id) }}" class="btn-action btn-action-info"
                                        data-bs-toggle="tooltip" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                    <h6>Belum Ada Hasil Perhitungan</h6>
                                    <p>Proses perhitungan belum dilakukan atau belum ada data siswa yang dinilai</p>
                                    <a href="{{ route('admin.perhitungan.index') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-calculator"></i> Mulai Perhitungan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($hasil->hasPages())
            <div class="pagination-wrapper">
                {{ $hasil->links() }}
            </div>
        @endif
    </div>

    <style>
        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .stat-card.stat-success::before {
            background: linear-gradient(180deg, #059669 0%, #10b981 100%);
        }

        .stat-card.stat-secondary::before {
            background: linear-gradient(180deg, #6b7280 0%, #9ca3af 100%);
        }

        .stat-card.stat-primary::before {
            background: linear-gradient(180deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .stat-card.stat-info::before {
            background: linear-gradient(180deg, #0c4a6e 0%, #0ea5e9 100%);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            flex-shrink: 0;
        }

        .stat-success .stat-icon {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .stat-secondary .stat-icon {
            background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);
        }

        .stat-primary .stat-icon {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .stat-info .stat-icon {
            background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 100%);
        }

        .stat-details {
            flex: 1;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            line-height: 1;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }

        .stat-badge {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #6b7280;
        }

        /* Card Header Modern */
        .card-header-modern {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px;
            border-bottom: 2px solid #f3f4f6;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-left .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-left .card-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
        }

        .header-right {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .filter-group .form-select-sm {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 35px 8px 12px;
            font-size: 13px;
            font-weight: 500;
            min-width: 180px;
        }

        /* Table Modern */
        .table-modern {
            margin: 0;
        }

        .table-modern thead th {
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px;
            border: none;
            white-space: nowrap;
        }

        .table-modern thead th i {
            margin-right: 6px;
            color: #6b7280;
        }

        .table-modern tbody td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }

        .table-modern tbody tr {
            transition: background 0.2s ease;
        }

        .table-modern tbody tr:hover {
            background: #f9fafb;
        }

        /* Ranking Display */
        .ranking-wrapper {
            display: flex;
            justify-content: center;
        }

        .medal-badge {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-weight: 700;
            font-size: 16px;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .medal-1 {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }

        .medal-2 {
            background: linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);
        }

        .medal-3 {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .medal-badge i {
            font-size: 20px;
        }

        .ranking-number {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: #374151;
        }

        /* NIS Badge */
        .nis-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            font-family: 'Courier New', monospace;
        }

        /* Student Info */
        .student-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-avatar {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: white;
            flex-shrink: 0;
        }

        .student-details {
            flex: 1;
        }

        .student-name {
            font-weight: 600;
            font-size: 14px;
            color: #111827;
            margin-bottom: 2px;
        }

        .student-meta {
            font-size: 12px;
            color: #6b7280;
        }

        .student-meta i {
            margin-right: 4px;
        }

        /* Badge Kelas */
        .badge-kelas {
            display: inline-block;
            background: #e0e7ff;
            color: #3730a3;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        /* Score Display */
        .score-display {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .score-value {
            font-size: 16px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .score-progress {
            width: 100%;
        }

        .score-progress .progress {
            background: #e5e7eb;
            border-radius: 10px;
        }

        .score-progress .progress-bar {
            border-radius: 10px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
        }

        .status-lulus {
            background: #d1fae5;
            color: #065f46;
        }

        .status-tidak-lulus {
            background: #e5e7eb;
            color: #4b5563;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-action-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-action-info:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 64px;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-state h6 {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 24px;
        }

        /* Pagination Wrapper */
        .pagination-wrapper {
            padding: 20px 24px;
            border-top: 2px solid #f3f4f6;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-header-modern {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-right {
                width: 100%;
            }

            .filter-group .form-select-sm {
                width: 100%;
            }

            .student-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>

    <script>
        // Filter table by status
        function filterTable() {
            const filterValue = document.getElementById('filterStatus').value;
            const rows = document.querySelectorAll('.table-row');

            rows.forEach(row => {
                const status = row.getAttribute('data-status');

                if (filterValue === 'all') {
                    row.style.display = '';
                } else {
                    if (status === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
