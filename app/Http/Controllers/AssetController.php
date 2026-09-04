<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar, eager load category supaya nama kategori bisa ditampilkan
        // tanpa N+1 query saat looping di Blade
        $query = Asset::with('category');

        // Search: cocokkan ke nama barang, pengguna, atau lokasi sekaligus
        // (sesuai placeholder di desain: "Cari nama barang, pengguna, atau lokasi...")
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('pengguna', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter dropdown "Semua Lokasi" — hanya diterapkan kalau user pilih lokasi spesifik
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Filter dropdown "Semua Ketersediaan" — qty > 0 dianggap "Ada", qty = 0 dianggap "Tidak Ada"
        if ($request->filled('ketersediaan')) {
            if ($request->ketersediaan === 'ada') {
                $query->where('qty', '>', 0);
            } elseif ($request->ketersediaan === 'tidak_ada') {
                $query->where('qty', '=', 0);
            }
        }

        // Pagination 5 per halaman, sesuai desain ("Menampilkan 1-5 dari 124 aset")
        // withQueryString() supaya filter/search tetap kebawa saat pindah halaman
        $assets = $query->latest()->paginate(5)->withQueryString();

        // Ambil daftar lokasi unik untuk isi dropdown filter "Semua Lokasi"
        $locations = Asset::select('location')->distinct()->whereNotNull('location')->pluck('location');

        return view('assets.data-barang', [
            'assets'    => $assets,
            'locations' => $locations,
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('assets.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'name'              => 'required|string|max:255',
            'code_asset'        => 'required|string|max:255|unique:assets,code_asset',
            'serial_number'     => 'nullable|string|max:255',
            'spesifikasi'       => 'nullable|string|max:255',
            'condition_status'  => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'qty'               => 'required|integer|min:0',
            'pengguna'          => 'nullable|string|max:255',
            'location'          => 'nullable|string|max:255',
            'tanggal_beli'      => 'required|date',
            'harga_beli'        => 'required|numeric|min:0',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description'       => 'nullable|string',
        ]);

        // Upload foto barang kalau ada, simpan path-nya saja ke database
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets', 'public');
        }

        Asset::create($data);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function edit(Asset $asset)
    {
        $categories = Category::orderBy('name')->get();

        return view('assets.edit', [
            'asset'      => $asset,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Asset $asset)
    {
        $data = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'name'              => 'required|string|max:255',
            // unique diabaikan untuk record ini sendiri, supaya update tanpa ganti kode tidak dianggap duplikat
            'code_asset'        => 'required|string|max:255|unique:assets,code_asset,' . $asset->id,
            'serial_number'     => 'nullable|string|max:255',
            'spesifikasi'       => 'nullable|string|max:255',
            'condition_status'  => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'qty'               => 'required|integer|min:0',
            'pengguna'          => 'nullable|string|max:255',
            'location'          => 'nullable|string|max:255',
            'tanggal_beli'      => 'required|date',
            'harga_beli'        => 'required|numeric|min:0',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description'       => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Hapus foto lama supaya tidak menumpuk file yatim di storage
            if ($asset->image) {
                \Storage::disk('public')->delete($asset->image);
            }
            $data['image'] = $request->file('image')->store('assets', 'public');
        }

        $asset->update($data);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        // Hapus foto dari storage juga, bukan cuma record database
        if ($asset->image) {
            \Storage::disk('public')->delete($asset->image);
        }

        // Soft delete (tabel assets punya kolom deleted_at), jadi data tidak hilang permanen
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus.');
    }

    public function detail(Asset $asset)
    {
        // Eager load supaya tidak N+1 query saat looping handovers
        $asset->load('category', 'handovers');

        return response()->json([
            'id'               => $asset->id,
            'name'             => $asset->name,
            'code_asset'       => $asset->code_asset,
            'serial_number'    => $asset->serial_number,
            'condition_status' => $asset->condition_status,
            'tanggal_beli'     => $asset->tanggal_beli->format('d F Y'),
            'pengguna'         => $asset->pengguna,
            'location'         => $asset->location,
            'description'      => $asset->description,
            'image'            => $asset->image ? asset('storage/' . $asset->image) : null,
            'ketersediaan'     => $asset->qty > 0 ? 'Ada' : 'Tidak Ada',

            'handovers' => $asset->handovers->map(function ($h) {
                return [
                    'id'             => $h->id,
                    'jenis_surat'    => $h->jenis_surat,
                    'peminjam_nama'  => $h->peminjam_nama,
                    'tanggal_pinjam' => $h->tanggal_pinjam->format('d M Y'),
                    'status'         => $h->status,
                    'file_path'      => $h->file_path ? asset('storage/' . $h->file_path) : null,
                ];
            }),
        ]);
    }
}