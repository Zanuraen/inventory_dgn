<?php

namespace App\Http\Controllers;

use App\Exports\AssetsExport;
use App\Models\Asset;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $totalUnit     = Asset::sum('qty');
        $totalLokasi   = Asset::whereNotNull('location')->distinct()->count('location');
        $totalKategori = Category::count();

        $perKategori = Asset::selectRaw('category_id, SUM(qty) as total')
            ->with('category')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->get();

        $perLokasi = Asset::selectRaw('location, SUM(qty) as total')
            ->whereNotNull('location')
            ->groupBy('location')
            ->orderByDesc('total')
            ->get();

        $asetRusak = Asset::whereIn('condition_status', ['Rusak Ringan', 'Rusak Berat'])->sum('qty');

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

        $pdf = Pdf::loadView('reports.pdf', compact('assets'))->setPaper('a4', 'portrait');

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
}