<?php

namespace App\Http\Controllers;

use App\Models\Awards;
use App\Models\Profile;
use App\Models\Publication;
use App\Models\Thesis;
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

        if (!is_null($image = User::find($user_id)->image)) {
            $profile->image = $image;
        }
        return view('user.profile.create', ['user' => $profile, 'lang' => $lang]);
    }
    public function settings(Request $request)
    {
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['sometimes', 'confirmed'],
            'slug' => ['required', 'string']
        ]);
        $id = Auth::id();
        $user = User::find($id);
        $user->email = $request->email;
        if (!is_null($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->slug = $request->slug;
        $user->save();
        session()->forget('slug');
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
                $lang = 'fa';
                break;
        }
        $user_id = Auth::id();
        $profile = Profile::where("user_id", $user_id)->where("language", $lang_id)->first();
        if (is_null($profile)) {
            $profile = new Profile();
            $profile->user_id = $user_id;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
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
        return redirect()->route('user.profile', ['lang' => $lang]);
    }
    public function pubs(Request $request)
    {
        $user = Auth::id();
        $publications = new Publication();
        $publications->name  = $request->name;
        $publications->language = $request->language;
        $publications->user_id = $user;
        $publications->save();
        return redirect()->route('user.publications');
    }
    public function pubs_edit(Request $request)
    {
        $publications = Publication::find($request->id);
        abort_if(is_null($publications), 404);
        $publications->name  = $request->name;
        $publications->language = $request->language;
        $publications->save();
        return redirect()->route('user.publications');
    }
    public function pubs_list()
    {
        $user = Auth::id();
        $publications = Publication::where('user_id', $user)->get();
        return view('user.list', ['data' => $publications, 'route' => 'publications']);
    }
    public function awards(Request $request)
    {
        $user = Auth::id();
        $awards = new Awards();
        $awards->name  = $request->name;
        $awards->language = $request->language;
        $awards->user_id = $user;
        $awards->save();
        return redirect()->route('user.awards');
    }
    public function awards_edit(Request $request)
    {
        $awards = Awards::find($request->id);
        abort_if(is_null($awards), 404);
        $awards->name  = $request->name;
        $awards->language = $request->language;
        $awards->save();
        return redirect()->route('user.awards');
    }
    public function awards_list()
    {
        $user = Auth::id();
        $awards = Awards::where('user_id', $user)->get();
        return view('user.list', ['data' => $awards, 'route' => 'awards']);
    }
    public function delete($table, $id)
    {
        switch ($table) {
            case 'publications':
                $model = Publication::find($id);
                break;
            case 'awards':
                $model = Awards::find($id);
                break;
            case 'thesis':
                $model = Thesis::find($id);
                break;

            default:
                abort(404);
                break;
        }
        abort_if(is_null($model), 404);
        $model->delete();
        return back();
    }
    public function thesis(Request $request)
    {
        $thesis = new Thesis();
        $thesis->language = $request->language;
        $thesis->name = $request->name;
        $thesis->project_name = $request->project_name;
        $thesis->degree = $request->degree;
        $thesis->degree = $request->degree;
        $thesis->defense_date = $request->defense_date;
        $thesis->user_id = Auth::id();
        $thesis->save();
        return redirect()->route("user.thesis");
    }
    public function thesis_edit(Request $request)
    {
        $thesis = Thesis::find($request->id);
        $thesis->language = $request->language;
        $thesis->name = $request->name;
        $thesis->project_name = $request->project_name;
        $thesis->degree = $request->degree;
        $thesis->degree = $request->degree;
        $thesis->defense_date = $request->defense_date;
        $thesis->user_id = Auth::id();
        $thesis->save();
        return redirect()->route("user.thesis");
    }
    public function thesis_list()
    {
        $thesis = Thesis::where('user_id', Auth::id())->get();
        return view('user.thesis', ['data' => $thesis]);
    }
}
