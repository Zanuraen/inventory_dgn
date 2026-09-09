<x-layouts.app>

    <x-header-banner
        title="Data Aset"
        description="Seluruh aset perusahaan beserta detail lengkap untuk transparansi dan manajemen inventaris terpadu."
    >
        <x-slot:action>
            <a href="{{ route('assets.create') }}"
               class="bg-[#F26522] hover:bg-[#FF7A00] text-white font-medium px-4 py-2.5 rounded-lg inline-flex items-center justify-center gap-2 transition w-full sm:w-auto">
                <x-icon name="plus" class="w-4 h-4" />
                Tambah Aset
            </a>
        </x-slot:action>
    </x-header-banner>

    <div class="p-4 sm:p-6 space-y-4">

        {{-- Flash message sukses (setelah create/update/delete) --}}
        <x-flash-alert />

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('assets.index') }}"
              class="bg-white border border-[#E5E7EB] rounded-xl p-4 flex flex-col md:flex-row gap-3">

            <div class="flex-1 relative">
                <x-icon name="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" />
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama barang, pengguna, atau lokasi..."
                    class="w-full border border-gray-300 rounded-lg pl-9 pr-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none"
                >
            </div>

            {{-- 2 dropdown filter dijadikan grid 2 kolom di mobile, sejajar biasa di desktop --}}
            <div class="grid grid-cols-2 md:flex gap-3">
                <select name="location" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                    <option value="">Semua Lokasi</option>
                    @foreach ($locations as $loc)
                        <option value="{{ $loc }}" @selected(request('location') === $loc)>{{ $loc }}</option>
                    @endforeach
                </select>

                <select name="ketersediaan" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                    <option value="">Semua Ketersediaan</option>
                    <option value="ada" @selected(request('ketersediaan') === 'ada')>Ada</option>
                    <option value="tidak_ada" @selected(request('ketersediaan') === 'tidak_ada')>Tidak Ada</option>
                </select>
            </div>

            <button type="submit"
                    class="bg-[#0A4C62] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#154E64] transition">
                Cari
            </button>
        </form>

        {{-- ============ TAMPILAN DESKTOP/TABLET: TABEL (tersembunyi di mobile) ============ --}}
        <div class="hidden md:block bg-white border border-[#E5E7EB] rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                            <th class="text-left px-4 py-3">No</th>
                            <th class="text-left px-4 py-3">Nama Barang</th>
                            <th class="text-left px-4 py-3">Qty</th>
                            <th class="text-left px-4 py-3">Pengguna</th>
                            <th class="text-left px-4 py-3">Ketersediaan</th>
                            <th class="text-left px-4 py-3">Lokasi</th>
                            <th class="text-center px-4 py-3">Detail</th>
                            <th class="text-center px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assets as $index => $asset)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $assets->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-[#111827]">{{ $asset->name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $asset->category->name ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-3 font-medium">{{ $asset->qty }}</td>
                                <td class="px-4 py-3">
                                    <p class="font-medium">{{ $asset->pengguna ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($asset->qty > 0)
                                        <span class="inline-flex items-center gap-1.5 bg-[#E8F5E9] text-[#2E7D32] text-xs px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#2E7D32]"></span> Ada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-[#FFEBEE] text-[#D32F2F] text-xs px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#D32F2F]"></span> Tidak Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="bg-[#E3F2FD] text-[#1565C0] text-xs px-2.5 py-1 rounded-lg">
                                        {{ $asset->location ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button
                                        type="button"
                                        x-on:click="$dispatch('open-asset-detail', { assetId: {{ $asset->id }} })"
                                        class="text-[#1565C0] hover:opacity-70"
                                        title="Lihat Detail"
                                    >
                                        <x-icon name="eye" class="w-5 h-5" />
                                    </button>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('assets.edit', $asset) }}"
                                           class="text-gray-400 hover:text-[#0A4C62]" title="Edit">
                                            <x-icon name="pencil" class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('assets.destroy', $asset) }}" method="POST"
                                              onsubmit="return confirm('Yakin hapus aset ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-[#D32F2F]" title="Hapus">
                                                <x-icon name="trash" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-gray-400">
                                    Belum ada data aset.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination desktop --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4 py-3 border-t border-gray-100 text-sm text-gray-500">
                <span>
                    Menampilkan {{ $assets->firstItem() ?? 0 }}-{{ $assets->lastItem() ?? 0 }}
                    dari {{ $assets->total() }} aset
                </span>
                {{ $assets->links() }}
            </div>
        </div>

        {{-- ============ TAMPILAN MOBILE: CARD LIST (tersembunyi di desktop) ============ --}}
        <div class="md:hidden space-y-3">
            @forelse ($assets as $asset)
                <div class="bg-white border border-[#E5E7EB] rounded-xl p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-medium text-[#111827] truncate">{{ $asset->name }}</p>
                            <p class="text-gray-400 text-xs">{{ $asset->category->name ?? '-' }}</p>
                        </div>
                        @if ($asset->qty > 0)
                            <span class="shrink-0 inline-flex items-center gap-1.5 bg-[#E8F5E9] text-[#2E7D32] text-xs px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#2E7D32]"></span> Ada
                            </span>
                        @else
                            <span class="shrink-0 inline-flex items-center gap-1.5 bg-[#FFEBEE] text-[#D32F2F] text-xs px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#D32F2F]"></span> Tidak Ada
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs">Qty</p>
                            <p class="font-medium">{{ $asset->qty }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Pengguna</p>
                            <p class="font-medium">{{ $asset->pengguna ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-400 text-xs">Lokasi</p>
                            <span class="inline-block bg-[#E3F2FD] text-[#1565C0] text-xs px-2.5 py-1 rounded-lg mt-0.5">
                                {{ $asset->location ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-4 pt-3 border-t border-gray-100">
                        <button
                            type="button"
                            x-on:click="$dispatch('open-asset-detail', { assetId: {{ $asset->id }} })"
                            class="flex-1 flex items-center justify-center gap-1.5 text-[#1565C0] text-sm font-medium py-2 rounded-lg border border-gray-200"
                        >
                            <x-icon name="eye" class="w-4 h-4" /> Detail
                        </button>
                        <a href="{{ route('assets.edit', $asset) }}"
                           class="flex-1 flex items-center justify-center gap-1.5 text-[#0A4C62] text-sm font-medium py-2 rounded-lg border border-gray-200">
                            <x-icon name="pencil" class="w-4 h-4" /> Edit
                        </a>
                        <form action="{{ route('assets.destroy', $asset) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus aset ini?')" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-1.5 text-[#D32F2F] text-sm font-medium py-2 rounded-lg border border-gray-200">
                                <x-icon name="trash" class="w-4 h-4" /> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-[#E5E7EB] rounded-xl p-10 text-center text-gray-400">
                    Belum ada data aset.
                </div>
            @endforelse

            {{-- Pagination mobile --}}
            <div class="flex flex-col items-center gap-2 pt-2">
                <span class="text-sm text-gray-500">
                    Menampilkan {{ $assets->firstItem() ?? 0 }}-{{ $assets->lastItem() ?? 0 }}
                    dari {{ $assets->total() }} aset
                </span>
                {{ $assets->links() }}
            </div>
        </div>

    </div>

</x-layouts.app>