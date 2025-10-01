<?php

namespace App\Exports;

use App\Models\HasilPerhitungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
     protected $status;
     private $rowCount = 0;

     public function __construct($status)
     {
          $this->status = $status;
     }

     /**
      * @return \Illuminate\Support\Collection
      */
     public function collection()
     {
          $query = HasilPerhitungan::with('siswa')->orderBy('ranking', 'asc');

          if ($this->status == 'lulus') {
               $query->where('status_kelulusan', 'lulus');
          } elseif ($this->status == 'tidak_lulus') {
               $query->where('status_kelulusan', 'tidak_lulus');
          }

          $collection = $query->get();
          $this->rowCount = $collection->count();
          return $collection;
     }

     public function headings(): array
     {
          return [
               'No',
               'Nama Siswa',
               'NIS',
               'Skor Akhir',
               'Peringkat',
               'Status',
          ];
     }

     /**
      * @var HasilPerhitungan $item
      */
     public function map($item): array
     {
          static $number = 0;
          $number++;

          return [
               $number,
               // PERBAIKAN FINAL: Menggunakan kolom 'nama_lengkap' dan 'nis' dari model Siswa
               $item->siswa->nama_lengkap,
               $item->siswa->nis,
               number_format($item->skor_akhir, 4),
               $item->ranking,
               ucfirst($item->status_kelulusan),
          ];
     }

     public function styles(Worksheet $sheet)
     {
          // Ganti judul kolom NISN menjadi NIS
          $sheet->setCellValue('C1', 'NIS');

          $cellRange = 'A1:F' . ($this->rowCount + 1);
          $sheet->getStyle($cellRange)->applyFromArray([
               'borders' => [
                    'allBorders' => [
                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => ['argb' => '000000'],
                    ],
               ],
          ]);

          $sheet->getStyle('A1:F1')->applyFromArray([
               'font' => [
                    'bold' => true,
               ],
               'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
               ]
          ]);
     }
}
