<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function profile(string $lang = null)
    {
        $user_id = Auth::id();
        switch ($lang) {
            case 'en':
                $lang_id = 0;
                break;
            case 'fa':
                $lang_id = 1;
                break;

            default:
                $lang = 'fa';
                $lang_id = 1;
                break;
        }
        $profile = Profile::where("user_id", $user_id)->where("language", $lang_id)->first();
        // return $profile;
        return view('user.profile.create', ['user' => $profile, 'lang' => $lang]);
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
    public function setProfile(Request $request, $lang = null)
    {
        switch ($lang) {
            case 'en':
                $lang_id = 0;
                break;
            case 'fa':
                $lang_id = 1;
                break;

            default:
                $lang_id = 1;
                break;
        }
        $user_id = Auth::id();
        $profile = Profile::where("user_id", $user_id)->first();
        if (is_null($profile)) {
            $profile = new Profile([
                'user_id' => $user_id
            ]);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getExtension();
            $filename = "user-" . $user_id . '.' . $ext;
            $path = $image->storeAs('uploads', $filename, 'public');
            $user = User::find($user_id);
            $user->image = $path;
            $user->save();
        }
        $profile->name = $request->name;
        $profile->last_name = $request->last_name;
        $profile->language = $lang_id;
        $profile->phone = $request->phone;
        $profile->public_mail = $request->public_mail;
        $profile->field = $request->field;
        if ($request->has('optional_fields')) {
            $profile->optional_fields = $request->optional_fields;
        }
        $profile->save();
        return redirect()->route('user.profile');
    }
}
