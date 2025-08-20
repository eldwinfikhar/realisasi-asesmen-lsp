<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AssesseeController;
use App\Http\Controllers\AssessorController;
use App\Http\Controllers\RekapBandController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\TargetRealisasiController;
use Illuminate\Support\Facades\Route;

// Railway health check endpoint
Route::get('/up', function () {
    return response('OK', 200);
});

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Special Assessment Routes ---
    Route::get('/assessments/external', [AssessmentController::class, 'indexExternal'])->name('assessments.indexExternal');
    Route::get('/assessments/external/create', [AssessmentController::class, 'createExternal'])->name('assessments.createExternal');
    Route::post('/assessments/external', [AssessmentController::class, 'storeExternal'])->name('assessments.storeExternal');
    Route::get('/assessments/external/{assessment}/edit', [AssessmentController::class, 'editExternal'])->name('assessments.editExternal');
    Route::put('/assessments/external/{assessment}', [AssessmentController::class, 'updateExternal'])->name('assessments.updateExternal');
    Route::delete('/assessments/external/{assessment}', [AssessmentController::class, 'destroyExternal'])->name('assessments.destroyExternal');

    // --- Resource Controllers ---
    Route::resource('assessees', AssesseeController::class);
    Route::resource('assessors', AssessorController::class);
    Route::resource('assessments', AssessmentController::class);
    Route::resource('schemes', SchemeController::class);

    // --- Report Pages Routes ---
    Route::get('/laporan/rekap-band', [RekapBandController::class, 'index'])->name('laporan.rekap-band');
    Route::get('/laporan/target-realisasi', [TargetRealisasiController::class, 'index'])->name('laporan.target-realisasi');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
