@extends('layouts.admin')

@section('title', 'Perhitungan AHP')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Proses Perhitungan AHP</h1>
        <p class="page-subtitle">Analytical Hierarchy Process - Perhitungan Calon Penerima Beasiswa</p>
    </div>

    <!-- Validation Status AHP -->
    <div class="validation-section">
        <div class="content-card mb-4">
            <div class="validation-header">
                <div
                    class="validation-icon {{ $isAhpComplete && $ahpValidation['is_valid'] ? 'validation-success' : 'validation-error' }}">
                    <i
                        class="fas {{ $isAhpComplete && $ahpValidation['is_valid'] ? 'fa-check-circle' : 'fa-exclamation-triangle' }}"></i>
                </div>
                <div class="validation-content">
                    <h5 class="validation-title">
                        {{ $isAhpComplete && $ahpValidation['is_valid'] ? 'Validasi AHP Berhasil!' : 'Validasi AHP Gagal!' }}
                    </h5>
                    <p class="validation-message">
                        @if (!$isAhpComplete)
                            Matriks perbandingan AHP belum lengkap. Mohon lengkapi perbandingan kriteria di menu AHP
                            Management.
                        @elseif(!$ahpValidation['is_valid'])
                            {{ $ahpValidation['message'] }}
                        @else
                            Matriks AHP konsisten dan siap digunakan untuk perhitungan.
                        @endif
                    </p>
                </div>
                @if (!$isAhpComplete || !$ahpValidation['is_valid'])
                    <a href="{{ route('admin.ahp.index') }}" class="btn btn-danger">
                        <i class="fas fa-tools"></i> Perbaiki AHP
                    </a>
                @endif
            </div>

            @if ($isAhpComplete && $ahpValidation['is_valid'])
                <div class="validation-details">
                    <div class="detail-item">
                        <div class="detail-label">Consistency Ratio (CR)</div>
                        <div class="detail-value">
                            <span class="badge badge-success-custom">{{ number_format($ahpValidation['cr'], 4) }} ≤
                                0.1</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Lambda Max (λmax)</div>
                        <div class="detail-value">{{ number_format($ahpValidation['lambda_max'], 4) }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Consistency Index (CI)</div>
                        <div class="detail-value">{{ number_format($ahpValidation['ci'], 4) }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-value">{{ $totalSiswaVerifikasi }}</div>
                    <div class="stat-label">Siswa Terverifikasi</div>
                </div>
                <div class="stat-progress">
                    <div class="progress-mini">
                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-value">{{ $siswaLengkap }}</div>
                    <div class="stat-label">Nilai Lengkap</div>
                </div>
                <div class="stat-progress">
                    <div class="progress-mini">
                        <div class="progress-bar bg-success"
                            style="width: {{ $totalSiswaVerifikasi > 0 ? ($siswaLengkap / $totalSiswaVerifikasi) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-info">
                <div class="stat-icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-value">{{ $sudahDihitung }}</div>
                    <div class="stat-label">Sudah Dihitung</div>
                </div>
                <div class="stat-progress">
                    <div class="progress-mini">
                        <div class="progress-bar bg-info"
                            style="width: {{ $siswaLengkap > 0 ? ($sudahDihitung / $siswaLengkap) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-value">{{ $belumDihitung }}</div>
                    <div class="stat-label">Belum Dihitung</div>
                </div>
                <div class="stat-progress">
                    <div class="progress-mini">
                        <div class="progress-bar bg-warning"
                            style="width: {{ $siswaLengkap > 0 ? ($belumDihitung / $siswaLengkap) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Panel -->
    <div class="content-card mb-4">
        <div class="action-panel">
            <div class="action-info">
                <div class="action-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="action-content">
                    <h5 class="action-title">Mulai Proses Perhitungan</h5>
                    <p class="action-description">
                        Sistem akan menghitung bobot dan ranking siswa menggunakan metode AHP berdasarkan kriteria penilaian
                        yang telah ditentukan.
                    </p>
                    @if (!$ahpValidation['is_valid'] || $siswaLengkap == 0)
                        <div class="action-requirements">
                            <div
                                class="requirement-item {{ $ahpValidation['is_valid'] ? 'requirement-complete' : 'requirement-pending' }}">
                                <i
                                    class="fas {{ $ahpValidation['is_valid'] ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                <span>Validasi AHP Konsisten</span>
                            </div>
                            <div
                                class="requirement-item {{ $siswaLengkap > 0 ? 'requirement-complete' : 'requirement-pending' }}">
                                <i class="fas {{ $siswaLengkap > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                <span>Data Siswa Tersedia</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="action-buttons">
                @if ($ahpValidation['is_valid'] && $siswaLengkap > 0)
                    <form action="{{ route('admin.perhitungan.proses') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg"
                            onclick="return confirm('Yakin ingin memulai proses perhitungan? Hasil perhitungan sebelumnya akan diganti.')">
                            <i class="fas fa-play"></i>
                            <span>Mulai Perhitungan</span>
                        </button>
                    </form>

                    @if ($sudahDihitung > 0)
                        <a href="{{ route('admin.perhitungan.recalculate') }}" class="btn btn-warning btn-lg"
                            onclick="return confirm('Hitung ulang dengan bobot AHP terbaru?')">
                            <i class="fas fa-redo"></i>
                            <span>Hitung Ulang</span>
                        </a>
                    @endif
                @else
                    <button type="button" class="btn btn-secondary btn-lg" disabled>
                        <i class="fas fa-lock"></i>
                        <span>Perhitungan Tidak Dapat Dilakukan</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if ($hasilPerhitungan && count($hasilPerhitungan) > 0)
        <!-- Bobot Kriteria -->
        <div class="content-card mb-4">
            <div class="card-header-modern">
                <h5 class="card-title">
                    <i class="fas fa-weight"></i>
                    Bobot Prioritas Kriteria (Hasil AHP)
                </h5>
            </div>

            <div class="criteria-grid">
                @foreach ($kriteria as $k)
                    <div class="criteria-card">
                        <div class="criteria-header">
                            <div class="criteria-code">{{ $k->kode_kriteria }}</div>
                            <div class="criteria-percentage">{{ number_format($k->bobot * 100, 2) }}%</div>
                        </div>
                        <div class="criteria-name">{{ $k->nama_kriteria }}</div>
                        <div class="criteria-progress">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: {{ $k->bobot * 100 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="criteria-weight">Bobot: {{ number_format($k->bobot, 4) }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Formula Perhitungan -->
        <div class="content-card">
            <div class="card-header-modern">
                <h5 class="card-title">
                    <i class="fas fa-function"></i>
                    Metode Perhitungan AHP
                </h5>
            </div>

            <div class="formula-section">
                <div class="formula-box">
                    <div class="formula-title">
                        <i class="fas fa-calculator"></i>
                        Rumus Perhitungan Skor Akhir
                    </div>
                    <div class="formula-content">
                        <div class="formula-main">
                            Skor Akhir = Σ (Bobot Kriteria × Nilai Sub-Kriteria)
                        </div>
                        <div class="formula-explanation">
                            <p><strong>Keterangan:</strong></p>
                            <ul>
                                @foreach ($kriteria as $k)
                                    <li>
                                        <span class="criteria-code-inline">{{ $k->kode_kriteria }}</span>
                                        = {{ $k->nama_kriteria }}
                                        <span class="weight-badge">{{ number_format($k->bobot, 4) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="validation-info">
                    <div class="validation-badge">
                        <i class="fas fa-shield-check"></i>
                        <div>
                            <strong>Validasi Konsistensi AHP</strong>
                            <p>CR = {{ number_format($ahpValidation['cr'], 4) }} ≤ 0.1 (Matriks Konsisten)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Validation Section */
        .validation-section {
            margin-bottom: 24px;
        }

        .validation-header {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 24px;
        }

        .validation-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            flex-shrink: 0;
        }

        .validation-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .validation-error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
        }

        .validation-content {
            flex: 1;
        }

        .validation-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 8px 0;
        }

        .validation-message {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
            line-height: 1.6;
        }

        .validation-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 0 24px 24px 24px;
            margin-top: 20px;
            border-top: 2px solid #f3f4f6;
            padding-top: 20px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .detail-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }

        .badge-success-custom {
            background: #d1fae5;
            color: #065f46;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .stat-card.stat-primary::before {
            background: linear-gradient(180deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .stat-card.stat-success::before {
            background: linear-gradient(180deg, #059669 0%, #10b981 100%);
        }

        .stat-card.stat-info::before {
            background: linear-gradient(180deg, #0c4a6e 0%, #0ea5e9 100%);
        }

        .stat-card.stat-warning::before {
            background: linear-gradient(180deg, #b45309 0%, #f59e0b 100%);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 12px;
        }

        .stat-primary .stat-icon {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .stat-success .stat-icon {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .stat-info .stat-icon {
            background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 100%);
        }

        .stat-warning .stat-icon {
            background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        }

        .stat-details {
            margin-bottom: 12px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            line-height: 1;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }

        .stat-progress {
            margin-top: 8px;
        }

        .progress-mini {
            height: 6px;
            background: #f3f4f6;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-mini .progress-bar {
            border-radius: 10px;
        }

        /* Action Panel */
        .action-panel {
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .action-info {
            display: flex;
            gap: 20px;
            flex: 1;
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            flex-shrink: 0;
        }

        .action-content {
            flex: 1;
        }

        .action-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 8px 0;
        }

        .action-description {
            font-size: 14px;
            color: #6b7280;
            margin: 0 0 12px 0;
            line-height: 1.6;
        }

        .action-requirements {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .requirement-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 500;
        }

        .requirement-complete {
            color: #059669;
        }

        .requirement-pending {
            color: #dc2626;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-lg {
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Criteria Grid */
        .criteria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 24px;
        }

        .criteria-card {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .criteria-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .criteria-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .criteria-code {
            background: #1e3a8a;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
        }

        .criteria-percentage {
            font-size: 20px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .criteria-name {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 12px;
        }

        .criteria-progress {
            margin-bottom: 8px;
        }

        .criteria-progress .progress {
            background: #e5e7eb;
            border-radius: 10px;
        }

        .criteria-weight {
            font-size: 12px;
            color: #6b7280;
            text-align: right;
        }

        /* Card Header Modern */
        .card-header-modern {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px;
            border-bottom: 2px solid #f3f4f6;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-left .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-left .card-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
        }

        /* Table Modern */
        .table-modern {
            margin: 0;
        }

        .table-modern thead th {
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px;
            border: none;
        }

        .table-modern tbody td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }

        .table-modern tbody tr:hover {
            background: #f9fafb;
        }

        /* Medal Badge */
        .medal-badge {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-weight: 700;
            font-size: 16px;
            color: white;
            margin: 0 auto;
        }

        .medal-1 {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }

        .medal-2 {
            background: linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);
        }

        .medal-3 {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .medal-badge i {
            font-size: 20px;
        }

        .ranking-number {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: #374151;
            margin: 0 auto;
        }

        /* NIS Badge */
        .nis-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            font-family: 'Courier New', monospace;
        }

        /* Student Info */
        .student-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-avatar {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: white;
            flex-shrink: 0;
        }

        .student-name {
            font-weight: 600;
            font-size: 14px;
            color: #111827;
        }

        /* Badge Kelas */
        .badge-kelas {
            display: inline-block;
            background: #e0e7ff;
            color: #3730a3;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        /* Score Display */
        .score-display {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .score-value {
            font-size: 16px;
            font-weight: 700;
            color: #1e3a8a;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
        }

        .status-lulus {
            background: #d1fae5;
            color: #065f46;
        }

        .status-tidak-lulus {
            background: #e5e7eb;
            color: #4b5563;
        }

        /* Table Footer */
        .table-footer {
            padding: 20px 24px;
            border-top: 2px solid #f3f4f6;
            background: #f9fafb;
        }

        .footer-text {
            margin: 0;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
        }

        .footer-text a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        /* Formula Section */
        .formula-section {
            padding: 24px;
        }

        .formula-box {
            background: #f0f9ff;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            border-left: 4px solid #1e3a8a;
        }

        .formula-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .formula-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        .formula-main {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            text-align: center;
            padding: 16px;
            background: #dbeafe;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .formula-explanation {
            font-size: 14px;
            color: #374151;
        }

        .formula-explanation ul {
            list-style: none;
            padding: 0;
            margin: 12px 0 0 0;
        }

        .formula-explanation li {
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .formula-explanation li:last-child {
            border-bottom: none;
        }

        .criteria-code-inline {
            display: inline-block;
            background: #1e3a8a;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 13px;
            margin-right: 8px;
        }

        .weight-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            margin-left: 8px;
        }

        /* Formula Example */
        .formula-example {
            background: #fef3c7;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            border-left: 4px solid #b45309;
        }

        .example-title {
            font-size: 16px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .example-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            font-size: 14px;
            color: #374151;
        }

        .example-list {
            list-style: none;
            padding: 0;
            margin: 12px 0;
        }

        .example-list li {
            padding: 8px 0;
            padding-left: 20px;
            position: relative;
        }

        .example-list li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: #b45309;
            font-weight: 700;
        }

        .calculation-steps {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #fbbf24;
        }

        .calculation-steps .step {
            padding: 10px;
            margin-bottom: 8px;
            background: #fef3c7;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }

        .calculation-steps .step.result {
            background: #10b981;
            color: white;
            font-size: 16px;
            font-weight: 700;
            text-align: center;
        }

        /* Validation Info */
        .validation-info {
            background: #d1fae5;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #059669;
        }

        .validation-badge {
            display: flex;
            align-items: center;
            gap: 16px;
            color: #065f46;
        }

        .validation-badge i {
            font-size: 32px;
        }

        .validation-badge strong {
            display: block;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .validation-badge p {
            margin: 0;
            font-size: 13px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .action-panel {
                flex-direction: column;
                align-items: stretch;
            }

            .action-info {
                flex-direction: column;
            }

            .action-buttons {
                width: 100%;
                flex-direction: column;
            }

            .action-buttons .btn-lg {
                width: 100%;
                justify-content: center;
            }

            .validation-header {
                flex-direction: column;
                text-align: center;
            }

            .card-header-modern {
                flex-direction: column;
                align-items: flex-start;
            }

            .criteria-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
