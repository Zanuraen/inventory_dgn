<x-layouts.app>

    <div class="p-4 sm:p-6 space-y-4">

        <a href="{{ route('assets.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#0A4C62]">
            <x-icon name="chevron-down" class="w-4 h-4 rotate-90" />
            Kembali ke Data Aset
        </a>

        <x-flash-alert />

        @include('assets.partials.show-header-banner')

        @include('assets.partials.show-informasi')

        @include('assets.partials.show-foto-produk')

        {{-- ============ TAB UTAMA ============ --}}
        <div x-data="{ activeTab: 'dokumen' }" class="bg-white border border-[#E5E7EB] rounded-xl overflow-hidden">

            <div class="flex border-b border-gray-100 overflow-x-auto">
                <button type="button" @click="activeTab = 'dokumen'"
                    class="px-5 py-3 text-sm font-medium whitespace-nowrap border-b-2 transition"
                    :class="activeTab === 'dokumen' ? 'border-[#F26522] text-[#F26522]' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    Dokumen Aset
                </button>
                <button type="button" @click="activeTab = 'pemeliharaan'"
                    class="px-5 py-3 text-sm font-medium whitespace-nowrap border-b-2 transition"
                    :class="activeTab === 'pemeliharaan' ? 'border-[#F26522] text-[#F26522]' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    Riwayat Pemeliharaan
                </button>
                <button type="button" @click="activeTab = 'log'"
                    class="px-5 py-3 text-sm font-medium whitespace-nowrap border-b-2 transition"
                    :class="activeTab === 'log' ? 'border-[#F26522] text-[#F26522]' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    Log Aktivitas
                </button>
            </div>

            <div class="p-5 sm:p-6">

                <div x-show="activeTab === 'dokumen'">
                    @include('assets.partials.show-tab-dokumen')
                </div>

                <div x-show="activeTab === 'pemeliharaan'" x-cloak>
                    @include('assets.partials.show-tab-pemeliharaan')
                </div>

                <div x-show="activeTab === 'log'" x-cloak>
                    <p class="text-sm text-gray-400 py-10 text-center">
                        Fitur log aktivitas belum tersedia untuk halaman ini.
                    </p>
                </div>

            </div>
        </div>

    </div>

    @include('assets.partials.show-modal-lihat-surat')

</x-layouts.app>