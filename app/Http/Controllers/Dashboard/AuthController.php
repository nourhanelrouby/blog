<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdateAccountRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $path;

    public function __construct()
    {
        $this->path = 'dashboard.auth.';
    }

    public function login()
    {
        return view($this->path . 'login');
    }

    public function loginPost(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember_token') ? true : false;
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.home');
        }
        return back()->with('error', 'Incorrect username or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('dashboard.login');
    }

    public function profile(){
        $title = 'User Profile';
        $user = Auth::user();
        return view($this->path.'profile',compact('title','user'));
    }

     public function profileUpdate(UpdateAccountRequest $request){
         $user = auth()->user();
         $user->update($request->only('name','email'));

         if($request->filled('password')){
            $user->update([
                'password'=>Hash::make($request->password),
            ]);
         }

           return back()->with('success', 'Profile updated successfully!');
     }


}
