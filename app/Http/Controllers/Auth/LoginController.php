<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Tangani login manual
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Logika untuk mengarahkan user setelah login
    protected function redirectBasedOnRole($user)
    {
        switch ($user->role->role_name) {
            case 'super_admin':
                return redirect()->intended('/superadmin/dashboard');
            case 'unit_kerja':
                return redirect()->intended('/unitkerja/dashboard');
            case 'responden':
                return redirect()->intended('/');
            default:
                return redirect()->intended('/');
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
