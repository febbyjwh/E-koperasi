<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function formlogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return redirect()->back()->with(['pesan' => 'Username tidak terdaftar!']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with(['pesan' => 'Password tidak sesuai!']);
        }

        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            $authenticatedUser = Auth::user();

            if ($authenticatedUser->role === 'admin') {
                return redirect()->route('dashboard');
            } elseif ($authenticatedUser->role === 'anggota') {
                return redirect()->route('anggota.home');
            }

            Auth::logout();
            return redirect()->back()->with(['pesan' => 'Role tidak dikenali.']);
        }

        return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.formlogin')->with('pesan', 'Anda telah berhasil logout.');
    }

    public function register()
    {
        return view('auth.register');
    }
}
