@extends('layouts.admin')

@section('title', 'Edit User Admin')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit User Admin</h1>
        <p class="page-subtitle">Perbarui informasi akun admin</p>
    </div>

    <div class="content-card">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr class="my-4">

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Kosongkan password jika tidak ingin mengubahnya
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Minimal 6 karakter</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
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
