@extends('layouts.admin')

@section('title', 'Input Perbandingan Kriteria')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Input Perbandingan Kriteria AHP</h1>
        <p class="page-subtitle">Input nilai perbandingan berpasangan antar kriteria</p>
    </div>

    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <strong>Petunjuk:</strong> Bandingkan setiap pasangan kriteria dengan skala 1-9 dimana:
        <br>1 = Sama penting, 3 = Sedikit lebih penting, 5 = Lebih penting, 7 = Sangat lebih penting, 9 = Mutlak lebih
        penting
    </div>

    <div class="content-card">
        <h5 class="card-title mb-4">Perbandingan yang Belum Diinput</h5>

        @foreach ($missingComparisons as $index => $missing)
            <div class="comparison-card">
                <form action="{{ route('admin.ahp.store-comparison') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kriteria_1" value="{{ $missing['kriteria_1']->id }}">
                    <input type="hidden" name="kriteria_2" value="{{ $missing['kriteria_2']->id }}">

                    <div class="comparison-header">
                        <h6>Perbandingan {{ $index + 1 }}</h6>
                        <div class="criteria-comparison">
                            <div class="criteria-box">
                                <div class="criteria-code">{{ $missing['kriteria_1']->kode_kriteria }}</div>
                                <div class="criteria-name">{{ $missing['kriteria_1']->nama_kriteria }}</div>
                            </div>
                            <div class="vs-divider">VS</div>
                            <div class="criteria-box">
                                <div class="criteria-code">{{ $missing['kriteria_2']->kode_kriteria }}</div>
                                <div class="criteria-name">{{ $missing['kriteria_2']->nama_kriteria }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="comparison-input">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label class="form-label">Nilai Perbandingan</label>
                                <select class="form-select" name="nilai_perbandingan" required
                                    onchange="updateInterpretation(this, {{ $index }})">
                                    <option value="">Pilih Nilai</option>
                                    <option value="9">9 - Mutlak lebih penting</option>
                                    <option value="8">8</option>
                                    <option value="7">7 - Sangat lebih penting</option>
                                    <option value="6">6</option>
                                    <option value="5">5 - Lebih penting</option>
                                    <option value="4">4</option>
                                    <option value="3">3 - Sedikit lebih penting</option>
                                    <option value="2">2</option>
                                    <option value="1" selected>1 - Sama penting</option>
                                    <option value="0.5">1/2</option>
                                    <option value="0.333">1/3 - Sedikit kurang penting</option>
                                    <option value="0.25">1/4</option>
                                    <option value="0.2">1/5 - Kurang penting</option>
                                    <option value="0.167">1/6</option>
                                    <option value="0.143">1/7 - Sangat kurang penting</option>
                                    <option value="0.125">1/8</option>
                                    <option value="0.111">1/9 - Mutlak kurang penting</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Interpretasi</label>
                                <div class="interpretation-box" id="interpretation-{{ $index }}">
                                    {{ $missing['kriteria_1']->kode_kriteria }} sama penting dengan
                                    {{ $missing['kriteria_2']->kode_kriteria }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Keterangan (Opsional)</label>
                                <input type="text" class="form-control" name="keterangan"
                                    placeholder="Alasan perbandingan">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perbandingan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endforeach

        <div class="mt-4">
            <a href="{{ route('admin.ahp.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke AHP Management
            </a>
        </div>
    </div>

    <style>
        .comparison-card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f9fafb;
        }

        .comparison-header h6 {
            color: #1e3a8a;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .criteria-comparison {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .criteria-box {
            background: white;
            border: 2px solid #3b82f6;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            min-width: 200px;
        }

        .criteria-code {
            font-size: 18px;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 5px;
        }

        .criteria-name {
            font-size: 13px;
            color: #6b7280;
        }

        .vs-divider {
            background: #1e3a8a;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
        }

        .comparison-input {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
        }

        .interpretation-box {
            background: #dbeafe;
            padding: 10px 15px;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
            font-size: 14px;
            color: #1e3a8a;
            font-weight: 500;
        }
    </style>

    <script>
        function updateInterpretation(select, index) {
            const value = parseFloat(select.value);
            const k1 = '{{ $missing['kriteria_1']->kode_kriteria ?? '' }}';
            const k2 = '{{ $missing['kriteria_2']->kode_kriteria ?? '' }}';

            let interpretation = '';

            if (value == 1) {
                interpretation = `${k1} sama penting dengan ${k2}`;
            } else if (value > 1) {
                let level = '';
                if (value <= 2) level = 'sedikit lebih penting dari';
                else if (value <= 4) level = 'lebih penting dari';
                else if (value <= 6) level = 'sangat lebih penting dari';
                else if (value <= 8) level = 'mutlak lebih penting dari';
                else level = 'ekstrim lebih penting dari';

                interpretation = `${k1} ${level} ${k2}`;
            } else if (value < 1) {
                let level = '';
                if (value >= 0.5) level = 'sedikit kurang penting dari';
                else if (value >= 0.25) level = 'kurang penting dari';
                else if (value >= 0.15) level = 'sangat kurang penting dari';
                else level = 'mutlak kurang penting dari';

                interpretation = `${k1} ${level} ${k2}`;
            }

            document.getElementById(`interpretation-${index}`).textContent = interpretation;
        }
    </script>
@endsection
