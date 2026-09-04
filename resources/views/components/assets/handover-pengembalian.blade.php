<div
    x-data="{
        open: false,
        handoverId: null,
        submitting: false,
        previewSesudah: [],
        handleFotoSesudah(e) {
            this.previewSesudah = Array.from(e.target.files).map(f => URL.createObjectURL(f));
        }
    }"
    x-on:open-pengembalian.window="open = true; handoverId = $event.detail.handoverId"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
>
    <div @click.outside="open = false" class="bg-white w-full max-w-md rounded-xl shadow-lg overflow-hidden">
        <div class="bg-[#0A4C62] px-6 py-4 flex items-center justify-between">
            <h2 class="text-white text-lg font-bold">Konfirmasi Pengembalian</h2>
            <button type="button" @click="open = false" class="text-white/80 hover:text-white text-xl leading-none">&times;</button>
        </div>

        <form :action="`/handovers/${handoverId}/kembalikan`" method="POST"
            enctype="multipart/form-data" @submit="submitting = true"
            class="p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Kondisi Barang — Sesudah Dikembalikan *</label>
                <p class="text-xs text-gray-400 mb-2">Sebagai bukti kondisi akhir. Boleh lebih dari 1 foto.</p>

                <label class="border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center py-6 cursor-pointer hover:border-[#F26522] transition">
                    <input type="file" name="foto_sesudah[]" accept="image/*" multiple required
                        x-on:change="handleFotoSesudah($event)" class="hidden">
                    <span class="text-sm text-gray-400">Klik untuk ambil/upload foto</span>
                </label>

                <div class="flex gap-2 mt-2 flex-wrap">
                    <template x-for="src in previewSesudah" :key="src">
                        <img :src="src" class="w-16 h-16 rounded object-cover border border-gray-200">
                    </template>
                </div>
            </div>

            <button type="submit" :disabled="submitting"
                class="w-full bg-[#F26522] text-white font-medium py-2.5 rounded-lg hover:bg-[#FF7A00] transition disabled:opacity-50">
                <span x-show="!submitting">Konfirmasi Barang Kembali</span>
                <span x-show="submitting">Menyimpan...</span>
            </button>
        </form>
    </div>
</div>