<div x-data="{ handover: null, previewImage: null, previewOpen: false }"
    x-on:lihat-surat.window="handover = $event.detail" x-show="handover" x-cloak
    class="fixed inset-0 z-50 flex items-start justify-center bg-black/40 overflow-y-auto py-8 px-4">
    <div @click.outside="handover = null" class="bg-white w-full max-w-lg rounded-xl shadow-lg overflow-hidden">

        <div class="bg-[#0A4C62] px-6 py-4 flex items-center justify-between">
            <h2 class="text-white text-lg font-bold">
                <span x-text="handover?.jenis_surat === 'fisik' ? 'Surat Fisik' : 'Surat Digital'"></span>
            </h2>
            <button type="button" @click="handover = null"
                class="text-white/80 hover:text-white text-xl leading-none">&times;</button>
        </div>

        <div class="p-6 space-y-5 max-h-[75vh] overflow-y-auto text-sm">

            <template x-if="handover?.jenis_surat === 'fisik' && handover?.file_path">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide mb-2">Scan Surat</p>
                    <button type="button" @click="previewImage = handover.file_path; previewOpen = true"
                        class="w-full flex items-center gap-3 border border-gray-200 rounded-lg p-3 hover:border-[#0A4C62] hover:bg-gray-50 transition text-left">
                        <div class="w-10 h-10 rounded-lg bg-[#E3F2FD] flex items-center justify-center shrink-0">
                            <x-icon name="file-text" class="w-5 h-5 text-[#1565C0]" />
                        </div>
                        <div class="min-w-0">
                            <p class="font-medium text-sm text-[#111827]">Surat Fisik</p>
                            <p class="text-xs text-gray-400">Klik untuk lihat scan surat</p>
                        </div>
                    </button>
                </div>
            </template>

            <div class="grid grid-cols-2 gap-y-3">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Nama</p>
                    <p class="font-medium" x-text="handover?.peminjam_nama"></p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Tujuan</p>
                    <p class="font-medium" x-text="handover?.tujuan_penggunaan || '-'"></p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Lokasi Penggunaan</p>
                    <p class="font-medium" x-text="handover?.lokasi_penggunaan || '-'"></p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Tanggal Pinjam</p>
                    <p class="font-medium" x-text="handover?.tanggal_pinjam"></p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Tanggal Kembali</p>
                    <p class="font-medium" x-text="handover?.tanggal_kembalian || '-'"></p>
                </div>
            </div>

            <template x-if="handover?.notes">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide">Catatan</p>
                    <p class="font-medium mt-0.5" x-text="handover?.notes"></p>
                </div>
            </template>

            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wide mb-2">Foto Kondisi — Sebelum</p>
                <div class="flex gap-2 flex-wrap">
                    <template x-for="src in (handover?.foto_sebelum || [])" :key="src">
                        <button type="button" @click="previewImage = src; previewOpen = true">
                            <img :src="src"
                                class="w-16 h-16 rounded-lg object-cover border border-gray-100 hover:opacity-80 transition">
                        </button>
                    </template>
                </div>
            </div>

            <template x-if="handover?.foto_sesudah && handover.foto_sesudah.length > 0">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide mb-2">Foto Kondisi — Sesudah</p>
                    <div class="flex gap-2 flex-wrap">
                        <template x-for="src in handover.foto_sesudah" :key="src">
                            <button type="button" @click="previewImage = src; previewOpen = true">
                                <img :src="src"
                                    class="w-16 h-16 rounded-lg object-cover border border-gray-100 hover:opacity-80 transition">
                            </button>
                        </template>
                    </div>
                </div>
            </template>

        </div>
    </div>

    <div x-show="previewOpen" x-cloak @click="previewOpen = false" @keydown.escape.window="previewOpen = false"
        class="fixed inset-0 z-[60] bg-black/80 flex items-center justify-center p-4">

        <button type="button" @click="previewOpen = false"
            class="absolute top-4 right-4 text-white/70 hover:text-white text-2xl">&times;</button>

        <img :src="previewImage" class="max-h-[85vh] max-w-full rounded-lg object-contain">
    </div>
</div>