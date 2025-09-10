<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\VikorController;
use App\Http\Controllers\RangkingController;
use App\Http\Controllers\HasilBukuTerminatController;

/*
|--------------------------------------------------------------------------
| Halaman Awal / Login
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('auth.login'));

/*
|--------------------------------------------------------------------------
| Akses untuk Semua yang Sudah Login & Verifikasi
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // === Dashboard ===
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

    // === Rangking (VIKOR) ===
    Route::get('/vikor/rangking', [VikorController::class, 'rangking'])
    ->name('vikor.rangking');

    // === Rangking (Opsional tambahan) ===
    Route::get('/rangking', [RangkingController::class, 'index'])
    ->name('rangking');

    // === Hasil Buku Terminat (boleh dilihat semua)
    Route::get('/hasil-buku-terminat', [HasilBukuTerminatController::class, 
    'index'])->name('hasil.buku.terminat');
    Route::get('/hasil-buku/export-pdf', [HasilBukuTerminatController::class, 
    'exportPDF'])->name('hasil_buku.export_pdf');

    // === Profil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])
        ->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])
        ->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])
        ->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Akses Khusus Admin (login + verifikasi + role admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // === Manajemen User ===
    Route::resource('users', UserController::class)->only(['index', 'store', 
    'edit', 'update', 'destroy']);

    // === Kriteria ===
    Route::resource('kriteria', KriteriaController::class);

    // === Sub Kriteria ===
    Route::prefix('subkriteria')->name('subkriteria.')->group(function () {
        Route::get('/', [SubKriteriaController::class, 'index'])
        ->name('index');
        Route::post('/', [SubKriteriaController::class, 'store'])
        ->name('store');
        Route::get('/{id}/edit', [SubKriteriaController::class, 'edit'])
        ->name('edit');
        Route::put('/{id}', [SubKriteriaController::class, 'update'])
        ->name('update');
        Route::delete('/{id}', [SubKriteriaController::class, 'destroy'])
        ->name('destroy');
    });

    // === Alternatif ===
    Route::prefix('alternatif')->name('alternatif.')->group(function () {
        Route::get('/', [AlternatifController::class, 'index'])
        ->name('index');
        Route::post('/upload', [AlternatifController::class, 'upload'])
        ->name('upload');
        Route::post('/', [AlternatifController::class, 'store'])
        ->name('store');
        Route::get('/{id}/edit', [AlternatifController::class, 'edit'])
        ->name('edit');
        Route::put('/{id}', [AlternatifController::class, 'update'])
        ->name('update');
        Route::delete('/{id}', [AlternatifController::class, 'destroy'])
        ->name('destroy');
        Route::delete('/clear', [AlternatifController::class, 'clear'])
        ->name('clear');
    });

    // === Perhitungan VIKOR ===
    Route::prefix('vikor')->name('vikor.')->group(function () {
        Route::post('/hitung', [VikorController::class, 'hitung'])
        ->name('hitung');
    });
});

/*
|--------------------------------------------------------------------------
| Otentikasi Breeze / Fortify
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
