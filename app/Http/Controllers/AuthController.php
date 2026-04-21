<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function index() {
        return view ('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate ([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ini agar otomatis berdasarkan role nya
            return match (Auth::user()->role) {
                'admin' => redirect() -> intended('/admin/dashboard'),
                'guru' => redirect() -> intended('/guru/dashboard'),
                'siswa' => redirect() -> intended('/siswa/dashboard'),
                default => redirect('/'),
            };
        }
        return back() -> withErrors(['username' => 'Username atau password salah']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}