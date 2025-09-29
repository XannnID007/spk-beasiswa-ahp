@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Manajemen User Admin</h1>
                <p class="page-subtitle">Kelola akun admin sistem</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Admin
            </a>
        </div>
    </div>

    <div class="content-card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th width="120">Role</th>
                        <th width="180">Terdaftar Sejak</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-primary">Admin</span></td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if ($user->id != auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus user admin ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada user admin</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>

    <style>
        .table {
            font-size: 14px;
        }

        .table thead th {
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            border: none;
            padding: 12px 15px;
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .btn-sm {
            padding: 6px 10px;
            font-size: 13px;
        }
    </style>
@endsection
