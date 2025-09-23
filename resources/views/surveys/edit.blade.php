@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">Edit Survei</h1>

    <form action="{{ route('surveys.update', $survey->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Survei:</label>
                <input type="text" id="title" name="title" value="{{ $survey->title }}" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi:</label>
                <textarea id="description" name="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">{{ $survey->description }}</textarea>
            </div>

            <div>
                <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai:</label>
                <input type="date" id="start_date" name="start_date" value="{{ $survey->start_date }}" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
            </div>
            <div>
                <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Selesai:</label>
                <input type="date" id="end_date" name="end_date" value="{{ $survey->end_date }}" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
            </div>

            <div class="md:col-span-2">
                <label for="unit_kerja" class="block text-sm font-semibold text-gray-700 mb-1">Unit Kerja:</label>
                <div id="unit-kerja-dropdown" class="dropdown w-full">
                    <button class="btn btn-outline-secondary dropdown-toggle w-full text-left rounded-lg border-gray-300 shadow-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="selected-units-label">Pilih satu atau lebih unit kerja</span>
                    </button>
                    <div class="dropdown-menu p-2" aria-labelledby="unit-kerja-dropdown">
                        @foreach($unitKerja as $unit)
                        <div class="form-check">
                            <input class="form-check-input unit-checkbox" type="checkbox" name="unit_kerja[]" value="{{ $unit->id }}" id="unit-{{ $unit->id }}"
                                {{ $survey->unitKerja->contains($unit->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="unit-{{ $unit->id }}">
                                {{ $unit->unit_kerja_name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <input type="hidden" name="unit_kerja_validate" id="hidden_unit_kerja_input" required>
            </div>
        </div>

        <div class="flex items-center space-x-4 mt-8">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-lg transform hover:scale-105">
                Perbarui Survei
            </button>
            <a href="{{ route('surveys.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg text-lg font-medium hover:bg-gray-400 transition duration-300 shadow-lg transform hover:scale-105">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectedLabel = document.getElementById('selected-units-label');
        const checkboxes = document.querySelectorAll('.unit-checkbox');
        const dropdownMenu = document.querySelector('.dropdown-menu');
        const hiddenInput = document.getElementById('hidden_unit_kerja_input');

        let selectedUnits = {};

        checkboxes.forEach(function(checkbox) {
            // Logika untuk menandai unit kerja yang sudah dipilih saat halaman dimuat
            if (checkbox.checked) {
                selectedUnits[checkbox.value] = checkbox.nextElementSibling.textContent.trim();
            }

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    selectedUnits[this.value] = this.nextElementSibling.textContent.trim();
                } else {
                    delete selectedUnits[this.value];
                }
                updateSelectedUnitsLabel();
            });
        });

        function updateSelectedUnitsLabel() {
            const unitNames = Object.values(selectedUnits);
            selectedLabel.textContent = '';
            if (unitNames.length === 0) {
                selectedLabel.textContent = 'Pilih satu atau lebih unit kerja';
                hiddenInput.removeAttribute('name');
            } else {
                hiddenInput.setAttribute('name', 'unit_kerja_validate');
                hiddenInput.value = unitNames.join(',');
                unitNames.forEach(function(name) {
                    const tag = document.createElement('span');
                    tag.className = 'badge bg-indigo-600 text-white mr-1';
                    tag.textContent = name;
                    selectedLabel.appendChild(tag);
                });
            }
        }

        dropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Panggil fungsi ini sekali saat halaman dimuat untuk menampilkan pilihan awal
        updateSelectedUnitsLabel();
    });
</script>
@endsection