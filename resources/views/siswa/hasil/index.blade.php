@extends('layouts.siswa')

@section('title', 'Hasil Seleksi')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Hasil Seleksi Beasiswa</h1>
        <p class="page-subtitle">Hasil penilaian dan ranking Anda dalam seleksi beasiswa</p>
    </div>

    @if ($hasil)
        <div class="row">
            <!-- Result Summary Card -->
            <div class="col-lg-4 mb-4">
                <div class="content-card result-card">
                    <div class="result-header {{ $hasil->status_kelulusan == 'lulus' ? 'bg-success' : 'bg-secondary' }}">
                        <div class="result-icon">
                            <i class="fas {{ $hasil->status_kelulusan == 'lulus' ? 'fa-trophy' : 'fa-user-graduate' }}"></i>
                        </div>
                        <div class="result-status">
                            {{ $hasil->status_kelulusan == 'lulus' ? 'SELAMAT! ANDA LULUS' : 'TERIMA KASIH ATAS PARTISIPASINYA' }}
                        </div>
                    </div>

                    <div class="result-details">
                        <div class="detail-item">
                            <div class="detail-label">Ranking Anda</div>
                            <div class="detail-value ranking-{{ min($hasil->ranking, 3) }}">
                                #{{ $hasil->ranking }}
                                @if ($hasil->ranking <= 3)
                                    <i class="fas fa-medal ms-2"></i>
                                @endif
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Skor Akhir</div>
                            <div class="detail-value">{{ number_format($hasil->skor_akhir, 4) }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                @if ($hasil->status_kelulusan == 'lulus')
                                    <span class="badge bg-success">Penerima Beasiswa</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Lolos</span>
                                @endif
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Tanggal Pengumuman</div>
                            <div class="detail-value">{{ $hasil->tanggal_perhitungan->format('d F Y') }}</div>
                        </div>
                    </div>

                    <div class="result-actions">
                        <a href="{{ route('siswa.hasil.cetak-pdf') }}" class="btn btn-primary w-100">
                            <i class="fas fa-download"></i> Unduh Sertifikat Hasil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Detail Calculations -->
            <div class="col-lg-8 mb-4">
                <!-- Your Score Breakdown -->
                <div class="content-card mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-chart-bar text-primary"></i> Rincian Penilaian Anda
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Kriteria</th>
                                    <th width="100">Bobot</th>
                                    <th>Kategori Anda</th>
                                    <th width="100">Nilai</th>
                                    <th width="120">Kontribusi Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penilaian as $p)
                                    <tr>
                                        <td>
                                            <strong>{{ $p->kriteria->kode_kriteria }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $p->kriteria->nama_kriteria }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="weight-badge">{{ number_format($p->kriteria->bobot * 100, 1) }}%</span>
                                        </td>
                                        <td>
                                            <div class="category-info">
                                                <strong>{{ $p->subKriteria->nama_sub_kriteria }}</strong>
                                                @if ($p->subKriteria->kategori)
                                                    <br><small class="text-muted">{{ $p->subKriteria->kategori }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="value-badge">{{ number_format($p->subKriteria->nilai_sub, 4) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <strong class="score-contribution">
                                                {{ number_format($p->kriteria->bobot * $p->subKriteria->nilai_sub, 4) }}
                                            </strong>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-success">
                                    <td colspan="4" class="text-end"><strong>TOTAL SKOR AKHIR ANDA:</strong></td>
                                    <td class="text-center">
                                        <strong class="final-score">{{ number_format($hasil->skor_akhir, 4) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- AHP Method Explanation -->
                <div class="content-card mb-4">
                    <h5 class="section-title">
                        <i class="fas fa-info-circle text-primary"></i> Tentang Metode Penilaian (AHP)
                    </h5>

                    <div class="method-explanation">
                        <div class="explanation-box">
                            <h6><i class="fas fa-graduation-cap"></i> Analytical Hierarchy Process (AHP)</h6>
                            <p>Sistem seleksi beasiswa menggunakan metode AHP untuk menentukan penerima beasiswa secara
                                objektif dan adil.
                                Metode ini membandingkan setiap kriteria secara berpasangan untuk mendapatkan bobot yang
                                akurat.</p>

                            <div class="process-steps">
                                <div class="step-item">
                                    <div class="step-number">1</div>
                                    <div class="step-content">
                                        <strong>Perbandingan Kriteria</strong>
                                        <p>Setiap kriteria dibandingkan secara berpasangan oleh tim penilai</p>
                                    </div>
                                </div>
                                <div class="step-item">
                                    <div class="step-number">2</div>
                                    <div class="step-content">
                                        <strong>Perhitungan Bobot</strong>
                                        <p>Dari perbandingan tersebut dihitung bobot prioritas setiap kriteria</p>
                                    </div>
                                </div>
                                <div class="step-item">
                                    <div class="step-number">3</div>
                                    <div class="step-content">
                                        <strong>Penilaian Siswa</strong>
                                        <p>Data siswa dinilai berdasarkan setiap kriteria dan dikalikan bobotnya</p>
                                    </div>
                                </div>
                                <div class="step-item">
                                    <div class="step-number">4</div>
                                    <div class="step-content">
                                        <strong>Ranking Final</strong>
                                        <p>Siswa diurutkan berdasarkan skor akhir dari yang tertinggi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Criteria Weights -->
                @if ($priorityVector && count($priorityVector) > 0)
                    <div class="content-card mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-balance-scale text-primary"></i> Bobot Kriteria Penilaian
                        </h5>

                        <div class="criteria-weights">
                            @foreach ($kriteria as $i => $k)
                                <div class="weight-item">
                                    <div class="weight-header">
                                        <div class="criteria-info">
                                            <span class="criteria-code">{{ $k->kode_kriteria }}</span>
                                            <span class="criteria-name">{{ $k->nama_kriteria }}</span>
                                        </div>
                                        <div class="weight-percentage">{{ number_format($priorityVector[$i] * 100, 1) }}%
                                        </div>
                                    </div>
                                    <div class="weight-bar">
                                        <div class="weight-fill" style="width: {{ $priorityVector[$i] * 100 }}%"></div>
                                    </div>
                                    <div class="weight-description">
                                        <small class="text-muted">{{ $k->keterangan }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Matrix Display (Collapsible) -->
                    <div class="content-card mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-table text-primary"></i> Detail Perhitungan Matrix AHP
                        </h5>

                        <div class="accordion" id="matrixAccordion">
                            <!-- Comparison Matrix -->
                            @if ($comparisonMatrix && count($comparisonMatrix) > 0)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingComparison">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseComparison" aria-expanded="false">
                                            <i class="fas fa-table me-2"></i> Matrix Perbandingan Kriteria
                                        </button>
                                    </h2>
                                    <div id="collapseComparison" class="accordion-collapse collapse"
                                        data-bs-parent="#matrixAccordion">
                                        <div class="accordion-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered matrix-table">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th width="120">Kriteria</th>
                                                            @foreach ($kriteria as $k)
                                                                <th width="80" class="text-center">
                                                                    {{ $k->kode_kriteria }}</th>
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
                                                                    <td class="text-center">
                                                                        @if ($i == $j)
                                                                            <span class="diagonal-value">1.000</span>
                                                                        @else
                                                                            {{ number_format($comparisonMatrix[$i][$j], 3) }}
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
                                                    Matrix ini menunjukkan perbandingan tingkat kepentingan antar kriteria.
                                                    Nilai > 1 berarti kriteria baris lebih penting dari kriteria kolom.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Normalized Matrix -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingNormalized">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseNormalized"
                                            aria-expanded="false">
                                            <i class="fas fa-calculator me-2"></i> Matrix Normalisasi & Bobot
                                        </button>
                                    </h2>
                                    <div id="collapseNormalized" class="accordion-collapse collapse"
                                        data-bs-parent="#matrixAccordion">
                                        <div class="accordion-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered matrix-table">
                                                    <thead class="table-success">
                                                        <tr>
                                                            <th width="120">Kriteria</th>
                                                            @foreach ($kriteria as $k)
                                                                <th width="80" class="text-center">
                                                                    {{ $k->kode_kriteria }}</th>
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
                                                                    <td class="text-center">
                                                                        {{ number_format($normalizedMatrix[$i][$j], 4) }}
                                                                    </td>
                                                                @endforeach
                                                                <td class="text-center weight-cell">
                                                                    <strong>{{ number_format($priorityVector[$i], 4) }}</strong>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="matrix-info">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i>
                                                    Matrix normalisasi diperoleh dengan membagi setiap elemen dengan jumlah
                                                    kolomnya.
                                                    Bobot adalah rata-rata dari setiap baris matrix normalisasi.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Consistency Check -->
                            @if ($ahpCalculation)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingConsistency">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseConsistency"
                                            aria-expanded="false">
                                            <i class="fas fa-check-circle me-2"></i> Uji Konsistensi
                                        </button>
                                    </h2>
                                    <div id="collapseConsistency" class="accordion-collapse collapse"
                                        data-bs-parent="#matrixAccordion">
                                        <div class="accordion-body">
                                            <div class="consistency-info">
                                                <div class="consistency-metrics">
                                                    <div class="metric">
                                                        <div class="metric-label">Lambda Max (λmax)</div>
                                                        <div class="metric-value">
                                                            {{ number_format($ahpCalculation->lambda_max, 4) }}</div>
                                                    </div>
                                                    <div class="metric">
                                                        <div class="metric-label">Consistency Index (CI)</div>
                                                        <div class="metric-value">
                                                            {{ number_format($ahpCalculation->consistency_index, 4) }}
                                                        </div>
                                                    </div>
                                                    <div class="metric">
                                                        <div class="metric-label">Consistency Ratio (CR)</div>
                                                        <div
                                                            class="metric-value {{ $ahpCalculation->is_consistent ? 'text-success' : 'text-danger' }}">
                                                            {{ number_format($ahpCalculation->consistency_ratio, 4) }}
                                                            @if ($ahpCalculation->is_consistent)
                                                                <small class="text-success">✓ Konsisten</small>
                                                            @else
                                                                <small class="text-danger">✗ Tidak Konsisten</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="consistency-explanation">
                                                    <h6>Penjelasan Uji Konsistensi:</h6>
                                                    <ul>
                                                        <li><strong>CR ≤ 0.1:</strong> Matrix perbandingan konsisten dan
                                                            dapat dipercaya</li>
                                                        <li><strong>CR > 0.1:</strong> Matrix perbandingan tidak konsisten,
                                                            perlu diperbaiki</li>
                                                    </ul>
                                                    <p class="mb-0">
                                                        <i
                                                            class="fas {{ $ahpCalculation->is_consistent ? 'fa-check-circle text-success' : 'fa-exclamation-triangle text-warning' }}"></i>
                                                        {{ $ahpCalculation->is_consistent ? 'Perhitungan ini menggunakan matrix yang konsisten dan valid.' : 'Matrix yang digunakan dalam perhitungan ini konsisten namun mendekati batas toleransi.' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- No Results -->
        <div class="content-card text-center py-5">
            <div class="empty-state">
                <i class="fas fa-hourglass-half fa-4x text-muted mb-4"></i>
                <h4>Hasil Seleksi Belum Tersedia</h4>
                <p class="text-muted">Proses seleksi masih berlangsung. Hasil akan diumumkan setelah semua tahap evaluasi
                    selesai.</p>
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    @endif

    <style>
        /* Result Card Styling */
        .result-card {
            overflow: hidden;
        }

        .result-header {
            padding: 25px;
            text-align: center;
            color: white;
            margin: -25px -25px 20px -25px;
        }

        .result-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .result-status {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .result-details {
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }

        .detail-value {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .ranking-1 {
            color: #f59e0b;
        }

        .ranking-2 {
            color: #9ca3af;
        }

        .ranking-3 {
            color: #f97316;
        }

        /* Section Titles */
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Table Styling */
        .weight-badge {
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
        }

        .value-badge {
            background: #d1fae5;
            color: #059669;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
        }

        .score-contribution {
            color: #1e3a8a;
            font-size: 14px;
        }

        .final-score {
            color: #059669;
            font-size: 18px;
            background: #d1fae5;
            padding: 8px 16px;
            border-radius: 8px;
        }

        /* Method Explanation */
        .method-explanation {
            margin-top: 20px;
        }

        .explanation-box {
            background: #f0f9ff;
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid #3b82f6;
        }

        .explanation-box h6 {
            color: #1e3a8a;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .explanation-box p {
            color: #374151;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .process-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .step-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .step-number {
            width: 30px;
            height: 30px;
            background: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .step-content strong {
            display: block;
            color: #111827;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .step-content p {
            font-size: 12px;
            color: #6b7280;
            margin: 0;
            line-height: 1.4;
        }

        /* Criteria Weights */
        .criteria-weights {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .weight-item {
            background: #f9fafb;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .weight-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .criteria-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .criteria-code {
            background: #1e3a8a;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
        }

        .criteria-name {
            font-weight: 600;
            color: #111827;
            font-size: 14px;
        }

        .weight-percentage {
            font-size: 18px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .weight-bar {
            height: 8px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .weight-fill {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6 0%, #1e3a8a 100%);
            border-radius: 10px;
            transition: width 0.8s ease;
        }

        .weight-description {
            margin-top: 8px;
        }

        /* Matrix Tables */
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

        .diagonal-value {
            color: #059669;
            font-weight: 700;
            background: #d1fae5;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .weight-cell {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
        }

        .weight-cell strong {
            color: #1e3a8a;
            background: white;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .matrix-info {
            margin-top: 15px;
            padding: 12px;
            background: #f0f9ff;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }

        /* Accordion Styling */
        .accordion-button {
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            border: none;
            padding: 15px 20px;
        }

        .accordion-button:not(.collapsed) {
            background: #3b82f6;
            color: white;
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border: none;
        }

        .accordion-body {
            padding: 20px;
        }

        /* Consistency Info */
        .consistency-info {
            background: #f9fafb;
            padding: 20px;
            border-radius: 10px;
        }

        .consistency-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .metric {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }

        .metric-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .metric-value {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .consistency-explanation {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .consistency-explanation h6 {
            color: #1e3a8a;
            margin-bottom: 15px;
        }

        .consistency-explanation ul {
            margin-bottom: 15px;
        }

        .consistency-explanation li {
            margin-bottom: 5px;
            font-size: 14px;
        }

        /* Rankings List */
        .rankings-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .ranking-item {
            background: #f9fafb;
            padding: 15px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .ranking-item.current-user {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: #3b82f6;
            transform: scale(1.02);
        }

        .ranking-number {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: white;
            flex-shrink: 0;
        }

        .rank-1 {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }

        .rank-2 {
            background: linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);
        }

        .rank-3 {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .ranking-number:not(.rank-1):not(.rank-2):not(.rank-3) {
            background: #6b7280;
        }

        .ranking-info {
            flex: 1;
        }

        .ranking-name {
            font-weight: 600;
            color: #111827;
            font-size: 14px;
        }

        .ranking-class {
            font-size: 12px;
            color: #6b7280;
        }

        .ranking-score {
            font-weight: 700;
            color: #1e3a8a;
            font-size: 14px;
            min-width: 80px;
            text-align: center;
        }

        .ranking-status {
            min-width: 80px;
            text-align: center;
        }

        /* Empty State */
        .empty-state {
            padding: 60px 20px;
        }

        .empty-state h4 {
            color: #374151;
            margin-bottom: 15px;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 16px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .process-steps {
                grid-template-columns: 1fr;
            }

            .consistency-metrics {
                grid-template-columns: 1fr;
            }

            .weight-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .criteria-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .ranking-item {
                flex-wrap: wrap;
                gap: 10px;
            }

            .matrix-table {
                font-size: 11px;
            }

            .matrix-table th,
            .matrix-table td {
                padding: 6px 4px;
            }
        }

        /* Animation */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-card {
            animation: slideInUp 0.6s ease-out;
        }

        .weight-fill {
            animation: fillAnimation 1.5s ease-out;
        }

        @keyframes fillAnimation {
            from {
                width: 0%;
            }
        }
    </style>

    <script>
        // Auto-expand first accordion item if available
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scroll behavior for anchors
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Animate weight bars on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const weightFills = entry.target.querySelectorAll('.weight-fill');
                        weightFills.forEach((fill, index) => {
                            setTimeout(() => {
                                fill.style.animation =
                                    'fillAnimation 1s ease-out forwards';
                            }, index * 200);
                        });
                    }
                });
            }, observerOptions);

            // Observe weight sections
            document.querySelectorAll('.criteria-weights').forEach(section => {
                observer.observe(section);
            });
        });
    </script>
@endsection
