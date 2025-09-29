@extends('layouts.admin')

@section('title', 'Edit Beasiswa')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Data Beasiswa</h1>
        <p class="page-subtitle">Perbarui informasi beasiswa</p>
    </div>

    <div class="content-card">
        <form action="{{ route('admin.beasiswa.update', $beasiswa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Beasiswa <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_beasiswa') is-invalid @enderror"
                        name="nama_beasiswa" value="{{ old('nama_beasiswa', $beasiswa->nama_beasiswa) }}"
                        placeholder="Contoh: Beasiswa Prestasi 2025" required>
                    @error('nama_beasiswa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Beasiswa <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_beasiswa') is-invalid @enderror" name="jenis_beasiswa"
                        required>
                        <option value="">Pilih Jenis</option>
                        <option value="prestasi"
                            {{ old('jenis_beasiswa', $beasiswa->jenis_beasiswa) == 'prestasi' ? 'selected' : '' }}>Prestasi
                        </option>
                        <option value="tidak mampu"
                            {{ old('jenis_beasiswa', $beasiswa->jenis_beasiswa) == 'tidak mampu' ? 'selected' : '' }}>Tidak
                            Mampu</option>
                        <option value="full"
                            {{ old('jenis_beasiswa', $beasiswa->jenis_beasiswa) == 'full' ? 'selected' : '' }}>Full/Penuh
                        </option>
                    </select>
                    @error('jenis_beasiswa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="3"
                        placeholder="Deskripsi singkat tentang beasiswa ini">{{ old('deskripsi', $beasiswa->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kuota Penerima <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('kuota') is-invalid @enderror" name="kuota"
                        value="{{ old('kuota', $beasiswa->kuota) }}" min="1" required>
                    @error('kuota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nominal Beasiswa</label>
                    <input type="number" class="form-control @error('nominal') is-invalid @enderror" name="nominal"
                        value="{{ old('nominal', $beasiswa->nominal) }}" min="0"
                        placeholder="Opsional, nominal dalam Rupiah">
                    @error('nominal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Buka Pendaftaran <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_buka') is-invalid @enderror"
                        name="tanggal_buka" value="{{ old('tanggal_buka', $beasiswa->tanggal_buka->format('Y-m-d')) }}"
                        required>
                    @error('tanggal_buka')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Tutup Pendaftaran <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_tutup') is-invalid @enderror"
                        name="tanggal_tutup" value="{{ old('tanggal_tutup', $beasiswa->tanggal_tutup->format('Y-m-d')) }}"
                        required>
                    @error('tanggal_tutup')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror"
                        name="tahun_ajaran" value="{{ old('tahun_ajaran', $beasiswa->tahun_ajaran) }}"
                        placeholder="2025/2026" required>
                    @error('tahun_ajaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                        <option value="aktif" {{ old('status', $beasiswa->status) == 'aktif' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="nonaktif" {{ old('status', $beasiswa->status) == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.beasiswa.index') }}" class="btn btn-secondary">
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
