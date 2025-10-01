<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hasil Seleksi Beasiswa - {{ $siswa->nama_lengkap }}</title>
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
            margin: 5px 0 0 0;
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
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            margin: 15px 0;
        }

        .info-table td {
            padding: 8px 10px;
            vertical-align: top;
            border-bottom: 1px solid #ddd;
        }

        .info-table td:first-child {
            width: 200px;
            font-weight: bold;
        }

        .info-table td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        /* Result Box */
        .result-box {
            border: 3px solid #000;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
            background-color: #f9f9f9;
        }

        .result-label {
            font-size: 11pt;
            margin-bottom: 10px;
        }

        .result-status {
            font-size: 18pt;
            font-weight: bold;
            margin: 15px 0;
        }

        .result-status.lulus {
            color: #155724;
        }

        .result-status.tidak-lulus {
            color: #721c24;
        }

        .result-details {
            margin-top: 15px;
            font-size: 11pt;
        }

        .result-details p {
            margin: 5px 0;
        }

        /* Tabel Penilaian */
        table.assessment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        table.assessment-table th,
        table.assessment-table td {
            border: 1px solid #000;
            padding: 8px 6px;
            text-align: left;
        }

        table.assessment-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            font-size: 10pt;
        }

        table.assessment-table td {
            font-size: 10pt;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Note Box */
        .note-box {
            margin: 20px 0;
            padding: 15px;
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-left: 4px solid #ffc107;
        }

        .note-box p {
            margin: 0 0 8px 0;
            font-size: 10pt;
        }

        .note-box p:last-child {
            margin-bottom: 0;
        }

        .note-box strong {
            font-size: 11pt;
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
            background: white;
        }

        /* Prevent table overlap with footer */
        body {
            margin-bottom: 60px;
        }

        table.assessment-table {
            page-break-inside: auto;
        }

        table.assessment-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .section-title {
            page-break-after: avoid;
        }

        /* Clearfix */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
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
        <div class="doc-title">Surat Hasil Seleksi Penerima Beasiswa</div>
        <div class="doc-number">
            Nomor: {{ str_pad($hasil->id, 4, '0', STR_PAD_LEFT) }}/BS-MA/{{ date('m') }}/{{ date('Y') }}
        </div>
        <div class="doc-number">
            Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}
        </div>
    </div>

    <!-- Pernyataan Pembuka -->
    <div class="opening-statement">
        <p>
            Berdasarkan hasil seleksi calon penerima beasiswa yang telah dilaksanakan dengan menggunakan
            metode <em>Analytical Hierarchy Process</em> (AHP), dengan ini kami menyampaikan hasil seleksi
            untuk siswa yang bersangkutan.
        </p>
        <p>
            Proses seleksi telah dilakukan secara objektif dengan mempertimbangkan empat kriteria penilaian
            utama yang telah ditetapkan. Berikut adalah data dan hasil penilaian untuk siswa yang bersangkutan:
        </p>
    </div>

    <!-- Data Siswa -->
    <div class="section-title">I. Data Siswa</div>
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

    <!-- Hasil Penilaian Kriteria -->
    <div class="section-title">II. Hasil Penilaian Kriteria</div>
    <table class="assessment-table">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Kriteria Penilaian</th>
                <th width="100">Bobot</th>
                <th>Sub-Kriteria</th>
                <th width="100">Nilai Sub</th>
                <th width="100">Skor</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($penilaian as $p)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $p->kriteria->nama_kriteria }}</td>
                    <td class="text-center">{{ number_format($p->kriteria->bobot, 4) }}</td>
                    <td>{{ $p->subKriteria->nama_sub_kriteria }}</td>
                    <td class="text-center">{{ number_format($p->subKriteria->nilai_sub, 4) }}</td>
                    <td class="text-center">
                        <strong>{{ number_format($p->kriteria->bobot * $p->subKriteria->nilai_sub, 4) }}</strong>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-right" style="font-weight: bold; background-color: #f0f0f0;">
                    TOTAL SKOR AKHIR:
                </td>
                <td class="text-center" style="font-weight: bold; font-size: 12pt; background-color: #f0f0f0;">
                    {{ number_format($hasil->skor_akhir, 4) }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Hasil Keputusan -->
    <div class="section-title">III. Hasil Keputusan Seleksi</div>
    <div class="result-box">
        <div class="result-label">
            Berdasarkan hasil perhitungan yang telah dilakukan, dengan skor akhir
            <strong>{{ number_format($hasil->skor_akhir, 4) }}</strong> dan menduduki peringkat
            ke-<strong>{{ $hasil->ranking }}</strong> dari total
            <strong>{{ \App\Models\HasilPerhitungan::count() }}</strong> peserta seleksi,
            maka dengan ini siswa yang bersangkutan dinyatakan:
        </div>
        <div class="result-status {{ $hasil->status_kelulusan }}">
            @if ($hasil->status_kelulusan == 'lulus')
                LULUS SELEKSI BEASISWA
            @else
                TIDAK LULUS SELEKSI BEASISWA
            @endif
        </div>
        <div class="result-details">
            <table style="width: 100%; margin-top: 15px; border: none;">
                <tr>
                    <td style="border: none; padding: 5px; width: 40%; text-align: right;"><strong>Peringkat</strong>
                    </td>
                    <td style="border: none; padding: 5px; width: 5%; text-align: center;">:</td>
                    <td style="border: none; padding: 5px; text-align: left;">{{ $hasil->ranking }} dari
                        {{ \App\Models\HasilPerhitungan::count() }} peserta</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 5px; text-align: right;"><strong>Tanggal Perhitungan</strong></td>
                    <td style="border: none; padding: 5px; text-align: center;">:</td>
                    <td style="border: none; padding: 5px; text-align: left;">
                        {{ $hasil->tanggal_perhitungan->format('d F Y') }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if ($hasil->status_kelulusan == 'lulus')
        <!-- Catatan untuk yang Lulus -->
        <div class="note-box">
            <p style="text-align: center; font-weight: bold; margin-bottom: 15px; font-size: 11pt;">CATATAN PENTING</p>
            <p style="text-align: justify; text-indent: 0;">
                Siswa yang dinyatakan lulus seleksi beasiswa diharapkan untuk melengkapi berkas administrasi
                beasiswa ke bagian kesiswaan paling lambat 7 (tujuh) hari kerja setelah pengumuman ini dikeluarkan.
            </p>
            <p style="text-align: justify; text-indent: 0; margin-top: 10px;">
                Berkas yang harus dilengkapi meliputi: Fotokopi Kartu Keluarga, Surat Keterangan Tidak Mampu
                (apabila diperlukan), dan formulir penerima beasiswa yang dapat diambil di bagian kesiswaan.
            </p>
            <p style="text-align: justify; text-indent: 0; margin-top: 10px;">
                Apabila dalam waktu yang ditentukan siswa tidak melengkapi berkas administrasi, maka kesempatan
                dapat diberikan kepada siswa dengan peringkat berikutnya.
            </p>
        </div>
    @else
        <!-- Catatan untuk yang Tidak Lulus -->
        <div class="note-box">
            <p style="text-align: center; font-weight: bold; margin-bottom: 15px; font-size: 11pt;">CATATAN</p>
            <p style="text-align: justify; text-indent: 0;">
                Terima kasih atas partisipasi yang telah diberikan dalam seleksi penerima beasiswa ini.
                Mohon maaf atas hasil seleksi yang belum sesuai harapan.
            </p>
            <p style="text-align: justify; text-indent: 0; margin-top: 10px;">
                Siswa dapat mencoba kembali pada periode seleksi beasiswa berikutnya dengan terus meningkatkan
                prestasi akademik maupun non-akademik. Tetap semangat dalam mengejar cita-cita dan jangan
                menyerah untuk terus berusaha.
            </p>
        </div>
    @endif

    <!-- Penutup -->
    <div style="margin: 30px 0 20px 0; text-align: justify; line-height: 1.8;">
        <p style="text-indent: 50px; margin-bottom: 12px;">
            Demikian surat hasil seleksi penerima beasiswa ini kami sampaikan. Keputusan ini merupakan hasil
            dari proses seleksi yang telah dilakukan secara objektif dan transparan berdasarkan kriteria yang
            telah ditetapkan.
        </p>
        <p style="text-indent: 50px; margin-bottom: 12px;">
            Kami berharap hasil seleksi ini dapat diterima dengan baik dan dapat menjadi motivasi bagi siswa
            untuk terus meningkatkan prestasi di bidang akademik maupun non-akademik. Bagi siswa yang dinyatakan
            lulus, diharapkan dapat memanfaatkan beasiswa ini dengan sebaik-baiknya untuk menunjang kegiatan
            pembelajaran.
        </p>
        <p style="text-indent: 50px; margin-bottom: 0;">
            Atas perhatian, kerjasama, dan partisipasi yang telah diberikan, kami ucapkan terima kasih.
            Semoga program beasiswa ini dapat memberikan manfaat yang optimal bagi kemajuan pendidikan siswa.
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
