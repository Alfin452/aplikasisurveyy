@csrf
{{-- Menggunakan Alpine.js untuk form dinamis --}}
<div x-data="{ roleId: '{{ old('role_id', $user->role_id ?? '3') }}' }"> {{-- Default ke role 'User' atau sesuaikan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

        {{-- DIUBAH: Ukuran font label diperbesar dengan menghapus 'text-sm' --}}

        {{-- Username --}}
        <div>
            <label for="username" class="block font-semibold text-gray-700 mb-1">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username', $user->username ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
            @error('username') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Password --}}
        <div class="md:col-span-2">
            <label for="password" class="block font-semibold text-gray-700 mb-1">Password</label>
            <input type="password" id="password" name="password" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" {{ isset($user) ? '' : 'required' }}>
            @if(isset($user))
            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
            @endif
            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Peran (Role) --}}
        <div>
            <label for="role_id" class="block font-semibold text-gray-700 mb-1">Peran</label>
            <select id="role_id" name="role_id" x-model="roleId" class="w-full" required>
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                @endforeach
            </select>
            @error('role_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Unit Kerja (Muncul secara kondisional) --}}
        <div x-show="roleId === '2'" x-transition>
            <label for="unit_kerja_id" class="block font-semibold text-gray-700 mb-1">Unit Kerja</label>
            <select id="unit_kerja_id" name="unit_kerja_id" class="w-full">
                <option value="">-- Pilih Unit Kerja --</option>
                @foreach($unitKerja as $unit)
                <option value="{{ $unit->id }}" {{ old('unit_kerja_id', $user->unit_kerja_id ?? '') == $unit->id ? 'selected' : '' }}>{{ $unit->unit_kerja_name }}</option>
                @endforeach
            </select>
            @error('unit_kerja_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

<div class="flex items-center space-x-4 mt-8">
    <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-lg transform hover:scale-105">
        {{ isset($user) ? 'Perbarui Pengguna' : 'Simpan Pengguna' }}
    </button>
    <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg text-lg font-medium hover:bg-gray-300 transition duration-300 shadow-lg">
        Batal
    </a>
</div>