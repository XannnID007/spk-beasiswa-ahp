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
            line-height: 1.6;
            color: #000;
        }

        /* Header dengan Logo dan Kop Surat */
        .header {
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .logo-section {
            display: table-cell;
            width: 100px;
            vertical-align: middle;
            text-align: center;
        }

        .logo-section img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .school-info {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 0 20px;
        }

        .school-name {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .school-address {
            font-size: 10pt;
            margin: 5px 0 0 0;
            line-height: 1.4;
        }

        .school-contact {
            font-size: 9pt;
            margin: 3px 0 0 0;
            font-style: italic;
        }

        /* Judul Dokumen */
        .document-title {
            text-align: center;
            margin: 30px 0 10px 0;
        }

        .doc-title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .doc-number {
            font-size: 10pt;
            margin: 0;
        }

        /* Pernyataan Pembuka */
        .opening-statement {
            text-align: justify;
            margin: 25px 0;
            line-height: 1.8;
        }

        .opening-statement p {
            margin: 0 0 12px 0;
            text-indent: 50px;
        }

        /* Section Title */
        .section-title {
            font-weight: bold;
            font-size: 11pt;
            margin: 25px 0 15px 0;
            text-transform: uppercase;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px 6px;
            text-align: left;
        }

        table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
        }

        table td {
            font-size: 10pt;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Badge Status */
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
            display: inline-block;
        }

        .badge-lulus {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .badge-tidak-lulus {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Keterangan */
        .criteria-info {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .criteria-info p {
            margin: 0 0 8px 0;
            font-size: 10pt;
        }

        .criteria-info ul {
            margin: 5px 0 0 20px;
            padding: 0;
        }

        .criteria-info li {
            margin-bottom: 5px;
            font-size: 10pt;
        }

        /* Tanda Tangan */
        .signature-section {
            margin-top: 50px;
            page-break-inside: avoid;
        }

        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }

        .signature-date {
            margin-bottom: 20px;
        }

        .signature-position {
            margin-bottom: 10px;
            font-weight: normal;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .signature-nip {
            font-size: 10pt;
            margin-top: 5px;
        }

        /* Footer */
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

        /* Clearfix */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Ranking Number Style */
        .ranking-number {
            font-weight: bold;
            font-size: 11pt;
        }
    </style>
</head>

<body>
    <!-- Header dengan Kop Surat -->
    <div class="header">
        <div class="header-content">
            <div class="logo-section">
                <img src="{{ public_path('img/logo.jpg') }}" alt="Logo Sekolah">
            </div>
            <div class="school-info">
                <div class="school-name">Madrasah Aliyah Muhammadiyah 1 Bandung</div>
                <div class="school-address">
                    Jl. Otto Iskandar Dinata No.77B-95, Pelindung Hewan, Kec. Astanaanyar<br>
                    Kota Bandung, Jawa Barat 40243
                </div>
                <div class="school-contact">
                    Telp: (022) 4262873 | Email: ma.muh1bandung@gmail.com
                </div>
            </div>
            <div class="logo-section">
                <!-- Spacer untuk simetri -->
            </div>
        </div>
    </div>

    <!-- Judul Dokumen -->
    <div class="document-title">
        <div class="doc-title">Laporan Hasil Seleksi Penerima Beasiswa</div>
        <div class="doc-number">Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</div>
    </div>

    <!-- Pernyataan Pembuka -->
    <div class="opening-statement">
        <p>
            Berdasarkan hasil seleksi calon penerima beasiswa yang telah dilaksanakan dengan menggunakan
            metode <em>Analytical Hierarchy Process</em> (AHP), dengan ini kami menyampaikan laporan hasil
            seleksi penerima beasiswa MA Muhammadiyah 1 Bandung.
        </p>
        <p>
            Proses seleksi dilakukan secara objektif dengan mempertimbangkan empat kriteria penilaian
            utama yang telah ditetapkan. Setiap siswa dinilai berdasarkan kriteria tersebut dan dihitung
            skor akhirnya untuk menentukan peringkat dan status kelulusan.
        </p>
        <p>
            Berikut adalah daftar hasil seleksi calon penerima beasiswa yang telah diurutkan berdasarkan
            peringkat dari yang tertinggi hingga terendah:
        </p>
    </div>

    <!-- Section Title -->
    <div class="section-title">Daftar Hasil Seleksi Penerima Beasiswa</div>

    <!-- Tabel Hasil -->
    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th width="60">Ranking</th>
                <th width="90">NIS</th>
                <th>Nama Lengkap</th>
                <th width="60">Kelas</th>
                <th width="100">Skor Akhir</th>
                <th width="100">Status Kelulusan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil as $index => $h)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        <span class="ranking-number">{{ $h->ranking }}</span>
                    </td>
                    <td class="text-center">{{ $h->siswa->nis }}</td>
                    <td>{{ $h->siswa->nama_lengkap }}</td>
                    <td class="text-center">{{ $h->siswa->kelas }}</td>
                    <td class="text-center">{{ number_format($h->skor_akhir, 4) }}</td>
                    <td class="text-center">
                        @if ($h->status_kelulusan == 'lulus')
                            <span class="badge badge-lulus">LULUS</span>
                        @else
                            <span class="badge badge-tidak-lulus">TIDAK LULUS</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Keterangan Kriteria -->
    <div class="criteria-info">
        <p><strong>Keterangan Kriteria Penilaian:</strong></p>
        <p>Perhitungan menggunakan metode <em>Analytical Hierarchy Process</em> (AHP) dengan 4 (empat) kriteria
            penilaian sebagai berikut:</p>
        <ul>
            @foreach ($kriteria as $k)
                <li>
                    <strong>{{ $k->kode_kriteria }}</strong> - {{ $k->nama_kriteria }}
                    (Bobot: {{ number_format($k->bobot, 4) }} atau {{ number_format($k->bobot * 100, 2) }}%)
                </li>
            @endforeach
        </ul>
        <p style="margin-top: 10px;">
            Skor akhir diperoleh dari penjumlahan hasil perkalian antara bobot kriteria dengan nilai
            sub-kriteria yang diperoleh setiap siswa. Siswa dengan skor akhir tertinggi mendapatkan
            peringkat terbaik.
        </p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section clearfix">
        <div class="signature-box">
            <div class="signature-date">
                Bandung, {{ date('d F Y') }}
            </div>
            <div class="signature-position">
                Kepala Madrasah
            </div>
            <div style="margin: 80px 0 5px 0;">
                <!-- Space untuk tanda tangan -->
            </div>
            <div class="signature-name">
                Drs. Musa Muhammad. A, M.E.Sy.
            </div>
            <div class="signature-nip">
                NIP. -
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div style="font-weight: bold; color: #1e3a8a;">MA Muhammadiyah 1 Bandung</div>
        Dokumen ini dicetak secara otomatis dari Sistem Pendukung Keputusan Beasiswa
        <br>Dicetak pada: {{ date('d F Y, H:i:s') }} WIB
    </div>
</body>

</html>
