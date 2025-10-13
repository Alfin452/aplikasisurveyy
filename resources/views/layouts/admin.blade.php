<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- CSS Library --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

    {{-- Mengimpor Font Poppins dari Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Poppins', sans-serif !important;
        }

        .pulsing-dots div {
            animation: pulse 1.4s infinite ease-in-out both;
            background-color: #3b82f6;
            border-radius: 50%;
            display: inline-block;
            height: 10px;
            width: 10px;
        }

        .pulsing-dots .dot-1 {
            animation-delay: -0.32s;
        }

        .pulsing-dots .dot-2 {
            animation-delay: -0.16s;
        }

        @keyframes pulse {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1.0);
            }
        }

        .ts-control {
            border-radius: 0.5rem !important;
            border-color: #d1d5db !important;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
        }

        .ts-control.focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 2px #c7d2fe !important;
        }

        .sortable-ghost {
            background-color: #dbeafe;
            opacity: 0.7;
            border: 2px dashed #60a5fa;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal"
    x-data="{ openLogout: false, openDeleteModal: false, deleteUrl: '', deleteItemName: '' }"
    @open-delete-modal.window="openDeleteModal = true; deleteUrl = event.detail.url; deleteItemName = event.detail.name">

    {{-- Elemen Loading Screen --}}
    <div x-cloak x-show="$store.globals.isLoading" x-transition.opacity
        class="fixed inset-0 bg-white/60 backdrop-blur-sm flex items-center justify-center z-[9999]">
        <div class="pulsing-dots space-x-2">
            <div class="dot-1"></div>
            <div class="dot-2"></div>
            <div class="dot-3"></div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="bg-gradient-to-b from-cyan-500 to-blue-600 text-gray-100 h-screen w-64 fixed flex flex-col p-4 shadow-xl">
        <div class="text-2xl font-semibold text-white mb-6 flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo UIN" class="w-10 h-10 rounded-full">
            SURVEY UIN Antasari
        </div>
        <nav class="flex-1">
            <a href="{{ route('superadmin.dashboard') }}" @click="$store.globals.isLoading = true" class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">Dashboard</a>
            <a href="{{ route('unit-kerja.index') }}" @click="$store.globals.isLoading = true" class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">Unit Kerja</a>
            <a href="{{ route('surveys.index') }}" @click="$store.globals.isLoading = true" class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">Survei</a>
            <a href="{{ route('users.index') }}" @click="$store.globals.isLoading = true" class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">Manajemen Pengguna</a>
        </nav>
        <div class="mt-auto">
            <button @click="openLogout = true" class="w-full flex items-center gap-3 p-4 text-left text-gray-100 hover:bg-red-500 hover:text-white rounded-lg transition-all duration-300 ease-in-out transform hover:scale-[1.02]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                Logout
            </button>
        </div>
    </div>

    <!-- Konten -->
    <div class="flex-1 ml-64 p-1">
        <div class="bg-white rounded-xl shadow-md">
            @yield('content')
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div x-cloak x-show="openLogout" x-transition.opacity class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div x-show="openLogout" @click.away="openLogout = false" x-transition.scale class="bg-white rounded-xl shadow-xl p-6 w-80 text-center">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Logout</h2>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="flex justify-center gap-3">
                <button @click="openLogout = false" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition">Batal</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" @click="$store.globals.isLoading = true" class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-medium shadow-md transition transform hover:scale-105">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div x-cloak x-show="openDeleteModal" x-transition.opacity class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div x-show="openDeleteModal" @click.away="openDeleteModal = false" x-transition.scale class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100"><svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg></div>
            <h2 class="text-2xl font-bold text-gray-800 mt-4">Konfirmasi Hapus</h2>
            <p class="text-gray-600 my-4">Apakah Anda yakin ingin menghapus <strong x-text="deleteItemName" class="font-semibold text-gray-900"></strong>?<br>Aksi ini tidak dapat dibatalkan.</p>
            <div class="flex justify-center gap-4 mt-6">
                <button @click="openDeleteModal = false" class="px-6 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold transition">Batal</button>
                <form x-bind:action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" @click="$store.globals.isLoading = true" class="px-6 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold shadow-md transition">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript Libraries & Skrip Global --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('globals', {
                isLoading: false
            });
            document.querySelectorAll('form:not([data-no-loader])').forEach(form => {
                form.addEventListener('submit', (e) => {
                    const submitter = e.submitter;
                    if (!submitter || !submitter.hasAttribute('formnovalidate')) {
                        Alpine.store('globals').isLoading = true;
                    }
                });
            });
            window.addEventListener('pageshow', (event) => {
                if (event.persisted) {
                    Alpine.store('globals').isLoading = false;
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>