<x-layouts.app title="Dashboard">
    <div class="p-6">
        <h1 class="text-2xl font-bold text-brand-teal">Halo, Layout Berhasil!</h1>
        <p class="text-ink-secondary mt-2">Kalau tulisan ini berwarna teal dan font-nya Manrope, berarti Tailwind v4 sudah nyambung.</p>

        <div x-data="{ open: false }" class="mt-4">
            <button @click="open = !open" class="px-4 py-2 bg-brand-orange text-white rounded-btn">
                Tes Alpine
            </button>
            <p x-show="open" class="mt-2">Alpine juga jalan! 🎉</p>
        </div>
    </div>
</x-layouts.app>