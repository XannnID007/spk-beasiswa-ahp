@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Profil Admin</h1>
        <p class="page-subtitle">Kelola informasi profil Anda</p>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="content-card text-center">
                <div class="admin-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>

                <h5 class="mt-3 mb-1">{{ Auth::user()->name }}</h5>
                <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                <span class="badge bg-primary">Administrator</span>

                <div class="account-info mt-4">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <div class="info-label">Bergabung Sejak</div>
                            <div class="info-value">{{ Auth::user()->created_at->format('d F Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-user-edit text-primary"></i> Informasi Akun
                </h5>

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name', Auth::user()->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', Auth::user()->email) }}" required>
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

                <form action="{{ route('admin.profile.change-password') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Password Lama <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="new_password" required>
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
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
        .admin-avatar {
            width: 120px;
            height: 120px;
            margin: 20px auto;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: 700;
        }

        .account-info {
            padding: 20px 0;
            border-top: 2px solid #e5e7eb;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .info-item i {
            font-size: 24px;
            color: #3b82f6;
            width: 30px;
            text-align: center;
        }

        .info-label {
            font-size: 12px;
            color: #6b7280;
        }

        .info-value {
            font-size: 14px;
            color: #111827;
            font-weight: 600;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
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
    </style>
@endsection
