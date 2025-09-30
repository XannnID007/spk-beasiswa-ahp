@extends('layouts.admin')

@section('title', 'Data Kriteria')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Data Kriteria Penilaian</h1>
                <p class="page-subtitle">4 Kriteria metode AHP</p>
            </div>
            <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kriteria
            </a>
        </div>
    </div>

    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        Kriteria dan bobot sudah ditetapkan sesuai perhitungan AHP. Data ini tidak disarankan untuk
        diubah.
    </div>

    <div class="content-card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="80">Kode</th>
                        <th>Nama Kriteria</th>
                        <th width="120">Bobot</th>
                        <th width="120">Persentase</th>
                        <th width="150">Sub-Kriteria</th>
                        <th>Keterangan</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kriteria as $k)
                        <tr>
                            <td><strong class="text-primary">{{ $k->kode_kriteria }}</strong></td>
                            <td><strong>{{ $k->nama_kriteria }}</strong></td>
                            <td class="text-center"><span class="badge bg-primary">{{ number_format($k->bobot, 4) }}</span>
                            </td>
                            <td class="text-center"><strong>{{ number_format($k->bobot * 100, 2) }}%</strong></td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $k->sub_kriteria_count }} items</span>
                            </td>
                            <td>{{ $k->keterangan }}</td>
                            <td>
                                <a href="{{ route('admin.kriteria.edit', $k->id) }}" class="btn btn-sm btn-warning"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.kriteria.destroy', $k->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus kriteria ini? Ini akan mempengaruhi perhitungan AHP!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="content-card mt-4">
        <h5 class="card-title mb-4">
            <i class="fas fa-chart-pie text-primary"></i> Distribusi Bobot Kriteria
        </h5>

        <div class="row">
            @foreach ($kriteria as $k)
                <div class="col-md-6 mb-3">
                    <div class="progress-box">
                        <div class="progress-header">
                            <span class="progress-label">{{ $k->kode_kriteria }}: {{ $k->nama_kriteria }}</span>
                            <span class="progress-value">{{ number_format($k->bobot * 100, 2) }}%</span>
                        </div>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $k->bobot * 100 }}%"
                                aria-valuenow="{{ $k->bobot * 100 }}" aria-valuemin="0" aria-valuemax="100">
                                <strong>{{ number_format($k->bobot, 4) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
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

        .btn-sm {
            padding: 6px 10px;
            font-size: 13px;
        }

        .progress-box {
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .progress-label {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .progress-value {
            font-size: 14px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .progress-bar {
            font-size: 13px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }
    </style>
@endsection
