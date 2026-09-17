<div
    x-show="showAddModal"
    x-cloak
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
>
    <div
        @click.outside="showAddModal = false"
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
        documentNames: [],
        handleFiles(event) {
            this.documentNames = Array.from(event.target.files).map(f => f.name);
        },
        photoPreviews: [],
        handlePhotos(event) {
            this.photoPreviews.forEach(p => URL.revokeObjectURL(p.url));
            this.photoPreviews = Array.from(event.target.files).map(f => ({
                name: f.name,
                url: URL.createObjectURL(f),
            }));
        },
    }"
    class="bg-white rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
    >
        <form action="{{ route('maintenances.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Header modal --}}
            <div class="flex items-start justify-between px-6 py-5 border-b border-gray-100">
                <div>
                    <h2 class="text-lg font-semibold text-[#111827]">Tambah Jadwal Pemeliharaan</h2>
                    <p class="text-sm text-gray-400 mt-0.5">Menambahkan jadwal servis, kalibrasi, atau perawatan aset.</p>
                </div>
                <button type="button" @click="showAddModal = false" class="text-gray-400 hover:text-gray-600">
                    <x-icon name="x" class="w-5 h-5" />
                </button>
            </div>

            <div class="px-6 py-5 space-y-6">

                {{-- INFORMASI ASET --}}
                <div>
                    <h3 class="text-sm font-semibold text-[#0A4C62] mb-3">Informasi Aset</h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="relative">
    <label class="text-sm font-medium text-gray-700">Nama Aset <span class="text-red-500">*</span></label>
    <input
        type="text"
        x-model="query"
        @focus="open = true"
        @input="open = true; selectedAssetId = ''"
        autocomplete="off"
        placeholder="Ketik nama atau nomor aset..."
        class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none @error('asset_id') border-red-400 @enderror"
    >
    <input type="hidden" name="asset_id" :value="selectedAssetId">

    {{-- Dropdown hasil pencarian --}}
    <div
        x-show="open && filteredAssets.length"
        x-cloak
        class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto"
    >
        <template x-for="asset in filteredAssets" :key="asset.id">
            <button
                type="button"
                @click="selectAsset(asset)"
                class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 flex justify-between gap-2"
            >
                <span x-text="asset.name"></span>
                <span class="text-gray-400 text-xs" x-text="asset.code_asset"></span>
            </button>
        </template>
    </div>

    @error('asset_id')
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="text-sm font-medium text-gray-700">Nomor Aset</label>
    <input
        type="text"
        readonly
        :value="selectedAsset ? selectedAsset.code_asset : ''"
        placeholder="Terisi otomatis"
        class="mt-1 w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-500"
    >
