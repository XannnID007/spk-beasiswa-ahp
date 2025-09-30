@php
    use App\Helpers\NumberHelper;
@endphp
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

    {{-- Status Cards dengan Desain Konsisten --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="status-card">
                <div class="status-icon bg-primary">
                    <i class="fas fa-table"></i>
                </div>
                <div class="status-content">
                    <div class="status-number">{{ $comparisons->count() }}</div>
                    <div class="status-label">Perbandingan Tersedia</div>
                </div>
                <div class="status-indicator {{ $isComplete ? 'complete' : 'incomplete' }}"></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="status-card">
                <div class="status-icon bg-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="status-content">
                    <div class="status-number">{{ count($missingComparisons) }}</div>
                    <div class="status-label">Perbandingan Kurang</div>
                </div>
                <div class="status-indicator {{ count($missingComparisons) == 0 ? 'complete' : 'incomplete' }}"></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="status-card">
                <div class="status-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="status-content">
                    <div class="status-number">
                        {{ $latestCalculation ? number_format($latestCalculation->consistency_ratio, 4) : '0.0000' }}
                    </div>
                    <div class="status-label">Consistency Ratio</div>
                </div>
                <div
                    class="status-indicator {{ $latestCalculation && $latestCalculation->is_consistent ? 'complete' : 'incomplete' }}">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="status-card">
                <div class="status-icon bg-info">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="status-content">
                    <div class="status-number">{{ $latestCalculation ? 'Ya' : 'Belum' }}</div>
                    <div class="status-label">Sudah Dihitung</div>
                </div>
                <div class="status-indicator {{ $latestCalculation ? 'complete' : 'incomplete' }}"></div>
            </div>
        </div>
    </div>

    {{-- Alert Status dengan Warna yang Konsisten --}}
    @if (!$isComplete)
        <div class="alert alert-warning-custom">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
                <strong>Matriks Belum Lengkap!</strong>
                <p>Masih ada {{ count($missingComparisons) }} perbandingan yang belum diinput. Silakan lengkapi terlebih
                    dahulu.</p>
            </div>
        </div>
    @elseif($latestCalculation && !$latestCalculation->is_consistent)
        <div class="alert alert-danger-custom">
            <div class="alert-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="alert-content">
                <strong>Matriks Tidak Konsisten!</strong>
                <p>CR = {{ number_format($latestCalculation->consistency_ratio, 4) }} > 0.1. Mohon perbaiki perbandingan
                    kriteria.</p>
            </div>
        </div>
    @elseif($latestCalculation && $latestCalculation->is_consistent)
        <div class="alert alert-success-custom">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-content">
                <strong>Matriks Konsisten!</strong>
                <p>CR = {{ number_format($latestCalculation->consistency_ratio, 4) }} ≤ 0.1. Bobot kriteria siap digunakan.
                </p>
            </div>
        </div>
    @endif

    {{-- Action Buttons dengan Desain Modern --}}
    <div class="content-card mb-4">
        <div class="card-header-modern">
            <h5 class="card-title">
                <i class="fas fa-cogs text-primary"></i> Aksi Perhitungan
            </h5>
        </div>

        <div class="action-buttons">
            @if ($isComplete)
                <button type="button" class="btn btn-primary-modern" onclick="calculateAHP()">
                    <i class="fas fa-calculator"></i>
                    <span>Hitung Bobot AHP</span>
                </button>

                @if ($latestCalculation)
                    <a href="{{ route('admin.ahp.detail') }}" class="btn btn-info-modern">
                        <i class="fas fa-eye"></i>
                        <span>Lihat Detail Perhitungan</span>
                    </a>
                @endif
            @endif

            <button type="button" class="btn btn-secondary-modern" data-bs-toggle="modal" data-bs-target="#bulkInputModal">
                <i class="fas fa-upload"></i>
                <span>Input Massal</span>
            </button>

            @if ($comparisons->count() > 0)
                <button type="button" class="btn btn-danger-modern" onclick="resetComparisons()">
                    <i class="fas fa-trash"></i>
                    <span>Reset Semua</span>
                </button>
            @endif
        </div>
    </div>

    {{-- Tabel Perbandingan dengan Desain Bersih --}}
    <div class="content-card">
        <div class="card-header-modern">
            <h5 class="card-title">
                <i class="fas fa-list text-primary"></i> Daftar Perbandingan Kriteria
            </h5>
        </div>

        @if ($comparisons->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Kriteria 1</th>
                            <th>Kriteria 2</th>
                            <th width="140">Nilai Perbandingan</th>
                            <th>Interpretasi</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparisons as $index => $comp)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="criteria-info">
                                        <span class="criteria-code">{{ $comp->kriteriaFirst->kode_kriteria }}</span>
                                        <span class="criteria-name">{{ $comp->kriteriaFirst->nama_kriteria }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="criteria-info">
                                        <span class="criteria-code">{{ $comp->kriteriaSecond->kode_kriteria }}</span>
                                        <span class="criteria-name">{{ $comp->kriteriaSecond->nama_kriteria }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="comparison-value">{{ NumberHelper::formatComparison($comp->nilai_perbandingan) }}</span>
                                </td>
                                <td>
                                    <span class="interpretation-text">
                                        @php
                                            $nilai = $comp->nilai_perbandingan;
                                            if ($nilai == 1) {
                                                $interpretasi = 'sama penting dengan';
                                            } elseif ($nilai <= 2) {
                                                $interpretasi = 'sedikit lebih penting dari';
                                            } elseif ($nilai <= 4) {
                                                $interpretasi = 'lebih penting dari';
                                            } elseif ($nilai <= 6) {
                                                $interpretasi = 'sangat lebih penting dari';
                                            } elseif ($nilai <= 8) {
                                                $interpretasi = 'mutlak lebih penting dari';
                                            } else {
                                                $interpretasi = 'ekstrim lebih penting dari';
                                            }
                                        @endphp
                                        {{ $comp->kriteriaFirst->kode_kriteria }}
                                        {{ $interpretasi }}
                                        {{ $comp->kriteriaSecond->kode_kriteria }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons-small">
                                        <a href="{{ route('admin.ahp.edit-comparison', $comp->id) }}"
                                            class="btn btn-sm btn-warning-modern">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger-modern"
                                            onclick="deleteComparison({{ $comp->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h6>Belum Ada Perbandingan</h6>
                <p>Belum ada perbandingan kriteria yang diinput</p>
                <a href="{{ route('admin.ahp.create-comparison') }}" class="btn btn-primary-modern">
                    <i class="fas fa-plus"></i> Tambah Perbandingan
                </a>
            </div>
        @endif
    </div>

    {{-- Modal dengan Desain Konsisten --}}
    <div class="modal fade" id="bulkInputModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-modern">
                <div class="modal-header">
                    <h5 class="modal-title">Input Massal Perbandingan Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.ahp.bulk-comparison') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info-custom">
                            <i class="fas fa-info-circle"></i>
                            Masukkan nilai perbandingan untuk setiap pasangan kriteria.
                            Nilai 1-9 dimana 1=sama penting, 9=sangat lebih penting.
                        </div>

                        @php $pairIndex = 0; @endphp
                        @for ($i = 0; $i < $kriteria->count(); $i++)
                            @for ($j = $i + 1; $j < $kriteria->count(); $j++)
                                <div class="comparison-input-group">
                                    <label class="form-label">
                                        <span class="criteria-badge">{{ $kriteria[$i]->kode_kriteria }}</span>
                                        <span class="vs-text">vs</span>
                                        <span class="criteria-badge">{{ $kriteria[$j]->kode_kriteria }}</span>
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
                        <button type="button" class="btn btn-secondary-modern" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-modern">Simpan Semua</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Status Cards Modern */
        .status-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .status-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .status-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            flex-shrink: 0;
        }

        .status-icon.bg-primary {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .status-icon.bg-warning {
            background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        }

        .status-icon.bg-success {
            background: linear-gradient(135deg, #065f46 0%, #10b981 100%);
        }

        .status-icon.bg-info {
            background: linear-gradient(135deg, #0c4a6e 0%, #06b6d4 100%);
        }

        .status-content {
            flex: 1;
        }

        .status-number {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            line-height: 1;
        }

        .status-label {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }

        .status-indicator {
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
        }

        .status-indicator.complete {
            background: #10b981;
        }

        .status-indicator.incomplete {
            background: #ef4444;
        }

        /* Alert Modern */
        .alert-warning-custom,
        .alert-danger-custom,
        .alert-success-custom,
        .alert-info-custom {
            border: none;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
        }

        .alert-warning-custom {
            background: #fef3c7;
            color: #92400e;
        }

        .alert-danger-custom {
            background: #fee2e2;
            color: #dc2626;
        }

        .alert-success-custom {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-info-custom {
            background: #dbeafe;
            color: #1e40af;
        }

        .alert-icon {
            font-size: 20px;
            margin-top: 2px;
        }

        .alert-content strong {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .alert-content p {
            margin: 0;
            font-size: 14px;
        }

        /* Card Header Modern */
        .card-header-modern {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Action Buttons Modern */
        .action-buttons {
            padding: 20px 24px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-primary-modern,
        .btn-info-modern,
        .btn-secondary-modern,
        .btn-danger-modern,
        .btn-warning-modern {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 14px;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
        }

        .btn-primary-modern:hover {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
            transform: translateY(-1px);
            color: white;
        }

        .btn-info-modern {
            background: linear-gradient(135deg, #0c4a6e 0%, #06b6d4 100%);
            color: white;
        }

        .btn-info-modern:hover {
            background: linear-gradient(135deg, #164e63 0%, #0891b2 100%);
            transform: translateY(-1px);
            color: white;
        }

        .btn-secondary-modern {
            background: #f3f4f6;
            color: #374151;
            border: 2px solid #e5e7eb;
        }

        .btn-secondary-modern:hover {
            background: #e5e7eb;
            color: #111827;
            transform: translateY(-1px);
        }

        .btn-danger-modern {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: white;
        }

        .btn-danger-modern:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
            transform: translateY(-1px);
            color: white;
        }

        .btn-warning-modern {
            background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
            color: white;
        }

        .btn-warning-modern:hover {
            background: linear-gradient(135deg, #92400e 0%, #d97706 100%);
            transform: translateY(-1px);
            color: white;
        }

        /* Table Modern */
        .table-modern {
            margin: 0;
        }

        .table-modern thead th {
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            font-size: 13px;
            border: none;
            padding: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-modern tbody td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }

        .table-modern tbody tr:hover {
            background: #f9fafb;
        }

        .criteria-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .criteria-code {
            font-weight: 700;
            color: #1e3a8a;
            font-size: 14px;
        }

        .criteria-name {
            font-size: 12px;
            color: #6b7280;
        }

        .comparison-value {
            background: #dbeafe;
            color: #1e40af;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .interpretation-text {
            font-size: 13px;
            color: #4b5563;
            font-style: italic;
        }

        .action-buttons-small {
            display: flex;
            gap: 6px;
        }

        .btn-sm.btn-warning-modern,
        .btn-sm.btn-danger-modern {
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 12px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 16px;
        }

        .empty-state h6 {
            color: #374151;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 24px;
        }

        /* Modal Modern */
        .modal-modern {
            border-radius: 16px;
            border: none;
        }

        .modal-modern .modal-header {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 16px 16px 0 0;
            padding: 20px 24px;
        }

        .modal-modern .modal-body {
            padding: 24px;
        }

        .modal-modern .modal-footer {
            border-top: 1px solid #e5e7eb;
            padding: 20px 24px;
            background: #f9fafb;
            border-radius: 0 0 16px 16px;
        }

        .comparison-input-group {
            margin-bottom: 20px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 10px;
        }

        .criteria-badge {
            background: #1e3a8a;
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
        }

        .vs-text {
            margin: 0 8px;
            color: #6b7280;
            font-weight: 500;
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
