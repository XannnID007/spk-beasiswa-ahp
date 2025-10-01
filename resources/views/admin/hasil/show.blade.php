@extends('layouts.admin')

@section('title', 'Detail Hasil')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Detail Hasil Seleksi</h1>
                <p class="page-subtitle">Informasi lengkap hasil penilaian siswa dan perhitungan AHP</p>
            </div>
            <a href="{{ route('admin.hasil.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="content-card">
                <div class="text-center mb-4">
                    <div class="student-avatar">
                        {{ strtoupper(substr($hasil->siswa->nama_lengkap, 0, 2)) }}
                    </div>
                    <h5 class="mt-3 mb-2">{{ $hasil->siswa->nama_lengkap }}</h5>
                    <p class="text-muted mb-0">{{ $hasil->siswa->nis }}</p>
                    <span class="badge bg-info mt-2">{{ $hasil->siswa->kelas }}</span>
                </div>

                <div class="result-summary">
                    <div class="result-item">
                        <div class="result-label">Ranking</div>
                        <div class="result-value ranking-{{ $hasil->ranking }}">
                            {{ $hasil->ranking }}
                        </div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">Skor Akhir</div>
                        <div class="result-value">{{ number_format($hasil->skor_akhir, 6) }}</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">Status</div>
                        <div class="result-value">
                            @if ($hasil->status_kelulusan == 'lulus')
                                <span class="badge bg-success">Lulus</span>
                            @else
                                <span class="badge bg-secondary">Tidak Lulus</span>
                            @endif
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.hasil.update-status', $hasil->id) }}" method="POST" class="mt-4">
                    @csrf
                    <label class="form-label">Ubah Status Kelulusan</label>
                    <select class="form-select mb-2" name="status_kelulusan" required>
                        <option value="lulus" {{ $hasil->status_kelulusan == 'lulus' ? 'selected' : '' }}>Lulus</option>
                        <option value="tidak_lulus" {{ $hasil->status_kelulusan == 'tidak_lulus' ? 'selected' : '' }}>Tidak
                            Lulus</option>
                    </select>
                    <textarea class="form-control mb-2" name="catatan" rows="3" placeholder="Catatan (opsional)">{{ $hasil->catatan }}</textarea>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <!-- Detail Penilaian Kriteria -->
            <div class="content-card mb-4">
                <h5 class="card-title mb-4">
                    <i class="fas fa-chart-line text-primary"></i> Detail Penilaian Kriteria
                </h5>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria</th>
                                <th width="100">Bobot</th>
                                <th>Sub-Kriteria</th>
                                <th width="100">Nilai Sub</th>
                                <th width="120">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penilaian as $p)
                                <tr>
                                    <td><strong>{{ $p->kriteria->nama_kriteria }}</strong></td>
                                    <td class="text-center">{{ number_format($p->kriteria->bobot, 4) }}</td>
                                    <td>{{ $p->subKriteria->nama_sub_kriteria }}</td>
                                    <td class="text-center">{{ number_format($p->subKriteria->nilai_sub, 4) }}</td>
                                    <td class="text-center">
                                        <strong>{{ number_format($p->kriteria->bobot * $p->subKriteria->nilai_sub, 4) }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="table-primary">
                                <td colspan="4" class="text-end"><strong>TOTAL SKOR AKHIR:</strong></td>
                                <td class="text-center">
                                    <strong style="font-size: 16px;">{{ number_format($hasil->skor_akhir, 4) }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Matrix Perbandingan AHP -->
            @if ($comparisonMatrix && count($comparisonMatrix) > 0)
                <div class="content-card mb-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-table text-primary"></i> Matrix Perbandingan Kriteria (AHP)
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover matrix-table">
                            <thead class="table-primary">
                                <tr>
                                    <th width="120" class="text-center">Kriteria</th>
                                    @foreach ($kriteria as $k)
                                        <th width="80" class="text-center">{{ $k->kode_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriteria as $i => $k1)
                                    <tr>
                                        <td class="text-center kriteria-label">
                                            <strong>{{ $k1->kode_kriteria }}</strong>
                                        </td>
                                        @foreach ($kriteria as $j => $k2)
                                            <td class="text-center matrix-cell">
                                                @if ($i == $j)
                                                    <span class="diagonal-cell">1.000</span>
                                                @else
                                                    <span
                                                        class="comparison-value">{{ number_format($comparisonMatrix[$i][$j], 1) }}</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="matrix-info">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Matrix ini menunjukkan perbandingan berpasangan antar kriteria berdasarkan metode AHP
                        </small>
                    </div>
                </div>

                <!-- Matrix Normalisasi -->
                <div class="content-card mb-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-calculator text-primary"></i> Matrix Normalisasi
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover matrix-table">
                            <thead class="table-success">
                                <tr>
                                    <th width="120" class="text-center">Kriteria</th>
                                    @foreach ($kriteria as $k)
                                        <th width="80" class="text-center">{{ $k->kode_kriteria }}</th>
                                    @endforeach
                                    <th width="100" class="text-center">Bobot</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriteria as $i => $k1)
                                    <tr>
                                        <td class="text-center kriteria-label">
                                            <strong>{{ $k1->kode_kriteria }}</strong>
                                        </td>
                                        @foreach ($kriteria as $j => $k2)
                                            <td class="text-center matrix-cell">
                                                <span
                                                    class="normalized-value">{{ number_format($normalizedMatrix[$i][$j], 4) }}</span>
                                            </td>
                                        @endforeach
                                        <td class="text-center weight-cell">
                                            <strong
                                                class="weight-value">{{ number_format($priorityVector[$i], 4) }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-light">
                                    <td class="text-center"><strong>Total</strong></td>
                                    @foreach ($kriteria as $j => $k)
                                        @php
                                            $columnSum = 0;
                                            foreach ($normalizedMatrix as $row) {
                                                $columnSum += $row[$j];
                                            }
                                        @endphp
                                        <td class="text-center">
                                            <strong>{{ number_format($columnSum, 4) }}</strong>
                                        </td>
                                    @endforeach
                                    <td class="text-center">
                                        <strong
                                            class="total-weight">{{ number_format(array_sum($priorityVector), 4) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="matrix-info">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Matrix normalisasi diperoleh dengan membagi setiap elemen dengan jumlah kolomnya.
                            Bobot adalah rata-rata dari setiap baris.
                        </small>
                    </div>
                </div>

                <!-- Konsistensi AHP -->
                @if ($ahpCalculation)
                    <div class="content-card mb-4">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-check-circle text-primary"></i> Validasi Konsistensi AHP
                        </h5>

                        <div class="consistency-metrics">
                            <div class="metric-card">
                                <div class="metric-icon bg-primary">
                                    <i class="fas fa-lambda"></i>
                                </div>
                                <div class="metric-content">
                                    <div class="metric-label">Lambda Max (λmax)</div>
                                    <div class="metric-value">{{ number_format($ahpCalculation->lambda_max, 6) }}</div>
                                </div>
                            </div>

                            <div class="metric-card">
                                <div class="metric-icon bg-warning">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <div class="metric-content">
                                    <div class="metric-label">Consistency Index (CI)</div>
                                    <div class="metric-value">{{ number_format($ahpCalculation->consistency_index, 6) }}
                                    </div>
                                </div>
                            </div>

                            <div class="metric-card">
                                <div
                                    class="metric-icon {{ $ahpCalculation->is_consistent ? 'bg-success' : 'bg-danger' }}">
                                    <i class="fas {{ $ahpCalculation->is_consistent ? 'fa-check' : 'fa-times' }}"></i>
                                </div>
                                <div class="metric-content">
                                    <div class="metric-label">Consistency Ratio (CR)</div>
                                    <div
                                        class="metric-value {{ $ahpCalculation->is_consistent ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($ahpCalculation->consistency_ratio, 6) }}
                                        <small
                                            class="d-block">{{ $ahpCalculation->is_consistent ? '≤ 0.1 (Konsisten)' : '> 0.1 (Tidak Konsisten)' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="consistency-formula mt-4">
                            <div class="formula-box">
                                <h6><i class="fas fa-formula"></i> Rumus Konsistensi AHP</h6>
                                <div class="formula-steps">
                                    <div class="step">CI = (λmax - n) / (n - 1)</div>
                                    <div class="step">CR = CI / RI</div>
                                    <div class="step">Dimana n = {{ count($kriteria) }}, RI =
                                        {{ count($kriteria) == 4 ? '0.90' : '1.12' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Data Siswa -->
            <div class="content-card">
                <h5 class="card-title mb-4">
                    <i class="fas fa-user text-primary"></i> Data Siswa
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">NIS</span>
                            <span class="detail-value">{{ $hasil->siswa->nis }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Nama</span>
                            <span class="detail-value">{{ $hasil->siswa->nama_lengkap }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Kelas</span>
                            <span class="detail-value">{{ $hasil->siswa->kelas }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-row">
                            <span class="detail-label">Tempat, Tanggal Lahir</span>
                            <span class="detail-value">{{ $hasil->siswa->tempat_lahir }},
                                {{ $hasil->siswa->tanggal_lahir->format('d F Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">No. Telepon</span>
                            <span class="detail-value">{{ $hasil->siswa->no_telp }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tanggal Perhitungan</span>
                            <span class="detail-value">{{ $hasil->tanggal_perhitungan->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .student-avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            font-weight: 700;
        }

        .result-summary {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
        }

        .result-item {
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .result-value {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }

        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 14px;
            color: #6b7280;
            min-width: 180px;
            font-weight: 500;
        }

        .detail-value {
            font-size: 14px;
            color: #111827;
            flex: 1;
        }

        /* Matrix Styling */
        .matrix-table {
            font-size: 13px;
            margin: 0;
        }

        .matrix-table th {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            font-weight: 600;
            text-align: center;
            font-size: 12px;
            padding: 12px 8px;
        }

        .matrix-table .table-success th {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .matrix-table tbody td {
            padding: 10px 8px;
            text-align: center;
            vertical-align: middle;
        }

        .kriteria-label {
            background: #f3f4f6 !important;
            font-weight: 700;
            color: #1e3a8a;
        }

        .matrix-cell {
            background: #fafafa;
            transition: background 0.3s ease;
        }

        .matrix-cell:hover {
            background: #e5e7eb;
        }

        .diagonal-cell {
            color: #059669;
            font-weight: 700;
            background: #d1fae5;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .comparison-value {
            color: #1e3a8a;
            font-weight: 600;
        }

        .normalized-value {
            color: #059669;
            font-weight: 500;
        }

        .weight-cell {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
        }

        .weight-value {
            color: #1e3a8a;
            font-size: 14px;
            padding: 4px 8px;
            border-radius: 4px;
            background: white;
        }

        .total-weight {
            color: #059669;
            font-size: 14px;
            background: white;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .matrix-info {
            margin-top: 12px;
            padding: 10px;
            background: #f0f9ff;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
        }

        /* Consistency Metrics */
        .consistency-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .metric-card {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .metric-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .metric-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
        }

        .metric-icon.bg-primary {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .metric-icon.bg-warning {
            background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        }

        .metric-icon.bg-success {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .metric-icon.bg-danger {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        }

        .metric-content {
            flex: 1;
        }

        .metric-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .metric-value {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }

        /* Formula Box */
        .formula-box {
            background: #f0f9ff;
            border-radius: 10px;
            padding: 20px;
            border-left: 4px solid #1e3a8a;
        }

        .formula-box h6 {
            color: #1e3a8a;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .formula-steps {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .step {
            background: white;
            padding: 10px 15px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #374151;
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

        /* Responsive */
        @media (max-width: 768px) {
            .consistency-metrics {
                grid-template-columns: 1fr;
            }

            .matrix-table {
                font-size: 11px;
            }

            .matrix-table th,
            .matrix-table td {
                padding: 6px 4px;
            }
        }
    </style>
@endsection
