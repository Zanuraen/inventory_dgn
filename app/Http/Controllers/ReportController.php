<?php

namespace App\Http\Controllers;

use App\Exports\AssetsExport;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $totalUnit     = Asset::count();
        $totalLokasi   = Asset::whereNotNull('location')->distinct()->count('location');
        $totalKategori = Category::count();

        $perKategori = Asset::selectRaw('category_id, COUNT(*) as total')
            ->with('category')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->get();

        $perLokasi = Asset::selectRaw('location, COUNT(*) as total')
            ->whereNotNull('location')
            ->groupBy('location')
            ->orderByDesc('total')
            ->get();

        $asetRusak = Asset::whereIn('condition_status', ['Rusak Ringan', 'Rusak Berat'])->count();

        $assets = $this->filteredQuery($request)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('reports.index', compact(
            'totalUnit', 'totalLokasi', 'totalKategori',
            'perKategori', 'perLokasi', 'asetRusak', 'assets'
        ));
    }

    public function exportPdf(Request $request)
    {
        $assets = $this->filteredQuery($request)->latest()->get();

        $logoPath    = $this->flattenedLogoPath();
        $companyName = Setting::first()?->company_name ?? 'PT Digital Inteligensi Nusantara';

        $pdf = Pdf::loadView('reports.pdf', compact('assets', 'logoPath', 'companyName'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['isRemoteEnabled' => true, 'chroot' => public_path()]);

        return $pdf->download('laporan-aset-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $assets = $this->filteredQuery($request)->latest()->get();

        return Excel::download(new AssetsExport($assets), 'laporan-aset-' . now()->format('Y-m-d') . '.xlsx');
    }

    private function filteredQuery(Request $request)
    {
        return Asset::with('category')
            ->when($request->search, function ($q, $search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%")
                       ->orWhere('code_asset', 'like', "%{$search}%");
                });
            })
            ->when($request->status && $request->status !== 'all', function ($q) use ($request) {
                $q->where('condition_status', $request->status);
            });
    }

    /**
     * Membuat salinan logo dengan background putih (bukan transparan)
     * supaya tidak tampil hitam di dompdf. File asli tidak diubah.
     */
    private function flattenedLogoPath(): string
    {
        $original  = public_path('images/dgn-logo.png');
        $flattened = public_path('images/dgn-logo-pdf.png');

        if (! file_exists($flattened)) {
            $src    = imagecreatefrompng($original);
            $width  = imagesx($src);
            $height = imagesy($src);

            $canvas = imagecreatetruecolor($width, $height);
            imagefill($canvas, 0, 0, imagecolorallocate($canvas, 255, 255, 255));
            imagecopy($canvas, $src, 0, 0, 0, 0, $width, $height);
            imagepng($canvas, $flattened);

            imagedestroy($src);
            imagedestroy($canvas);
        }

        return $flattened;
    }
}