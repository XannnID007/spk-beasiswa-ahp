@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Tambah Data Siswa</h1>
        <p class="page-subtitle">Input data siswa baru</p>
    </div>

    <div class="content-card">
        <form action="{{ route('admin.siswa.store') }}" method="POST">
            @csrf

            <div class="section-header">Akun Login</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="section-header">Data Pribadi</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIS <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nis') is-invalid @enderror" name="nis"
                        value="{{ old('nis') }}" required>
                    @error('nis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                        name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required>
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Kelas <span class="text-danger">*</span></label>
                    <select class="form-select @error('kelas') is-invalid @enderror" name="kelas" required>
                        <option value="">Pilih Kelas</option>
                        <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                        name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp"
                        value="{{ old('no_telp') }}" required>
                    @error('no_telp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="2" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="section-header">Data Orang Tua</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Ayah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" name="nama_ayah"
                        value="{{ old('nama_ayah') }}" required>
                    @error('nama_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" name="nama_ibu"
                        value="{{ old('nama_ibu') }}" required>
                    @error('nama_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Pekerjaan Ayah</label>
                    <input type="text" class="form-control" name="pekerjaan_ayah"
                        value="{{ old('pekerjaan_ayah') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Pekerjaan Ibu</label>
                    <input type="text" class="form-control" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Penghasilan Orang Tua</label>
                    <input type="number" class="form-control" name="penghasilan_ortu"
                        value="{{ old('penghasilan_ortu') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Tanggungan</label>
                    <input type="number" class="form-control" name="jumlah_tanggungan"
                        value="{{ old('jumlah_tanggungan') }}">
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
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
