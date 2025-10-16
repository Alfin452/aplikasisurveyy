@csrf
<div class="space-y-6 bg-white p-6 rounded-xl shadow-lg border">
    {{-- Judul Program --}}
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Judul Program Survei</label>
        <input type="text" name="title" id="title" value="{{ old('title', $program->title ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: Survei Penilaian Zona Integritas 2025">
        @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    {{-- Deskripsi --}}
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Jelaskan tujuan umum dari program survei ini...">{{ old('description', $program->description ?? '') }}</textarea>
        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    {{-- Target Unit Kerja --}}
    <div>
        <label for="targeted_unit_kerjas_select" class="block text-sm font-medium text-gray-700">Targetkan ke Unit Kerja</label>
        <select name="targeted_unit_kerjas[]" id="targeted_unit_kerjas_select" multiple required>
            <option value="">Pilih Unit Kerja</option>
            @foreach($unitKerjas as $unit)
            <option value="{{ $unit->id }}"
                {{ (in_array($unit->id, old('targeted_unit_kerjas', $program->targetedUnitKerjas->pluck('id')->toArray() ?? []))) ? 'selected' : '' }}>
                {{ $unit->unit_kerja_name }}
            </option>
            @endforeach
        </select>
        @error('targeted_unit_kerjas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>
</div>

{{-- Tombol Aksi --}}
<div class="mt-8 pt-6 border-t flex justify-end space-x-3">
    <a href="{{ route('programs.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
        Batal
    </a>
    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
        Simpan Program
    </button>
</div>