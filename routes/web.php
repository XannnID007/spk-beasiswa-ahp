<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AhpController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HasilController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Siswa\ProfileController;
use App\Http\Controllers\Admin\BeasiswaController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\PenilaianController;
use App\Http\Controllers\Admin\PerhitunganController;
use App\Http\Controllers\Admin\SubKriteriaController;
use App\Http\Controllers\Siswa\HasilController as SiswaHasilController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\PengajuanController as SiswaPengajuanController;

// Landing atau redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Protected)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Data Beasiswa
    Route::resource('beasiswa', BeasiswaController::class);

    // Data Siswa
    Route::resource('siswa', SiswaController::class);
    Route::get('siswa/{id}/detail', [SiswaController::class, 'detail'])->name('siswa.detail');

    // Data Kriteria
    Route::resource('kriteria', KriteriaController::class);

    // Data Sub-Kriteria
    Route::resource('sub-kriteria', SubKriteriaController::class);
    Route::get('sub-kriteria/by-kriteria/{kriteria_id}', [SubKriteriaController::class, 'getByKriteria'])->name('sub-kriteria.by-kriteria');

    // Pengajuan Beasiswa
    Route::resource('pengajuan', AdminPengajuanController::class);
    Route::post('pengajuan/{id}/verifikasi', [AdminPengajuanController::class, 'verifikasi'])->name('pengajuan.verifikasi');
    Route::post('pengajuan/{id}/tolak', [AdminPengajuanController::class, 'tolak'])->name('pengajuan.tolak');

    // Penilaian Siswa
    Route::get('penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('penilaian/create', [PenilaianController::class, 'create'])->name('penilaian.create');
    Route::post('penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::get('penilaian/{siswa_id}/edit', [PenilaianController::class, 'edit'])->name('penilaian.edit');
    Route::put('penilaian/{siswa_id}', [PenilaianController::class, 'update'])->name('penilaian.update');
    Route::delete('penilaian/{siswa_id}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');

    Route::prefix('ahp')->name('ahp.')->group(function () {
        Route::get('/', [AhpController::class, 'index'])->name('index');
        Route::get('/create-comparison', [AhpController::class, 'createComparison'])->name('create-comparison');
        Route::post('/store-comparison', [AhpController::class, 'storeComparison'])->name('store-comparison');
        Route::post('/bulk-comparison', [AhpController::class, 'bulkComparison'])->name('bulk-comparison');
        Route::get('/calculate', [AhpController::class, 'calculate'])->name('calculate');
        Route::get('/detail', [AhpController::class, 'detail'])->name('detail');
        Route::get('/comparison/{id}/edit', [AhpController::class, 'editComparison'])->name('edit-comparison');
        Route::put('/comparison/{id}', [AhpController::class, 'updateComparison'])->name('update-comparison');
        Route::get('/comparison/{id}/delete', [AhpController::class, 'deleteComparison'])->name('delete-comparison');
        Route::get('/reset', [AhpController::class, 'resetComparisons'])->name('reset');
    });

    // Perhitungan AHP
    Route::get('perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
    Route::post('perhitungan/proses', [PerhitunganController::class, 'proses'])->name('perhitungan.proses');
    Route::get('perhitungan/detail', [PerhitunganController::class, 'detail'])->name('perhitungan.detail');
    Route::get('perhitungan/recalculate', [PerhitunganController::class, 'recalculate'])->name('perhitungan.recalculate');

    // Hasil & Ranking
    Route::get('hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('hasil/{id}', [HasilController::class, 'show'])->name('hasil.show');
    Route::post('hasil/{id}/update-status', [HasilController::class, 'updateStatus'])->name('hasil.update-status');

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/cetak-pdf', [LaporanController::class, 'cetakPDF'])->name('laporan.cetak-pdf');
    Route::get('laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');

    // Manajemen User
    Route::resource('users', UserController::class);

    // Profile & Settings
    Route::get('profile', function () {
        return view('admin.profile');
    })->name('profile');

    Route::get('settings', function () {
        return view('admin.settings');
    })->name('settings');
});

// Siswa Routes (Protected)
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // Pengajuan Beasiswa
    Route::get('pengajuan/create', [SiswaPengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('pengajuan', [SiswaPengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('pengajuan/{id}', [SiswaPengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('pengajuan/{id}/edit', [SiswaPengajuanController::class, 'edit'])->name('pengajuan.edit');
    Route::put('pengajuan/{id}', [SiswaPengajuanController::class, 'update'])->name('pengajuan.update');

    // Hasil Seleksi
    Route::get('hasil', [SiswaHasilController::class, 'index'])->name('hasil');
    Route::get('hasil/cetak-pdf', [SiswaHasilController::class, 'cetakPDF'])->name('hasil.cetak-pdf');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::post('profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
});
