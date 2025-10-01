@extends('layouts.admin')

@section('title', 'Detail Hasil')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Detail Hasil Seleksi</h1>
                <p class="page-subtitle">Informasi lengkap hasil penilaian siswa</p>
            </div>
            <a href="{{ route('admin.hasil.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="content-card">
                <div class="text-center mb-4">
                    <div class="student-avatar">
                        {{ strtoupper(substr($hasil->siswa->nama_lengkap, 0, 2)) }}
                    </div>
                    <h5 class="mt-3 mb-2">{{ $hasil->siswa->nama_lengkap }}</h5>
                    <p class="text-muted mb-0">{{ $hasil->siswa->nis }}</p>
                    <span class="badge bg-info mt-2">{{ $hasil->siswa->kelas }}</span>
                </div>

                <div class="result-summary">
                    <div class="result-item">
                        <div class="result-label">Ranking</div>
                        <div class="result-value ranking-{{ $hasil->ranking }}">
                            {{ $hasil->ranking }}
                        </div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">Skor Akhir</div>
                        <div class="result-value">{{ number_format($hasil->skor_akhir, 6) }}</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">Status</div>
                        <div class="result-value">
                            @if ($hasil->status_kelulusan == 'lulus')
                                <span class="badge bg-success">Lulus</span>
                            @else
                                <span class="badge bg-secondary">Tidak Lulus</span>
                            @endif
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.hasil.update-status', $hasil->id) }}" method="POST" class="mt-4">
                    @csrf
                    <label class="form-label">Ubah Status Kelulusan</label>
                    <select class="form-select mb-2" name="status_kelulusan" required>
                        <option value="lulus" {{ $hasil->status_kelulusan == 'lulus' ? 'selected' : '' }}>Lulus</option>
                        <option value="tidak_lulus" {{ $hasil->status_kelulusan == 'tidak_lulus' ? 'selected' : '' }}>Tidak
                            Lulus</option>
                    </select>
                    <textarea class="form-control mb-2" name="catatan" rows="3" placeholder="Catatan (opsional)">{{ $hasil->catatan }}</textarea>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-chart-line text-primary"></i> Detail Penilaian Kriteria
                </h5>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria</th>
                                <th width="100">Bobot</th>
                                <th>Sub-Kriteria</th>
                                <th width="100">Nilai Sub</th>
                                <th width="120">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penilaian as $p)
                                <tr>
                                    <td><strong>{{ $p->kriteria->nama_kriteria }}</strong></td>
                                    <td class="text-center">{{ number_format($p->kriteria->bobot, 4) }}</td>
                                    <td>{{ $p->subKriteria->nama_sub_kriteria }}</td>
                                    <td class="text-center">{{ number_format($p->subKriteria->nilai_sub, 4) }}</td>
                                    <td class="text-center">
                                        <strong>{{ number_format($p->kriteria->bobot * $p->subKriteria->nilai_sub, 4) }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="table-primary">
                                <td colspan="4" class="text-end"><strong>TOTAL SKOR AKHIR:</strong></td>
                                <td class="text-center">
                                    <strong style="font-size: 16px;">{{ number_format($hasil->skor_akhir, 4) }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card mt-4">
                <h5 class="card-title mb-4">
                    <i class="fas fa-user text-primary"></i> Data Siswa
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">NIS</span>
                            <span class="detail-value">{{ $hasil->siswa->nis }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Nama</span>
                            <span class="detail-value">{{ $hasil->siswa->nama_lengkap }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Kelas</span>
                            <span class="detail-value">{{ $hasil->siswa->kelas }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Tempat, Tanggal Lahir</span>
                            <span class="detail-value">{{ $hasil->siswa->tempat_lahir }},
                                {{ $hasil->siswa->tanggal_lahir->format('d F Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">No. Telepon</span>
                            <span class="detail-value">{{ $hasil->siswa->no_telp }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tanggal Perhitungan</span>
                            <span class="detail-value">{{ $hasil->tanggal_perhitungan->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .student-avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            font-weight: 700;
        }

        .result-summary {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
        }

        .result-item {
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .result-value {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
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
            min-width: 180px;
            font-weight: 500;
        }

        .detail-value {
            font-size: 14px;
            color: #111827;
            flex: 1;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
@endsection
