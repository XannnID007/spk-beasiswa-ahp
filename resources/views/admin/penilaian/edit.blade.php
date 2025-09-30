@extends('layouts.admin')

@section('title', 'Edit Penilaian')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Penilaian Siswa</h1>
        <p class="page-subtitle">Perbarui nilai siswa untuk setiap kriteria penilaian</p>
    </div>

    <div class="content-card">
        <form action="{{ route('admin.penilaian.update', $siswa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="section-header">
                <i class="fas fa-user"></i> Data Siswa
            </div>

            <div class="student-info">
                <div class="info-item">
                    <span class="label">NIS:</span>
                    <span class="value">{{ $siswa->nis }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Nama:</span>
                    <span class="value">{{ $siswa->nama_lengkap }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Kelas:</span>
                    <span class="value">{{ $siswa->kelas }}</span>
                </div>
            </div>

            <div class="section-header">
                <i class="fas fa-clipboard-list"></i> Input Nilai Kriteria
            </div>

            @php
                $nilaiRaport = $penilaian->where('kriteria.kode_kriteria', 'K1')->first()?->nilai ?? 0;
                $jumlahTanggungan = $penilaian->where('kriteria.kode_kriteria', 'K2')->first()?->nilai ?? 0;
                $penghasilanOrtu = $penilaian->where('kriteria.kode_kriteria', 'K3')->first()?->nilai ?? 0;
                $jumlahKeaktifan = $penilaian->where('kriteria.kode_kriteria', 'K4')->first()?->nilai ?? 0;
            @endphp

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">K1: Nilai Rata-rata Raport <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('nilai_raport') is-invalid @enderror"
                        name="nilai_raport" step="0.01" min="0" max="100"
                        value="{{ old('nilai_raport', $nilaiRaport) }}" required>
                    @error('nilai_raport')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        • ≥91 = Sangat Penting<br>
                        • 83-90 = Penting<br>
                        • 75-82 = Cukup Penting<br>
                        • <75=Sama Penting </small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">K2: Jumlah Tanggungan Keluarga <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('jumlah_tanggungan') is-invalid @enderror"
                        name="jumlah_tanggungan" min="1" value="{{ old('jumlah_tanggungan', $jumlahTanggungan) }}"
                        required>
                    @error('jumlah_tanggungan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        • ≥5 = Sangat Penting<br>
                        • 4 = Penting<br>
                        • 3 = Cukup Penting<br>
                        • ≤2 = Sama Penting
                    </small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">K3: Penghasilan Orang Tua per Bulan <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('penghasilan_ortu') is-invalid @enderror"
                        name="penghasilan_ortu" min="0" value="{{ old('penghasilan_ortu', $penghasilanOrtu) }}"
                        required>
                    @error('penghasilan_ortu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        • <Rp 1.000.000=Sangat Penting<br>
                            • Rp 1-2 Juta = Penting<br>
                            • Rp 2-3 Juta = Cukup Penting<br>
                            • >Rp 3 Juta = Sama Penting
                    </small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">K4: Keaktifan Siswa (Organisasi + Ekskul) <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('jumlah_keaktifan') is-invalid @enderror"
                        name="jumlah_keaktifan" min="1" value="{{ old('jumlah_keaktifan', $jumlahKeaktifan) }}"
                        required>
                    @error('jumlah_keaktifan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        • ≥4 (IPM + 3 Ekskul) = Sangat Penting<br>
                        • 3 (IPM + 2 Ekskul) = Penting<br>
                        • 2 (IPM + 1 Ekskul) = Cukup Penting<br>
                        • 1 (Hanya IPM) = Sama Penting
                    </small>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Penilaian
                </button>
                <a href="{{ route('admin.penilaian.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <style>
        .section-header {
            background: #f9fafb;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            color: #1e3a8a;
            margin: 25px 0 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .student-info {
            background: #dbeafe;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            gap: 30px;
        }

        .info-item {
            display: flex;
            gap: 8px;
        }

        .info-item .label {
            font-weight: 600;
            color: #1e3a8a;
        }

        .info-item .value {
            color: #111827;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        small.text-muted {
            display: block;
            margin-top: 5px;
            line-height: 1.6;
        }
    </style>
@endsection
