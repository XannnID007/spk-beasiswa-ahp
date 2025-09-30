@extends('layouts.admin')

@section('title', 'AHP Management')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">AHP Management</h1>
                <p class="page-subtitle">Kelola matriks perbandingan dan perhitungan bobot kriteria</p>
            </div>
            @if (!$isComplete)
                <a href="{{ route('admin.ahp.create-comparison') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Input Perbandingan
                </a>
            @endif
        </div>
    </div>

    {{-- Status AHP --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card {{ $isComplete ? 'bg-success' : 'bg-warning' }}">
                <div class="stat-icon">
                    <i class="fas fa-matrix"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $comparisons->count() }}</div>
                    <div class="stat-label">Perbandingan Tersedia</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card {{ count($missingComparisons) == 0 ? 'bg-success' : 'bg-danger' }}">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ count($missingComparisons) }}</div>
                    <div class="stat-label">Perbandingan Kurang</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div
                class="stat-card {{ $latestCalculation && $latestCalculation->is_consistent ? 'bg-success' : 'bg-secondary' }}">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">
                        {{ $latestCalculation ? number_format($latestCalculation->consistency_ratio, 4) : '-' }}
                    </div>
                    <div class="stat-label">Consistency Ratio</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card {{ $latestCalculation ? 'bg-info' : 'bg-secondary' }}">
                <div class="stat-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $latestCalculation ? 'Ya' : 'Belum' }}</div>
                    <div class="stat-label">Sudah Dihitung</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Status --}}
    @if (!$isComplete)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Matriks Belum Lengkap!</strong> Masih ada {{ count($missingComparisons) }} perbandingan yang belum
            diinput.
        </div>
    @elseif($latestCalculation && !$latestCalculation->is_consistent)
        <div class="alert alert-danger">
            <i class="fas fa-times-circle"></i>
            <strong>Matriks Tidak Konsisten!</strong> CR = {{ number_format($latestCalculation->consistency_ratio, 4) }} >
            0.1.
            Mohon perbaiki perbandingan kriteria.
        </div>
    @elseif($latestCalculation && $latestCalculation->is_consistent)
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <strong>Matriks Konsisten!</strong> CR = {{ number_format($latestCalculation->consistency_ratio, 4) }} ≤ 0.1.
            Bobot kriteria siap digunakan.
        </div>
    @endif

    {{-- Action Buttons --}}
    <div class="content-card mb-4">
        <div class="d-flex gap-2 flex-wrap">
            @if ($isComplete)
                <button type="button" class="btn btn-primary" onclick="calculateAHP()">
                    <i class="fas fa-calculator"></i> Hitung Bobot AHP
                </button>
                @if ($latestCalculation)
                    <a href="{{ route('admin.ahp.detail') }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Lihat Detail Perhitungan
                    </a>
                @endif
            @endif

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#bulkInputModal">
                <i class="fas fa-upload"></i> Input Massal
            </button>

            @if ($comparisons->count() > 0)
                <button type="button" class="btn btn-danger" onclick="resetComparisons()">
                    <i class="fas fa-trash"></i> Reset Semua
                </button>
            @endif
        </div>
    </div>

    {{-- Daftar Perbandingan --}}
    <div class="content-card">
        <h5 class="card-title mb-4">
            <i class="fas fa-list text-primary"></i> Daftar Perbandingan Kriteria
        </h5>

        @if ($comparisons->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Kriteria 1</th>
                            <th>Kriteria 2</th>
                            <th width="150">Nilai Perbandingan</th>
                            <th>Interpretasi</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparisons as $index => $comp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $comp->kriteriaFirst->kode_kriteria }}</strong> -
                                    {{ $comp->kriteriaFirst->nama_kriteria }}
                                </td>
                                <td>
                                    <strong>{{ $comp->kriteriaSecond->kode_kriteria }}</strong> -
                                    {{ $comp->kriteriaSecond->nama_kriteria }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $comp->nilai_perbandingan }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $comp->kriteriaFirst->kode_kriteria }}
                                        {{ $this->getInterpretation($comp->nilai_perbandingan) }}
                                        {{ $comp->kriteriaSecond->kode_kriteria }}
                                    </small>
                                </td>
                                <td>
                                    <a href="{{ route('admin.ahp.edit-comparison', $comp->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="deleteComparison({{ $comp->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada perbandingan kriteria yang diinput</p>
            </div>
        @endif
    </div>

    {{-- Modal Bulk Input --}}
    <div class="modal fade" id="bulkInputModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Massal Perbandingan Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.ahp.bulk-comparison') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Masukkan nilai perbandingan untuk setiap pasangan kriteria.
                            Nilai 1-9 dimana 1=sama penting, 9=sangat lebih penting.
                        </div>

                        @php $pairIndex = 0; @endphp
                        @for ($i = 0; $i < $kriteria->count(); $i++)
                            @for ($j = $i + 1; $j < $kriteria->count(); $j++)
                                <div class="mb-3">
                                    <label class="form-label">
                                        <strong>{{ $kriteria[$i]->kode_kriteria }}</strong> vs
                                        <strong>{{ $kriteria[$j]->kode_kriteria }}</strong>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="number" step="0.001" min="0.111" max="9"
                                                class="form-control" name="comparisons[{{ $pairIndex }}]"
                                                value="1" required>
                                        </div>
                                        <div class="col-md-8">
                                            <small class="text-muted">
                                                {{ $kriteria[$i]->nama_kriteria }} dibanding
                                                {{ $kriteria[$j]->nama_kriteria }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                @php $pairIndex++; @endphp
                            @endfor
                        @endfor
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Semua</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .bg-success .stat-icon {
            background: linear-gradient(135deg, #065f46 0%, #10b981 100%);
        }

        .bg-warning .stat-icon {
            background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        }

        .bg-danger .stat-icon {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        }

        .bg-secondary .stat-icon {
            background: linear-gradient(135deg, #4b5563 0%, #6b7280 100%);
        }

        .bg-info .stat-icon {
            background: linear-gradient(135deg, #0c4a6e 0%, #06b6d4 100%);
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            margin-top: 2px;
        }
    </style>

    <script>
        function calculateAHP() {
            if (confirm('Hitung bobot kriteria menggunakan AHP? Bobot lama akan diganti.')) {
                window.location.href = '{{ route('admin.ahp.calculate') }}';
            }
        }

        function resetComparisons() {
            if (confirm('Reset semua perbandingan kriteria? Data ini tidak dapat dikembalikan.')) {
                window.location.href = '{{ route('admin.ahp.reset') }}';
            }
        }

        function deleteComparison(id) {
            if (confirm('Hapus perbandingan ini?')) {
                window.location.href = `/admin/ahp/comparison/${id}/delete`;
            }
        }
    </script>
@endsection

@php
    function getInterpretation($value)
    {
        if ($value == 1) {
            return 'sama penting dengan';
        }
        if ($value <= 2) {
            return 'sedikit lebih penting dari';
        }
        if ($value <= 4) {
            return 'lebih penting dari';
        }
        if ($value <= 6) {
            return 'sangat lebih penting dari';
        }
        if ($value <= 8) {
            return 'mutlak lebih penting dari';
        }
        return 'ekstrim lebih penting dari';
    }
@endphp
