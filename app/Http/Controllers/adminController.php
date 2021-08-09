<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function get_users($trash = null)
    {
        // abort_unless()
        !is_null($trash) ? $trash = true : $trash = false;
        if (!$trash) {
            $users = User::where("deleted", '0')->paginate(25);
        } else {
            $users = User::where("deleted", '1')->paginate(25);
        }
        return view('admin.users', ['users' => $users, 'trash' => $trash]);
    }
    public function get_lang()
    {
        $langs = Language::paginate(10);
        return view('admin.language', ['languages' => $langs]);
    }
    public function create_lang(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);
        $lang = new Language();
        $lang->name = $request->name;
        $lang->save();
        return redirect()->route('admin.language');
    }
    public function new_user(Request $request)
    {
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['required', 'confirmed']
        ]);
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('admin.users');
    }
    public function hard_delete_user($id)
    {
        $user = User::find($id);
        abort_if(is_null($user), "404", "User Not Found!");
        $user->delete();
        return redirect()->route("admin.users");
    }
    public function soft_delete_user($id)
    {
        $user = User::find($id);
        abort_if(is_null($user), "404", "User Not Found!");
        $user->deleted = true;
        $user->save();
        return redirect()->route("admin.users");
    }
    public function settings(Request $request)
    {
        // return $request->all();
        $request->validate([
            'name' => ['string', 'required'],
            'email' => ['email', 'required'],
            'password' => ['confirmed']
        ]);
        $id = Auth::guard("admin")->id();
        $user = Admin::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if (!is_null($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route("dashboard.account");
    }
}
