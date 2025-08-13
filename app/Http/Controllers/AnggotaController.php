<?php

namespace App\Http\Controllers;

use App\Models\Datadiri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'anggota');

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('username', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $anggota = $query->latest()->paginate(10); 

        return view('admin.kelola_anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('admin.kelola_anggota.create');
    }

    // Simpan data anggota baru
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
        ]);

        User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'password' => Hash::make('password123'), // Default password
            'role' => 'anggota',
        ]);

        return redirect()->route('kelola_anggota.kelola_anggota')
                         ->with('pesan', 'Anggota berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $anggota = User::findOrFail($id);
        return view('admin.kelola_anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $anggota->id,
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $anggota->id,
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $anggota->update([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        return redirect()->route('kelola_anggota.kelola_anggota')
                         ->with('edit', 'Data anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = User::findOrFail($id);
        $anggota->delete();

        return redirect()->route('kelola_anggota.kelola_anggota')
                         ->with('hapus', 'Data anggota berhasil dihapus.');
    }

    public function index_anggota(){
        return view('anggota.index');
    }

    public function profile(){
        $user = auth()->user();
        return view('anggota.profile_anggota.index', compact('user'));
    }

    public function identitas(){
        $user = auth()->user();
        $anggota = Datadiri::where('user_id', $user->id)->first();
        return view('anggota.profile_anggota.identitas', compact('user', 'anggota'));
    }

}
