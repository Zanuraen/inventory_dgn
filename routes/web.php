<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetHandoverController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\DashboardController;

// === fitur dashboard ====
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// === fitur data barang ====
Route::resource('assets', AssetController::class);
Route::get('assets/{asset}/detail', [AssetController::class, 'detail'])->name('assets.detail');
Route::post('assets/{asset}/handovers', [AssetHandoverController::class, 'store'])->name('handovers.store');
Route::post('handovers/{handover}/kembalikan', [AssetHandoverController::class, 'kembalikan'])->name('handovers.kembalikan');

// fitur pemeliharaan
Route::resource('maintenances', MaintenanceController::class)->except(['create', 'edit']);
Route::delete('maintenances/{maintenance}/documents/{document}', [MaintenanceController::class, 'destroyDocument'])
    ->name('maintenances.documents.destroy');
Route::delete('maintenances/{maintenance}/photos/{photo}', [MaintenanceController::class, 'destroyPhoto'])
    ->name('maintenances.photos.destroy');
Route::patch('maintenances/{maintenance}/selesai', [MaintenanceController::class, 'markAsDone'])
    ->name('maintenances.mark-done');