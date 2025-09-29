<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hasil Seleksi Beasiswa</title>
    <style>
        @page {
            margin: 2cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 15px;
        }

        .logo-section {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .logo {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
        }

        .school-info {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .school-name {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .school-address {
            font-size: 10pt;
            margin: 5px 0;
        }

        .doc-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 30px 0 5px 0;
        }

        .doc-number {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 25px;
        }

        .content {
            margin: 20px 0;
        }

        .section-title {
            font-weight: bold;
            font-size: 12pt;
            margin: 20px 0 10px 0;
            padding: 5px 0;
            border-bottom: 2px solid #1e3a8a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .info-table td {
            padding: 8px 10px;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 180px;
            font-weight: bold;
        }

        .info-table td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        .result-table {
            border: 1px solid #000;
        }

        .result-table th,
        .result-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .result-table th {
            background-color: #1e3a8a;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .result-box {
            border: 3px solid #1e3a8a;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            background-color: #f0f4ff;
        }

        .result-status {
            font-size: 20pt;
            font-weight: bold;
            color: #1e3a8a;
            margin: 10px 0;
        }

        .result-status.lulus {
            color: #059669;
        }

        .result-status.tidak-lulus {
            color: #dc2626;
        }

        .signature-section {
            margin-top: 50px;
        }

        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }

        .signature-box .date {
            margin-bottom: 80px;
        }

        .signature-box .name {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .note {
            font-size: 10pt;
            font-style: italic;
            color: #666;
            margin-top: 20px;
            padding: 10px;
            border-left: 4px solid #1e3a8a;
            background-color: #f9fafb;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <!-- Header Kop Surat -->
    <div class="header">
        <div class="logo-section">
            <div class="school-info">
                <h1 class="school-name">MA Muhammadiyah 1 Bandung</h1>
                <p class="school-address">
                    Jl. Otto Iskandar Dinata No.77B-95, Pelindung Hewan, Kec. Astanaanyar<br>
                    Kota Bandung, Jawa Barat 40243<br>
                    Telp: (022) 4262873 | Email: ma.muh1bandung@gmail.com
                </p>
            </div>
        </div>
    </div>

    <!-- Judul Dokumen -->
    <h2 class="doc-title">HASIL SELEKSI PENERIMA BEASISWA</h2>
    <p class="doc-number">Nomor:
        {{ str_pad($hasil->id, 4, '0', STR_PAD_LEFT) }}/BS-MA/{{ date('m') }}/{{ date('Y') }}</p>

    <!-- Isi Konten -->
    <div class="content">
        <p>
            Berdasarkan hasil seleksi calon penerima beasiswa menggunakan metode Analytical Hierarchy Process (AHP),
            dengan ini kami sampaikan hasil seleksi untuk:
        </p>

        <!-- Data Siswa -->
        <div class="section-title">I. DATA SISWA</div>
        <table class="info-table">
            <tr>
                <td>Nomor Induk Siswa (NIS)</td>
                <td>:</td>
                <td>{{ $siswa->nis }}</td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>{{ $siswa->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $siswa->kelas }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $siswa->alamat }}</td>
            </tr>
        </table>

        <!-- Hasil Penilaian -->
        <div class="section-title">II. HASIL PENILAIAN KRITERIA</div>
        <table class="result-table">
            <thead>
                <tr>
                    <th width="40">No</th>
                    <th>Kriteria</th>
                    <th width="100">Bobot</th>
                    <th>Nilai Sub-Kriteria</th>
                    <th width="100">Skor</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($penilaian as $p)
                    <tr>
                        <td style="text-align: center;">{{ $no++ }}</td>
                        <td>{{ $p->kriteria->nama_kriteria }}</td>
                        <td style="text-align: center;">{{ number_format($p->kriteria->bobot, 4) }}</td>
                        <td>{{ $p->subKriteria->nama_sub_kriteria }}
                            ({{ number_format($p->subKriteria->nilai_sub, 4) }})</td>
                        <td style="text-align: center;">
                            <strong>{{ number_format($p->kriteria->bobot * $p->subKriteria->nilai_sub, 6) }}</strong>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">TOTAL SKOR AKHIR:</td>
                    <td style="text-align: center; font-weight: bold; font-size: 14pt;">
                        {{ number_format($hasil->skor_akhir, 6) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Hasil Keputusan -->
        <div class="section-title">III. HASIL KEPUTUSAN</div>
        <div class="result-box">
            <p style="margin: 0; font-size: 12pt;">Dengan skor akhir
                <strong>{{ number_format($hasil->skor_akhir, 6) }}</strong> dan ranking
                ke-<strong>{{ $hasil->ranking }}</strong> dari {{ \App\Models\HasilPerhitungan::count() }} peserta,
            </p>
            <p class="result-status {{ $hasil->status_kelulusan }}">
                @if ($hasil->status_kelulusan == 'lulus')
                    ✓ LULUS SELEKSI BEASISWA
                @else
                    TIDAK LULUS SELEKSI BEASISWA
                @endif
            </p>
        </div>

        @if ($hasil->status_kelulusan == 'lulus')
            <div class="note">
                <strong>Catatan:</strong><br>
                Bagi siswa yang dinyatakan lulus, diharapkan untuk melengkapi berkas administrasi beasiswa
                ke bagian kesiswaan paling lambat 7 hari setelah pengumuman ini dikeluarkan.
            </div>
        @endif

        <!-- Tanda Tangan -->
        <div class="signature-section clearfix">
            <div class="signature-box">
                <p class="date">Bandung, {{ date('d F Y') }}</p>
                <p>Kepala Madrasah</p>
                <br><br><br>
                <p class="name">Drs. Musa Muhammad Ahmad, M.E.Sy.</p>
                <p>NIP. -</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Dokumen ini dicetak secara otomatis dari Sistem Pendukung Keputusan Beasiswa MA Muhammadiyah 1 Bandung
    </div>
</body>

</html>
