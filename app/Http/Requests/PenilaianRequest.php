<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenilaianRequest extends FormRequest
{
    public function rules()
    {
        return [
            'siswa_id' => 'required|exists:siswa,id|unique:penilaian,siswa_id',
            'nilai_raport' => 'required|numeric|min:0|max:100',
            'jumlah_tanggungan' => 'required|integer|min:1|max:20',
            'penghasilan_ortu' => 'required|numeric|min:0|max:999999999',
            'jumlah_keaktifan' => 'required|integer|min:1|max:50',
        ];
    }

    public function messages()
    {
        return [
            'nilai_raport.required' => 'Nilai raport wajib diisi',
            'nilai_raport.numeric' => 'Nilai raport harus berupa angka',
            'nilai_raport.min' => 'Nilai raport minimal 0',
            'nilai_raport.max' => 'Nilai raport maksimal 100',
            'jumlah_tanggungan.required' => 'Jumlah tanggungan wajib diisi',
            'jumlah_tanggungan.integer' => 'Jumlah tanggungan harus berupa angka bulat',
            'penghasilan_ortu.required' => 'Penghasilan orang tua wajib diisi',
            'penghasilan_ortu.numeric' => 'Penghasilan harus berupa angka',
        ];
    }
}
