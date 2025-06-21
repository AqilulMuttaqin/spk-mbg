<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PerhitunganRekomendasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'head'], '/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    } else if (auth()->user()) {
        return redirect()->route('dashboard');
    }
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
        Route::post('/import/nilai-kriteria', 'importNilaiKriteria')->name('nilai-kriteria.import');
        Route::get('/export/format-import', 'formatImport')->name('nilai-kriteria.export-format-import');
    });
    
    Route::controller(SekolahController::class)->prefix('sekolah')->name('sekolah.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{sekolah}', 'show')->name('show');
        Route::put('/{sekolah}', 'update')->name('update');
        Route::delete('/{sekolah}', 'destroy')->name('destroy');
        
        Route::get('/get-kelurahan/{wilayah_kecamatan_id}', 'getKelurahan')->name('getKelurahan');
        
        Route::post('/nilai-kriteria-', 'updateNilaiKriteria')->name('nilai-kriteria.update');
        Route::post('/import/nilai-kriteria', 'importNilaiKriteria')->name('nilai-kriteria.import');
        Route::get('/export/format-import', 'formatImport')->name('nilai-kriteria.export-format-import');
    });

    Route::get('/rekomendasi', [PerhitunganRekomendasiController::class, 'index'])->name('rekomendasi.index');
});

require __DIR__.'/auth.php';
