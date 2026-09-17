<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetHandoverController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Sudah jalan
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('/settings/company', [SettingController::class, 'updateCompany'])->name('settings.company.update');
Route::resource('categories', CategoryController::class)->except('show'); // dipakai di dalam Settings (Kategori & Kode Aset)
Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
Route::get('/laporan/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
Route::get('/laporan/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');

// ---- Menunggu implementasi anggota tim lain ----
// Pastikan nama route-nya (name(...)) sama persis dengan daftar di bawah,
// supaya sidebar di layouts/app.blade.php otomatis nyambung & ke-highlight saat aktif.

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// "Data Barang" di sidebar = Data Aset (BUKAN kategori). Ini resource terpisah, misal AssetController:
// Route::resource('items', ItemController::class)->names('items'); // items.index, items.show, dst

// Route::get('/pemeliharaan', [MaintenanceController::class, 'index'])->name('maintenance.index');

// Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

// Route::get('/aktivitas', [ActivityLogController::class, 'index'])->name('activity.index');

// Route::get('/account', [AccountController::class, 'edit'])->name('account');

Route::resource('assets', AssetController::class);
Route::get('assets/{asset}/detail', [AssetController::class, 'detail'])->name('assets.detail');
Route::post('assets/{asset}/handovers', [AssetHandoverController::class, 'store'])->name('handovers.store');
Route::post('handovers/{handover}/kembalikan', [AssetHandoverController::class, 'kembalikan'])->name('handovers.kembalikan');