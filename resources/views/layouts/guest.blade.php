<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventaris DGN') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-950">

    <div class="min-h-screen flex">

        {{-- =========================================================
             LEFT SIDE - BRANDING
        ========================================================== --}}
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-950">

            {{-- Background decoration --}}
            <div class="absolute -top-40 -left-40 w-96 h-96
                        bg-orange-500/20 rounded-full blur-3xl">
            </div>

            <div class="absolute -bottom-40 -right-40 w-96 h-96
                        bg-blue-500/20 rounded-full blur-3xl">
            </div>

            <div class="relative z-10 flex flex-col justify-between
                        w-full p-12 xl:p-16">

                {{-- Brand --}}
                <div class="flex items-center gap-4">

                    {{-- Logo --}}
                    <div class="flex items-center justify-center
                                w-12 h-12 rounded-xl
                                bg-white shadow-lg">

                        <span class="text-xl font-black text-slate-950">
                            D
                        </span>

                    </div>

                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-white">
                            Inventaris
                            <span class="text-orange-400">DGN</span>
                        </h1>

                        <p class="text-xs text-slate-400 mt-0.5">
                            Asset Management System
                        </p>
                    </div>

                </div>


                {{-- Main Content --}}
                <div class="max-w-xl">

                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2
                                px-3 py-1.5 mb-6
                                rounded-full
                                bg-white/5
                                border border-white/10
                                text-xs font-medium text-slate-300">

                        <span class="w-2 h-2 rounded-full bg-orange-400"></span>

                        Internal Inventory System

                    </div>


                    {{-- Heading --}}
                    <h2 class="text-4xl xl:text-5xl
                               font-bold
                               leading-tight
                               tracking-tight
                               text-white">

                        Kelola aset perusahaan
                        <span class="text-orange-400">
                            lebih mudah.
                        </span>

                    </h2>


                    {{-- Description --}}
                    <p class="mt-6 text-base leading-7
                              text-slate-400 max-w-lg">

                        Sistem inventaris terintegrasi untuk membantu
                        mengelola data barang, kategori, pemeliharaan aset,
                        surat serah terima, dan laporan inventaris perusahaan.

                    </p>


                    {{-- Features --}}
                    <div class="grid grid-cols-2 gap-4 mt-10">

                        {{-- Feature 1 --}}
                        <div class="flex items-center gap-3">

                            <div class="flex items-center justify-center
                                        w-9 h-9 rounded-lg
                                        bg-white/5
                                        border border-white/10">

                                <svg class="w-5 h-5 text-orange-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.03-.13-2.03-.382-2.984z"
                                    />

                                </svg>

                            </div>

                            <span class="text-sm text-slate-300">
                                Data aset terorganisir
                            </span>

                        </div>


                        {{-- Feature 2 --}}
                        <div class="flex items-center gap-3">

                            <div class="flex items-center justify-center
                                        w-9 h-9 rounded-lg
                                        bg-white/5
                                        border border-white/10">

                                <svg class="w-5 h-5 text-orange-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M9 17v-2a4 4 0 014-4h4m0 0V7m0 4l-3-3m3 3l3-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"
                                    />

                                </svg>

                            </div>

                            <span class="text-sm text-slate-300">
                                Laporan inventaris
                            </span>

                        </div>


                        {{-- Feature 3 --}}
                        <div class="flex items-center gap-3">

                            <div class="flex items-center justify-center
                                        w-9 h-9 rounded-lg
                                        bg-white/5
                                        border border-white/10">

                                <svg class="w-5 h-5 text-orange-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />

                                </svg>

                            </div>

                            <span class="text-sm text-slate-300">
                                Riwayat pemeliharaan
                            </span>

                        </div>


                        {{-- Feature 4 --}}
                        <div class="flex items-center gap-3">

                            <div class="flex items-center justify-center
                                        w-9 h-9 rounded-lg
                                        bg-white/5
                                        border border-white/10">

                                <svg class="w-5 h-5 text-orange-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />

                                </svg>

                            </div>

                            <span class="text-sm text-slate-300">
                                Dokumen serah terima
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="text-xs text-slate-500">
                    © {{ date('Y') }} DGN. Internal use only.
                </div>

            </div>

        </div>


        {{-- =========================================================
             RIGHT SIDE - LOGIN
        ========================================================== --}}
        <div class="flex-1 flex items-center justify-center
                    px-6 py-12 bg-slate-50">

            <div class="w-full max-w-md">

                {{-- Mobile Brand --}}
                <div class="flex lg:hidden items-center
                            justify-center gap-3 mb-10">

                    <div class="flex items-center justify-center
                                w-11 h-11 rounded-xl
                                bg-slate-950 shadow-lg">

                        <span class="text-lg font-black text-white">
                            D
                        </span>

                    </div>

                    <div>

                        <h1 class="text-lg font-bold text-slate-900">
                            Inventaris
                            <span class="text-orange-600">DGN</span>
                        </h1>

                        <p class="text-xs text-slate-500">
                            Asset Management System
                        </p>

                    </div>

                </div>


                {{-- Login Card --}}
                <div class="bg-white
                            rounded-2xl
                            border border-slate-200
                            shadow-xl shadow-slate-200/60
                            px-7 py-8
                            sm:px-9 sm:py-10">

                    {{ $slot }}

                </div>


                {{-- Footer --}}
                <div class="mt-6 text-center">

                    <p class="text-xs text-slate-400">
                        Sistem Inventaris Internal
                    </p>

                </div>

            </div>

        </div>

    </div>

</body>
</html>