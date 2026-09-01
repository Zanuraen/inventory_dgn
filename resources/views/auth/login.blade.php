<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Inventory DGN</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50">

    <div class="min-h-screen flex">

        <!-- =========================
             LEFT SIDE
        ========================== -->
        <div class="hidden lg:flex lg:w-1/2 bg-slate-900 relative overflow-hidden">

            <!-- Background decoration -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>

            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-orange-500/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col justify-center px-16 xl:px-24 text-white">

                <!-- Logo -->
                <div class="mb-10">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Inventory DGN"
                        class="w-32 h-auto object-contain"
                    >
                </div>

                <!-- Heading -->
                <h1 class="text-4xl xl:text-5xl font-semibold leading-tight">
                    Inventory
                    <span class="text-blue-400">Management</span>
                    System
                </h1>

                <p class="mt-6 text-slate-300 text-lg leading-relaxed max-w-lg">
                    Kelola aset dan inventaris perusahaan dengan lebih
                    mudah, terstruktur, dan efisien dalam satu sistem.
                </p>

                <!-- Feature -->
                <div class="mt-10 space-y-5">

                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                            <svg
                                class="w-5 h-5 text-blue-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="font-medium">
                                Pengelolaan Aset
                            </p>

                            <p class="text-sm text-slate-400">
                                Kelola data barang dan aset perusahaan.
                            </p>
                        </div>
                    </div>


                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                            <svg
                                class="w-5 h-5 text-orange-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 17v-2a4 4 0 014-4h4m0 0V7m0 4l-3-3m3 3l3-3M5 20h14"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="font-medium">
                                Laporan Terintegrasi
                            </p>

                            <p class="text-sm text-slate-400">
                                Buat dan kelola laporan inventaris.
                            </p>
                        </div>
                    </div>


                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                            <svg
                                class="w-5 h-5 text-blue-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v2h8z"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="font-medium">
                                Aman dan Terstruktur
                            </p>

                            <p class="text-sm text-slate-400">
                                Sistem login untuk akses administrator.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <!-- =========================
             RIGHT SIDE - LOGIN
        ========================== -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">

            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="flex justify-center mb-8 lg:hidden">

                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Inventory DGN"
                        class="w-28 h-auto object-contain"
                    >

                </div>


                <!-- Login Header -->
                <div class="text-center lg:text-left mb-8">

                    <p class="text-sm font-medium text-blue-600 mb-2">
                        INVENTORY MANAGEMENT SYSTEM
                    </p>

                    <h2 class="text-3xl font-semibold text-slate-900">
                        Selamat Datang
                    </h2>

                    <p class="mt-2 text-slate-500">
                        Silakan masuk untuk mengakses dashboard.
                    </p>

                </div>


                <!-- Login Card -->
                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 p-8">

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-5 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif


                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-5 rounded-lg bg-red-50 border border-red-200 px-4 py-3">

                            <p class="text-sm font-medium text-red-700">
                                Login gagal
                            </p>

                            <ul class="mt-1 text-sm text-red-600 list-disc list-inside">

                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>
                    @endif


                    <form method="POST" action="{{ route('login') }}">

                        @csrf


                        <!-- Email -->
                        <div>

                            <label
                                for="email"
                                class="block text-sm font-medium text-slate-700 mb-2"
                            >
                                Email
                            </label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Masukkan email Anda"
                                class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500 transition"
                            >

                        </div>


                        <!-- Password -->
                        <div class="mt-5">

                            <label
                                for="password"
                                class="block text-sm font-medium text-slate-700 mb-2"
                            >
                                Password
                            </label>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password Anda"
                                class="w-full rounded-xl border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500 transition"
                            >

                        </div>


                        <!-- Remember -->
                        <div class="flex items-center justify-between mt-5">

                            <label class="flex items-center gap-2 cursor-pointer">

                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                >

                                <span class="text-sm text-slate-600">
                                    Ingat saya
                                </span>

                            </label>

                        </div>


                        <!-- Button -->
                        <button
                            type="submit"
                            class="w-full mt-7 bg-slate-900 hover:bg-blue-600 text-white font-semibold rounded-xl py-3.5 transition duration-200 shadow-lg shadow-slate-900/10 hover:shadow-blue-600/20"
                        >
                            Masuk ke Dashboard
                        </button>

                    </form>

                </div>


                <!-- Footer -->
                <div class="text-center mt-8">

                    <p class="text-xs text-slate-400">
                        © {{ date('Y') }} Inventory Management System
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Sistem Manajemen Inventaris Perusahaan
                    </p>

                </div>

            </div>

        </div>

    </div>

</body>
</html>