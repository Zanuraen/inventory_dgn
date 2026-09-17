<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetHandoverController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\DashboardController;

// === fitur dashboard ====
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Sudah jalan
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('/settings/company', [SettingController::class, 'updateCompany'])->name('settings.company.update');
Route::resource('categories', CategoryController::class)->except('show'); // dipakai di dalam Settings (Kategori & Kode Aset)
Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
Route::get('/laporan/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
Route::get('/laporan/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');

// ---- Menunggu implementasi anggota tim lain ----
// Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
// Route::get('/aktivitas', [ActivityLogController::class, 'index'])->name('activity.index');
// Route::get('/account', [AccountController::class, 'edit'])->name('account');

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