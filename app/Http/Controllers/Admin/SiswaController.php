<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('user')->latest()->paginate(10);
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nis' => 'required|unique:siswa,nis',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'kelas' => 'required|string',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // Create siswa
        Siswa::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'kelas' => $request->kelas,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'penghasilan_ortu' => $request->penghasilan_ortu,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $siswa = Siswa::with(['user', 'pengajuanBeasiswa', 'penilaian', 'hasilPerhitungan'])->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'nis' => 'required|unique:siswa,nis,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'kelas' => 'required|string',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
        ]);

        // Update user
        $siswa->user->update([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $siswa->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Update siswa
        $siswa->update([
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'kelas' => $request->kelas,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'penghasilan_ortu' => $request->penghasilan_ortu,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->user->delete(); // Cascade akan menghapus siswa juga

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }
}
