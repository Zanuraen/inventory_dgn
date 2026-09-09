<div
    x-data="{ open: false, assetId: null }"
    x-on:open-tambah-surat.window="open = true; assetId = $event.detail.assetId"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
>
    <div @click.outside="open = false" class="bg-white w-full max-w-sm rounded-xl shadow-lg overflow-hidden">
        <div class="bg-[#0A4C62] px-6 py-4 flex items-center justify-between">
            <h2 class="text-white text-lg font-bold">Tambah Surat</h2>
            <button @click="open = false" class="text-white/80 hover:text-white text-xl leading-none">&times;</button>
        </div>

        <div class="p-6 space-y-3">
            <p class="text-sm text-gray-500 mb-2">Pilih jenis surat serah terima yang ingin dibuat:</p>

            <button
                type="button"
                @click="open = false; $dispatch('open-surat-fisik', { assetId })"
                class="w-full flex items-center gap-3 border border-gray-200 rounded-lg p-4 hover:border-[#F26522] hover:bg-orange-50 transition"
            >
                <x-icon name="camera" class="w-6 h-6 text-[#0A4C62]" />
                <div class="text-left">
                    <p class="font-medium text-gray-800">Surat Fisik</p>
                    <p class="text-xs text-gray-400">Upload foto/scan surat yang sudah ditandatangani manual</p>
                </div>
            </button>

            <button
                type="button"
                @click="open = false; $dispatch('open-surat-digital', { assetId })"
                class="w-full flex items-center gap-3 border border-gray-200 rounded-lg p-4 hover:border-[#F26522] hover:bg-orange-50 transition"
            >
                <x-icon name="document" class="w-6 h-6 text-[#0A4C62]" />
                <div class="text-left">
                    <p class="font-medium text-gray-800">Surat Digital</p>
                    <p class="text-xs text-gray-400">Isi form langsung di sistem, tanpa cetak fisik</p>
                </div>
            </button>
        </div>
    </div>
</div>