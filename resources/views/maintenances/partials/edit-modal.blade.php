<div
    x-show="showEditModal"
    x-cloak
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
>
    <div
        @click.outside="showEditModal = false"
        x-show="editData"
        x-data="{
            assets: {{ Js::from($assets) }},
            query: '',
            open: false,
            selectedAssetId: '',
            get filteredAssets() {
                if (this.query.length < 1) return [];
                const q = this.query.toLowerCase();
                return this.assets.filter(a =>
                    a.name.toLowerCase().includes(q) || a.code_asset.toLowerCase().includes(q)
                ).slice(0, 8);
            },
            get selectedAsset() {
                return this.assets.find(a => a.id == this.selectedAssetId) ?? null;
            },
            selectAsset(asset) {
                this.selectedAssetId = asset.id;
                this.query = asset.name;
                this.open = false;
            },
        }"
        x-init="$watch('editData', value => {
            if (value) {
                selectedAssetId = value.asset_id;
                query = value.asset_name;
            }
        })"
        class="bg-white rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
    >
        <template x-if="editData">
            <form :action="'/maintenances/' + editData.id" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="asset_id" x-model="selectedAssetId">

                <div class="flex items-start justify-between px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-[#111827]">Edit Jadwal Pemeliharaan</h2>
                    <button type="button" @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                        <x-icon name="x" class="w-5 h-5" />
                    </button>
                </div>

                <div class="px-6 py-5 space-y-6">

                    <div>
                        <h3 class="text-sm font-semibold text-[#0A4C62] mb-3">Informasi Aset</h3>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="relative">
                                <label class="text-sm font-medium text-gray-700">Nama Aset <span class="text-red-500">*</span></label>
                                <input type="text" x-model="query" @focus="open = true" @input="open = true"
                                    autocomplete="off"
                                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                                <div x-show="open && filteredAssets.length" x-cloak
                                     class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                                    <template x-for="asset in filteredAssets" :key="asset.id">
                                        <button type="button" @click="selectAsset(asset)"
                                            class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 flex justify-between gap-2">
                                            <span x-text="asset.name"></span>
                                            <span class="text-gray-400 text-xs" x-text="asset.code_asset"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-700">Nomor Aset</label>
                                <input type="text" readonly :value="selectedAsset ? selectedAsset.code_asset : ''"
                                    class="mt-1 w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-500">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-700">Vendor <span class="text-red-500">*</span></label>
                                <input type="text" name="vendor" x-model="editData.vendor"
                                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-700">Kontak Vendor <span class="text-red-500">*</span></label>
                                <input type="text" name="kontak_vendor" x-model="editData.kontak_vendor"
                                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-[#0A4C62] mb-3">Detail Pemeliharaan</h3>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="text-sm font-medium text-gray-700">Jenis Pemeliharaan <span class="text-red-500">*</span></label>
                                <input type="text" name="jenis_pemeliharaan" x-model="editData.jenis_pemeliharaan"
                                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700">Tanggal Pemeliharaan <span class="text-red-500">*</span></label>
                                <input type="date" name="maintenance_date" x-model="editData.maintenance_date"
                                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700">Jadwal Jatuh Tempo <span class="text-red-500">*</span></label>
                                <input type="date" name="jatuh_tempo" x-model="editData.jatuh_tempo"
                                    class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="text-sm font-medium text-gray-700">Prioritas <span class="text-red-500">*</span></label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach (['rendah' => 'Rendah', 'sedang' => 'Sedang', 'tinggi' => 'Tinggi'] as $value => $label)
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="radio" name="priority" value="{{ $value }}" x-model="editData.priority">
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="text-sm font-medium text-gray-700">Jadwal Berulang</label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach (['tidak' => 'Tidak', 'mingguan' => 'Setiap Minggu', 'bulanan' => 'Setiap Bulan', 'tahunan' => 'Setiap Tahun'] as $value => $label)
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="radio" name="recurrence" value="{{ $value }}" x-model="editData.recurrence">
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-[#0A4C62] mb-3">Catatan</h3>
                        <textarea name="description" rows="3" x-model="editData.description"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none"></textarea>
                    </div>

                    {{-- DOKUMEN YANG SUDAH ADA --}}
                    <div>
                        <h3 class="text-sm font-semibold text-[#0A4C62] mb-3">Dokumen Tersimpan</h3>
                        <template x-if="editData.documents.length === 0">
                            <p class="text-sm text-gray-400">Belum ada dokumen.</p>
                        </template>
                        <ul class="space-y-2">
                            <template x-for="doc in editData.documents" :key="doc.id">
                                <li class="flex items-center justify-between gap-2 border border-gray-100 rounded-lg px-3 py-2">
                                    <a :href="doc.url" target="_blank" class="text-sm text-[#0A4C62] truncate hover:underline" x-text="doc.original_name"></a>
                                    <button type="button"
                                        @click="if (confirm('Hapus dokumen ini?')) { $dispatch('delete-attachment', { type: 'documents', maintenanceId: editData.id, itemId: doc.id }) }"
                                        class="text-xs text-red-500 shrink-0 hover:underline">Hapus</button>
                                </li>
                            </template>
                        </ul>
                        <label class="mt-3 block text-sm font-medium text-gray-700">Tambah Dokumen Baru</label>
                        <input type="file" name="documents[]" multiple accept=".pdf,.docx,.jpg,.jpeg,.png"
                            class="mt-1 text-sm">
                    </div>

                    {{-- FOTO YANG SUDAH ADA --}}
                    <div>
                        <h3 class="text-sm font-semibold text-[#0A4C62] mb-3">Foto Tersimpan</h3>
                        <template x-if="editData.photos.length === 0">
                            <p class="text-sm text-gray-400">Belum ada foto.</p>
                        </template>
                        <div class="grid grid-cols-4 gap-2">
                            <template x-for="photo in editData.photos" :key="photo.id">
                                <div class="relative">
                                    <img :src="photo.url" class="w-full h-16 object-cover rounded-lg border border-gray-200">
                                    <button type="button"
                                        @click="if (confirm('Hapus foto ini?')) { $dispatch('delete-attachment', { type: 'photos', maintenanceId: editData.id, itemId: photo.id }) }"
                                        class="absolute -top-1.5 -right-1.5 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs leading-none">×</button>
                                </div>
                            </template>
                        </div>
                        <label class="mt-3 block text-sm font-medium text-gray-700">Tambah Foto Baru</label>
                        <input type="file" name="photos[]" multiple accept=".jpg,.jpeg,.png"
                            class="mt-1 text-sm">
                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
                    <button type="button" @click="showEditModal = false"
                        class="px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg border border-gray-300 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-[#F26522] hover:bg-[#FF7A00] rounded-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </template>
    </div>
</div>

{{-- Form tersembunyi untuk hapus dokumen/foto individual --}}
<form
    x-ref="deleteAttachmentForm"
    method="POST"
    :action="deleteAttachmentUrl"
    class="hidden"
    x-data="{ deleteAttachmentUrl: '' }"
    @delete-attachment.window="
        deleteAttachmentUrl = '/maintenances/' + $event.detail.maintenanceId + '/' + $event.detail.type + '/' + $event.detail.itemId;
        $nextTick(() => $refs.deleteAttachmentForm.submit());
    "
>
    @csrf
    @method('DELETE')
</form>