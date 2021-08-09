<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile($user)
    {
        $locale = session("app.locale");
        $profile = Profile::where("user_id", $user)->where("language_id", $locale)->first();
        abort_if(is_null($profile), 404, "Profile Not Found");
        return $profile;
    }
    public function settings(Request $request)
    {
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['sometimes', 'required', 'confirmed']
        ]);
        $id = Auth::id();
        $user = User::find($id);
        $user->email = $request->email;
        if (!is_null($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route("dashboard.account");
    }
}
