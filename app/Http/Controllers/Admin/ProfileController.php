<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    use FileUploadTrait;
    public function index()

    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $avatarPath = $this->uploadImage($request, 'avatar', $request->old_avatar);

        $user = Auth::user();
        $user->avatar = !empty($avatarPath) ? $avatarPath : $request->old_avatar;
        $user->name = $request->name;
        $user->email = $request->email;
      

        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
    function  PasswordUpdate(Request $request): RedirectResponse
    { //redirdectResponse is a return type for redirecting to the same page
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

     
        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
