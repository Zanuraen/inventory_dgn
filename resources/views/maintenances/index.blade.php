<x-layouts.app>

    <div x-data="{
        showAddModal: false,
        showDetailModal: false,
        selectedDetail: null,
        showEditModal: false,
        editData: null,
    }" @open-maintenance-detail.window="selectedDetail = $event.detail; showDetailModal = true"
        @open-maintenance-edit.window="editData = $event.detail; showEditModal = true">

        <x-header-banner title="Pemeliharaan Aset"
            description="Jadwal servis, kalibrasi, dan perawatan aset perusahaan secara berkala untuk menjaga efisiensi operasional.">
            <x-slot:action>
                <button type="button" @click="showAddModal = true"
                    class="bg-[#F26522] hover:bg-[#FF7A00] text-white font-medium px-4 py-2.5 rounded-lg inline-flex items-center justify-center gap-2 transition w-full sm:w-auto">
                    <x-icon name="plus" class="w-4 h-4" />
                    Tambah Jadwal Pemeliharaan
                </button>
            </x-slot:action>
        </x-header-banner>

        <div class="p-4 sm:p-6 space-y-4">

            <x-flash-alert />

            {{-- ====== STATISTIK ====== --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('maintenances.index', ['status' => 'terjadwal']) }}"
                    class="bg-white border border-[#E5E7EB] rounded-xl p-4 block hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <x-icon name="file-text" class="w-5 h-5 text-[#1565C0]" />
                        <span
                            class="text-[10px] font-semibold bg-[#E3F2FD] text-[#1565C0] px-2 py-0.5 rounded-full">TERJADWAL</span>
                    </div>
                    <p class="text-2xl font-bold text-[#111827] mt-3">{{ $stats['terjadwal'] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Aset menunggu giliran</p>
                </a>

                <a href="{{ route('maintenances.index', ['status' => 'terdekat']) }}"
                    class="bg-white border border-[#E5E7EB] rounded-xl p-4 block hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <x-icon name="alert-circle" class="w-5 h-5 text-[#F26522]" />
                        <span
                            class="text-[10px] font-semibold bg-[#FFF3E0] text-[#F26522] px-2 py-0.5 rounded-full">TERDEKAT</span>
                    </div>
                    <p class="text-2xl font-bold text-[#111827] mt-3">{{ $stats['jatuh_tempo_7_hari'] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Perlu tindakan segera</p>
                </a>

                <a href="{{ route('maintenances.index', ['status' => 'terlambat']) }}"
                    class="bg-white border border-[#E5E7EB] rounded-xl p-4 block hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <x-icon name="alert-circle" class="w-5 h-5 text-[#D32F2F]" />
                        <span
                            class="text-[10px] font-semibold bg-[#FFEBEE] text-[#D32F2F] px-2 py-0.5 rounded-full">BAHAYA</span>
                    </div>
                    <p class="text-2xl font-bold text-[#D32F2F] mt-3">{{ $stats['terlambat'] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Melewati jadwal rutin</p>
                </a>

                <a href="{{ route('maintenances.index', ['status' => 'selesai']) }}"
                    class="bg-white border border-[#E5E7EB] rounded-xl p-4 block hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <x-icon name="check-circle" class="w-5 h-5 text-[#2E7D32]" />
                        <span
                            class="text-[10px] font-semibold bg-[#E8F5E9] text-[#2E7D32] px-2 py-0.5 rounded-full">SELESAI</span>
                    </div>
                    <p class="text-2xl font-bold text-[#111827] mt-3">{{ $stats['selesai_bulan_ini'] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Pekerjaan diselesaikan</p>
                </a>
            </div>

            {{-- ====== SEARCH & FILTER (fungsional di STEP 7-8) ====== --}}

            <form method="GET" action="{{ route('maintenances.index') }}"
                class="bg-white border border-[#E5E7EB] rounded-xl p-4 flex flex-col md:flex-row gap-3">

                <div class="flex-1 relative">
                    <x-icon name="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" />
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama aset, nomor aset, atau vendor..."
                        class="w-full border border-gray-300 rounded-lg pl-9 pr-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                </div>

                <div class="grid grid-cols-2 md:flex gap-3">
                    <select name="status" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                        <option value="">Semua Status</option>
                        <option value="terjadwal" @selected(request('status') === 'terjadwal')>Terjadwal</option>
                        <option value="terdekat" @selected(request('status') === 'terdekat')>Jatuh Tempo 7 Hari</option>
                        <option value="terlambat" @selected(request('status') === 'terlambat')>Terlambat</option>
                        <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                    </select>

                    <select name="jenis" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenisOptions as $jenis)
                            <option value="{{ $jenis }}" @selected(request('jenis') === $jenis)>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>


                <button type="submit"
                    class="bg-[#0A4C62] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#154E64] transition">
                    Cari
                </button>
            </form>

            {{-- ====== TABEL (DESKTOP) ====== --}}
            <div class="hidden md:block bg-white border border-[#E5E7EB] rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                                <th class="text-left px-4 py-3">No</th>
                                <th class="text-left px-4 py-3">Nama Aset</th>
                                <th class="text-left px-4 py-3">Nomor Aset</th>
                                <th class="text-left px-4 py-3">Jenis Pemeliharaan</th>
                                <th class="text-left px-4 py-3">Jadwal Jatuh Tempo</th>
                                <th class="text-left px-4 py-3">Kontak Vendor</th>
                                <th class="text-left px-4 py-3">Status</th>
                                <th class="text-center px-4 py-3">Detail</th>
                                <th class="text-center px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($maintenances as $index => $m)
                                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                                            <td class="px-4 py-3 text-gray-500">{{ $maintenances->firstItem() + $index }}</td>
                                                            <td class="px-4 py-3 font-medium text-[#111827]">{{ $m->asset->name }}</td>
                                                            <td class="px-4 py-3 text-gray-500">{{ $m->asset->code_asset }}</td>
                                                            <td class="px-4 py-3">{{ $m->jenis_pemeliharaan }}</td>
                                                            <td class="px-4 py-3">
                                                                <p class="font-medium text-[#111827]">
                                                                    {{ $m->jatuh_tempo->translatedFormat('d M Y') }}
                                                                </p>
                                                            </td>
                                                            <td class="px-4 py-3">
                                                                <p class="font-medium">{{ $m->vendor }}</p>
                                                                <p class="text-gray-400 text-xs">{{ $m->kontak_vendor }}</p>
                                                            </td>
                                                            <td class="px-4 py-3">
                                                                @php
                                                                    $statusStyle = [
                                                                        'terjadwal' => 'bg-[#E3F2FD] text-[#1565C0]',
                                                                        'terlambat' => 'bg-[#FFEBEE] text-[#D32F2F]',
                                                                        'selesai' => 'bg-[#E8F5E9] text-[#2E7D32]',
                                                                    ][$m->status];
                                                                @endphp
                                                                <span
                                                                    class="inline-flex items-center gap-1.5 {{ $statusStyle }} text-xs px-2.5 py-1 rounded-full uppercase font-medium">
                                                                    {{ $m->status }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-3 text-center">
                                                                <button type="button" @click="$dispatch('open-maintenance-detail', {{ Js::from([
                                    'id' => $m->id,
                                    'asset_id' => $m->asset_id,
                                    'asset_name' => $m->asset->name,
                                    'asset_code' => $m->asset->code_asset,
                                    'vendor' => $m->vendor,
                                    'kontak_vendor' => $m->kontak_vendor,
                                    'jenis_pemeliharaan' => $m->jenis_pemeliharaan,
                                    'maintenance_date' => $m->maintenance_date->translatedFormat('d M Y'),
                                    'jatuh_tempo' => $m->jatuh_tempo->translatedFormat('d M Y'),
                                    'priority' => $m->priority,
                                    'status' => $m->status,
                                    'recurrence' => $m->recurrence,
                                    'description' => $m->description,
                                    'documents' => $m->documents->map(fn($d) => [
                                        'original_name' => $d->original_name,
                                        'url' => \Illuminate\Support\Facades\Storage::url($d->file_path),
                                    ])->values(),
                                    'photos' => $m->photos->map(fn($p) => [
                                        'original_name' => $p->original_name,
                                        'url' => \Illuminate\Support\Facades\Storage::url($p->photo_path),
                                    ])->values(),
                                ]) }})" class="text-[#1565C0] hover:opacity-70" title="Lihat Detail">
                                                                    <x-icon name="eye" class="w-5 h-5" />
                                                                </button>
                                                            </td>
                                                            <td class="px-4 py-3">
                                                                <div class="flex items-center justify-center gap-2">
                                                                    <button type="button" @click="$dispatch('open-maintenance-edit', {{ Js::from([
                                    'id' => $m->id,
                                    'asset_id' => $m->asset_id,
                                    'asset_name' => $m->asset->name,
                                    'vendor' => $m->vendor,
                                    'kontak_vendor' => $m->kontak_vendor,
                                    'jenis_pemeliharaan' => $m->jenis_pemeliharaan,
                                    'maintenance_date' => $m->maintenance_date->format('Y-m-d'),
                                    'jatuh_tempo' => $m->jatuh_tempo->format('Y-m-d'),
                                    'priority' => $m->priority,
                                    'recurrence' => $m->recurrence,
                                    'description' => $m->description,
                                    'documents' => $m->documents->map(fn($d) => [
                                        'id' => $d->id,
                                        'original_name' => $d->original_name,
                                        'url' => \Illuminate\Support\Facades\Storage::url($d->file_path),
                                    ])->values(),
                                    'photos' => $m->photos->map(fn($p) => [
                                        'id' => $p->id,
                                        'original_name' => $p->original_name,
                                        'url' => \Illuminate\Support\Facades\Storage::url($p->photo_path),
                                    ])->values(),
                                ]) }})" class="text-gray-400 hover:text-[#0A4C62]" title="Edit">
                                                                        <x-icon name="pencil" class="w-4 h-4" />
                                                                    </button>
                                                                    <button type="button"
                                                                        @click="if (confirm('Yakin hapus jadwal pemeliharaan ini? Semua dokumen dan foto terkait akan ikut terhapus.')) { $dispatch('delete-maintenance', { id: {{ $m->id }} }) }"
                                                                        class="text-gray-400 hover:text-[#D32F2F]" title="Hapus">
                                                                        <x-icon name="trash" class="w-4 h-4" />
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-10 text-center text-gray-400">Belum ada data
                                        pemeliharaan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div
                    class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4 py-3 border-t border-gray-100 text-sm text-gray-500">
                    <span>
                        Menampilkan {{ $maintenances->firstItem() ?? 0 }}-{{ $maintenances->lastItem() ?? 0 }}
                        dari {{ $maintenances->total() }} data
                    </span>
                    {{ $maintenances->links() }}
                </div>
            </div>

            {{-- ====== CARD (MOBILE) ====== --}}
            <div class="md:hidden space-y-3">
                @forelse ($maintenances as $m)
                                <div class="bg-white border border-[#E5E7EB] rounded-xl p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="font-medium text-[#111827] truncate">{{ $m->asset->name }}</p>
                                            <p class="text-gray-400 text-xs">{{ $m->asset->code_asset }}</p>
                                        </div>
                                        @php
                                            $statusStyle = [
                                                'terjadwal' => 'bg-[#E3F2FD] text-[#1565C0]',
                                                'terlambat' => 'bg-[#FFEBEE] text-[#D32F2F]',
                                                'selesai' => 'bg-[#E8F5E9] text-[#2E7D32]',
                                            ][$m->status];
                                        @endphp
                                        <span
                                            class="shrink-0 {{ $statusStyle }} text-xs px-2.5 py-1 rounded-full uppercase font-medium">
                                            {{ $m->status }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                                        <div>
                                            <p class="text-gray-400 text-xs">Jenis</p>
                                            <p class="font-medium">{{ $m->jenis_pemeliharaan }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-400 text-xs">Jatuh Tempo</p>
                                            <p class="font-medium">{{ $m->jatuh_tempo->translatedFormat('d M Y') }}</p>
                                        </div>
                                        <div class="col-span-2">
                                            <p class="text-gray-400 text-xs">Vendor</p>
                                            <p class="font-medium">{{ $m->vendor }} — {{ $m->kontak_vendor }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 mt-4 pt-3 border-t border-gray-100">
                                        <button type="button" @click="$dispatch('open-maintenance-detail', {{ Js::from([
                        'id' => $m->id,
                        'asset_id' => $m->asset_id,
                        'asset_name' => $m->asset->name,
                        'asset_code' => $m->asset->code_asset,
                        'vendor' => $m->vendor,
                        'kontak_vendor' => $m->kontak_vendor,
                        'jenis_pemeliharaan' => $m->jenis_pemeliharaan,
                        'maintenance_date' => $m->maintenance_date->translatedFormat('d M Y'),
                        'jatuh_tempo' => $m->jatuh_tempo->translatedFormat('d M Y'),
                        'priority' => $m->priority,
                        'status' => $m->status,
                        'recurrence' => $m->recurrence,
                        'description' => $m->description,
                        'documents' => $m->documents->map(fn($d) => [
                            'original_name' => $d->original_name,
                            'url' => \Illuminate\Support\Facades\Storage::url($d->file_path),
                        ])->values(),
                        'photos' => $m->photos->map(fn($p) => [
                            'original_name' => $p->original_name,
                            'url' => \Illuminate\Support\Facades\Storage::url($p->photo_path),
                        ])->values(),
                    ]) }})"
                                            class="flex-1 flex items-center justify-center gap-1.5 text-[#1565C0] text-sm font-medium py-2 rounded-lg border border-gray-200">
                                            <x-icon name="eye" class="w-4 h-4" /> Detail
                                        </button>
                                        <button type="button" @click="$dispatch('open-maintenance-edit', {{ Js::from([
                        'id' => $m->id,
                        'asset_id' => $m->asset_id,
                        'asset_name' => $m->asset->name,
                        'vendor' => $m->vendor,
                        'kontak_vendor' => $m->kontak_vendor,
                        'jenis_pemeliharaan' => $m->jenis_pemeliharaan,
                        'maintenance_date' => $m->maintenance_date->format('Y-m-d'),
                        'jatuh_tempo' => $m->jatuh_tempo->format('Y-m-d'),
                        'priority' => $m->priority,
                        'recurrence' => $m->recurrence,
                        'description' => $m->description,
                        'documents' => $m->documents->map(fn($d) => [
                            'id' => $d->id,
                            'original_name' => $d->original_name,
                            'url' => \Illuminate\Support\Facades\Storage::url($d->file_path),
                        ])->values(),
                        'photos' => $m->photos->map(fn($p) => [
                            'id' => $p->id,
                            'original_name' => $p->original_name,
                            'url' => \Illuminate\Support\Facades\Storage::url($p->photo_path),
                        ])->values(),
                    ]) }})"
                                            class="flex-1 flex items-center justify-center gap-1.5 text-[#0A4C62] text-sm font-medium py-2 rounded-lg border border-gray-200">
                                            <x-icon name="pencil" class="w-4 h-4" />
                                        </button>


                                        <button type="button"
                                            @click="if (confirm('Yakin hapus jadwal pemeliharaan ini? Semua dokumen dan foto terkait akan ikut terhapus.')) { $dispatch('delete-maintenance', { id: {{ $m->id }} }) }"
                                            class="flex-1 flex items-center justify-center gap-1.5 text-[#D32F2F] text-sm font-medium py-2 rounded-lg border border-gray-200">
                                            <x-icon name="trash" class="w-4 h-4" /> Hapus
                                        </button>
                                    </div>
                                </div>
                @empty
                    <div class="bg-white border border-[#E5E7EB] rounded-xl p-10 text-center text-gray-400">
                        Belum ada data pemeliharaan.
                    </div>
                @endforelse

                <div class="flex flex-col items-center gap-2 pt-2">
                    <span class="text-sm text-gray-500">
                        Menampilkan {{ $maintenances->firstItem() ?? 0 }}-{{ $maintenances->lastItem() ?? 0 }}
                        dari {{ $maintenances->total() }} data
                    </span>
                    {{ $maintenances->links() }}
                </div>
            </div>

        </div>

        @include('maintenances.partials.create-modal'),
        @include('maintenances.partials.detail-modal'),
        @include('maintenances.partials.edit-modal')

        <form x-ref="deleteMaintenanceForm" method="POST" :action="'/maintenances/' + deleteMaintenanceId"
            class="hidden" x-data="{ deleteMaintenanceId: '' }" @delete-maintenance.window="
                deleteMaintenanceId = $event.detail.id;
                $nextTick(() => $refs.deleteMaintenanceForm.submit());
            ">
            @csrf
            @method('DELETE')
        </form>
    </div>

</x-layouts.app>