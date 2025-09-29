<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBeasiswa;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = PengajuanBeasiswa::with(['siswa', 'beasiswa']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $pengajuan = $query->latest()->paginate(10);

        return view('admin.pengajuan.index', compact('pengajuan', 'status'));
    }

    public function show($id)
    {
        $pengajuan = PengajuanBeasiswa::with(['siswa', 'beasiswa'])->findOrFail($id);
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function verifikasi($id)
    {
        $pengajuan = PengajuanBeasiswa::findOrFail($id);
        $pengajuan->update(['status' => 'diverifikasi']);

        return back()->with('success', 'Pengajuan berhasil diverifikasi!');
    }

    public function tolak(Request $request, $id)
    {
        $pengajuan = PengajuanBeasiswa::findOrFail($id);
        $pengajuan->update(['status' => 'ditolak']);

        return back()->with('success', 'Pengajuan ditolak!');
    }
}
