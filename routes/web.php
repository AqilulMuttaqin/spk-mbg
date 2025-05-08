<?php

use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PerhitunganRekomendasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekolahController;
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

    Route::controller(KriteriaController::class)->prefix('kriteria')->name('kriteria.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{kriteria}', 'update')->name('update');
        Route::delete('/{kriteria}', 'destroy')->name('destroy');
    });

    Route::controller(WilayahController::class)->prefix('wilayah')->name('wilayah.')->group(function () {
        Route::get('/', 'index')->name('index');
        
        Route::post('/kecamatan', 'storeKecamatan')->name('kecamatan.store');
        Route::put('/kecamatan/{kecamatan}', 'updateKecamatan')->name('kecamatan.update');
        Route::delete('/kecamatan/{kecamatan}', 'destroyKecamatan')->name('kecamatan.destroy');
    
        Route::post('/kelurahan', 'storeKelurahan')->name('kelurahan.store');
        Route::put('/kelurahan/{kelurahan}', 'updateKelurahan')->name('kelurahan.update');
        Route::delete('/kelurahan/{kelurahan}', 'destroyKelurahan')->name('kelurahan.destroy');
    
        Route::post('/nilai-kriteria', 'updateNilaiKriteria')->name('nilai-kriteria.update');
        Route::post('/nilai-kriteria-import', 'importNilaiKriteria')->name('nilai-kriteria.import');
        Route::get('/export-format-import', 'formatImport')->name('nilai-kriteria.export-format-import');
    });
    
    Route::controller(SekolahController::class)->prefix('sekolah')->name('sekolah.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{sekolah}', 'show')->name('show');
        Route::put('/{sekolah}', 'update')->name('update');
        Route::delete('/{sekolah}', 'destroy')->name('destroy');
    
        Route::get('/get-kelurahan/{wilayah_kecamatan_id}', 'getKelurahan')->name('getKelurahan');
        Route::post('/nilai-kriteria-', 'updateNilaiKriteria')->name('nilai-kriteria.update');
    });

    // Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    // Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
    // Route::put('/kriteria/{kriteria}', [KriteriaController::class, 'update'])->name('kriteria.update');
    // Route::delete('/kriteria/{kriteria}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');

    // Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');
    // Route::post('/wilayah-kecamatan', [WilayahController::class, 'storeKecamatan'])->name('wilayah.kecamatan.store');
    // Route::put('/wilayah-kecamatan/{kecamatan}', [WilayahController::class, 'updateKecamatan'])->name('wilayah.kecamatan.update');
    // Route::delete('/wilayah-kecamatan/{kecamatan}', [WilayahController::class, 'destroyKecamatan'])->name('wilayah.kecamatan.destroy');
    // Route::post('/wilayah-kelurahan', [WilayahController::class, 'storeKelurahan'])->name('wilayah.kelurahan.store');
    // Route::put('/wilayah-kelurahan/{kelurahan}', [WilayahController::class, 'updateKelurahan'])->name('wilayah.kelurahan.update');
    // Route::delete('/wilayah-kelurahan/{kelurahan}', [WilayahController::class, 'destroyKelurahan'])->name('wilayah.kelurahan.destroy');
    // Route::post('/nilai-kriteria-wilayah', [WilayahController::class, 'updateNilaiKriteria'])->name('wilayah.nilai-kriteria.update');

    // Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
    // Route::get('/get-kelurahan/{wilayah_kecamatan_id}', [SekolahController::class, 'getKelurahan'])->name('sekolah.getKelurahan');
    // Route::post('/sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
    // Route::get('/sekolah/{sekolah}', [SekolahController::class, 'show'])->name('sekolah.show');
    // Route::put('/sekolah/{sekolah}', [SekolahController::class, 'update'])->name('sekolah.update');
    // Route::delete('/sekolah/{sekolah}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    // Route::post('/nilai-kriteria-sekolah', [SekolahController::class, 'updateNilaiKriteria'])->name('sekolah.nilai-kriteria.update');

    Route::get('/rekomendasi', [PerhitunganRekomendasiController::class, 'index'])->name('rekomendasi.index');
});

require __DIR__.'/auth.php';
