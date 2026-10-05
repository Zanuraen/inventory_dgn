@forelse ($asset->maintenances->sortByDesc('maintenance_date') as $m)
    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
        <div>
            <p class="font-medium text-sm text-[#111827]">{{ $m->jenis_pemeliharaan }}</p>
            <p class="text-xs text-gray-400 mt-0.5">
                {{ $m->vendor }} · {{ $m->maintenance_date->translatedFormat('d M Y') }}
            </p>
        </div>
        <span class="text-xs px-2.5 py-1 rounded-full
                @class([
                    'bg-[#E8F5E9] text-[#2E7D32]' => $m->status === 'selesai',
                    'bg-[#FFEBEE] text-[#D32F2F]' => $m->status === 'terlambat',
                    'bg-[#FFF3E0] text-[#D3591E]' => $m->status === 'terjadwal',
                ])">
            {{ ucfirst($m->status) }}
        </span>
    </div>
@empty
    <p class="text-sm text-gray-400 py-10 text-center">Belum ada riwayat pemeliharaan.</p>
@endforelse