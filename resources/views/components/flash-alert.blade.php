@if (session('success') || session('error'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition
        x-cloak
        class="fixed right-4 top-4 z-50 w-[calc(100%-2rem)] max-w-sm sm:right-6 sm:top-6"
    >
        @if (session('success'))
            <div class="flex items-start gap-3 rounded-button bg-success-bg px-4 py-3 text-success-text shadow-card">
                <x-icon name="check-circle" class="mt-0.5 h-5 w-5 shrink-0" />
                <p class="text-sm font-medium">{{ session('success') }}</p>
                <button @click="show = false" class="ml-auto text-success-text/70 hover:text-success-text" aria-label="Tutup">
                    <x-icon name="x" class="h-4 w-4" />
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-start gap-3 rounded-button bg-danger-bg px-4 py-3 text-danger-text shadow-card">
                <x-icon name="alert-circle" class="mt-0.5 h-5 w-5 shrink-0" />
                <p class="text-sm font-medium">{{ session('error') }}</p>
                <button @click="show = false" class="ml-auto text-danger-text/70 hover:text-danger-text" aria-label="Tutup">
                    <x-icon name="x" class="h-4 w-4" />
                </button>
            </div>
        @endif
    </div>
@endif
