<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        return back()->with('error', 'Email atau password salah!');
    }

    // Tampilkan halaman register
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.register');
    }

    // Proses register siswa
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nis' => 'required|unique:siswa,nis',
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'nis.required' => 'NIS wajib diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'kelas.required' => 'Kelas wajib diisi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create user account
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // Create siswa data dengan data minimal
        Siswa::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'kelas' => $request->kelas,
            // Data lengkap akan diisi saat pengajuan beasiswa
            'jenis_kelamin' => 'L', // default, bisa diubah nanti
            'tempat_lahir' => '-',
            'tanggal_lahir' => now(),
            'alamat' => '-',
            'no_telp' => '-',
            'nama_ayah' => '-',
            'nama_ibu' => '-',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dan lengkapi data Anda saat mengajukan beasiswa.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }

    // Redirect berdasarkan role
    private function redirectBasedOnRole()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('siswa.dashboard');
        }
    }
}
