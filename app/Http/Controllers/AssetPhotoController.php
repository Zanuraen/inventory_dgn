<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetPhoto;
use Illuminate\Http\Request;

class AssetPhotoController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $request->validate([
            'photos'   => 'required|array|min:1',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cek apakah aset ini sudah punya cover sebelumnya
        $hasCover = $asset->photos()->where('is_cover', true)->exists();

        foreach ($request->file('photos') as $index => $file) {
            $path = $file->store('assets/photos', 'public');

            $asset->photos()->create([
                'path'     => $path,
                // Foto pertama yang diupload otomatis jadi cover HANYA kalau
                // aset ini belum pernah punya cover sama sekali sebelumnya
                'is_cover' => (!$hasCover && $index === 0),
            ]);
        }

        return back()->with('success', 'Foto berhasil ditambahkan.');
    }

    public function destroy(Asset $asset, AssetPhoto $photo)
    {
        // Pastikan foto ini benar-benar milik asset yang dimaksud di URL
        // (mencegah orang iseng hapus foto aset lain lewat ID sembarangan)
        abort_unless($photo->asset_id === $asset->id, 404);

        $wasCover = $photo->is_cover;

        \Storage::disk('public')->delete($photo->path);
        $photo->delete();

        // Kalau yang dihapus tadi kebetulan cover, otomatis pindahkan
        // status cover ke foto tersisa yang paling awal diupload
        if ($wasCover) {
            $nextPhoto = $asset->photos()->oldest()->first();
            if ($nextPhoto) {
                $nextPhoto->update(['is_cover' => true]);
            }
        }

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function setCover(Asset $asset, AssetPhoto $photo)
    {
        abort_unless($photo->asset_id === $asset->id, 404);

        // Lepas status cover dari foto manapun yang sebelumnya jadi cover
        $asset->photos()->update(['is_cover' => false]);

        // Jadikan foto yang dipilih sebagai cover baru
        $photo->update(['is_cover' => true]);

        return back()->with('success', 'Foto sampul berhasil diperbarui.');
    }
}