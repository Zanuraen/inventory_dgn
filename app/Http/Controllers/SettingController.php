<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        // Pakai baris pertama; kalau belum ada, buat default sekali saja
        $company = Setting::first() ?? Setting::create([
            'company_name' => 'PT Digital Inteligensi Nusantara',
            'company_code' => 'DGN',
        ]);

        return view('settings.index', compact('categories', 'company'));
    }

    public function updateCompany(Request $request)
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_code' => ['required', 'string', 'max:10'],
        ]);

        $company = Setting::first() ?? new Setting();
        $company->fill($data)->save();

        return redirect()->route('settings.index')->with('success', 'Informasi perusahaan berhasil diperbarui.');
    }
}