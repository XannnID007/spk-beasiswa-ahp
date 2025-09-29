<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBeasiswa;
use App\Models\Beasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengajuanController extends Controller
{
    public function create()
    {
        $siswa = Auth::user()->siswa;

        // Cek apakah sudah pernah mengajukan
        $pengajuanExists = PengajuanBeasiswa::where('siswa_id', $siswa->id)->first();

        // Ambil beasiswa yang aktif
        $beasiswaAktif = Beasiswa::aktif()->get();

        return view('siswa.pengajuan.create', compact('pengajuanExists', 'beasiswaAktif'));
    }

    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;

        // Cek apakah sudah pernah mengajukan
        $pengajuanExists = PengajuanBeasiswa::where('siswa_id', $siswa->id)->first();
        if ($pengajuanExists) {
            return back()->with('error', 'Anda sudah mengajukan beasiswa sebelumnya!');
        }

        $validator = Validator::make($request->all(), [
            'beasiswa_id' => 'nullable|exists:beasiswa,id',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'alasan_pengajuan' => 'required|string|min:50',
            'berkas_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'penghasilan_ortu' => 'required|numeric',
            'jumlah_tanggungan' => 'required|integer',
        ], [
            'alasan_pengajuan.required' => 'Alasan pengajuan wajib diisi',
            'alasan_pengajuan.min' => 'Alasan pengajuan minimal 50 karakter',
            'berkas_pendukung.mimes' => 'Format berkas harus PDF, JPG, JPEG, atau PNG',
            'berkas_pendukung.max' => 'Ukuran berkas maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update data siswa dengan data lengkap
        $siswa->update([
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'penghasilan_ortu' => $request->penghasilan_ortu,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
        ]);

        // Upload berkas jika ada
        $berkasPath = null;
        if ($request->hasFile('berkas_pendukung')) {
            $berkas = $request->file('berkas_pendukung');
            $berkasName = time() . '_' . $siswa->id . '.' . $berkas->getClientOriginalExtension();
            $berkas->move(public_path('uploads/berkas_beasiswa'), $berkasName);
            $berkasPath = 'uploads/berkas_beasiswa/' . $berkasName;
        }

        // Simpan pengajuan
        PengajuanBeasiswa::create([
            'siswa_id' => $siswa->id,
            'beasiswa_id' => $request->beasiswa_id,
            'status' => 'pending',
            'alasan_pengajuan' => $request->alasan_pengajuan,
            'berkas_pendukung' => $berkasPath,
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Pengajuan beasiswa berhasil dikirim! Silakan tunggu proses verifikasi.');
    }

    public function show($id)
    {
        $pengajuan = PengajuanBeasiswa::with(['siswa', 'beasiswa'])->findOrFail($id);

        // Pastikan hanya siswa yang bersangkutan yang bisa melihat
        if ($pengajuan->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        return view('siswa.pengajuan.show', compact('pengajuan'));
    }
}
