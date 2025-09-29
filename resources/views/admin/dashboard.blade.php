@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Sistem Pendukung Keputusan Calon Penerima Beasiswa</p>
    </div>

    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalSiswa }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-success">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $pengajuanPending }}</div>
                    <div class="stat-label">Pengajuan Pending</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-warning">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $pengajuanDiverifikasi }}</div>
                    <div class="stat-label">Sudah Diverifikasi</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-info">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalLulus }}</div>
                    <div class="stat-label">Penerima Beasiswa</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-chart-bar text-primary"></i> Grafik Pengajuan Beasiswa
                </h5>
                <canvas id="pengajuanChart" height="100"></canvas>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-chart-pie text-primary"></i> Status Pengajuan
                </h5>
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-clock text-primary"></i> Pengajuan Terbaru
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanTerbaru as $pengajuan)
                                <tr>
                                    <td>{{ $pengajuan->siswa->nis }}</td>
                                    <td>{{ $pengajuan->siswa->nama_lengkap }}</td>
                                    <td>{{ $pengajuan->siswa->kelas }}</td>
                                    <td>{{ $pengajuan->tanggal_pengajuan->format('d M Y') }}</td>
                                    <td>
                                        @if ($pengajuan->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($pengajuan->status == 'diverifikasi')
                                            <span class="badge bg-success">Diverifikasi</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada pengajuan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
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
            transition: transform 0.3s ease;
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
            color: white;
        }

        .bg-primary .stat-icon {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .bg-success .stat-icon {
            background: linear-gradient(135deg, #065f46 0%, #10b981 100%);
        }

        .bg-warning .stat-icon {
            background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        }

        .bg-info .stat-icon {
            background: linear-gradient(135deg, #0c4a6e 0%, #06b6d4 100%);
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

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 20px;
        }

        .table {
            font-size: 14px;
        }

        .table thead th {
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            border: none;
            padding: 12px;
        }

        .table tbody td {
            padding: 12px;
            vertical-align: middle;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Chart Pengajuan Beasiswa
            const pengajuanCtx = document.getElementById('pengajuanChart').getContext('2d');
            new Chart(pengajuanCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ago', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Pengajuan Beasiswa',
                        data: @json($chartData),
                        backgroundColor: '#3b82f6',
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Chart Status
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Diverifikasi', 'Ditolak'],
                    datasets: [{
                        data: [{{ $pengajuanPending }}, {{ $pengajuanDiverifikasi }},
                            {{ $pengajuanDitolak }}],
                        backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
