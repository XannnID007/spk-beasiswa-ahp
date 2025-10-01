@extends('layouts.siswa')

@section('title', 'Pengajuan Beasiswa')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Form Pengajuan Beasiswa</h1>
        <p class="page-subtitle">Lengkapi formulir di bawah ini untuk mengajukan beasiswa</p>
    </div>

    <div class="content-card">
        @if ($pengajuanExists)
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Anda sudah mengajukan beasiswa sebelumnya.
                <a href="{{ route('siswa.pengajuan.show', $pengajuanExists->id) }}" class="alert-link">Lihat detail
                    pengajuan</a>
            </div>
        @else
            <form action="{{ route('siswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="section-header">
                    <i class="fas fa-award"></i> Pilih Program Beasiswa
                </div>

                @if ($beasiswaAktif->count() > 0)
                    <div class="mb-4">
                        <label class="form-label">Beasiswa yang Tersedia</label>
                        <select class="form-select @error('beasiswa_id') is-invalid @enderror" name="beasiswa_id">
                            <option value="">Pilih Beasiswa (Opsional)</option>
                            @foreach ($beasiswaAktif as $b)
                                <option value="{{ $b->id }}" {{ old('beasiswa_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama_beasiswa }} - {{ $b->jenis_beasiswa }} (Kuota: {{ $b->kuota }})
                                </option>
                            @endforeach
                        </select>
                        @error('beasiswa_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Pilih program beasiswa yang ingin Anda ajukan</small>
                    </div>
                @else
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle"></i> Saat ini belum ada program beasiswa yang aktif. Anda
                        tetap bisa mengajukan untuk seleksi umum.
                    </div>
                @endif

                <div class="section-header">
                    <i class="fas fa-user"></i> Data Pribadi
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Lengkapi data pribadi Anda terlebih dahulu sebelum mengajukan
                    beasiswa
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">NIS</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->siswa->nis }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                            name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->siswa->nama_lengkap) }}"
                            required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin"
                            required>
                            <option value="L"
                                {{ old('jenis_kelamin', Auth::user()->siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="P"
                                {{ old('jenis_kelamin', Auth::user()->siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->siswa->kelas }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                            name="tempat_lahir"
                            value="{{ old('tempat_lahir', Auth::user()->siswa->tempat_lahir != '-' ? Auth::user()->siswa->tempat_lahir : '') }}"
                            required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', Auth::user()->siswa->tanggal_lahir->format('Y-m-d')) }}"
                            required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp"
                            value="{{ old('no_telp', Auth::user()->siswa->no_telp != '-' ? Auth::user()->siswa->no_telp : '') }}"
                            required>
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="2" required>{{ old('alamat', Auth::user()->siswa->alamat != '-' ? Auth::user()->siswa->alamat : '') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="section-header">
                    <i class="fas fa-users"></i> Data Orang Tua
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Ayah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" name="nama_ayah"
                            value="{{ old('nama_ayah', Auth::user()->siswa->nama_ayah != '-' ? Auth::user()->siswa->nama_ayah : '') }}"
                            required>
                        @error('nama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                            name="nama_ibu"
                            value="{{ old('nama_ibu', Auth::user()->siswa->nama_ibu != '-' ? Auth::user()->siswa->nama_ibu : '') }}"
                            required>
                        @error('nama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan Ayah</label>
                        <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                            name="pekerjaan_ayah"
                            value="{{ old('pekerjaan_ayah', Auth::user()->siswa->pekerjaan_ayah) }}">
                        @error('pekerjaan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                            name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', Auth::user()->siswa->pekerjaan_ibu) }}">
                        @error('pekerjaan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="section-header">
                    <i class="fas fa-file-alt"></i> Formulir Pengajuan
                </div>

                <div class="mb-3">
                    <label class="form-label">Alasan Pengajuan Beasiswa <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alasan_pengajuan') is-invalid @enderror" name="alasan_pengajuan"
                        rows="5" placeholder="Jelaskan alasan Anda membutuhkan beasiswa..." required>{{ old('alasan_pengajuan') }}</textarea>
                    @error('alasan_pengajuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 50 karakter</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Berkas Pendukung</label>
                    <input type="file" class="form-control @error('berkas_pendukung') is-invalid @enderror"
                        name="berkas_pendukung" accept=".pdf,.jpg,.jpeg,.png">
                    @error('berkas_pendukung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Upload foto KK, dan SKTM (jika ada) dalam bentuk (PDF, Max
                        2MB)</small>
                </div>

                <div class="section-header">
                    <i class="fas fa-users"></i> Informasi Keluarga
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Penghasilan Orang Tua per Bulan <span
                                class="text-danger">*</span></label>
                        <select class="form-select @error('penghasilan_ortu') is-invalid @enderror"
                            name="penghasilan_ortu" required>
                            <option value="">Pilih Range Penghasilan</option>
                            <option value="500000" {{ old('penghasilan_ortu') == '500000' ? 'selected' : '' }}>
                                < Rp 1.000.000</option>
                            <option value="1500000" {{ old('penghasilan_ortu') == '1500000' ? 'selected' : '' }}>Rp
                                1.000.000 - Rp 2.000.000</option>
                            <option value="2500000" {{ old('penghasilan_ortu') == '2500000' ? 'selected' : '' }}>Rp
                                2.000.000 - Rp 3.000.000</option>
                            <option value="3500000" {{ old('penghasilan_ortu') == '3500000' ? 'selected' : '' }}>> Rp
                                3.000.000</option>
                        </select>
                        @error('penghasilan_ortu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jumlah Tanggungan Keluarga <span class="text-danger">*</span></label>
                        <select class="form-select @error('jumlah_tanggungan') is-invalid @enderror"
                            name="jumlah_tanggungan" required>
                            <option value="">Pilih Jumlah Tanggungan</option>
                            <option value="1" {{ old('jumlah_tanggungan') == '1' ? 'selected' : '' }}>1-2 Orang
                            </option>
                            <option value="3" {{ old('jumlah_tanggungan') == '3' ? 'selected' : '' }}>3 Orang
                            </option>
                            <option value="4" {{ old('jumlah_tanggungan') == '4' ? 'selected' : '' }}>4 Orang
                            </option>
                            <option value="5" {{ old('jumlah_tanggungan') == '5' ? 'selected' : '' }}>≥5 Orang
                            </option>
                        </select>
                        @error('jumlah_tanggungan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="section-header">
                    <i class="fas fa-check-circle"></i> Pernyataan
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Data yang Anda masukkan akan digunakan untuk proses seleksi penerima
                    beasiswa.
                    Pastikan semua informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan.
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="persetujuan" required>
                    <label class="form-check-label" for="persetujuan">
                        Saya menyatakan bahwa data yang saya masukkan adalah benar dan dapat dipertanggungjawabkan
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                    </button>
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>

        @endif
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

        .section-header:first-child {
            margin-top: 0;
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

        .btn {
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-primary {
            background: #1e3a8a;
            border: none;
        }

        .btn-primary:hover {
            background: #1e40af;
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }
    </style>
@endsection
