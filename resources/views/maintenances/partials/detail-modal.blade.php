<div x-show="showDetailModal" x-cloak x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
    <div @click.outside="showDetailModal = false" x-show="selectedDetail"
        class="bg-white rounded-xl w-full max-w-xl max-h-[90vh] overflow-y-auto">
        <template x-if="selectedDetail">
            <div>
                <div class="flex items-start justify-between px-6 py-5 border-b border-gray-100">
                    <div>
                        <h2 class="text-lg font-semibold text-[#111827]" x-text="selectedDetail.asset_name"></h2>
                        <p class="text-sm text-gray-400 mt-0.5" x-text="selectedDetail.asset_code"></p>
                    </div>
                    <button type="button" @click="showDetailModal = false" class="text-gray-400 hover:text-gray-600">
                        <x-icon name="x" class="w-5 h-5" />
                    </button>
                </div>
                <div class="px-6 py-5 space-y-5">

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs">Jenis Pemeliharaan</p>
                            <p class="font-medium" x-text="selectedDetail.jenis_pemeliharaan"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Status</p>
                            <p class="font-medium capitalize" x-text="selectedDetail.status"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Tanggal Pemeliharaan</p>
                            <p class="font-medium" x-text="selectedDetail.maintenance_date"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Jadwal Jatuh Tempo</p>
                            <p class="font-medium" x-text="selectedDetail.jatuh_tempo"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Prioritas</p>
                            <p class="font-medium capitalize" x-text="selectedDetail.priority"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Jadwal Berulang</p>
                            <p class="font-medium capitalize" x-text="selectedDetail.recurrence"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Vendor</p>
                            <p class="font-medium" x-text="selectedDetail.vendor"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Kontak Vendor</p>
                            <p class="font-medium" x-text="selectedDetail.kontak_vendor"></p>
                        </div>
                    </div>

                    <div>
                        <p class="text-gray-400 text-xs">Catatan</p>
                        <p class="text-sm mt-1" x-text="selectedDetail.description || '-'"></p>
                    </div>

                    <div>
                        <p class="text-gray-400 text-xs mb-2">Dokumen Terlampir</p>
                        <template x-if="selectedDetail.documents.length === 0">
                            <p class="text-sm text-gray-400">Belum ada dokumen.</p>
                        </template>
                        <ul class="space-y-2">
                            <template x-for="doc in selectedDetail.documents" :key="doc.url">
                                <li
                                    class="flex items-center justify-between gap-2 border border-gray-100 rounded-lg px-3 py-2">
                                    <span class="text-sm truncate" x-text="doc.original_name"></span>
                                    <a :href="doc.url" target="_blank"
                                        class="text-xs text-[#0A4C62] font-medium shrink-0 hover:underline">
                                        Unduh
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-2">Foto Barang</p>
                        <template x-if="selectedDetail.photos.length === 0">
                            <p class="text-sm text-gray-400">Belum ada foto.</p>
                        </template>
                        <div class="grid grid-cols-4 gap-2">
                            <template x-for="photo in selectedDetail.photos" :key="photo.url">
                                <a :href="photo.url" target="_blank">
                                    <img :src="photo.url" :alt="photo.original_name"
                                        class="w-full h-16 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition">
                                </a>
                            </template>
                        </div>
                    </div>
                    <div class="pt-2 flex gap-2">
                        <!-- Tombol Riwayat -->
                        <button type="button"
                            @click="showDetailModal = false; $dispatch('open-asset-detail', { assetId: selectedDetail.asset_id })"
                            class="flex-1 flex items-center justify-center gap-2 text-sm font-medium text-[#0A4C62] border border-[#0A4C62] rounded-lg py-2.5 hover:bg-[#0A4C62] hover:text-white transition">
                            <x-icon name="clock" class="w-4 h-4" />
                            Lihat Riwayat Aset
                        </button>
                        <!-- Tombol Tandai Selesai -->
                        <template x-if="selectedDetail.status !== 'selesai'">
                            <form :action="'/maintenances/' + selectedDetail.id + '/selesai'" method="POST"
                                class="flex-1">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    onclick="return confirm('Tandai maintenance ini sebagai selesai?')"
                                    class="w-full flex items-center justify-center gap-2 text-sm font-medium text-white bg-[#2E7D32] rounded-lg py-2.5 hover:opacity-90 transition">
                                    <x-icon name="check-circle" class="w-4 h-4" />
                                    Tandai Selesai
                                </button>
                            </form>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>