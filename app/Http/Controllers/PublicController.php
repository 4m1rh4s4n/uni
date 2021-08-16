<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\App;

class PublicController extends Controller
{
    public function index($slug, $locale = null)
    {
        if (!is_null($locale)) {
            App::setLocale($locale);
            $lang_id = 0;
        } else {
            $lang_id = 1;
            App::setLocale('fa');
        }
        $user = User::with([
            'profile' =>  function ($query) use ($lang_id) {
                $query->where('language', $lang_id);
            },
            'publications' =>  function ($query) use ($lang_id) {
                $query->where('language', $lang_id);
            },
            'awards' =>  function ($query) use ($lang_id) {
                $query->where('language', $lang_id);
            },
            'thesis' =>  function ($query) use ($lang_id) {
                $query->where('language', $lang_id);
            },
        ])->where('slug', $slug)->first();
        abort_if(is_null($user), 404);
        abort_if(is_null($user->profile), 404);
        // return $user;
        return view('welcome', ['user' => $user, 'lang' => $lang_id]);
    }
    /**
     * @deprecated 0.01
     */
    public function locale($id)
    {
        switch ($id) {
            case '1':
                session()->put("app.locale", '1');
                session()->put("app.localeName", 'fa');
                break;
            case '0':
                session()->put("app.locale", '0');
                session()->put("app.localeName", 'en');
                break;
        }
        return redirect()->back();
    }
}
