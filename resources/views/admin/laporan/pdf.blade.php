<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Seleksi Beasiswa</title>
    <style>
        @page {
            margin: 1.5cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 15px;
        }

        .school-name {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0;
        }

        .school-address {
            font-size: 9pt;
            margin: 3px 0;
        }

        .doc-title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10pt;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px 6px;
            text-align: left;
        }

        th {
            background-color: #1e3a8a;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .badge-lulus {
            background: #059669;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9pt;
            font-weight: bold;
        }

        .badge-tidak-lulus {
            background: #6b7280;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9pt;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .signature-section {
            margin-top: 40px;
            float: right;
            width: 200px;
            text-align: center;
        }

        .signature-section .date {
            margin-bottom: 70px;
        }

        .signature-section .name {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="school-name">MA MUHAMMADIYAH 1 BANDUNG</h1>
        <p class="school-address">
            Jl. Otto Iskandar Dinata No.77B-95, Pelindung Hewan, Kec. Astanaanyar<br>
            Kota Bandung, Jawa Barat 40243 | Telp: (022) 4262873
        </p>
    </div>

    <h2 class="doc-title">LAPORAN HASIL SELEKSI PENERIMA BEASISWA</h2>
    <p style="text-align: center; margin-bottom: 20px;">
        Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}
    </p>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="50">Rank</th>
                <th width="80">NIS</th>
                <th>Nama Siswa</th>
                <th width="50">Kelas</th>
                <th width="80">Skor Akhir</th>
                <th width="80">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil as $index => $h)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center"><strong>{{ $h->ranking }}</strong></td>
                    <td>{{ $h->siswa->nis }}</td>
                    <td>{{ $h->siswa->nama_lengkap }}</td>
                    <td class="text-center">{{ $h->siswa->kelas }}</td>
                    <td class="text-center"><strong>{{ number_format($h->skor_akhir, 6) }}</strong></td>
                    <td class="text-center">
                        @if ($h->status_kelulusan == 'lulus')
                            <span class="badge-lulus">LULUS</span>
                        @else
                            <span class="badge-tidak-lulus">TIDAK LULUS</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 30px; font-size: 10pt;">
        <strong>Keterangan:</strong><br>
        Perhitungan menggunakan metode Analytical Hierarchy Process (AHP) dengan 4 kriteria penilaian:
    </p>
    <ul style="font-size: 10pt; margin-left: 20px;">
        @foreach ($kriteria as $k)
            <li>{{ $k->kode_kriteria }}: {{ $k->nama_kriteria }} (Bobot: {{ number_format($k->bobot * 100, 2) }}%)</li>
        @endforeach
    </ul>

    <div class="signature-section">
        <p class="date">Bandung, {{ date('d F Y') }}</p>
        <p>Kepala Madrasah</p>
        <br><br>
        <p class="name">Drs. Musa Muhammad Ahmad, M.E.Sy.</p>
    </div>

    <div class="footer">
        Dokumen ini dicetak secara otomatis dari Sistem Pendukung Keputusan Beasiswa MA Muhammadiyah 1 Bandung
    </div>
</body>

</html>
