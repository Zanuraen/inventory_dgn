<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Aset</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h1 { font-size: 18px; margin-bottom: 0; color: #0B4A63; }
        p.subtitle { margin-top: 2px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background-color: #0B4A63; color: white; font-size: 11px; text-transform: uppercase; }
        tr:nth-child(even) { background-color: #f8f9fc; }
    </style>
</head>
<body>
    <h1>Laporan Aset</h1>
    <p class="subtitle">PT Digital Inteligensi Nusantara — Sistem Inventaris Aset</p>
    <p class="subtitle">Dicetak pada: {{ now()->format('d F Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Nomor Aset</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Pemakai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assets as $i => $asset)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->code_asset }}</td>
                    <td>{{ $asset->qty }}</td>
                    <td>{{ $asset->condition_status }}</td>
                    <td>{{ $asset->pengguna ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>