<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dosen\QRController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\Mahasiswa\ScanQRController;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'dosen'
            ? redirect()->route('dosen.dashboard')
            : redirect()->route('mahasiswa.dashboard');
    }
    return redirect()->route('login');
});
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', function () {
        return view('dosen.dashboard');
    })->name('dosen.dashboard');
    Route::get('/list_mahasiswa', [MahasiswaController::class, 'dosenIndex'])->name('dosen.mahasiswa.index');
    Route::post('/list_mahasiswa', [MahasiswaController::class, 'store'])->name('dosen.mahasiswa.store');
    Route::put('/list_mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('dosen.mahasiswa.update');
    Route::delete('/list_mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('dosen.mahasiswa.destroy');

    Route::get('/list_matakuliah', [MatakuliahController::class, 'dosenIndex'])->name('dosen.matakuliah.index');
    Route::post('/list_matakuliah', [MatakuliahController::class, 'store'])->name('dosen.matakuliah.store');
    Route::put('/list_matakuliah/{matakuliah}', [MatakuliahController::class, 'update'])->name('dosen.matakuliah.update');
    Route::delete('/list_matakuliah/{matakuliah}', [MatakuliahController::class, 'destroy'])->name('dosen.matakuliah.destroy');
    Route::get('/profile', function () {
        return view('dosen.profile');
    });
    Route::get('/generate_qr', [QRController::class, 'index']);
    Route::get('/generate_qr/presensis', [QRController::class, 'presensis']);

    Route::post('/generate_qr/process', [QRController::class, 'store']);

    Route::get('/izin_mahasiswa', function () {
        return view('dosen.izin_mahasiswa');
    })->name('dosen.izin.index');
});

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');
    Route::get('/list_matakuliah', [MatakuliahController::class, 'mahasiswaIndex'])->name('mahasiswa.matakuliah.index');
    Route::get('/profile', function () {
        return view('mahasiswa.profile');
    });
    Route::get('/scan_qr', function () {
        return view('mahasiswa.scan_qr');
    });
    Route::get('/scan/{token}', [ScanQRController::class, 'scan']);
    Route::post(
        '/scan/process',
        [ScanQRController::class, 'process']
    );
//     Route::post('/scan/process', function () {
//     die('HALO DARI ROUTE');
// });
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
