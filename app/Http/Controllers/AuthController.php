<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials  = $request->validate([
            'email' => ['email', 'required'],
            'password' => ['required']
        ]);
        if ($request->has('admin') && $request->admin === "true") {
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                session()->put('role', 'admin');
                return redirect()->intended('admin/dashboard');
            }
        } else {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                session()->put('role', 'user');
                $user = User::find(Auth::id());
                if (is_null($user->slug)) {
                    session()->put('slug', false);
                }
                return redirect()->intended('admin/dashboard');
            }
        }
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.'
        ]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['sometimes', 'required', 'string'],
            'password' => ['required', 'confirmed'],
            'email' => ['email', 'required']
        ]);
        if ($request->has("admin") && $request->admin === "true") {
            $user = new Admin();
            $user->name = $request->name;
        } else {
            $user = new User();
        }
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->save();
        return redirect()->route("public.login", ['admin' => 'test']);
    }
    public function login_form(Request $request)
    {
        if ($request->has("admin") && $request->admin === "true") {
            return view("auth.login", ['admin' => true]);
        }
        return view("auth.login", ['admin' => false]);
    }
    public function register_form(Request $request)
    {
        if ($request->has("admin") && $request->admin === "true") {
            return view("auth.register", ['admin' => true]);
        }
        return view("auth.register", ['admin' => false]);
    }
}
