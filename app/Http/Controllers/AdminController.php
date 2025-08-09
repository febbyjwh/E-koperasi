<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile_admin.index', compact('user'));
    }



    public function changepass()
    {
        return view('admin.profile_admin.changepass');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed',
            'terms' => 'accepted',
        ]);

        $user = auth()->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->route('profile_admin.index')->with('success', 'Password updated successfully!');
    }

    public function changephoto(Request $request)
    {
        // Tampilkan form kalau GET
        if ($request->isMethod('get')) {
            return view('admin.profile_admin.changephoto');
        }

        // Validasi file
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        $user = auth()->user();

        // Hapus foto lama kalau ada
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Format nama file: namaanggota_nomorrandom.extension
        $filename = Str::slug($user->name, '_') . '_' . rand(1000, 9999) . '.' . $request->photo->extension();

        // Simpan file ke storage/app/public/photos
        $path = $request->photo->storeAs('photos', $filename, 'public');

        // Simpan path di database
        $user->photo = $path;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diubah.');
    }
}
