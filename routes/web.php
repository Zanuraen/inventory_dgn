<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetHandoverController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetPhotoController;

Route::get('/', function () {
    return redirect()->route('login');
});

// === fitur dashboard ====
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // === fitur data barang ====
    Route::resource('assets', AssetController::class);
    Route::post('assets/{asset}/handovers', [AssetHandoverController::class, 'store'])->name('handovers.store');
    Route::post('handovers/{handover}/kembalikan', [AssetHandoverController::class, 'kembalikan'])->name('handovers.kembalikan');
    // route photo barang 
    Route::post('assets/{asset}/photos', [AssetPhotoController::class, 'store'])->name('assets.photos.store');
    Route::delete('assets/{asset}/photos/{photo}', [AssetPhotoController::class, 'destroy'])->name('assets.photos.destroy');
    Route::patch('assets/{asset}/photos/{photo}/cover', [AssetPhotoController::class, 'setCover'])->name('assets.photos.set-cover');

    // fitur pemeliharaan
    Route::resource('maintenances', MaintenanceController::class)->except(['create', 'edit']);
    Route::delete('maintenances/{maintenance}/documents/{document}', [MaintenanceController::class, 'destroyDocument'])
        ->name('maintenances.documents.destroy');
    Route::delete('maintenances/{maintenance}/photos/{photo}', [MaintenanceController::class, 'destroyPhoto'])
        ->name('maintenances.photos.destroy');
    Route::patch('maintenances/{maintenance}/selesai', [MaintenanceController::class, 'markAsDone'])
        ->name('maintenances.mark-done');
});

require __DIR__ . '/auth.php';