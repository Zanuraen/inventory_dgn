<?php

namespace App\Console\Commands;

use App\Models\Maintenance;
use Illuminate\Console\Command;

class GenerateRecurringMaintenances extends Command
{
    protected $signature = 'maintenances:generate-recurring';
    protected $description = 'Membuat jadwal maintenance berikutnya untuk jadwal berulang yang sudah jatuh tempo';

    public function handle(): void
    {
        $eligible = Maintenance::where('recurrence', '!=', 'tidak')
            ->whereNull('next_maintenance_id')
            ->where('jatuh_tempo', '<', now()->toDateString())
            ->get();

        foreach ($eligible as $maintenance) {
            $interval = match ($maintenance->recurrence) {
                'mingguan' => '1 week',
                'bulanan'  => '1 month',
                'tahunan'  => '1 year',
            };

            $newMaintenanceDate = (clone $maintenance->maintenance_date)->modify("+{$interval}");
            $newJatuhTempo = (clone $maintenance->jatuh_tempo)->modify("+{$interval}");

            $next = Maintenance::create([
                'asset_id'           => $maintenance->asset_id,
                'maintenance_date'   => $newMaintenanceDate,
                'jatuh_tempo'        => $newJatuhTempo,
                'jenis_pemeliharaan' => $maintenance->jenis_pemeliharaan,
                'vendor'             => $maintenance->vendor,
                'kontak_vendor'      => $maintenance->kontak_vendor,
                'priority'           => $maintenance->priority,
                'recurrence'         => $maintenance->recurrence,
                'status'             => 'terjadwal',
                'description'        => $maintenance->description,
            ]);

            $maintenance->update(['next_maintenance_id' => $next->id]);

            $this->info("Maintenance #{$maintenance->id} → dibuat jadwal baru #{$next->id} ({$newMaintenanceDate->format('d M Y')})");
        }

        $this->info("Selesai. Total {$eligible->count()} jadwal baru dibuat.");
    }
}