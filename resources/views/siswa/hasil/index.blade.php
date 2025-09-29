@extends('layouts.siswa')

@section('title', 'Hasil Seleksi')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Hasil Seleksi Beasiswa</h1>
        <p class="page-subtitle">Lihat hasil perhitungan dan ranking Anda</p>
    </div>

    @if ($hasil)
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="content-card">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-trophy text-primary"></i> Hasil Penilaian
                    </h5>

                    <div class="result-banner {{ $hasil->status_kelulusan == 'lulus' ? 'bg-success' : 'bg-secondary' }}">
                        <div class="result-icon">
                            <i
                                class="fas {{ $hasil->status_kelulusan == 'lulus' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                        </div>
                        <div class="result-content">
                            <h3>{{ $hasil->status_kelulusan == 'lulus' ? 'Selamat! Anda Dinyatakan LULUS' : 'Mohon Maaf, Anda Tidak Lulus' }}
                            </h3>
                            <p>Seleksi Penerima Beasiswa MA Muhammadiyah 1 Bandung</p>
                        </div>
                    </div>

                    <div class="result-details">
                        <div class="detail-row">
                            <span class="detail-label">Ranking</span>
                            <span class="detail-value"><strong>{{ $hasil->ranking }}</strong> dari
                                {{ \App\Models\HasilPerhitungan::count() }} peserta</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Skor Akhir</span>
                            <span class="detail-value"><strong>{{ number_format($hasil->skor_akhir, 6) }}</strong></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tanggal Perhitungan</span>
                            <span class="detail-value">{{ $hasil->tanggal_perhitungan->format('d F Y') }}</span>
                        </div>
                    </div>

                    <h6 class="section-subtitle">Detail Penilaian Kriteria</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Kriteria</th>
                                    <th width="120">Bobot</th>
                                    <th>Sub-Kriteria</th>
                                    <th width="120">Nilai Sub</th>
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
                                            <strong>{{ number_format($p->kriteria->bobot * $p->subKriteria->nilai_sub, 6) }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-primary">
                                    <td colspan="4" class="text-end"><strong>TOTAL SKOR AKHIR:</strong></td>
                                    <td class="text-center"><strong
                                            style="font-size: 16px;">{{ number_format($hasil->skor_akhir, 6) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if ($hasil->catatan)
                        <div class="alert alert-info mt-3">
                            <strong>Catatan:</strong> {{ $hasil->catatan }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="content-card">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-download text-primary"></i> Cetak Hasil
                    </h5>

                    <div class="text-center py-3">
                        <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                        <p class="text-muted mb-3">Unduh hasil seleksi dalam format PDF</p>
                        <a href="{{ route('siswa.hasil.cetak-pdf') }}" class="btn btn-danger w-100" target="_blank">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </a>
                    </div>
                </div>

                @if ($hasil->status_kelulusan == 'lulus')
                    <div class="content-card mt-3">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-bell text-primary"></i> Informasi
                        </h5>
                        <div class="info-box">
                            <p><i class="fas fa-check-circle text-success"></i> Selamat! Anda dinyatakan lulus seleksi
                                beasiswa.</p>
                            <p><i class="fas fa-exclamation-circle text-warning"></i> Harap melengkapi berkas administrasi
                                ke bagian kesiswaan dalam 7 hari.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="content-card text-center py-5">
            <i class="fas fa-hourglass-half fa-4x text-muted mb-3"></i>
            <h5>Hasil Seleksi Belum Tersedia</h5>
            <p class="text-muted">Proses perhitungan seleksi beasiswa masih berlangsung. Silakan cek kembali nanti.</p>
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-primary mt-3">
                <i class="fas fa-home"></i> Kembali ke Dashboard
            </a>
        </div>
    @endif

    <style>
        .result-banner {
            padding: 30px;
            border-radius: 12px;
            color: white;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .result-icon {
            font-size: 60px;
        }

        .result-content h3 {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .result-content p {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .result-details {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 14px;
            color: #6b7280;
        }

        .detail-value {
            font-size: 14px;
            color: #111827;
        }

        .section-subtitle {
            font-size: 15px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 15px;
        }

        .table {
            font-size: 13px;
        }

        .table th {
            font-weight: 600;
            font-size: 12px;
        }

        .info-box p {
            font-size: 13px;
            padding: 10px;
            background: #f9fafb;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .info-box p:last-child {
            margin-bottom: 0;
        }
    </style>
@endsection
