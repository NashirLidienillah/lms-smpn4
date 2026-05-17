<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Hapus jejak "intended URL" biar nggak nyasar ke halaman role lain gara-gara tombol back
            $request->session()->forget('url.intended');

            // Redirect MUTLAK berdasarkan role (Jangan pakai ->intended lagi)
            return match (Auth::user()->role) {
                'admin' => redirect('/admin/dashboard'),
                'guru'  => redirect('/guru/dashboard'),
                'siswa' => redirect('/siswa/dashboard'),
                default => redirect('/'),
            };
        }
        
        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}