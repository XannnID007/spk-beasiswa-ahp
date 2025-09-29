@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Data Siswa</h1>
                <p class="page-subtitle">Kelola data siswa calon penerima beasiswa</p>
            </div>
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Siswa
            </a>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header-custom">
            <h5 class="card-title mb-0">
                <i class="fas fa-users text-primary"></i> Daftar Siswa
            </h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="100">NIS</th>
                        <th>Nama Lengkap</th>
                        <th width="80">Kelas</th>
                        <th width="120">Jenis Kelamin</th>
                        <th width="150">No. Telepon</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                        <tr>
                            <td>{{ $siswa->firstItem() + $index }}</td>
                            <td><strong>{{ $s->nis }}</strong></td>
                            <td>{{ $s->nama_lengkap }}</td>
                            <td class="text-center"><span class="badge bg-info">{{ $s->kelas }}</span></td>
                            <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $s->no_telp }}</td>
                            <td>
                                <a href="{{ route('admin.siswa.show', $s->id) }}" class="btn btn-sm btn-info"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-sm btn-warning"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data siswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $siswa->links() }}
        </div>
    </div>

    <style>
        .card-header-custom {
            padding: 20px 25px;
            border-bottom: 2px solid #e5e7eb;
        }

        .table {
            font-size: 14px;
            margin-bottom: 0;
        }

        .table thead th {
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            border: none;
            padding: 12px 15px;
            vertical-align: middle;
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f9fafb;
        }

        .btn-sm {
            padding: 6px 10px;
            font-size: 13px;
        }
    </style>
@endsection
