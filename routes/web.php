<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;

Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/cari', [MahasiswaController::class, 'cari'])->name('cari');
Route::get('mahasiswa/nilai/{id_mahasiswa}', [MahasiswaController::class, 'nilai'])->name('nilai');
Route::prefix('mahasiswa')->group(function () {
    Route::get('nilai/{nim}', [MahasiswaController::class, 'viewKhs'])->name('mahasiswa.khs');
    Route::get('cetak_khs/{nim}', [MahasiswaController::class, 'cetak_khs'])->name('mahasiswa.cetak_khs');
});