<x-layouts.app title="Dashboard">

    <x-header-banner title="Dashboard" description="Ringkasan aset dan aktivitas perusahaan hari ini">
        <x-slot:action>
            <x-button href="{{ Route::has('assets.create') ? route('assets.create') : '#' }}">
                <x-icon name="plus" class="h-4 w-4" />
                Tambah Aset
            </x-button>
        </x-slot:action>
    </x-header-banner>

    <div class="space-y-6 p-4 sm:p-6 lg:p-8">

        {{-- Stat cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-stat-card label="Total Aset" value="842 Unit" icon-bg="bg-info-bg" icon-color="text-primary">
                <x-slot:icon><x-icon name="box" class="h-5 w-5" /></x-slot:icon>
            </x-stat-card>

            <x-stat-card label="Kondisi Baik" value="712 Unit" icon-bg="bg-success-bg" icon-color="text-success-text">
                <x-slot:icon><x-icon name="check-circle" class="h-5 w-5" /></x-slot:icon>
            </x-stat-card>

            <x-stat-card label="Perlu Diperbaiki" value="96 Unit" icon-bg="bg-warning-bg" icon-color="text-warning-text">
                <x-slot:icon><x-icon name="wrench" class="h-5 w-5" /></x-slot:icon>
            </x-stat-card>

            <x-stat-card label="Jadwal Pemeliharaan" value="14 Terdekat" icon-bg="bg-danger-bg" icon-color="text-danger-text">
                <x-slot:icon><x-icon name="clock" class="h-5 w-5" /></x-slot:icon>
            </x-stat-card>
        </div>

        {{-- Recent assets card, responsive: scrollable table on small screens --}}
        <div class="rounded-card border border-border-subtle bg-bg-surface p-5 shadow-card">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-bold text-text-primary">Aset Terbaru</h2>
                <x-badge status="info">6 Baru</x-badge>
            </div>

            <div class="-mx-5 overflow-x-auto">
                <table class="w-full min-w-[640px] text-left text-sm">
                    <thead>
                        <tr class="border-b border-border-subtle text-xs font-semibold uppercase tracking-wide text-text-secondary">
                            <th class="px-5 py-2">Nama Barang</th>
                            <th class="px-5 py-2">Kategori</th>
                            <th class="px-5 py-2">Lokasi</th>
                            <th class="px-5 py-2">Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-border-subtle last:border-0">
                            <td class="px-5 py-3 font-medium text-text-primary">Laptop Dell Latitude 5420</td>
                            <td class="px-5 py-3 text-text-secondary">Elektronik</td>
                            <td class="px-5 py-3">
                                <x-badge status="info">Lantai 3 · IT Room</x-badge>
                            </td>
                            <td class="px-5 py-3">
                                <x-badge status="success">Baik</x-badge>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-5 py-3 font-medium text-text-primary">Kursi Kantor Ergonomis</td>
                            <td class="px-5 py-3 text-text-secondary">Meubelair</td>
                            <td class="px-5 py-3">
                                <x-badge status="info">Lantai 2 · Ruang Rapat</x-badge>
                            </td>
                            <td class="px-5 py-3">
                                <x-badge status="warning">Rusak Ringan</x-badge>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>
