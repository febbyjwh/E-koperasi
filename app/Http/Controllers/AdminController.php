<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
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

    public function changephoto(){
        return view ('admin.profile_admin.changephoto');
    }

}
