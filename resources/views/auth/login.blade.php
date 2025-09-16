<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Survei ZI</title>
    @vite('resources/css/app.css')
    <style>
        /* Animasi untuk input */
        .input-anim {
            transition: all 0.3s ease-in-out;
        }

        .input-anim:focus {
            box-shadow: 0 0 12px rgba(37, 99, 235, 0.4);
            transform: scale(1.02);
            border-color: #2563eb;
            background-color: rgba(255, 255, 255, 0.9);
        }

        /* Fade-in container */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-white">

    <div class="w-11/12 md:w-3/4 lg:w-2/3 xl:w-3/4 grid grid-cols-1 md:grid-cols-2 gap-6 fade-in">

        <!-- Bagian Kiri -->
        <div class="rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 text-white p-8 flex flex-col justify-between shadow-xl">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16 mb-4">
                <h2 class="text-2xl font-bold mb-2">Kuisioner UIN Antasari</h2>
                <p class="text-sm opacity-90">Bantu kami meningkatkan kualitas layanan dengan mengisi formulir ini.</p>
            </div>
            <div class="mt-8 text-xs opacity-80">
                <p class="font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 15l9-5-9-5-9 5 9 5z"></path>
                        <path d="M12 15v5l9-5-9-5-9 5 9 5z"></path>
                    </svg>
                    Data Anda Dilindungi
                </p>
                <p>Data yang Anda masukkan disimpan secara anonim dan hanya untuk keperluan survei.</p>
            </div>
        </div>

        <!-- Bagian Kanan (Login Form) -->
        <div class="rounded-2xl bg-white/40 backdrop-blur-md shadow-xl p-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-6">Masuk ke Akun</h3>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" required autofocus
                        class="input-anim mt-1 block w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-3 bg-white/60 backdrop-blur-sm text-gray-900 placeholder-gray-500">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="input-anim mt-1 block w-full rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-3 bg-white/60 backdrop-blur-sm text-gray-900 placeholder-gray-500">
                </div>

                <!-- Tombol -->
                <div>
                    <button type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>