<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\PengajuanBeasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index()
    {
        // Ambil siswa yang sudah diverifikasi
        $siswaIds = PengajuanBeasiswa::where('status', 'diverifikasi')->pluck('siswa_id');
        $siswa = Siswa::whereIn('id', $siswaIds)->withCount('penilaian')->get();

        return view('admin.penilaian.index', compact('siswa'));
    }

    public function create()
    {
        // Ambil siswa yang sudah diverifikasi dan belum dinilai lengkap
        $siswaIds = PengajuanBeasiswa::where('status', 'diverifikasi')->pluck('siswa_id');
        $siswa = Siswa::whereIn('id', $siswaIds)->get();
        $kriteria = Kriteria::with('subKriteria')->orderBy('kode_kriteria')->get();

        return view('admin.penilaian.create', compact('siswa', 'kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nilai_raport' => 'required|numeric|min:0|max:100',
            'jumlah_tanggungan' => 'required|integer|min:1',
            'penghasilan_ortu' => 'required|numeric',
            'jumlah_keaktifan' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $siswa = Siswa::findOrFail($request->siswa_id);

            // Update data siswa
            $siswa->update([
                'penghasilan_ortu' => $request->penghasilan_ortu,
                'jumlah_tanggungan' => $request->jumlah_tanggungan,
            ]);

            // Hapus penilaian lama jika ada
            Penilaian::where('siswa_id', $request->siswa_id)->delete();

            // Get kriteria
            $kriteria = Kriteria::orderBy('kode_kriteria')->get();

            foreach ($kriteria as $k) {
                $nilai = 0;
                $subKriteriaId = null;

                // K1: Nilai Raport
                if ($k->kode_kriteria == 'K1') {
                    $nilai = $request->nilai_raport;
                    $subKriteriaId = $this->getSubKriteriaByRange($k->id, $nilai);
                }

                // K2: Jumlah Tanggungan
                if ($k->kode_kriteria == 'K2') {
                    $nilai = $request->jumlah_tanggungan;
                    $subKriteriaId = $this->getSubKriteriaByRange($k->id, $nilai);
                }

                // K3: Penghasilan Orang Tua
                if ($k->kode_kriteria == 'K3') {
                    $nilai = $request->penghasilan_ortu;
                    $subKriteriaId = $this->getSubKriteriaByRange($k->id, $nilai);
                }

                // K4: Keaktifan
                if ($k->kode_kriteria == 'K4') {
                    $nilai = $request->jumlah_keaktifan;
                    $subKriteriaId = $this->getSubKriteriaByRange($k->id, $nilai);
                }

                Penilaian::create([
                    'siswa_id' => $request->siswa_id,
                    'kriteria_id' => $k->id,
                    'nilai' => $nilai,
                    'sub_kriteria_id' => $subKriteriaId,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.penilaian.index')
                ->with('success', 'Penilaian berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $penilaian = Penilaian::where('siswa_id', $siswa_id)->with('kriteria')->get();
        $kriteria = Kriteria::with('subKriteria')->orderBy('kode_kriteria')->get();

        return view('admin.penilaian.edit', compact('siswa', 'penilaian', 'kriteria'));
    }

    public function update(Request $request, $siswa_id)
    {
        $request->validate([
            'nilai_raport' => 'required|numeric|min:0|max:100',
            'jumlah_tanggungan' => 'required|integer|min:1',
            'penghasilan_ortu' => 'required|numeric',
            'jumlah_keaktifan' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $siswa = Siswa::findOrFail($siswa_id);

            // Update data siswa
            $siswa->update([
                'penghasilan_ortu' => $request->penghasilan_ortu,
                'jumlah_tanggungan' => $request->jumlah_tanggungan,
            ]);

            // Hapus penilaian lama
            Penilaian::where('siswa_id', $siswa_id)->delete();

            // Get kriteria
            $kriteria = Kriteria::orderBy('kode_kriteria')->get();

            foreach ($kriteria as $k) {
                $nilai = 0;
                $subKriteriaId = null;

                if ($k->kode_kriteria == 'K1') {
                    $nilai = $request->nilai_raport;
                    $subKriteriaId = $this->getSubKriteriaByRange($k->id, $nilai);
                }

                if ($k->kode_kriteria == 'K2') {
                    $nilai = $request->jumlah_tanggungan;
                    $subKriteriaId = $this->getSubKriteriaByRange($k->id, $nilai);
                }

                if ($k->kode_kriteria == 'K3') {
                    $nilai = $request->penghasilan_ortu;
                    $subKriteriaId = $this->getSubKriteriaByRange($k->id, $nilai);
                }

                if ($k->kode_kriteria == 'K4') {
                    $nilai = $request->jumlah_keaktifan;
                    $subKriteriaId = $this->getSubKriteriaByRange($k->id, $nilai);
                }

                Penilaian::create([
                    'siswa_id' => $siswa_id,
                    'kriteria_id' => $k->id,
                    'nilai' => $nilai,
                    'sub_kriteria_id' => $subKriteriaId,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.penilaian.index')
                ->with('success', 'Penilaian berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($siswa_id)
    {
        Penilaian::where('siswa_id', $siswa_id)->delete();

        return redirect()->route('admin.penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus!');
    }

    private function getSubKriteriaByRange($kriteria_id, $nilai)
    {
        $subKriteria = SubKriteria::where('kriteria_id', $kriteria_id)
            ->where('range_min', '<=', $nilai)
            ->where('range_max', '>=', $nilai)
            ->first();

        return $subKriteria ? $subKriteria->id : null;
    }
}
