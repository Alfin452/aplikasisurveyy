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
            // DIUBAH: Menggunakan method redirect yang sudah disempurnakan
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * DIUBAH: Logika pengalihan sekarang menggunakan role_id untuk keandalan
     * dan mengarah ke rute yang benar.
     */
    protected function redirectBasedOnRole($user)
    {
        switch ($user->role_id) {
            // Role ID 1 untuk Superadmin
            case 1:
                return redirect()->route('superadmin.dashboard');
                // Role ID 2 untuk Admin Unit Kerja
            case 2:
                return redirect()->route('unitkerja.admin.dashboard');
                // Role ID 3 untuk Responden (atau peran lainnya)
            case 3:
                return redirect()->route('home'); // Sesuaikan jika responden punya dasbor sendiri
                // Default fallback
            default:
                return redirect()->route('home');
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
