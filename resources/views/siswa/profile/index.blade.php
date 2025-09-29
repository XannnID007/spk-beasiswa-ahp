@extends('layouts.siswa')

@section('title', 'Profil Saya')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Profil Saya</h1>
        <p class="page-subtitle">Kelola informasi profil dan keamanan akun Anda</p>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="content-card text-center">
                <div class="profile-photo-wrapper">
                    @if ($siswa->foto)
                        <img src="{{ asset($siswa->foto) }}" alt="Foto Profil" class="profile-photo">
                    @else
                        <div class="profile-photo-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>

                <h5 class="mt-3 mb-1">{{ $siswa->nama_lengkap }}</h5>
                <p class="text-muted mb-2">{{ $siswa->nis }}</p>
                <span class="badge bg-primary">{{ $siswa->kelas }}</span>

                <form action="{{ route('siswa.profile.update-photo') }}" method="POST" enctype="multipart/form-data"
                    class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="foto" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-camera"></i> Ubah Foto
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*" style="display: none;"
                            onchange="this.form.submit()">
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-user-edit text-primary"></i> Informasi Pribadi
                </h5>

                <form action="{{ route('siswa.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">NIS</label>
                            <input type="text" class="form-control" value="{{ $siswa->nis }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap"
                                value="{{ $siswa->nama_lengkap }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir"
                                value="{{ $siswa->tempat_lahir }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir"
                                value="{{ $siswa->tanggal_lahir->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required>{{ $siswa->alamat }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" name="no_telp" value="{{ $siswa->no_telp }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}"
                                required>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <h6 class="section-subtitle">Data Orang Tua</h6>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" class="form-control" name="nama_ayah" value="{{ $siswa->nama_ayah }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" class="form-control" name="nama_ibu" value="{{ $siswa->nama_ibu }}"
                                required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan Ayah</label>
                            <input type="text" class="form-control" name="pekerjaan_ayah"
                                value="{{ $siswa->pekerjaan_ayah }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan Ibu</label>
                            <input type="text" class="form-control" name="pekerjaan_ibu"
                                value="{{ $siswa->pekerjaan_ibu }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>

            <div class="content-card mt-4">
                <h5 class="card-title mb-4">
                    <i class="fas fa-lock text-primary"></i> Ubah Password
                </h5>

                <form action="{{ route('siswa.profile.change-password') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="new_password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="new_password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .profile-photo-wrapper {
            margin: 20px auto;
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #1e3a8a;
        }

        .profile-photo-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: white;
            font-size: 60px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }

        .section-divider {
            height: 2px;
            background: #e5e7eb;
            margin: 25px 0;
        }

        .section-subtitle {
            font-size: 14px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 15px;
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
