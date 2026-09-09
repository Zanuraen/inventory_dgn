<div
    x-data="{
        open: false,
        assetId: null,
        submitting: false,
        previewSurat: null,
        previewSebelum: [],
        handleSuratFile(e) {
            const file = e.target.files[0];
            this.previewSurat = file ? URL.createObjectURL(file) : null;
        },
        handleFotoSebelum(e) {
            this.previewSebelum = Array.from(e.target.files).map(f => URL.createObjectURL(f));
        }
    }"
    x-on:open-surat-fisik.window="open = true; assetId = $event.detail.assetId"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-start justify-center bg-black/40 overflow-y-auto py-8 px-4"
>
    <div @click.outside="open = false" class="bg-white w-full max-w-lg rounded-xl shadow-lg overflow-hidden">

        <div class="bg-[#0A4C62] px-6 py-4 flex items-center justify-between">
            <h2 class="text-white text-lg font-bold">Surat Fisik</h2>
            <button type="button" @click="open = false" class="text-white/80 hover:text-white text-xl leading-none">&times;</button>
        </div>

        <form
            :action="`/assets/${assetId}/handovers`"
            method="POST"
            enctype="multipart/form-data"
            @submit="submitting = true"
            class="p-6 space-y-5 max-h-[75vh] overflow-y-auto"
        >
            @csrf
            <input type="hidden" name="jenis_surat" value="fisik">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Peminjam *</label>
                <input type="text" name="peminjam_nama" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Penggunaan *</label>
                <input type="text" name="tujuan_penggunaan" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Penggunaan *</label>
                <input type="text" name="lokasi_penggunaan" required placeholder="Contoh: Ruang Meeting Lt. 2"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam *</label>
                    <input type="date" name="tanggal_pinjam" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rencana Kembali *</label>
                    <input type="date" name="tanggal_kembalian" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                </div>
            </div>

            {{-- Upload scan surat fisik --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Surat Fisik (foto/scan) *</label>
                <label class="border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center py-6 cursor-pointer hover:border-[#F26522] transition">
                    <input type="file" name="file_fisik" accept=".jpg,.jpeg,.png,.pdf" required
                        x-on:change="handleSuratFile($event)" class="hidden">
                    <template x-if="!previewSurat">
                        <span class="text-sm text-gray-400">Klik untuk ambil/upload foto surat</span>
                    </template>
                    <template x-if="previewSurat">
                        <img :src="previewSurat" class="h-24 rounded object-contain">
                    </template>
                </label>
                <p class="text-xs text-gray-400 mt-1">JPG/PNG/PDF, maks 10MB</p>
            </div>

            {{-- Foto kondisi SEBELUM dipinjam — bisa lebih dari 1 --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Kondisi Barang — Sebelum Dipinjam *</label>
                <p class="text-xs text-gray-400 mb-2">Sebagai bukti kondisi awal. Boleh lebih dari 1 foto.</p>

                <label class="border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center py-6 cursor-pointer hover:border-[#F26522] transition">
                    <input type="file" name="foto_sebelum[]" accept="image/*" multiple required
                        x-on:change="handleFotoSebelum($event)" class="hidden">
                    <span class="text-sm text-gray-400">Klik untuk ambil/upload foto</span>
                </label>

                <div class="flex gap-2 mt-2 flex-wrap">
                    <template x-for="src in previewSebelum" :key="src">
                        <img :src="src" class="w-16 h-16 rounded object-cover border border-gray-200">
                    </template>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <textarea name="notes" rows="2"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none"></textarea>
            </div>

            <label class="flex items-start gap-2 text-sm text-gray-600">
                <input type="checkbox" name="persetujuan" value="1" required class="mt-1">
                Saya bertanggung jawab penuh atas barang ini selama masa peminjaman dan akan mengembalikannya dalam kondisi baik sesuai tanggal yang dijanjikan.
            </label>

            <button type="submit" :disabled="submitting"
                class="w-full bg-[#0A4C62] text-white font-medium py-2.5 rounded-lg hover:bg-[#154E64] transition disabled:opacity-50">
                <span x-show="!submitting">Kirim</span>
                <span x-show="submitting">Menyimpan...</span>
            </button>
        </form>
    </div>
</div>