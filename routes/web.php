<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetHandoverController;

// === fitur dashboard ====
Route::get('/', function () {
    return view('dashboard');
});

// === fitur data barang ====
Route::resource('assets', AssetController::class);
Route::get('assets/{asset}/detail', [AssetController::class, 'detail'])->name('assets.detail');
Route::post('assets/{asset}/handovers', [AssetHandoverController::class, 'store'])->name('handovers.store');
Route::post('handovers/{handover}/kembalikan', [AssetHandoverController::class, 'kembalikan'])->name('handovers.kembalikan');