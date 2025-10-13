<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- DITAMBAHKAN
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role', 'unitKerja')
            ->filter($request->only('search', 'role', 'unit_kerja'));

        if ($request->filled('sort')) {
            match ($request->sort) {
                'name_asc'   => $query->orderBy('username', 'asc'),
                'name_desc'  => $query->orderBy('username', 'desc'),
                'latest'     => $query->latest(),
                'oldest'     => $query->oldest(),
                default      => $query->latest(),
            };
        } else {
            $query->latest();
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = Role::orderBy('role_name', 'asc')->get();
        $unitKerjas = UnitKerja::orderBy('unit_kerja_name', 'asc')->get();

        return view('users.index', compact('users', 'roles', 'unitKerjas'));
    }

    public function create()
    {
        $roles = Role::all();
        $unitKerja = UnitKerja::all();
        return view('users.create', compact('roles', 'unitKerja'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
            'unit_kerja_id' => 'nullable|exists:unit_kerjas,id',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $unitKerja = UnitKerja::all();
        return view('users.edit', compact('user', 'roles', 'unitKerja'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|min:6',
            'role_id' => 'required|exists:roles,id',
            'unit_kerja_id' => 'nullable|exists:unit_kerjas,id',
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        if (!isset($validatedData['unit_kerja_id'])) {
            $validatedData['unit_kerja_id'] = null;
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
