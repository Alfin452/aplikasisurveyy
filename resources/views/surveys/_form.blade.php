@csrf
<div class="space-y-8">
    {{-- KARTU 1: DETAIL SURVEI --}}
    <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">1. Detail Survei</h3>
        <div class="space-y-6">
            {{-- Judul Survei --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Survei</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="title" name="title" value="{{ old('title', $survey->title ?? '') }}" class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required placeholder="Contoh: Survei Kepuasan Layanan Akademik">
                </div>
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea id="description" name="description" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" placeholder="Jelaskan tujuan dari survei ini secara singkat">{{ old('description', $survey->description ?? '') }}</textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    {{-- KARTU 2: JADWAL & PENARGETAN --}}
    <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">2. Jadwal & Penargetan</h3>
        <div class="space-y-6">
            {{-- Periode Survei --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', isset($survey) ? $survey->start_date->format('Y-m-d') : '') }}" class="datepicker w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
                    @error('start_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', isset($survey) ? $survey->end_date->format('Y-m-d') : '') }}" class="datepicker w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
                    @error('end_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Target Unit Kerja --}}
            <div>
                <label for="unit_kerja_select" class="block text-sm font-medium text-gray-700 mb-1">Target Unit Kerja</label>
                <select id="unit_kerja_select" name="unit_kerja[]" multiple>
                    @foreach($unitKerja as $id => $name)
                    <option value="{{ $id }}"
                        @if(isset($survey) && $survey->unitKerja->contains($id)) selected @endif
                        @if(is_array(old('unit_kerja')) && in_array($id, old('unit_kerja'))) selected @endif
                        >{{ $name }}</option>
                    @endforeach
                </select>
                @error('unit_kerja') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                @error('unit_kerja.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="flex items-center p-2 border rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="h-5 w-5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_active', $survey->is_active ?? true) ? 'checked' : '' }}>
                    <span class="ml-3 text-sm font-medium text-gray-700">Aktifkan survei ini</span>
                </label>
            </div>
        </div>
    </div>
</div>

{{-- DIUBAH: Separator Visual Anti-Mainstream --}}
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


{{-- Tombol Aksi --}}
<div class="flex items-center justify-end space-x-4">
    <a href="{{ route('surveys.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-medium hover:bg-gray-300 transition duration-300">
        Batal
    </a>
    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-lg flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span>{{ isset($survey) ? 'Perbarui Survei' : 'Simpan & Lanjutkan' }}</span>
    </button>
</div>