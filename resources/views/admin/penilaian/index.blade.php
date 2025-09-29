@extends('layouts.admin')

@section('title', 'Penilaian Siswa')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Penilaian Siswa</h1>
                <p class="page-subtitle">Input nilai siswa untuk setiap kriteria penilaian</p>
            </div>
            <a href="{{ route('admin.penilaian.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Penilaian
            </a>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header-custom">
            <h5 class="card-title mb-0">
                <i class="fas fa-clipboard-list text-primary"></i> Daftar Siswa Terverifikasi
            </h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="100">NIS</th>
                        <th>Nama Siswa</th>
                        <th width="80">Kelas</th>
                        <th width="150">Status Penilaian</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $s->nis }}</strong></td>
                            <td>{{ $s->nama_lengkap }}</td>
                            <td class="text-center"><span class="badge bg-info">{{ $s->kelas }}</span></td>
                            <td class="text-center">
                                @if ($s->penilaian_count == 4)
                                    <span class="badge bg-success">Lengkap (4/4)</span>
                                @elseif($s->penilaian_count > 0)
                                    <span class="badge bg-warning">Belum Lengkap ({{ $s->penilaian_count }}/4)</span>
                                @else
                                    <span class="badge bg-secondary">Belum Dinilai</span>
                                @endif
                            </td>
                            <td>
                                @if ($s->penilaian_count > 0)
                                    <a href="{{ route('admin.penilaian.edit', $s->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.penilaian.destroy', $s->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus penilaian siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada siswa yang diverifikasi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
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

        .btn-sm {
            padding: 6px 10px;
            font-size: 13px;
        }
    </style>
@endsection
