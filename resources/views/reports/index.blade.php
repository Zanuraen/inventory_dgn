@extends('layouts.app')

@section('title', 'Laporan Aset')

@section('content')

<div class="bg-[#0B4A63] text-white rounded-lg p-6 mb-6">
    <h1 class="text-xl font-bold">Laporan Aset</h1>
    <p class="text-sm text-blue-200 mt-1">Ringkasan dan distribusi aset perusahaan</p>
</div>

{{-- Kartu ringkasan --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 7l1.5 12.5A2 2 0 006.49 21h11.02a2 2 0 001.99-1.5L21 7M3 7l1-3h16l1 3M9 11h6"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Total Aset</p>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalUnit) }} <span class="text-sm font-normal text-gray-400">Unit</span></p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-4-7-7.5-7-11a7 7 0 1114 0c0 3.5-3 7-7 11z"/>
                <circle cx="12" cy="10" r="2.5" stroke-width="1.8"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Aset per Lokasi</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totalLokasi }} <span class="text-sm font-normal text-gray-400">Lokasi</span></p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6a1 1 0 011 1v1H8V5a1 1 0 011-1zM6 6h12v14a1 1 0 01-1 1H7a1 1 0 01-1-1V6z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Kategori Aset</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totalKategori }} <span class="text-sm font-normal text-gray-400">Kategori</span></p>
        </div>
    </div>
</div>

{{-- Distribusi kategori & lokasi --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Donut per kategori --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-sm font-bold text-gray-700 tracking-wide mb-4">DISTRIBUSI ASET PER KATEGORI</h2>

        <div class="flex items-center gap-6">
            <div class="relative w-40 h-40 shrink-0">
                <canvas id="categoryChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-xl font-bold text-gray-800">{{ number_format($totalUnit) }}</span>
                    <span class="text-[10px] text-gray-400 uppercase">Total Aset</span>
                </div>
            </div>

            <ul class="space-y-2 text-sm flex-1">
                @php $colors = ['#3B82F6', '#22C55E', '#F97316', '#A855F7', '#EF4444', '#9CA3AF']; @endphp
                @foreach ($perKategori as $i => $item)
                    @php $pct = $totalUnit > 0 ? round($item->total / $totalUnit * 100, 1) : 0; @endphp
                    <li class="flex items-center justify-between gap-2">
                        <span class="flex items-center gap-2 text-gray-600">
                            <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $colors[$i % count($colors)] }}"></span>
                            {{ $item->category->name ?? 'Tanpa Kategori' }}
                        </span>
                        <span class="text-gray-400 text-xs">{{ $item->total }} ({{ $pct }}%)</span>
                    </li>
                @endforeach
            </ul>
        </div>

        @if ($asetRusak > 0)
            <div class="mt-4 bg-red-50 text-red-600 text-sm font-medium rounded px-4 py-2 flex items-center justify-between">
                <span>🛠️ Aset Rusak</span>
                <span>{{ $asetRusak }} Unit ({{ $totalUnit > 0 ? round($asetRusak / $totalUnit * 100, 1) : 0 }}%)</span>
            </div>
        @endif
    </div>

    {{-- Distribusi lokasi --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-sm font-bold text-gray-700 tracking-wide mb-4">DISTRIBUSI ASET PER LOKASI</h2>
        <div class="space-y-4">
            @forelse ($perLokasi as $lok)
                @php $pct = $totalUnit > 0 ? round($lok->total / $totalUnit * 100, 1) : 0; @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">{{ $lok->location }}</span>
                        <span class="text-gray-400">{{ $lok->total }} ({{ $pct }}%)</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-[#0B4A63] h-2 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400">Belum ada data lokasi.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Tabel data aset --}}
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-end gap-2 mb-4">
    <a href="{{ route('reports.export.pdf', request()->query()) }}"
       class="inline-flex items-center gap-2 border border-gray-300 text-gray-600 text-sm font-medium px-4 py-2 rounded hover:bg-gray-50 transition">
        📄 Download PDF
    </a>
    <a href="{{ route('reports.export.excel', request()->query()) }}"
       class="inline-flex items-center gap-2 bg-[#0B4A63] text-white text-sm font-medium px-4 py-2 rounded hover:bg-[#093c50] transition">
        📊 Download Excel
    </a>
</div>
    <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..."
               class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4A63]/30">

        <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded px-3 py-2 text-sm"></select>
            <option value="all">Semua Status</option>
            @foreach (['Baik', 'Rusak Ringan', 'Rusak Berat'] as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-[#F26522] text-white text-sm font-semibold px-4 py-2 rounded hover:bg-orange-600 transition">
            Cari
        </button>
    </form>

    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-y border-gray-200 text-gray-500 text-xs uppercase tracking-wide">
                <th class="py-2.5 px-2 text-left">No</th>
                <th class="py-2.5 px-2 text-left">Nama Barang</th>
                <th class="py-2.5 px-2 text-left">Nomor Aset</th>
                <th class="py-2.5 px-2 text-center">Qty</th>
                <th class="py-2.5 px-2 text-center">Status</th>
                <th class="py-2.5 px-2 text-left">Pemakai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assets as $i => $asset)
                @php
                    $badge = match($asset->condition_status) {
                        'Baik' => 'bg-green-100 text-green-700',
                        'Rusak Ringan' => 'bg-yellow-100 text-yellow-700',
                        'Rusak Berat' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-2 text-gray-400">{{ $assets->firstItem() + $i }}</td>
                    <td class="py-3 px-2 font-medium text-[#0B4A63]">{{ $asset->name }}</td>
                    <td class="py-3 px-2 text-gray-500">{{ $asset->code_asset }}</td>
                    <td class="py-3 px-2 text-center">{{ $asset->qty }}</td>
                    <td class="py-3 px-2 text-center">
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                            {{ $asset->condition_status }}
                        </span>
                    </td>
                    <td class="py-3 px-2 text-gray-600">{{ $asset->pengguna ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-400 text-xs">Belum ada data aset.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $assets->links('vendor.pagination.custom') }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($perKategori->pluck('category.name')) !!},
            datasets: [{
                data: {!! json_encode($perKategori->pluck('total')) !!},
                backgroundColor: {!! json_encode($colors) !!},
                borderWidth: 0,
            }]
        },
        options: {
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });
</script>

@endsection