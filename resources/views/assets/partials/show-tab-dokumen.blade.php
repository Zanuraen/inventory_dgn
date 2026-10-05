<div x-data="{ docSubTab: 'dipinjam' }">

    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
        <div class="flex bg-gray-100 rounded-lg p-1">
            <button type="button" @click="docSubTab = 'dipinjam'"
                class="px-4 py-1.5 text-sm font-medium rounded-md transition"
                :class="docSubTab === 'dipinjam' ? 'bg-white text-[#0A4C62] shadow-sm' : 'text-gray-500'">
                Dipinjam ({{ $handoversDipinjam->total() }})
            </button>
            <button type="button" @click="docSubTab = 'dikembalikan'"
                class="px-4 py-1.5 text-sm font-medium rounded-md transition"
                :class="docSubTab === 'dikembalikan' ? 'bg-white text-[#0A4C62] shadow-sm' : 'text-gray-500'">
                Dikembalikan ({{ $handoversDikembalikan->total() }})
            </button>
        </div>

        <button type="button" @click="$dispatch('open-tambah-surat', { assetId: {{ $asset->id }} })"
            class="bg-[#F26522] hover:bg-[#FF7A00] text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Tambah Surat
        </button>
    </div>

    {{-- SUB-TAB: DIPINJAM --}}
    <div x-show="docSubTab === 'dipinjam'">
        @forelse ($handoversDipinjam as $h)
            <div class="border border-gray-100 rounded-lg p-4 mb-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-medium text-sm text-[#111827] flex items-center gap-1.5">
                            <x-icon name="{{ $h->jenis_surat === 'fisik' ? 'file-text' : 'document' }}"
                                class="w-4 h-4 text-gray-400" />
                            {{ $h->jenis_surat === 'fisik' ? 'Surat Fisik' : 'Surat Digital' }}
                            · {{ $h->peminjam_nama }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $h->tanggal_pinjam->translatedFormat('d M Y') }}
                            @if ($h->tujuan_penggunaan) · {{ $h->tujuan_penggunaan }} @endif
                        </p>
                    </div>
                    <span class="shrink-0 bg-[#FFF3E0] text-[#D3591E] text-xs px-2.5 py-1 rounded-full">Dipinjam</span>
                </div>

                <div class="flex gap-2 mt-3">
                    <button type="button" @click="$dispatch('lihat-surat', @js([
                        'jenis_surat' => $h->jenis_surat,
                        'peminjam_nama' => $h->peminjam_nama,
                        'tujuan_penggunaan' => $h->tujuan_penggunaan,
                        'lokasi_penggunaan' => $h->lokasi_penggunaan,
                        'tanggal_pinjam' => $h->tanggal_pinjam->translatedFormat('d M Y'),
                        'tanggal_kembalian' => $h->tanggal_kembalian?->translatedFormat('d M Y'),
                        'notes' => $h->notes,
                        'file_path' => $h->file_path ? asset('storage/' . $h->file_path) : null,
                        'foto_sebelum' => collect($h->foto_sebelum)->map(fn($p) => asset('storage/' . $p)),
                        'foto_sesudah' => $h->foto_sesudah ? collect($h->foto_sesudah)->map(fn($p) => asset('storage/' . $p)) : [],
                    ]))" class="text-xs text-[#1565C0] font-medium hover:underline flex items-center gap-1">
                        <x-icon name="eye" class="w-3.5 h-3.5" /> Lihat Detail
                    </button>
                    <button type="button" @click="$dispatch('open-pengembalian', { handoverId: {{ $h->id }} })"
                        class="text-xs text-[#0A4C62] font-medium hover:underline">
                        Kembalikan
                    </button>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-400 py-10 text-center">Belum ada surat berstatus dipinjam.</p>
        @endforelse

        <div class="mt-3">
            {{ $handoversDipinjam->onEachSide(1)->links() }}
        </div>
    </div>

    {{-- SUB-TAB: DIKEMBALIKAN --}}
    <div x-show="docSubTab === 'dikembalikan'" x-cloak>
        @forelse ($handoversDikembalikan as $h)
            <div class="border border-gray-100 rounded-lg p-4 mb-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-medium text-sm text-[#111827] flex items-center gap-1.5">
                            <x-icon name="{{ $h->jenis_surat === 'fisik' ? 'file-text' : 'document' }}"
                                class="w-4 h-4 text-gray-400" />
                            {{ $h->jenis_surat === 'fisik' ? 'Surat Fisik' : 'Surat Digital' }}
                            · {{ $h->peminjam_nama }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            Dipinjam {{ $h->tanggal_pinjam->translatedFormat('d M Y') }}
                            · Kembali {{ $h->tanggal_kembalian->translatedFormat('d M Y') }}
                        </p>
                    </div>
                    <span class="shrink-0 bg-[#E8F5E9] text-[#2E7D32] text-xs px-2.5 py-1 rounded-full">Dikembalikan</span>
                </div>

                <div class="mt-3">
                    <button type="button" @click="$dispatch('lihat-surat', @js([
                        'jenis_surat' => $h->jenis_surat,
                        'peminjam_nama' => $h->peminjam_nama,
                        'tujuan_penggunaan' => $h->tujuan_penggunaan,
                        'lokasi_penggunaan' => $h->lokasi_penggunaan,
                        'tanggal_pinjam' => $h->tanggal_pinjam->translatedFormat('d M Y'),
                        'tanggal_kembalian' => $h->tanggal_kembalian?->translatedFormat('d M Y'),
                        'notes' => $h->notes,
                        'file_path' => $h->file_path ? asset('storage/' . $h->file_path) : null,
                        'foto_sebelum' => collect($h->foto_sebelum)->map(fn($p) => asset('storage/' . $p)),
                        'foto_sesudah' => $h->foto_sesudah ? collect($h->foto_sesudah)->map(fn($p) => asset('storage/' . $p)) : [],
                    ]))" class="text-xs text-[#1565C0] font-medium hover:underline flex items-center gap-1">
                        <x-icon name="eye" class="w-3.5 h-3.5" /> Lihat Surat
                    </button>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-400 py-10 text-center">Belum ada surat berstatus dikembalikan.</p>
        @endforelse

        <div class="mt-3">
            {{ $handoversDikembalikan->onEachSide(1)->links() }}
        </div>
    </div>

</div>