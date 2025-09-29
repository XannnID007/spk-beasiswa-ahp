@extends('layouts.admin')

@section('title', 'Detail Beasiswa')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Detail Beasiswa</h1>
                <p class="page-subtitle">Informasi lengkap program beasiswa</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.beasiswa.edit', $beasiswa->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="content-card">
                <div class="text-center mb-4">
                    <div class="beasiswa-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h4 class="mt-3 mb-2">{{ $beasiswa->nama_beasiswa }}</h4>
                    @if ($beasiswa->isAktif())
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </div>

                <div class="info-group">
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-tag"></i> Jenis</span>
                        <span class="info-value">{{ ucfirst($beasiswa->jenis_beasiswa) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-users"></i> Kuota</span>
                        <span class="info-value">{{ $beasiswa->kuota }} Siswa</span>
                    </div>
                    @if ($beasiswa->nominal)
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-money-bill"></i> Nominal</span>
                            <span class="info-value">Rp {{ number_format($beasiswa->nominal, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-calendar"></i> Tahun Ajaran</span>
                        <span class="info-value">{{ $beasiswa->tahun_ajaran }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-info-circle text-primary"></i> Informasi Beasiswa
                </h5>

                <div class="detail-section">
                    <div class="detail-row">
                        <span class="detail-label">Nama Beasiswa</span>
                        <span class="detail-value">{{ $beasiswa->nama_beasiswa }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jenis Beasiswa</span>
                        <span class="detail-value">
                            <span class="badge bg-info">{{ ucfirst($beasiswa->jenis_beasiswa) }}</span>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Deskripsi</span>
                        <span class="detail-value">{{ $beasiswa->deskripsi ?? '-' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Periode Pendaftaran</span>
                        <span class="detail-value">
                            {{ $beasiswa->tanggal_buka->format('d F Y') }} -
                            {{ $beasiswa->tanggal_tutup->format('d F Y') }}
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="detail-value">
                            @if ($beasiswa->isAktif())
                                <span class="badge bg-success">Sedang Aktif</span>
                            @elseif($beasiswa->tanggal_buka > now())
                                <span class="badge bg-warning">Belum Dibuka</span>
                            @else
                                <span class="badge bg-secondary">Sudah Ditutup</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="content-card mt-4">
                <h5 class="card-title mb-4">
                    <i class="fas fa-file-alt text-primary"></i> Daftar Pengajuan ({{ $beasiswa->pengajuan->count() }})
                </h5>

                @if ($beasiswa->pengajuan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($beasiswa->pengajuan as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->siswa->nis }}</td>
                                        <td>{{ $p->siswa->nama_lengkap }}</td>
                                        <td>{{ $p->siswa->kelas }}</td>
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
                                            <a href="{{ route('admin.pengajuan.show', $p->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada pengajuan untuk beasiswa ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .beasiswa-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
        }

        .info-group {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 14px;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-value {
            font-size: 14px;
            color: #111827;
            font-weight: 600;
        }

        .detail-section {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
        }

        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 14px;
            color: #6b7280;
            min-width: 200px;
            font-weight: 500;
        }

        .detail-value {
            font-size: 14px;
            color: #111827;
            flex: 1;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }

        .table {
            font-size: 13px;
        }

        .table thead th {
            background: #f9fafb;
            font-weight: 600;
            font-size: 12px;
        }
    </style>
@endsection
