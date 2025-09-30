<?php

namespace App\Helpers;

class NumberHelper
{
     /**
      * Format nilai perbandingan AHP
      */
     public static function formatComparison($value)
     {
          if (is_null($value)) return '-';

          // Jika angka bulat
          if ($value == floor($value)) {
               return number_format($value, 0);
          }

          // Jika 1 desimal cukup (contoh: 1.5)
          if ($value * 10 == floor($value * 10)) {
               return number_format($value, 1);
          }

          // Maksimal 3 desimal, hilangkan trailing zeros
          return rtrim(rtrim(number_format($value, 3), '0'), '.');
     }

     /**
      * Format bobot kriteria (4 desimal)
      */
     public static function formatWeight($value)
     {
          if (is_null($value)) return '0.0000';
          return number_format($value, 4);
     }

     /**
      * Format persentase bobot
      */
     public static function formatPercentage($value)
     {
          if (is_null($value)) return '0.00%';
          return number_format($value * 100, 2) . '%';
     }

     /**
      * Format skor akhir (6 desimal, hilangkan trailing zeros)
      */
     public static function formatScore($value)
     {
          if (is_null($value)) return '0';

          $formatted = number_format($value, 6);
          // Hilangkan trailing zeros
          $formatted = rtrim($formatted, '0');
          $formatted = rtrim($formatted, '.');

          return $formatted;
     }

     /**
      * Format nilai sub-kriteria
      */
     public static function formatSubCriteria($value)
     {
          if (is_null($value)) return '0';

          if ($value == 1) return '1';

          $formatted = number_format($value, 6);
          $formatted = rtrim($formatted, '0');
          $formatted = rtrim($formatted, '.');

          return $formatted;
     }

     /**
      * Format consistency ratio
      */
     public static function formatCR($value)
     {
          if (is_null($value)) return '0.0000';
          return number_format($value, 4);
     }
}
