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

    Route::get('/laporan-asesor', [\App\Http\Controllers\AssessorController::class, 'index'])->name('laporan.asesor');

    Route::get('/laporan-skema', function () {
        return view('pages.laporan-skema');
    })->name('laporan.skema');

    Route::get('/rekap-per-band', function () {
        return view('reports.rekap-band');
    })->name('laporan.rekap-band');

    Route::get('/target-realisasi', function () {
        return view('reports.target-realisasi');
    })->name('laporan.target-realisasi');

    Route::get('/assessments/create', [App\Http\Controllers\AssessmentController::class, 'create'])->name('assessments.create');
    Route::resource('assessments', App\Http\Controllers\AssessmentController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
