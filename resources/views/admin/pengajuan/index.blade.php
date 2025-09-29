@extends('layouts.admin')

@section('title', 'Pengajuan Beasiswa')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Pengajuan Beasiswa</h1>
        <p class="page-subtitle">Verifikasi pengajuan beasiswa dari siswa</p>
    </div>

    <div class="content-card">
        <div class="card-header-custom">
            <h5 class="card-title mb-3">
                <i class="fas fa-file-alt text-primary"></i> Daftar Pengajuan
            </h5>

            <div class="filter-tabs">
                <a href="{{ route('admin.pengajuan.index', ['status' => 'all']) }}"
                    class="filter-tab {{ $status == 'all' ? 'active' : '' }}">
                    Semua
                </a>
                <a href="{{ route('admin.pengajuan.index', ['status' => 'pending']) }}"
                    class="filter-tab {{ $status == 'pending' ? 'active' : '' }}">
                    Pending
                </a>
                <a href="{{ route('admin.pengajuan.index', ['status' => 'diverifikasi']) }}"
                    class="filter-tab {{ $status == 'diverifikasi' ? 'active' : '' }}">
                    Diverifikasi
                </a>
                <a href="{{ route('admin.pengajuan.index', ['status' => 'ditolak']) }}"
                    class="filter-tab {{ $status == 'ditolak' ? 'active' : '' }}">
                    Ditolak
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="100">NIS</th>
                        <th>Nama Siswa</th>
                        <th width="80">Kelas</th>
                        <th width="150">Tanggal Pengajuan</th>
                        <th width="120">Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $index => $p)
                        <tr>
                            <td>{{ $pengajuan->firstItem() + $index }}</td>
                            <td><strong>{{ $p->siswa->nis }}</strong></td>
                            <td>{{ $p->siswa->nama_lengkap }}</td>
                            <td class="text-center"><span class="badge bg-info">{{ $p->siswa->kelas }}</span></td>
                            <td>{{ $p->tanggal_pengajuan->format('d M Y') }}</td>
                            <td>
                                @if ($p->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($p->status == 'diverifikasi')
                                    <span class="badge bg-success">Diverifikasi</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pengajuan.show', $p->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>

                                @if ($p->status == 'pending')
                                    <form action="{{ route('admin.pengajuan.verifikasi', $p->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success"
                                            onclick="return confirm('Verifikasi pengajuan ini?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.pengajuan.tolak', $p->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Tolak pengajuan ini?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada pengajuan beasiswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $pengajuan->links() }}
        </div>
    </div>

    <style>
        .filter-tabs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            color: #6b7280;
            background: #f3f4f6;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .filter-tab:hover {
            background: #e5e7eb;
            color: #374151;
        }

        .filter-tab.active {
            background: #1e3a8a;
            color: white;
        }

        .card-header-custom {
            padding: 20px 25px;
            border-bottom: 2px solid #e5e7eb;
        }
    </style>
@endsection
