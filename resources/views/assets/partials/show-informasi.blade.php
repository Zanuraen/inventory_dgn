<div class="bg-white border border-[#E5E7EB] rounded-xl p-5 sm:p-6">
    <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-3 mb-4">Informasi</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm">
        <div>
            <p class="text-gray-400 text-xs uppercase tracking-wide">No Aset</p>
            <p class="font-medium text-[#111827] mt-0.5">{{ $asset->code_asset }}</p>
        </div>
        <div>
            <p class="text-gray-400 text-xs uppercase tracking-wide">Serial Number</p>
            <p class="font-medium text-[#111827] mt-0.5">{{ $asset->serial_number ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-400 text-xs uppercase tracking-wide">Tanggal Beli</p>
            <p class="font-medium text-[#111827] mt-0.5">{{ $asset->tanggal_beli->translatedFormat('d F Y') }}</p>
        </div>
        <div>
            <p class="text-gray-400 text-xs uppercase tracking-wide">Pengguna</p>
            <p class="font-medium text-[#111827] mt-0.5">{{ $asset->pengguna ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-400 text-xs uppercase tracking-wide">Lokasi</p>
            <p class="font-medium text-[#111827] mt-0.5">{{ $asset->location ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-400 text-xs uppercase tracking-wide">Kondisi</p>
            <p class="font-medium text-[#111827] mt-0.5">{{ $asset->condition_status }}</p>
        </div>
        <div class="sm:col-span-2">
            <p class="text-gray-400 text-xs uppercase tracking-wide">Keterangan</p>
            <p class="font-medium text-[#111827] mt-0.5">{{ $asset->description ?? '-' }}</p>
        </div>
    </div>
</div>