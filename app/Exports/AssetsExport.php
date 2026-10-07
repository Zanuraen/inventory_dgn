<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssetsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $assets;

    public function __construct($assets)
    {
        $this->assets = $assets;
    }

    public function collection(): Collection
    {
        return $this->assets;
    }

    public function headings(): array
    {
        return ['No', 'Nama Barang', 'Nomor Aset', 'Qty', 'Status', 'Pemakai'];
    }

    public function map($asset): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $asset->name,
            $asset->code_asset,
            $asset->qty,
            $asset->condition_status,
            $asset->pengguna ?? '-',
        ];
    }
}