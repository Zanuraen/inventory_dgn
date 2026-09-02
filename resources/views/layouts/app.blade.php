<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventaris Kantor')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F8F9FC]">

    <div class="flex min-h-screen">

        {{-- ===================== SIDEBAR ===================== --}}
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between fixed left-0 top-0 h-screen z-20">
            <div>
                {{-- Logo --}}
                <div class="flex items-center gap-2 px-6 py-6">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 via-teal-600 to-blue-400"></span>
                    <span class="font-bold text-lg text-gray-800">Digitelnusa</span>
                </div>

                {{-- Menu --}}
                <nav class="px-4 space-y-1.5 mt-2">
                    @php
                        $menus = [
                            ['label' => 'Dashboard',      'route' => 'dashboard',        'icon' => 'grid'],
                            ['label' => 'Data Barang',    'route' => 'items.index',      'icon' => 'archive'],
                            ['label' => 'Laporan',        'route' => 'reports.index',    'icon' => 'clipboard'],
                            ['label' => 'Pemeliharaan',   'route' => 'maintenance.index','icon' => 'wrench'],
                            ['label' => 'Settings',       'route' => 'settings.index',   'icon' => 'gear'],
                            ['label' => 'Notifications',  'route' => 'notifications.index','icon' => 'bell'],
                            ['label' => 'Aktivitas',      'route' => 'activity.index',   'icon' => 'clock'],
                        ];

                        $icons = [
                            'grid'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>',
                            'archive'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 7l1.5 12.5A2 2 0 006.49 21h11.02a2 2 0 001.99-1.5L21 7M3 7l1-3h16l1 3M9 11h6"/>',
                            'clipboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6a1 1 0 011 1v1H8V5a1 1 0 011-1zM6 6h12v14a1 1 0 01-1 1H7a1 1 0 01-1-1V6z"/>',
                            'wrench'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a4 4 0 11-5.4 5.4L4 17l3 3 5.3-5.3a4 4 0 015.4-5.4l-3 3-2-2 3-3z"/>',
                            'gear'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.3 3.3a1 1 0 011.4 0l.6.6a1 1 0 00.9.3l.8-.2a1 1 0 011.2.7l.2.8a1 1 0 00.6.7l.8.3a1 1 0 01.5 1.4l-.4.7a1 1 0 000 1l.4.7a1 1 0 01-.5 1.4l-.8.3a1 1 0 00-.6.7l-.2.8a1 1 0 01-1.2.7l-.8-.2a1 1 0 00-.9.3l-.6.6a1 1 0 01-1.4 0l-.6-.6a1 1 0 00-.9-.3l-.8.2a1 1 0 01-1.2-.7l-.2-.8a1 1 0 00-.6-.7l-.8-.3a1 1 0 01-.5-1.4l.4-.7a1 1 0 000-1l-.4-.7a1 1 0 01.5-1.4l.8-.3a1 1 0 00.6-.7l.2-.8a1 1 0 011.2-.7l.8.2a1 1 0 00.9-.3l.6-.6zM12 15a3 3 0 100-6 3 3 0 000 6z"/>',
                            'bell'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>',
                            'clock'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        ];
                    @endphp

                    @foreach ($menus as $menu)
                        @php $active = Route::has($menu['route']) && Route::currentRouteName() === $menu['route']; @endphp
                        <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                           class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium border transition
                                  {{ $active
                                        ? 'bg-[#F26522] text-white border-[#F26522]'
                                        : 'text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                {!! $icons[$menu['icon']] !!}
                            </svg>
                            <span>{{ $menu['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Account button --}}
            <div class="p-4">
                <a href="{{ Route::has('account') ? route('account') : '#' }}"
                   class="flex items-center justify-center gap-2 bg-[#0B4A63] hover:bg-[#093c50] text-white py-3 rounded-lg font-medium text-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.4 0-8 2-8 4.5V21h16v-2.5c0-2.5-3.6-4.5-8-4.5z"/>
                    </svg>
                    Account
                </a>
            </div>
        </aside>

        {{-- ===================== MAIN AREA ===================== --}}
        <div class="ml-64 flex-1 flex flex-col min-h-screen">

            {{-- Topbar --}}
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="relative w-80 max-w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.3-4.3M18 11a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Pencarian sistem..."
                           class="w-full pl-9 pr-4 py-2 rounded-lg bg-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B4A63]/40">
                </div>

                <div class="flex items-center gap-5">
                    <button class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>
                    <button class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <div class="text-right leading-tight">
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Profil Admin' }}</p>
                            <p class="text-xs text-gray-400">Administrator</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-[#0B4A63] text-white flex items-center justify-center text-sm font-semibold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="p-6">
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>