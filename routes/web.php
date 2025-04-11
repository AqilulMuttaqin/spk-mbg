<?php

use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return view('dashboard', [
            'title' => 'Dashboard'
        ]);
    })->name('dashboard');

    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
    Route::put('/kriteria/{kriteria}', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::delete('/kriteria/{kriteria}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');

    Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');
    Route::post('/wilayah-kecamatan', [WilayahController::class, 'storeKecamatan'])->name('wilayah.kecamatan.store');
    Route::put('/wilayah-kecamatan/{kecamatan}', [WilayahController::class, 'updateKecamatan'])->name('wilayah.kecamatan.update');
    Route::delete('/wilayah-kecamatan/{kecamatan}', [WilayahController::class, 'destroyKecamatan'])->name('wilayah.kecamatan.destroy');
    Route::post('/wilayah-kelurahan', [WilayahController::class, 'storeKelurahan'])->name('wilayah.kelurahan.store');
    Route::put('/wilayah-kelurahan/{kelurahan}', [WilayahController::class, 'updateKelurahan'])->name('wilayah.kelurahan.update');
    Route::delete('/wilayah-kelurahan/{kelurahan}', [WilayahController::class, 'destroyKelurahan'])->name('wilayah.kelurahan.destroy');
});

require __DIR__.'/auth.php';
