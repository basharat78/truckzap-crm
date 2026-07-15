<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function create(){
        if(Auth::check() && Auth::user()->hasRole('admin')){
            return redirect()->route('admin.dashboard.index');
        }

        return view('admin.auth.login');
    }
    public function store(Request $request){
        $credentials =$request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(!Auth::attempt($credentials, $request->boolean('remember'))){
            throw ValidationException::withMessages([
                'email' => __('the provided credentials do not match our records.'),
            ]);
           
        }
        if(!Auth::user()->hasRole('admin')){
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => __('the provided credentials do not match our records.'),
            ]);
            
        }
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard.index');
    }
        public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


}