</div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Vendor <span class="text-red-500">*</span></label>
                            <input type="text" name="vendor" value="{{ old('vendor') }}"
                                placeholder="Nama vendor"
                                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none @error('vendor') border-red-400 @enderror">
                            @error('vendor')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Kontak Vendor <span class="text-red-500">*</span></label>
                            <input type="text" name="kontak_vendor" value="{{ old('kontak_vendor') }}"
                                placeholder="No. telepon vendor"
                                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none @error('kontak_vendor') border-red-400 @enderror">
                            @error('kontak_vendor')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- DETAIL PEMELIHARAAN --}}
                <div>
                    <h3 class="text-sm font-semibold text-[#0A4C62] mb-3">Detail Pemeliharaan</h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="text-sm font-medium text-gray-700">Jenis Pemeliharaan <span class="text-red-500">*</span></label>
                            <input type="text" name="jenis_pemeliharaan" value="{{ old('jenis_pemeliharaan') }}"
                                placeholder="Contoh: Pembersihan Hardware"
                                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none @error('jenis_pemeliharaan') border-red-400 @enderror">
                            @error('jenis_pemeliharaan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Tanggal Pemeliharaan <span class="text-red-500">*</span></label>
                            <input type="date" name="maintenance_date" value="{{ old('maintenance_date') }}"
                                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none @error('maintenance_date') border-red-400 @enderror">
                            @error('maintenance_date')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Jadwal Jatuh Tempo <span class="text-red-500">*</span></label>
                            <input type="date" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}"
                                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none @error('jatuh_tempo') border-red-400 @enderror">
                            @error('jatuh_tempo')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Prioritas --}}
                    <div class="mt-4">
                        <label class="text-sm font-medium text-gray-700">Prioritas <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-4 mt-2">
                            @foreach (['rendah' => ['label' => 'Rendah', 'dot' => 'bg-green-500'], 'sedang' => ['label' => 'Sedang', 'dot' => 'bg-orange-500'], 'tinggi' => ['label' => 'Tinggi', 'dot' => 'bg-red-500']] as $value => $opt)
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="priority" value="{{ $value }}" @checked(old('priority') === $value)>
                                    <span class="w-2 h-2 rounded-full {{ $opt['dot'] }}"></span>
                                    {{ $opt['label'] }}
                                </label>
                            @endforeach
                        </div>
                        @error('priority')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Jadwal Berulang --}}
                    <div class="mt-4">
                        <label class="text-sm font-medium text-gray-700">Jadwal Berulang</label>
                        <div class="flex flex-wrap gap-4 mt-2">
                            @foreach (['tidak' => 'Tidak', 'mingguan' => 'Setiap Minggu', 'bulanan' => 'Setiap Bulan', 'tahunan' => 'Setiap Tahun'] as $value => $label)
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="recurrence" value="{{ $value }}"
                                        @checked(old('recurrence', 'tidak') === $value)>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                        @error('recurrence')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- DOKUMEN & CATATAN --}}
                <div>
                    <h3 class="text-sm font-semibold text-[#0A4C62] mb-3">Dokumen & Catatan</h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Upload Dokumen</label>
                            <label class="mt-1 flex flex-col items-center justify-center gap-1 border border-dashed border-gray-300 rounded-lg px-4 py-6 text-center cursor-pointer hover:bg-gray-50">
                                <x-icon name="camera" class="w-6 h-6 text-gray-400" />
                                <span class="text-xs text-gray-500">Drag & Drop file di sini</span>
                                <span class="text-xs text-[#0A4C62] underline">atau klik untuk upload</span>
                                <span class="text-[11px] text-gray-400">FORMAT: PDF, DOCX, JPG, PNG (MAKS. 10MB)</span>
                                <input type="file" name="documents[]" multiple class="hidden"
                                    accept=".pdf,.docx,.jpg,.jpeg,.png"
                                    @change="handleFiles($event)">
                            </label>
                            <template x-if="documentNames.length">
                                <ul class="mt-2 space-y-1 text-xs text-gray-600">
                                    <template x-for="name in documentNames" :key="name">
                                        <li x-text="name"></li>
                                    </template>
                                </ul>
                            </template>
                            @error('documents.*')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Catatan</label>
                            <textarea name="description" maxlength="500" rows="5"
                                placeholder="Tuliskan catatan tambahan (opsional)..."
                                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">{{ old('description') }}</textarea>
                            @error('description')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        {{-- DOKUMENTASI / FOTO BARANG --}}
                        <div>
    <h3 class="text-sm font-semibold text-[#0A4C62] mb-3">Dokumentasi / Foto Barang</h3>
    <label class="flex flex-col items-center justify-center gap-1 border border-dashed border-gray-300 rounded-lg px-4 py-6 text-center cursor-pointer hover:bg-gray-50">
        <x-icon name="camera" class="w-6 h-6 text-gray-400" />
        <span class="text-xs text-gray-500">Drag & Drop foto di sini</span>
        <span class="text-xs text-[#0A4C62] underline">atau klik untuk upload</span>
        <span class="text-[11px] text-gray-400">FORMAT: JPG, PNG (MAKS. 10MB)</span>
        <input type="file" name="photos[]" multiple class="hidden"
            accept=".jpg,.jpeg,.png"
            @change="handlePhotos($event)">
    </label>

    <template x-if="photoPreviews.length">
        <div class="grid grid-cols-4 gap-2 mt-3">
            <template x-for="photo in photoPreviews" :key="photo.url">
                <div class="relative">
                    <img :src="photo.url" class="w-full h-16 object-cover rounded-lg border border-gray-200">
                </div>
            </template>
        </div>
    </template>

    @error('photos.*')
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>
                    </div>
                </div>
            </div>
            


            {{-- Footer modal --}}
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
                <button type="button" @click="showAddModal = false"
                    class="px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg border border-gray-300 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-medium text-white bg-[#F26522] hover:bg-[#FF7A00] rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>