@extends('layouts.admin')

@section('title', 'Edit Sub-Kriteria')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Sub-Kriteria</h1>
        <p class="page-subtitle">Perbarui informasi sub-kriteria</p>
    </div>

    <div class="content-card">
        <form action="{{ route('admin.sub-kriteria.update', $subKriteria->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Kriteria <span class="text-danger">*</span></label>
                <select class="form-select @error('kriteria_id') is-invalid @enderror" name="kriteria_id" required>
                    <option value="">-- Pilih Kriteria --</option>
                    @foreach ($kriteria as $k)
                        <option value="{{ $k->id }}"
                            {{ old('kriteria_id', $subKriteria->kriteria_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->kode_kriteria }} - {{ $k->nama_kriteria }}
                        </option>
                    @endforeach
                </select>
                @error('kriteria_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Sub-Kriteria <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_sub_kriteria') is-invalid @enderror"
                    name="nama_sub_kriteria" value="{{ old('nama_sub_kriteria', $subKriteria->nama_sub_kriteria) }}"
                    required>
                @error('nama_sub_kriteria')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nilai Sub-Kriteria <span class="text-danger">*</span></label>
                <input type="number" step="0.000001" class="form-control @error('nilai_sub') is-invalid @enderror"
                    name="nilai_sub" value="{{ old('nilai_sub', $subKriteria->nilai_sub) }}" required>
                @error('nilai_sub')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Nilai prioritas sub-kriteria (6 desimal)</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Range Minimum</label>
                    <input type="number" step="0.01" class="form-control @error('range_min') is-invalid @enderror"
                        name="range_min" value="{{ old('range_min', $subKriteria->range_min) }}">
                    @error('range_min')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Range Maksimum</label>
                    <input type="number" step="0.01" class="form-control @error('range_max') is-invalid @enderror"
                        name="range_max" value="{{ old('range_max', $subKriteria->range_max) }}">
                    @error('range_max')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori"
                    value="{{ old('kategori', $subKriteria->kategori) }}">
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.sub-kriteria.index') }}" class="btn btn-secondary">
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
