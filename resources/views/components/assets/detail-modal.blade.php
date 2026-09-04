<div
    x-data="{
        open: false,
        loading: false,
        detail: null,
        async loadDetail(id) {
            this.loading = true;
            this.open = true;
            try {
                const res = await fetch(`/assets/${id}/detail`);
                if (!res.ok) throw new Error('Gagal memuat data');
                this.detail = await res.json();
            } catch (e) {
                console.error(e);
                alert('Gagal memuat detail aset.');
                this.open = false;
            } finally {
                this.loading = false;
            }
        }
    }"
    x-on:open-asset-detail.window="loadDetail($event.detail.assetId)"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-start justify-center bg-black/40 overflow-y-auto py-8 px-4"
>
    <div @click.outside="open = false" class="bg-white w-full max-w-xl rounded-xl shadow-lg overflow-hidden">

        <div class="bg-[#0A4C62] px-6 py-4 flex items-center justify-between">
            <h2 class="text-white text-lg font-bold">Detail Aset</h2>
            <button @click="open = false" class="text-white/80 hover:text-white text-xl leading-none">&times;</button>
        </div>

        <template x-if="loading">
            <div class="p-10 text-center text-gray-400 text-sm">Memuat detail...</div>
        </template>

        <template x-if="!loading && detail">
            <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">

                <div class="flex gap-4 border border-gray-200 rounded-xl p-4">
                    <img :src="detail.image ?? 'https://via.placeholder.com/80'" class="w-20 h-20 rounded-lg object-cover shrink-0" />
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-[#0A4C62] font-bold text-lg" x-text="detail.name"></h3>
                            <span
                                class="text-xs px-2 py-0.5 rounded-full"
                                :class="detail.ketersediaan === 'Ada' ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'bg-[#FFEBEE] text-[#D32F2F]'"
                                x-text="detail.ketersediaan"
                            ></span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1" x-text="detail.description"></p>
                        <p class="text-sm text-gray-600 mt-1 flex items-center gap-1">
                            <x-icon name="user" class="w-4 h-4" />
                            <span x-text="detail.pengguna + ' - ' + detail.location"></span>
                        </p>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 border-b pb-2 mb-3">Informasi</h4>
                    <div class="grid grid-cols-2 gap-y-4 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wide">No Aset</p>
                            <p class="font-medium" x-text="detail.code_asset"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wide">Serial Number</p>
                            <p class="font-medium bg-gray-100 inline-block px-2 py-0.5 rounded" x-text="detail.serial_number"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wide">Tanggal Beli</p>
                            <p class="font-medium" x-text="detail.tanggal_beli"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wide">Kondisi</p>
                            <p class="font-medium" x-text="detail.condition_status"></p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between border-b pb-2 mb-3">
                        <h4 class="font-semibold text-gray-700">Dokumen Aset</h4>
                        <button
                            type="button"
                            @click="open = false; $dispatch('open-tambah-surat', { assetId: detail.id })"
                            class="text-[#F26522] text-sm font-medium hover:underline"
                        >+ Tambah Surat</button>
                    </div>

                    <template x-if="detail.handovers.length === 0">
                        <p class="text-sm text-gray-400 py-2">Belum ada surat serah terima.</p>
                    </template>

                    <template x-for="h in detail.handovers" :key="h.id">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 text-sm">
                            <div>
                                <p class="font-medium" x-text="h.peminjam_nama"></p>
                                <p class="text-gray-400 text-xs">
                                    <span x-text="h.jenis_surat === 'fisik' ? 'Surat Fisik' : 'Surat Digital'"></span>
                                    &bull; <span x-text="h.tanggal_pinjam"></span>
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs whitespace-nowrap"
                                    :class="h.status === 'dipinjam' ? 'bg-[#FFF3E0] text-[#D3591E]' : 'bg-[#E8F5E9] text-[#2E7D32]'"
                                    x-text="h.status === 'dipinjam' ? 'Dipinjam' : 'Dikembalikan'"
                                ></span>
                                <template x-if="h.status === 'dipinjam'">
                                    <button
                                        type="button"
                                        @click="open = false; $dispatch('open-pengembalian', { handoverId: h.id })"
                                        class="text-xs text-[#1565C0] hover:underline whitespace-nowrap"
                                    >Kembalikan</button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>