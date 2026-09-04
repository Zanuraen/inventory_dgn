<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetHandover;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssetHandoverSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()->id;
        $assetIds = Asset::pluck('id');

        // Ambil beberapa asset secara acak untuk dibuatkan riwayat handover dummy
        foreach ($assetIds->random(min(10, $assetIds->count())) as $assetId) {

            $status = fake()->randomElement(['dipinjam', 'dikembalikan']);
            $jenisSurat = fake()->randomElement(['fisik', 'digital']);

            AssetHandover::create([
                'asset_id'          => $assetId,
                'user_id'           => $userId,
                'jenis_surat'       => $jenisSurat,
                'peminjam_nama'     => fake()->name(),
                'tujuan_penggunaan' => fake()->sentence(4),
                'lokasi_penggunaan' => fake()->randomElement([
                    'Ruang Meeting Lt. 2', 'Lantai 3 - IT Room', 'Gudang', 'Ruang Training',
                ]),
                'tanggal_pinjam'    => fake()->dateTimeBetween('-3 months', 'now'),
                'tanggal_kembalian' => fake()->dateTimeBetween('now', '+1 month'),
                'status'            => $status,
                'notes'             => fake()->sentence(6),

                // hanya diisi kalau jenis_surat fisik, meniru kondisi nyata
                'file_path'         => $jenisSurat === 'fisik' ? 'handovers/surat/dummy-surat.jpg' : null,

                // selalu ada foto sebelum (dibuat bersamaan saat surat dibuat)
                'foto_sebelum'      => ['handovers/kondisi-sebelum/dummy-1.jpg'],

                // foto sesudah HANYA ada kalau statusnya sudah dikembalikan
                'foto_sesudah'      => $status === 'dikembalikan' ? ['handovers/kondisi-sesudah/dummy-1.jpg'] : null,

                'persetujuan'       => true,
            ]);
        }
    }
}