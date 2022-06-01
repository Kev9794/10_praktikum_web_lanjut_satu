<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;

Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/cari', [MahasiswaController::class, 'cari'])->name('cari');
Route::get('mahasiswa/nilai/{id_mahasiswa}', [MahasiswaController::class, 'nilai'])->name('nilai');