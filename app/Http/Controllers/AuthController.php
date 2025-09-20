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

        if (Auth::guard('web')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            $authenticatedUser = Auth::user();

            if ($authenticatedUser->role === 'admin') {
                return redirect()->route('dashboard');
            } elseif ($authenticatedUser->role === 'anggota') {
                return redirect()->route('anggota.anggota');
            }

            Auth::logout();
            return redirect()->back()->with(['pesan' => 'Role tidak dikenali.']);
        }

        return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('formlogin'); // arahkan ke halaman login
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'no_hp' => [
                'required',
                'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,11}$/'
            ],
            'alamat' => 'nullable|string|max:255',
            'password' => [
            'required',
            'string',
            'confirmed',
            'min:8', // minimal 8 karakter
            'regex:/[A-Z]/', // harus ada huruf kapital
            'regex:/[a-z]/', // harus ada huruf kecil
            'regex:/[0-9]/', // harus ada angka
            'regex:/[@$!%*?&]/', // harus ada simbol
        ],
    ], [
        'no_hp.regex' => 'Nomor HP harus diawali 08 / 62 / +62 dan panjang 10-14 digit.',   
        'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.'
        ]);

        User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
        'password' => Hash::make($request->password),
        'role' => 'anggota', // default role
        ]);

        return redirect()->route('formlogin')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => [
            'required',
            'string',
            'confirmed',
            'min:8',
            'regex:/[A-Z]/',
            'regex:/[a-z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*?&]/',
            ]
        ], [
             'new_password.regex' => 'Password baru harus mengandung huruf besar, huruf kecil, angka, dan simbol.'
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        if (Auth::check() && Auth::id() == $user->id) {
            Auth::logout();
        }

        return redirect()->route('formlogin')->with('pesan', 'Kata sandi berhasil diubah. Silakan login dengan kata sandi baru.');
    }
}
