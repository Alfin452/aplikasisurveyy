@csrf
<div class="space-y-8">

    {{-- KARTU 1: INFORMASI UTAMA --}}
    <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">1. Informasi Utama</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="unit_kerja_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Unit Kerja</label>
                {{-- DIUBAH: Menghapus ikon dan memperbesar input --}}
                <input type="text" id="unit_kerja_name" name="unit_kerja_name" value="{{ old('unit_kerja_name', $unitKerja->unit_kerja_name ?? '') }}" class="w-full px-4 py-2.5 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
                @error('unit_kerja_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="uk_short_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Singkat (Akronim)</label>
                {{-- DIUBAH: Menghapus ikon dan memperbesar input --}}
                <input type="text" id="uk_short_name" name="uk_short_name" value="{{ old('uk_short_name', $unitKerja->uk_short_name ?? '') }}" class="w-full px-4 py-2.5 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                @error('uk_short_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- KARTU 2: STRUKTUR ORGANISASI --}}
    <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">2. Struktur Organisasi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="tipe_unit_id" class="block text-sm font-medium text-gray-700 mb-1">Tipe Unit</label>
                <select id="tipe_unit_select" name="tipe_unit_id" required>
                    <option value="">Pilih Tipe</option>
                    @foreach ($tipeUnits as $id => $nama)
                    <option value="{{ $id }}" {{ old('tipe_unit_id', $unitKerja->tipe_unit_id ?? '') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
                @error('tipe_unit_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Induk Unit Kerja (Opsional)</label>
                <select id="parent_select" name="parent_id">
                    <option value="">Tidak Ada Induk</option>
                    @foreach ($parentUnits as $id => $nama)
                    @if(isset($unitKerja) && $unitKerja->id === $id) @continue @endif
                    <option value="{{ $id }}" {{ old('parent_id', $unitKerja->parent_id ?? '') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
                @error('parent_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- KARTU 3: INFORMASI OPERASIONAL --}}
    <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">3. Informasi Operasional</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Kontak (Telepon/Email)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <input type="text" id="contact" name="contact" value="{{ old('contact', $unitKerja->contact ?? '') }}" class="w-full pl-10 py-2.5 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>
                @error('contact') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Lokasi (Gedung/Ruangan)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="address" name="address" value="{{ old('address', $unitKerja->address ?? '') }}" class="w-full pl-10 py-2.5 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>
                @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2 grid grid-cols-2 gap-6">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai Layanan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input type="text" id="start_time" name="start_time" value="{{ old('start_time', $unitKerja->start_time ?? '') }}" class="timepicker w-full pl-10 py-2.5 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    </div>
                    @error('start_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai Layanan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input type="text" id="end_time" name="end_time" value="{{ old('end_time', $unitKerja->end_time ?? '') }}" class="timepicker w-full pl-10 py-2.5 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    </div>
                    @error('end_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Separator & Tombol Aksi --}}
<div class="relative my-8">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-200"></div>
    </div>
    <div class="relative flex justify-center">
        <span class="bg-white px-4 text-gray-300">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
        </span>
    </div>
</div>

<div class="flex items-center justify-end space-x-4">
    <a href="{{ route('unit-kerja.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-medium hover:bg-gray-300 transition duration-300">
        Batal
    </a>
    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-lg flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span>{{ isset($unitKerja) ? 'Perbarui Data' : 'Simpan Data' }}</span>
    </button>
</div>