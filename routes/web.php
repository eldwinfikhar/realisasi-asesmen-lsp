<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/daftar-asesi', function () {
        return view('pages.daftar-asesi');
    })->name('asesi.index');

    Route::get('/laporan-asesor', function () {
        return view('pages.laporan-asesor');
    })->name('laporan.asesor');

    Route::get('/laporan-skema', function () {
        return view('pages.laporan-skema');
    })->name('laporan.skema');

    Route::resource('realisasi-asesmen', App\Http\Controllers\AssessmentController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
