<header class="sticky top-0 z-20 flex items-center justify-between gap-4 border-b border-border-subtle bg-bg-surface px-4 py-3 lg:hidden">
    <button
        @click="sidebarOpen = true"
        class="-ml-2 rounded-lg p-2 text-text-secondary hover:bg-bg-page"
        aria-label="Buka menu"
    >
        <x-icon name="menu" class="h-6 w-6" />
    </button>

    <img src="{{ asset('images/dgn-logo.png') }}" alt="Digitelnusa" class="h-7 w-auto">

    <a
        href="{{ Route::has('account.edit') ? route('account.edit') : '#' }}"
        class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-dark text-xs font-bold text-white"
    >
        {{ Str::upper(Str::substr(auth()->user()->name ?? 'A', 0, 1)) }}
    </a>
</header>
