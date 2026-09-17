@if ($paginator->hasPages())
    <nav class="flex items-center justify-between">
        <p class="text-sm text-gray-500">
            Menampilkan
            <span class="font-medium text-gray-700">{{ $paginator->firstItem() }}</span>
            -
            <span class="font-medium text-gray-700">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-medium text-gray-700">{{ $paginator->total() }}</span>
            data
        </p>

        <div class="flex items-center gap-1">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded text-gray-300 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="w-8 h-8 flex items-center justify-center rounded text-gray-500 hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            @endif

            {{-- Nomor Halaman --}}
            @for ($page = 1; $page <= $paginator->lastPage(); $page++)
                @if ($page === $paginator->currentPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded bg-[#F26522] text-white text-sm font-semibold">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $paginator->url($page) }}"
                       class="w-8 h-8 flex items-center justify-center rounded text-gray-600 hover:bg-gray-100 text-sm transition">
                        {{ $page }}
                    </a>
                @endif
            @endfor

            {{-- Tombol Selanjutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="w-8 h-8 flex items-center justify-center rounded text-gray-500 hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="w-8 h-8 flex items-center justify-center rounded text-gray-300 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif