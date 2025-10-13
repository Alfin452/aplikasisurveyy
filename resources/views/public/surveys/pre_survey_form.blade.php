<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Responden - {{ $survey->title }}</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-2xl">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo UIN Antasari" class="h-16 w-16 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Satu Langkah Lagi...</h1>
            <p class="text-gray-600 mt-2">Sebelum memulai survei <strong class="text-indigo-600">{{ $survey->title }}</strong>, mohon lengkapi data di bawah ini.</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg border p-6 sm:p-8">
            <form action="{{ route('surveys.pre-survey.store', $survey) }}" method="POST">
                @csrf
                <div class="space-y-6">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan nama lengkap Anda">
                        @error('full_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Jenis Kelamin & Usia --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <div class="mt-2 space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="Laki-laki" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('gender') == 'Laki-laki' ? 'checked' : '' }} required>
                                    <span class="ml-3 text-sm text-gray-700">Laki-laki</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="Perempuan" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('gender') == 'Perempuan' ? 'checked' : '' }} required>
                                    <span class="ml-3 text-sm text-gray-700">Perempuan</span>
                                </label>
                            </div>
                            @error('gender') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="age" class="block text-sm font-medium text-gray-700">Usia</label>
                            <input type="number" name="age" id="age" value="{{ old('age') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: 21">
                            @error('age') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Status & Unit Kerja/Fakultas --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status Anda</label>
                            <select id="status" name="status" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="" disabled {{ old('status') ? '' : 'selected' }}>Pilih status...</option>
                                <option value="Mahasiswa" {{ old('status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="Dosen" {{ old('status') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="Tenaga Kependidikan" {{ old('status') == 'Tenaga Kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan</option>
                                <option value="Lainnya" {{ old('status') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="unit_kerja_or_fakultas" class="block text-sm font-medium text-gray-700">Fakultas / Unit Kerja</label>
                            <input type="text" name="unit_kerja_or_fakultas" id="unit_kerja_or_fakultas" value="{{ old('unit_kerja_or_fakultas') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: FTIK, UPT TIPD, dll">
                            @error('unit_kerja_or_fakultas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t">
                    <div class="flex justify-end">
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-6 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300">
                            Lanjutkan ke Survei
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <p class="text-center text-gray-500 text-sm mt-6">&copy; {{ date('Y') }} Survei UIN Antasari. All rights reserved.</p>
    </div>

</body>

</html>