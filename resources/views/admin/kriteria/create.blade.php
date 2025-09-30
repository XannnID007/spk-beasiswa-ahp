@extends('layouts.admin')

@section('title', 'Tambah Kriteria')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Tambah Kriteria Penilaian</h1>
        <p class="page-subtitle">Input kriteria baru untuk penilaian beasiswa</p>
    </div>

    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Perhatian:</strong> Kriteria telah ditetapkan sesuai metode AHP pada BAB III. Penambahan kriteria baru tidak
        disarankan.
    </div>

    <div class="content-card">
        <form action="{{ route('admin.kriteria.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kode Kriteria <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('kode_kriteria') is-invalid @enderror" name="kode_kriteria"
                    value="{{ old('kode_kriteria') }}" placeholder="Contoh: K5" required>
                @error('kode_kriteria')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Format: K diikuti nomor urut</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Kriteria <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror" name="nama_kriteria"
                    value="{{ old('nama_kriteria') }}" placeholder="Contoh: Prestasi Non-Akademik" required>
                @error('nama_kriteria')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Bobot <span class="text-danger">*</span></label>
                <input type="number" step="0.0001" class="form-control @error('bobot') is-invalid @enderror"
                    name="bobot" value="{{ old('bobot') }}" placeholder="0.0000 - 1.0000" min="0" max="1"
                    required>
                @error('bobot')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Nilai bobot antara 0 dan 1 (desimal)</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="3"
                    placeholder="Deskripsi kriteria">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                Total bobot semua kriteria harus = 1.0000
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <style>
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
    </style>
@endsection
