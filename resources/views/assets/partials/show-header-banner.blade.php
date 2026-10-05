<div class="bg-[#0A4C62] rounded-xl p-5 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:items-start gap-4">

        <img src="{{ $asset->cover ? asset('storage/' . $asset->cover->path) : 'https://placehold.co/80x80?text=No+Photo' }}"
            class="w-20 h-20 rounded-lg object-cover shrink-0 bg-white/10">

        <div class="flex-1 min-w-0">
            <div class="flex flex-wrap items-center gap-2">
                <h1 class="text-lg sm:text-xl font-bold text-white">{{ $asset->name }}</h1>
                @if ($asset->qty > 0)
                    <span
                        class="inline-flex items-center gap-1.5 bg-[#E8F5E9] text-[#2E7D32] text-xs px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#2E7D32]"></span> Ada
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 bg-[#FFEBEE] text-[#D32F2F] text-xs px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#D32F2F]"></span> Tidak Ada
                    </span>
                @endif
            </div>

            <p class="text-white/70 text-sm mt-1">
                {{ $asset->qty > 0 ? 'Dialokasikan ke pengguna aktif.' : 'Barang sedang tidak tersedia.' }}
            </p>

            <p class="text-white/90 text-sm mt-2 flex items-center gap-1.5">
                <x-icon name="user" class="w-4 h-4" />
                {{ $asset->pengguna ?? '-' }} @if($asset->location) - {{ $asset->location }} @endif
            </p>
        </div>

        <div class="flex sm:flex-col gap-2 shrink-0">
            <a href="{{ route('assets.edit', $asset) }}"
                class="flex-1 sm:flex-none text-center bg-white/10 hover:bg-white/20 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Edit
            </a>
            <form action="{{ route('assets.destroy', $asset) }}" method="POST"
                onsubmit="return confirm('Yakin hapus aset ini?')" class="flex-1 sm:flex-none">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-white/10 hover:bg-[#D32F2F] text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>