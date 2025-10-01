@csrf
<div class="space-y-10">

    {{-- BAGIAN 1: INFORMASI UTAMA --}}
    <div>
        {{-- Header Bagian yang Unik --}}
        <div class="flex items-center mb-6">
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-indigo-500 text-white rounded-full">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.01 9.383l4.01 1.718a.999.999 0 01.356.257l4-1.714a1 1 0 11.788 1.838L9.08 12.335l1.94.83a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84zM12 13a1 1 0 100 2h3a1 1 0 100-2h-3z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Utama</h3>
                <p class="text-sm text-gray-500">Detail dasar mengenai unit kerja.</p>
            </div>
        </div>
        {{-- Konten Form --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-14">
            <div>
                <label for="unit_kerja_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Unit Kerja</label>
                <input type="text" id="unit_kerja_name" name="unit_kerja_name" value="{{ old('unit_kerja_name', $unitKerja->unit_kerja_name ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
                @error('unit_kerja_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="uk_short_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Singkat (Akronim)</label>
                <input type="text" id="uk_short_name" name="uk_short_name" value="{{ old('uk_short_name', $unitKerja->uk_short_name ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                @error('uk_short_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- BAGIAN 2: STRUKTUR ORGANISASI --}}
    <div>
        {{-- Header Bagian yang Unik --}}
        <div class="flex items-center mb-6">
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-indigo-500 text-white rounded-full">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.969A3 3 0 0012 12.75a3 3 0 00-3.75 0m-7.5 0a3 3 0 003.75 0M12 12.75a3 3 0 00-3.75 0M3.75 6.75a3 3 0 00-3.75 0m7.5 0a3 3 0 00-3.75 0m7.5 0a3 3 0 00-3.75 0m3.75 2.25a3 3 0 00-3.75 0m0 0a3 3 0 00-3.75 0m0 0a3 3 0 00-3.75 0M12 6.75a3 3 0 00-3.75 0m0 0a3 3 0 00-3.75 0m0 0a3 3 0 00-3.75 0" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-800">Struktur Organisasi</h3>
                <p class="text-sm text-gray-500">Kategori dan posisi dalam hierarki.</p>
            </div>
        </div>
        {{-- Konten Form --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-14">
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

    {{-- BAGIAN 3: INFORMASI OPERASIONAL --}}
    <div>
        {{-- Header Bagian yang Unik --}}
        <div class="flex items-center mb-6">
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-indigo-500 text-white rounded-full">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Operasional</h3>
                <p class="text-sm text-gray-500">Detail kontak, lokasi, dan jam layanan.</p>
            </div>
        </div>
        {{-- Konten Form --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-14">
            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Kontak (Telepon/Email)</label>
                <input type="text" id="contact" name="contact" value="{{ old('contact', $unitKerja->contact ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                @error('contact') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Lokasi (Gedung/Ruangan)</label>
                <input type="text" id="address" name="address" value="{{ old('address', $unitKerja->address ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                    <input type="text" id="start_time" name="start_time" value="{{ old('start_time', $unitKerja->start_time ?? '') }}" class="timepicker w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    @error('start_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                    <input type="text" id="end_time" name="end_time" value="{{ old('end_time', $unitKerja->end_time ?? '') }}" class="timepicker w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
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