<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal" x-data="{ openLogout: false }">

    <div class="bg-gradient-to-b from-cyan-500 to-blue-600 text-gray-100 h-screen w-64 fixed flex flex-col p-4 shadow-xl">
        <div class="text-2xl font-semibold text-white mb-6 flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo UIN" class="w-10 h-10 rounded-full">
            SURVEY UIN Antasari
        </div>
        <nav class="flex-1">
            <a href="{{ route('superadmin.dashboard') }}"
                class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">
                Dashboard
            </a>
            <a href="{{ route('unit-kerja.index') }}"
                class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">
                Unit Kerja
            </a>
            <a href="{{ route('surveys.index') }}"
                class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">
                Survei
            </a>
            <a href="{{ route('users.index') }}"
                class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">
                Manajemen Pengguna
            </a>
        </nav>
        <div class="mt-auto">
            <button @click="openLogout = true"
                class="w-full flex items-center gap-3 p-4 text-left text-gray-100 hover:bg-red-500 hover:text-white rounded-lg transition-all duration-300 ease-in-out transform hover:scale-[1.02]">
                <!-- Icon Logout -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                Logout
            </button>
        </div>
    </div>

    <!-- Konten -->
    <div class="flex-1 ml-64 p-8">
        <div class="bg-white rounded-xl shadow-md p-2">
            @yield('content')
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div x-cloak
        x-show="openLogout"
        x-transition.opacity
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div x-show="openLogout"
            x-transition.scale
            class="bg-white rounded-xl shadow-xl p-6 w-80 text-center">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Logout</h2>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="flex justify-center gap-3">
                <button @click="openLogout = false"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition">
                    Batal
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-medium shadow-md transition transform hover:scale-105">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>