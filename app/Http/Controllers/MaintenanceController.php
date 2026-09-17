<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaintenanceRequest;
use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateMaintenanceRequest;
use App\Models\MaintenanceDocument;
use App\Models\MaintenancePhoto;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    // method fitur search
    public function index(Request $request)
    {
        $maintenances = Maintenance::with('asset', 'documents', 'photos')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->query('search');

                $query->where('vendor', 'like', "%{$search}%")
                    ->orWhereHas('asset', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('code_asset', 'like', "%{$search}%");
                    });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $statusFilter = $request->query('status');

                if ($statusFilter === 'selesai') {
                    $query->where('status', 'selesai');
                } elseif ($statusFilter === 'terlambat') {
                    $query->where('status', '!=', 'selesai')->where('jatuh_tempo', '<', now()->toDateString());
                } elseif ($statusFilter === 'terjadwal') {
                    $query->where('status', '!=', 'selesai')->where('jatuh_tempo', '>=', now()->toDateString());
                } elseif ($statusFilter === 'terdekat') {
                    $query->where('status', '!=', 'selesai')
                        ->whereBetween('jatuh_tempo', [now(), now()->addDays(7)]);
                }
            })
            ->when($request->filled('jenis'), function ($query) use ($request) {
                $query->where('jenis_pemeliharaan', $request->query('jenis'));
            })
            ->latest('maintenance_date')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'terjadwal' => Maintenance::where('status', '!=', 'selesai')
                ->where('jatuh_tempo', '>=', now()->toDateString())
                ->count(),
            'jatuh_tempo_7_hari' => Maintenance::where('status', '!=', 'selesai')
                ->whereBetween('jatuh_tempo', [now(), now()->addDays(7)])
                ->count(),
            'terlambat' => Maintenance::where('status', '!=', 'selesai')
                ->where('jatuh_tempo', '<', now()->toDateString())
                ->count(),
            'selesai_bulan_ini' => Maintenance::where('status', 'selesai')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->count(),
        ];

        $assets = Asset::orderBy('name')->get(['id', 'name', 'code_asset']);

        $jenisOptions = Maintenance::query()
            ->select('jenis_pemeliharaan')
            ->distinct()
            ->orderBy('jenis_pemeliharaan')
            ->pluck('jenis_pemeliharaan');

        return view('maintenances.index', compact('maintenances', 'stats', 'assets', 'jenisOptions'));
    }

    public function store(StoreMaintenanceRequest $request)
    {
        $maintenance = Maintenance::create($request->validated());

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('maintenance-documents', 'public');

                $maintenance->documents()->create([
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('maintenance-photos', 'public');

                $maintenance->photos()->create([
                    'photo_path' => $path,
                    'original_name' => $photo->getClientOriginalName(),
                    'file_size' => $photo->getSize(),
                ]);
            }
        }

        return redirect()
            ->route('maintenances.index')
            ->with('success', 'Jadwal pemeliharaan berhasil ditambahkan.');
    }

    // method edit maintenance
    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance)
    {
        $maintenance->update($request->validated());

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('maintenance-documents', 'public');

                $maintenance->documents()->create([
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('maintenance-photos', 'public');

                $maintenance->photos()->create([
                    'photo_path' => $path,
                    'original_name' => $photo->getClientOriginalName(),
                    'file_size' => $photo->getSize(),
                ]);
            }
        }

        return redirect()
            ->route('maintenances.index')
            ->with('success', 'Jadwal pemeliharaan berhasil diperbarui.');
    }

    public function destroyDocument(Maintenance $maintenance, MaintenanceDocument $document)
    {
        abort_unless($document->maintenance_id === $maintenance->id, 404);

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function destroyPhoto(Maintenance $maintenance, MaintenancePhoto $photo)
    {
        abort_unless($photo->maintenance_id === $maintenance->id, 404);

        Storage::disk('public')->delete($photo->photo_path);
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    // method deltete
    public function destroy(Maintenance $maintenance)
    {
        foreach ($maintenance->documents as $document) {
            Storage::disk('public')->delete($document->file_path);
            $document->delete();
        }

        foreach ($maintenance->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
            $photo->delete();
        }

        $maintenance->delete();

        return redirect()
            ->route('maintenances.index')
            ->with('success', 'Jadwal pemeliharaan berhasil dihapus.');
    }

    //method markAsDone
    public function markAsDone(Maintenance $maintenance)
    {
        $maintenance->update(['status' => 'selesai']);

        return back()->with('success', 'Maintenance ditandai selesai.');
    }
}