@extends('layouts.admin')

@section('title', 'Data Beasiswa')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Data Beasiswa</h1>
                <p class="page-subtitle">Kelola program beasiswa yang tersedia</p>
            </div>
            <a href="{{ route('admin.beasiswa.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Beasiswa
            </a>
        </div>
    </div>

    <div class="content-card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Beasiswa</th>
                        <th width="120">Jenis</th>
                        <th width="80">Kuota</th>
                        <th width="150">Periode</th>
                        <th width="120">Tahun Ajaran</th>
                        <th width="100">Status</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beasiswa as $index => $b)
                        <tr>
                            <td>{{ $beasiswa->firstItem() + $index }}</td>
                            <td><strong>{{ $b->nama_beasiswa }}</strong></td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($b->jenis_beasiswa) }}</span>
                            </td>
                            <td class="text-center">{{ $b->kuota }}</td>
                            <td>{{ $b->tanggal_buka->format('d/m/Y') }} - {{ $b->tanggal_tutup->format('d/m/Y') }}</td>
                            <td class="text-center">{{ $b->tahun_ajaran }}</td>
                            <td>
                                @if ($b->isAktif())
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.beasiswa.show', $b->id) }}" class="btn btn-sm btn-info"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.beasiswa.edit', $b->id) }}" class="btn btn-sm btn-warning"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.beasiswa.destroy', $b->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus beasiswa ini?')">
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
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data beasiswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $beasiswa->links() }}
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
    </style>
@endsection
