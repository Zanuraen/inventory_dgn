@php
    $menu = [
        ['label' => 'Dashboard',     'route' => 'dashboard',          'icon' => 'home'],
        ['label' => 'Data Aset',     'route' => 'assets.index',       'icon' => 'box'],
        ['label' => 'Kategori',      'route' => 'categories.index',   'icon' => 'tag'],
        ['label' => 'Pemeliharaan',  'route' => 'maintenances.index', 'icon' => 'wrench'],
        ['label' => 'Laporan',       'route' => 'reports.index',      'icon' => 'file-text'],
        ['label' => 'Aktivitas',     'route' => 'activities.index',   'icon' => 'clock'],
    ];
@endphp

{{-- Backdrop, mobile only, closes the drawer on click --}}
<div
    x-show="sidebarOpen"
    x-transition.opacity
    @click="sidebarOpen = false"
    class="fixed inset-0 z-30 bg-black/40 lg:hidden"
    style="display: none;"
></div>

<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-40 flex w-[260px] w-(--width-sidebar) flex-col border-r border-border-subtle bg-bg-surface transition-transform duration-200 ease-in-out lg:translate-x-0"
>
    {{-- Logo --}}
    <div class="flex h-20 shrink-0 items-center gap-3 border-b border-border-subtle px-6">
        <img src="{{ asset('images/dgn-logo.png') }}" alt="Digitelnusa" class="h-9 w-auto">
        <button @click="sidebarOpen = false" class="ml-auto p-1 text-text-secondary lg:hidden" aria-label="Tutup menu">
            <x-icon name="x" class="h-5 w-5" />
        </button>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        @foreach ($menu as $item)
            @php $active = Route::has($item['route']) && request()->routeIs($item['route'].'*'); @endphp
            <a
                href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                @class([
                    'flex items-center gap-3 rounded-full px-4 py-2.5 text-sm font-medium transition-colors',
                    'bg-accent text-white' => $active,
                    'text-text-secondary hover:bg-bg-page hover:text-text-primary' => ! $active,
                ])
            >
                <x-icon :name="$item['icon']" class="h-5 w-5 shrink-0" />
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- Account, fixed at the bottom --}}
    <div class="shrink-0 border-t border-border-subtle p-3">
        <a
            href="{{ Route::has('account.edit') ? route('account.edit') : '#' }}"
            class="flex items-center gap-3 rounded-lg bg-primary-dark px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-primary"
        >
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/20 text-xs font-bold">
                {{ Str::upper(Str::substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </span>
            <span class="truncate">{{ auth()->user()->name ?? 'Account' }}</span>
        </a>
    </div>
</aside>
