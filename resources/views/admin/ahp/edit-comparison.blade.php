@extends('layouts.admin')

@section('title', 'Edit Perbandingan Kriteria')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Perbandingan Kriteria AHP</h1>
        <p class="page-subtitle">Ubah nilai perbandingan antara dua kriteria</p>
    </div>

    <div class="content-card">
        <div class="card-body">
            <div class="comparison-card">
                <form action="{{ route('admin.ahp.update-comparison', $comparison->id) }}" method="POST">
                    @csrf
                    <div class="comparison-header">
                        <div class="criteria-comparison">
                            <div class="criteria-box">
                                <div class="criteria-code">{{ $comparison->kriteriaFirst->kode_kriteria }}</div>
                                <div class="criteria-name">{{ $comparison->kriteriaFirst->nama_kriteria }}</div>
                            </div>
                            <div class="vs-divider">VS</div>
                            <div class="criteria-box">
                                <div class="criteria-code">{{ $comparison->kriteriaSecond->kode_kriteria }}</div>
                                <div class="criteria-name">{{ $comparison->kriteriaSecond->nama_kriteria }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="comparison-input">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label for="nilai_perbandingan" class="form-label">Nilai Perbandingan</label>
                                <select class="form-select" name="nilai_perbandingan" id="nilai_perbandingan" required
                                    onchange="updateInterpretation(this)">
                                    @php
                                        $options = [
                                            '9' => '9 - Mutlak lebih penting',
                                            '8' => '8',
                                            '7' => '7 - Sangat lebih penting',
                                            '6' => '6',
                                            '5' => '5 - Lebih penting',
                                            '4' => '4',
                                            '3' => '3 - Sedikit lebih penting',
                                            '2' => '2',
                                            '1' => '1 - Sama penting',
                                            '0.5' => '1/2',
                                            '0.333' => '1/3 - Sedikit kurang penting',
                                            '0.25' => '1/4',
                                            '0.2' => '1/5 - Kurang penting',
                                            '0.167' => '1/6',
                                            '0.143' => '1/7 - Sangat kurang penting',
                                            '0.125' => '1/8',
                                            '0.111' => '1/9 - Mutlak kurang penting',
                                        ];
                                    @endphp
                                    @foreach ($options as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ (float) $comparison->nilai_perbandingan == (float) $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Interpretasi</label>
                                <div class="interpretation-box" id="interpretation-box">
                                    {{-- Initial interpretation will be set by JS --}}
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.ahp.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
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
            min-height: 40px;
        }
    </style>

    <script>
        function updateInterpretation(select) {
            const value = parseFloat(select.value);
            const k1 = '{{ $comparison->kriteriaFirst->kode_kriteria }}';
            const k2 = '{{ $comparison->kriteriaSecond->kode_kriteria }}';
            let interpretation = '';

            if (value === 1) {
                interpretation = `${k1} sama penting dengan ${k2}`;
            } else if (value > 1) {
                let level = 'lebih penting dari';
                if (value <= 2) level = 'sedikit lebih penting dari';
                else if (value > 4 && value <= 6) level = 'sangat lebih penting dari';
                else if (value > 6) level = 'mutlak lebih penting dari';
                interpretation = `${k1} ${level} ${k2}`;
            } else if (value < 1) {
                let level = 'kurang penting dari';
                if (value >= 0.5) level = 'sedikit kurang penting dari';
                else if (value < 0.25 && value >= 0.15) level = 'sangat kurang penting dari';
                else if (value < 0.15) level = 'mutlak kurang penting dari';
                interpretation = `${k1} ${level} ${k2}`;
            }
            document.getElementById('interpretation-box').textContent = interpretation;
        }

        // Trigger on page load to show initial interpretation
        document.addEventListener('DOMContentLoaded', function() {
            updateInterpretation(document.getElementById('nilai_perbandingan'));
        });
    </script>
@endsection
