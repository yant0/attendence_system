<?php

use App\Http\Controllers\Mahasiswa\ProfileController as MahasiswaProfileController;
use App\Http\Controllers\Dosen\QRController;
use App\Http\Controllers\Dosen\IzinController as DosenIzinController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\ProfileController as DosenProfileController;
use App\Http\Controllers\Mahasiswa\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\Mahasiswa\ScanQRController;
use App\Http\Controllers\Mahasiswa\IzinController;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'dosen'
            ? redirect()->route('dosen.dashboard')
            : redirect()->route('mahasiswa.dashboard');
    }
    return redirect()->route('login');
});
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dosen.dashboard');
    Route::get('/list_mahasiswa', [MahasiswaController::class, 'dosenIndex'])->name('dosen.mahasiswa.index');
    Route::post('/list_mahasiswa', [MahasiswaController::class, 'store'])->name('dosen.mahasiswa.store');
    Route::put('/list_mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('dosen.mahasiswa.update');
    Route::delete('/list_mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('dosen.mahasiswa.destroy');

    Route::get('/list_matakuliah', [MatakuliahController::class, 'dosenIndex'])->name('dosen.matakuliah.index');
    Route::post('/list_matakuliah', [MatakuliahController::class, 'store'])->name('dosen.matakuliah.store');
    Route::put('/list_matakuliah/{matakuliah}', [MatakuliahController::class, 'update'])->name('dosen.matakuliah.update');
    Route::delete('/list_matakuliah/{matakuliah}', [MatakuliahController::class, 'destroy'])->name('dosen.matakuliah.destroy');
    Route::get('/profile', [DosenProfileController::class, 'show'])->name('dosen.profile');
    Route::put('/profile', [DosenProfileController::class, 'update'])->name('dosen.profile.update');
    Route::put('/profile/password', [DosenProfileController::class, 'updatePassword'])->name('dosen.profile.password');
    Route::get('/generate_qr', [QRController::class, 'index']);
    Route::get('/generate_qr/presensis', [QRController::class, 'presensis']);

    Route::post('/generate_qr/process', [QRController::class, 'store']);

    Route::get('/izin_mahasiswa', [DosenIzinController::class, 'index'])->name('dosen.izin.index');
    Route::patch('/izin_mahasiswa/{izin}/approve', [DosenIzinController::class, 'approve'])->name('dosen.izin.approve');
    Route::patch('/izin_mahasiswa/{izin}/reject', [DosenIzinController::class, 'reject'])->name('dosen.izin.reject');
});

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/list_matakuliah', [MatakuliahController::class, 'mahasiswaIndex'])->name('mahasiswa.matakuliah.index');
    Route::get('/profile', [MahasiswaProfileController::class, 'show'])->name('mahasiswa.profile');
    Route::get('/scan_qr', function () {
        return view('mahasiswa.scan_qr');
    });
    Route::get(
        '/dashboard/api',
        [DashboardController::class, 'apiDashboard']
    );
    Route::get('/scan/{token}', [ScanQRController::class, 'scan']);
    Route::post('/scan/process', [ScanQRController::class, 'process']);

    Route::get('/izin', [IzinController::class, 'index'])->name('mahasiswa.izin.index');
    Route::post('/izin', [IzinController::class, 'store'])->name('mahasiswa.izin.store');
    Route::delete('/izin/{izin}', [IzinController::class, 'destroy'])->name('mahasiswa.izin.destroy');
    Route::get(
        '/izin/api',
        [IzinController::class, 'apiIndex']
    );

    Route::post(
        '/izin/api',
        [IzinController::class, 'apiStore']
    );

    Route::delete(
        '/izin/api/{izin}',
        [IzinController::class, 'apiDestroy']
    );
    Route::get(
        '/list_matakuliah/api',
        [MatakuliahController::class, 'apiMahasiswaIndex']
    );
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
