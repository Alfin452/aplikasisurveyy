<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Survei UIN Antasari</title>

    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .nav-active {
            color: #4f46e5;
            font-weight: 600;
        }

        [x-cloak] {
            display: none !important;
        }

        .section-title-anim,
        .feature-card-anim,
        .survey-item-anim {
            opacity: 0;
            transform: translateY(40px);
        }
    </style>
</head>

<body class="bg-slate-50 antialiased">

    <header class="header-anim bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8" x-data="{ mobileMenuOpen: false }">
            <div class="flex items-center justify-between h-20">
                <a href="{{ url('/') }}" class="flex items-center space-x-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo UIN Antasari" class="h-10 w-10">
                    <span class="font-bold text-xl text-gray-800">Survei UIN Antasari</span>
                </a>

                <div class="hidden md:flex items-center space-x-10">
                    <a href="#beranda" class="text-gray-600 hover:text-indigo-600 transition-colors">Beranda</a>
                    <a href="#tentang" class="text-gray-600 hover:text-indigo-600 transition-colors">Tentang</a>
                    <a href="#unit-layanan" class="text-gray-600 hover:text-indigo-600 transition-colors">Survei</a>
                </div>

                <div class="hidden md:flex items-center">
                    @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2">
                            <span class="font-semibold text-gray-700">{{ Auth::user()->username }}</span>
                            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-cloak x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Riwayat Survei</a>
                            <div class="border-t my-1"></div>
                            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Keluar</button></form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-indigo-700 shadow-sm">Masuk</a>
                    @endauth
                </div>

                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-gray-900">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-4 space-y-2">
                <a href="#beranda" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Beranda</a>
                <a href="#tentang" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Tentang</a>
                <a href="#unit-layanan" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Survei</a>
                <div class="border-t pt-4">
                    @auth
                    <div class="px-4 space-y-2">
                        <a href="#" class="block text-gray-700 font-semibold">Profil Saya</a>
                        <a href="#" class="block text-gray-700 font-semibold">Riwayat Survei</a>
                        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="block w-full text-left text-red-600 font-semibold">Keluar</button></form>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="block text-center bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-semibold w-full">Masuk</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="beranda" class="relative bg-white pt-16 pb-32">
            <div class="container mx-auto grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">Suara Anda, <span class="text-indigo-600">Masa Depan Kita</span></h1>
                    <p class="mt-6 text-lg text-gray-600">Partisipasi Anda sangat berarti untuk peningkatan kualitas layanan di lingkungan UIN Antasari Banjarmasin.</p>
                    <a href="#unit-layanan" class="mt-8 inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 shadow-lg">Mulai Berkontribusi</a>
                </div>
            </div>
        </section>

        <section id="unit-layanan" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-gray-800">Survei yang Tersedia</h2>
                <p class="mt-3 text-center text-gray-600">Pilih survei di bawah ini untuk memulai.</p>

                <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($surveys as $survey)
                    <a href="{{ route('surveys.fill', $survey) }}" class="block bg-white rounded-2xl shadow-lg border border-gray-200 hover:border-indigo-500 hover:shadow-2xl p-6">
                        <h3 class="text-lg font-bold text-gray-800 hover:text-indigo-600">{{ $survey->title }}</h3>
                        <p class="mt-2 text-sm text-gray-600 h-12">{{ Str::limit($survey->description, 100) }}</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($survey->unitKerja->pluck('uk_short_name')->take(2) as $short_name)
                            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $short_name }}</span>
                            @endforeach
                            @if($survey->unitKerja->count() > 2)
                            <span class="text-gray-500 text-xs font-medium py-1">+{{ $survey->unitKerja->count() - 2 }}</span>
                            @endif
                        </div>
                    </a>
                    @empty
                    <div class="md:col-span-2 lg:col-span-4 text-center py-16 px-4 bg-white rounded-xl shadow-md border-2 border-dashed">
                        <p class="font-semibold text-gray-600">Belum Ada Survei yang Aktif</p>
                        <p class="text-sm mt-1">Silakan kembali lagi nanti untuk berpartisipasi.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <footer class="mt-16 py-10 bg-slate-100 border-t text-center text-gray-500">
        <p>&copy; {{ date('Y') }} Muhammad Alfin Nur Huda. All rights reserved.</p>
        <p class="text-sm mt-2">Dibuat untuk UIN Antasari Banjarmasin</p>
    </footer>

    @vite('resources/js/app.js')
</body>

</html>