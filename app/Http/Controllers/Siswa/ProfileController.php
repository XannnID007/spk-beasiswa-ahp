<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        return view('siswa.profile.index', compact('siswa'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $siswa = Auth::user()->siswa;

        // Update data siswa
        $siswa->update([
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
        ]);

        // Update email user
        Auth::user()->update([
            'email' => $request->email,
            'name' => $request->nama_lengkap,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // Cek password lama
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with('error', 'Password lama tidak sesuai!');
        }

        // Update password
        Auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $siswa = Auth::user()->siswa;

        // Hapus foto lama jika ada
        if ($siswa->foto && file_exists(public_path($siswa->foto))) {
            unlink(public_path($siswa->foto));
        }

        // Upload foto baru
        $foto = $request->file('foto');
        $fotoName = time() . '_' . $siswa->id . '.' . $foto->getClientOriginalExtension();
        $foto->move(public_path('uploads/foto_siswa'), $fotoName);

        $siswa->update([
            'foto' => 'uploads/foto_siswa/' . $fotoName
        ]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}
