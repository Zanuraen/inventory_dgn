<div
    x-data="{ show: false }"
    @open-account-modal.window="show = true"
    x-show="show"
    x-cloak
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
>
    <div
        @click.outside="show = false"
        class="bg-white rounded-xl w-full max-w-sm overflow-hidden"
    >
        <div class="flex items-start justify-between px-6 py-5 border-b border-gray-100">
            <div class="flex items-center gap-3 min-w-0">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary-dark text-sm font-bold text-white">
                    {{ Str::upper(Str::substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </span>
                <div class="min-w-0">
                    <p class="font-semibold text-[#111827] truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 shrink-0">
                <x-icon name="x" class="w-5 h-5" />
            </button>
        </div>

        <div class="p-2">
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                <x-icon name="user" class="w-4 h-4" />
                Edit Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-red-500 hover:bg-red-50">
                    <x-icon name="logout" class="w-4 h-4" />
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>