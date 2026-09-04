<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHandover;
use Illuminate\Http\Request;

class AssetHandoverController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $data = $request->validate([
            'jenis_surat'        => 'required|in:fisik,digital',
            'peminjam_nama'      => 'required|string|max:255',
            'tujuan_penggunaan'  => 'required|string|max:255',
            'lokasi_penggunaan'  => 'required|string|max:255',
            'tanggal_pinjam'     => 'required|date',
            'tanggal_kembalian'  => 'required|date|after_or_equal:tanggal_pinjam',
            'notes'              => 'nullable|string',
            'persetujuan'        => 'required|accepted',

            // wajib hanya kalau jenis_surat = fisik
            'file_fisik'         => 'required_if:jenis_surat,fisik|file|mimes:jpg,jpeg,png,pdf|max:10240',

            // wajib untuk kedua jenis surat, minimal 1 foto, boleh lebih
            'foto_sebelum'       => 'required|array|min:1',
            'foto_sebelum.*'     => 'image|mimes:jpg,jpeg,png|max:10240',
        ]);

        // Simpan scan surat fisik (kalau ada)
        $filePath = null;
        if ($request->jenis_surat === 'fisik' && $request->hasFile('file_fisik')) {
            $filePath = $request->file('file_fisik')->store('handovers/surat', 'public');
        }

        // Simpan SEMUA foto kondisi sebelum, kumpulkan jadi array path
        $fotoSebelumPaths = [];
        foreach ($request->file('foto_sebelum', []) as $foto) {
            $fotoSebelumPaths[] = $foto->store('handovers/kondisi-sebelum', 'public');
        }

        AssetHandover::create([
            'asset_id'          => $asset->id,
            'user_id'           => auth()->id(), // admin yang input, bukan peminjam
            'jenis_surat'       => $data['jenis_surat'],
            'peminjam_nama'     => $data['peminjam_nama'],
            'tujuan_penggunaan' => $data['tujuan_penggunaan'],
            'lokasi_penggunaan' => $data['lokasi_penggunaan'],
            'tanggal_pinjam'    => $data['tanggal_pinjam'],
            'tanggal_kembalian' => $data['tanggal_kembalian'], // ini masih "rencana kembali"
            'status'            => 'dipinjam',
            'notes'             => $data['notes'] ?? null,
            'file_path'         => $filePath,
            'foto_sebelum'      => $fotoSebelumPaths,
            'persetujuan'       => true,
        ]);

        return back()->with('success', 'Surat serah terima berhasil dibuat.');
    }

    public function kembalikan(Request $request, AssetHandover $handover)
    {
        $data = $request->validate([
            'foto_sesudah'    => 'required|array|min:1',
            'foto_sesudah.*'  => 'image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $fotoSesudahPaths = [];
        foreach ($request->file('foto_sesudah', []) as $foto) {
            $fotoSesudahPaths[] = $foto->store('handovers/kondisi-sesudah', 'public');
        }

        $handover->update([
            'foto_sesudah'      => $fotoSesudahPaths,
            'status'            => 'dikembalikan',
            'tanggal_kembalian' => now(), // timpa "rencana" dengan tanggal aktual kembali
        ]);

        return back()->with('success', 'Barang berhasil dikembalikan.');
    }
}