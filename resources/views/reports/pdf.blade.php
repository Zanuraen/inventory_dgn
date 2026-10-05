<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Aset</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { width: 100%; border-collapse: collapse; border-bottom: 2px solid #0A4C62; }
        .header td { border: none; padding: 0 0 12px 0; vertical-align: middle; }
        .header .logo img { width: 170px; }
        .header .info { text-align: right; }
        h1 { font-size: 18px; margin: 0; color: #0A4C62; }
        p.subtitle { margin: 3px 0 0; color: #666; font-size: 11px; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 18px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        table.data th { background-color: #0A4C62; color: white; font-size: 11px; text-transform: uppercase; }
        table.data tr:nth-child(even) { background-color: #f8f9fc; }
    </style>
</head>
<body>

    <table class="header">
        <tr>
            <td class="logo">
                <img src="{{ $logoPath }}" alt="Digitelnusa">
            </td>
            <td class="info">
                <h1>Laporan Aset</h1>
                <p class="subtitle">{{ $companyName }} — Sistem Inventaris Aset</p>
                <p class="subtitle">Dicetak pada: {{ now()->format('d F Y, H:i') }}</p>
            </td>
        </tr>
    </table>

    <table class="data">
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