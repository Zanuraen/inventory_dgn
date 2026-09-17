<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAset = Asset::count();

        $totalJadwalAktif = Maintenance::where('status', '!=', 'selesai')->count();

        $kondisiBarang = [
            'Baik' => Asset::where('condition_status', 'Baik')->count(),
            'Rusak Ringan' => Asset::where('condition_status', 'Rusak Ringan')->count(),
            'Rusak Berat' => Asset::where('condition_status', 'Rusak Berat')->count(),
        ];

        $aktifitasPemeliharaan = [
            'terjadwal' => Maintenance::where('status', '!=', 'selesai')
                ->where('jatuh_tempo', '>=', now()->toDateString())
                ->count(),
            'terdekat' => Maintenance::where('status', '!=', 'selesai')
                ->whereBetween('jatuh_tempo', [now(), now()->addDays(7)])
                ->count(),
            'terlambat' => Maintenance::where('status', '!=', 'selesai')
                ->where('jatuh_tempo', '<', now()->toDateString())
                ->count(),
            'selesai' => Maintenance::where('status', 'selesai')->count(),
        ];

        $kategoriBreakdown = Asset::selectRaw('category_id, count(*) as total')
            ->with('category')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->get();

        $recentAssets = Asset::with('category')
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->get();

        return view('dashboard', compact(
            'totalAset',
            'totalJadwalAktif',
            'kondisiBarang',
            'aktifitasPemeliharaan',
            'kategoriBreakdown',
            'recentAssets',
        ));
    }
}