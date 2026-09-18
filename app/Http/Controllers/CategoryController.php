<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Simpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:20|unique:categories,code',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()
            ->route('settings.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Update kategori yang sudah ada.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:20|unique:categories,code,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()
            ->route('settings.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(Category $category)
    {
        if ($category->assets()->exists()) {
            return redirect()
                ->route('settings.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh aset.');
        }

        $category->delete();

        return redirect()
            ->route('settings.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}