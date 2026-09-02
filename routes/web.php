<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Sudah jalan
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('/settings/company', [SettingController::class, 'updateCompany'])->name('settings.company.update');
Route::resource('categories', CategoryController::class)->except('show'); // dipakai di dalam Settings (Kategori & Kode Aset)

// ---- Menunggu implementasi anggota tim lain ----
// Pastikan nama route-nya (name(...)) sama persis dengan daftar di bawah,
// supaya sidebar di layouts/app.blade.php otomatis nyambung & ke-highlight saat aktif.

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// "Data Barang" di sidebar = Data Aset (BUKAN kategori). Ini resource terpisah, misal AssetController:
// Route::resource('items', ItemController::class)->names('items'); // items.index, items.show, dst

// Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');

// Route::get('/pemeliharaan', [MaintenanceController::class, 'index'])->name('maintenance.index');

// Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

// Route::get('/aktivitas', [ActivityLogController::class, 'index'])->name('activity.index');

// Route::get('/account', [AccountController::class, 'edit'])->name('account');