
<x-layouts.app title="Dashboard">

    <x-header-banner
        title="Selamat Datang, Admin"
        description="Pantau status inventaris kantor secara real-time. Anda memiliki {{ $totalJadwalAktif }} jadwal pemeliharaan yang masih berjalan hari ini."
    >
    </x-header-banner>

    <div class="space-y-6 p-4 sm:p-6 lg:p-8">

        {{-- Stat cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-stat-card label="Total Aset" value="{{ $totalAset }} Unit" icon-bg="bg-info-bg" icon-color="text-primary">
                <x-slot:icon><x-icon name="box" class="h-5 w-5" /></x-slot:icon>
            </x-stat-card>

                <x-stat-card label="Total Jadwal Maintenance Aktif" value="{{ $totalJadwalAktif }} Jadwal" icon-bg="bg-danger-bg" icon-color="text-danger-text">
                    <x-slot:icon><x-icon name="wrench" class="h-5 w-5" /></x-slot:icon>
                </x-stat-card>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Kategori Aset --}}
            <div class="rounded-card border border-border-subtle bg-bg-surface p-5 shadow-card lg:col-span-1">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-text-primary">Kategori Aset</h2>
                    <a href="{{ route('assets.index') }}" class="text-sm font-medium text-primary hover:underline">Detail</a>
                </div>

                <div class="space-y-4">
                    @forelse ($kategoriBreakdown as $item)
                        @php
                            $percentage = $totalAset > 0 ? round(($item->total / $totalAset) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-text-primary">{{ $item->category->name ?? 'Tanpa Kategori' }}</span>
                                <span class="font-medium text-text-primary">{{ $item->total }}</span>
                            </div>
                            <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-text-secondary">Belum ada data kategori.</p>
                    @endforelse
                </div>
            </div>

            {{-- Aktifitas Pemeliharaan --}}
            <div class="rounded-card border border-border-subtle bg-bg-surface p-5 shadow-card lg:col-span-1">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-text-primary">Aktifitas Pemeliharaan</h2>
                    <a href="{{ route('maintenances.index') }}" class="text-sm font-medium text-primary hover:underline">Detail</a>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('maintenances.index', ['status' => 'terjadwal']) }}" class="flex items-center justify-between text-sm hover:bg-bg-page rounded-lg px-2 py-1.5 -mx-2 transition">
                        <span class="flex items-center gap-2 text-text-primary">
                            <span class="h-2 w-2 rounded-full bg-[#1565C0]"></span> Terjadwal
                        </span>
                        <span class="font-semibold text-text-primary">{{ $aktifitasPemeliharaan['terjadwal'] }} Unit</span>
                    </a>
                    <a href="{{ route('maintenances.index', ['status' => 'terdekat']) }}" class="flex items-center justify-between text-sm hover:bg-bg-page rounded-lg px-2 py-1.5 -mx-2 transition">
                        <span class="flex items-center gap-2 text-text-primary">
                            <span class="h-2 w-2 rounded-full bg-[#F26522]"></span> Terdekat
                        </span>
                        <span class="font-semibold text-text-primary">{{ $aktifitasPemeliharaan['terdekat'] }} Unit</span>
                    </a>
                    <a href="{{ route('maintenances.index', ['status' => 'terlambat']) }}" class="flex items-center justify-between text-sm hover:bg-bg-page rounded-lg px-2 py-1.5 -mx-2 transition">
                        <span class="flex items-center gap-2 text-text-primary">
                            <span class="h-2 w-2 rounded-full bg-[#D32F2F]"></span> Terlambat
                        </span>
                        <span class="font-semibold text-[#D32F2F]">{{ $aktifitasPemeliharaan['terlambat'] }} Unit</span>
                    </a>
                    <a href="{{ route('maintenances.index', ['status' => 'selesai']) }}" class="flex items-center justify-between text-sm hover:bg-bg-page rounded-lg px-2 py-1.5 -mx-2 transition">
                        <span class="flex items-center gap-2 text-text-primary">
                            <span class="h-2 w-2 rounded-full bg-[#2E7D32]"></span> Selesai
                        </span>
                        <span class="font-semibold text-text-primary">{{ $aktifitasPemeliharaan['selesai'] }} Unit</span>
                    </a>
                </div>
            </div>

            {{-- Kondisi Barang --}}
            <div class="rounded-card border border-border-subtle bg-bg-surface p-5 shadow-card lg:col-span-1">
                <h2 class="text-lg font-bold text-text-primary mb-4">Kondisi Barang</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-text-primary">
                            <x-icon name="check-circle" class="h-4 w-4 text-success-text" /> Baik
                        </span>
                        <span class="font-semibold text-text-primary">{{ $kondisiBarang['Baik'] }} Unit</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-text-primary">
                            <x-icon name="alert-circle" class="h-4 w-4 text-warning-text" /> Rusak Ringan
                        </span>
                        <span class="font-semibold text-text-primary">{{ $kondisiBarang['Rusak Ringan'] }} Unit</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-text-primary">
                            <x-icon name="alert-circle" class="h-4 w-4 text-danger-text" /> Rusak Berat
                        </span>
                        <span class="font-semibold text-danger-text">{{ $kondisiBarang['Rusak Berat'] }} Unit</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Tabel Data Aset Terbaru --}}
        <div class="rounded-card border border-border-subtle bg-bg-surface p-5 shadow-card">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-bold text-text-primary">Data Aset Terbaru</h2>
                <x-badge status="info">{{ $recentAssets->count() }} Baru (7 hari)</x-badge>
            </div>

            <div class="-mx-5 overflow-x-auto">
                <table class="w-full min-w-[720px] text-left text-sm">
                    <thead>
                        <tr class="border-b border-border-subtle text-xs font-semibold uppercase tracking-wide text-text-secondary">
                            <th class="px-5 py-2">Tanggal</th>
                            <th class="px-5 py-2">Nama Barang</th>
                            <th class="px-5 py-2">Kondisi</th>
                            <th class="px-5 py-2">Pengguna/Lokasi</th>
                            <th class="px-5 py-2">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentAssets as $asset)
                            <tr class="border-b border-border-subtle last:border-0">
                                <td class="px-5 py-3 text-text-secondary whitespace-nowrap">{{ $asset->created_at->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-3 font-medium text-text-primary">{{ $asset->name }}</td>
                                <td class="px-5 py-3">
                                    @php
                                        $conditionStatus = match ($asset->condition_status) {
                                            'Baik' => 'success',
                                            'Rusak Ringan' => 'warning',
                                            'Rusak Berat' => 'danger',
                                        };
                                    @endphp
                                    <x-badge :status="$conditionStatus">{{ $asset->condition_status }}</x-badge>
                                </td>
                                <td class="px-5 py-3 text-text-secondary">
                                    {{ $asset->pengguna ?? '-' }} — {{ $asset->location ?? '-' }}
                                </td>
                                <td class="px-5 py-3 text-text-secondary">{{ $asset->description ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-6 text-center text-text-secondary">Belum ada aset baru dalam 7 hari terakhir.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>

