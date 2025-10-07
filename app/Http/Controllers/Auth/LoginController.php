<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login terpadu (Admin & Responden).
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses login untuk Admin.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->is_superadmin) {
                return redirect()->intended(route('superadmin.dashboard'));
            } elseif ($user->is_unitkerja_admin) {
                return redirect()->intended(route('unitkerja.admin.dashboard'));
            }

            // Jika bukan admin, logout dan beri pesan error
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda tidak memiliki hak akses admin.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Jika user ada, cek apakah dia admin. Jika ya, jangan biarkan login via Google.
                if ($user->is_superadmin || $user->is_unitkerja_admin) {
                    return redirect()->route('login')->withErrors(['email' => 'Login Admin harus menggunakan email dan password.']);
                }
                Auth::login($user);
            } else {
                $newUser = User::create([
                    'username' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(uniqid()),
                    'role_id' => 3,
                ]);
                Auth::login($newUser);
            }

            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
