{{-- resources/views/unit_kerja/_form.blade.php --}}
@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
    <!-- Nama Unit Kerja -->
    <div>
        <label for="unit_kerja_name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Unit Kerja:</label>
        <input type="text" id="unit_kerja_name" name="unit_kerja_name"
            value="{{ old('unit_kerja_name', $unitKerja->unit_kerja_name ?? '') }}"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('unit_kerja_name') border-red-500 @enderror" required>
        @error('unit_kerja_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <!-- Nama Singkat -->
    <div>
        <label for="uk_short_name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Singkat:</label>
        <input type="text" id="uk_short_name" name="uk_short_name"
            value="{{ old('uk_short_name', $unitKerja->uk_short_name ?? '') }}"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('uk_short_name') border-red-500 @enderror">
        @error('uk_short_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <!-- Tipe Unit -->
    <div>
        <label for="tipe_unit_id" class="block text-sm font-semibold text-gray-700 mb-1">Tipe Unit:</label>
        <select id="tipe_unit_id" name="tipe_unit_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('tipe_unit_id') border-red-500 @enderror" required>
            <option value="">Pilih Tipe</option>
            @foreach ($tipeUnits as $id => $nama)
            <option value="{{ $id }}" {{ old('tipe_unit_id', $unitKerja->tipe_unit_id ?? '') == $id ? 'selected' : '' }}>
                {{ $nama }}
            </option>
            @endforeach
        </select>
        @error('tipe_unit_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <!-- Induk Unit Kerja -->
    <div>
        <label for="parent_id" class="block text-sm font-semibold text-gray-700 mb-1">Induk Unit Kerja (Opsional):</label>
        <select id="parent_id" name="parent_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('parent_id') border-red-500 @enderror">
            <option value="">Tidak Ada Induk</option>
            @foreach ($parentUnits as $id => $nama)
            @if(isset($unitKerja) && $unitKerja->id === $id) @continue @endif
            <option value="{{ $id }}" {{ old('parent_id', $unitKerja->parent_id ?? '') == $id ? 'selected' : '' }}>
                {{ $nama }}
            </option>
            @endforeach
        </select>
        @error('parent_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <!-- Kontak & Lokasi (Tidak ada perubahan) -->
    <div>
        <label for="contact" class="block text-sm font-semibold text-gray-700 mb-1">Kontak:</label>
        <input type="text" id="contact" name="contact" value="{{ old('contact', $unitKerja->contact ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('contact') border-red-500 @enderror">
        @error('contact') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Lokasi:</label>
        <input type="text" id="address" name="address" value="{{ old('address', $unitKerja->address ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('address') border-red-500 @enderror">
        @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <!-- Jam Layanan (BAGIAN YANG DIUBAH) -->
    <div class="col-span-1 md:col-span-2 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6">
        <div class="w-full md:w-1/2">
            <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-1">Jam Mulai Layanan:</label>
            {{-- DIUBAH: type="time" menjadi "text" dan tambahkan class "timepicker" --}}
            <input type="text" id="start_time" name="start_time" value="{{ old('start_time', $unitKerja->start_time ?? '') }}"
                class="timepicker w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('start_time') border-red-500 @enderror">
            @error('start_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        <div class="w-full md:w-1/2">
            <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-1">Jam Selesai Layanan:</label>
            {{-- DIUBAH: type="time" menjadi "text" dan tambahkan class "timepicker" --}}
            <input type="text" id="end_time" name="end_time" value="{{ old('end_time', $unitKerja->end_time ?? '') }}"
                class="timepicker w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('end_time') border-red-500 @enderror">
            @error('end_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

<div class="flex items-center space-x-4 mt-8">
    <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-lg transform hover:scale-105">
        {{ isset($unitKerja) ? 'Perbarui Data' : 'Simpan Data' }}
    </button>
    <a href="{{ route('unit-kerja.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg text-lg font-medium hover:bg-gray-400 transition duration-300 shadow-lg transform hover:scale-105">
        Batal
    </a>
</div>