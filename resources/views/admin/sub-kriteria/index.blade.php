@php
    use App\Helpers\NumberHelper;
@endphp

@extends('layouts.admin')

@section('title', 'Data Sub-Kriteria')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Data Sub-Kriteria</h1>
                <p class="page-subtitle">Kelola sub-kriteria untuk setiap kriteria penilaian</p>
            </div>
            <a href="{{ route('admin.sub-kriteria.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Sub-Kriteria
            </a>
        </div>
    </div>

    <div class="content-card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="100">Kriteria</th>
                        <th>Nama Sub-Kriteria</th>
                        <th width="120">Nilai Sub</th>
                        <th width="150">Range</th>
                        <th>Kategori</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($subKriteria->groupBy('kriteria_id') as $kriteriaId => $items)
                        @foreach ($items as $index => $sk)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><strong class="text-primary">{{ $sk->kriteria->kode_kriteria }}</strong></td>
                                <td>{{ $sk->nama_sub_kriteria }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge bg-success">{{ NumberHelper::formatSubCriteria($sk->nilai_sub) }}</span>
                                </td>
                                <td class="text-center">
                                    @if ($sk->range_min !== null && $sk->range_max !== null)
                                        {{ number_format($sk->range_min, 0) }} - {{ number_format($sk->range_max, 0) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $sk->kategori ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.sub-kriteria.edit', $sk->id) }}" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.sub-kriteria.destroy', $sk->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus sub-kriteria ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if (!$loop->last)
                            <tr class="table-light">
                                <td colspan="7"></td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data sub-kriteria</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

        .table-light td {
            padding: 5px !important;
            background: #f3f4f6 !important;
        }

        .btn-sm {
            padding: 6px 10px;
            font-size: 13px;
        }
    </style>
@endsection
