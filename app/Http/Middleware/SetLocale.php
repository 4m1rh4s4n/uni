<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // $locale = session()->has("app.locale");
        // dd($locale);
        // if ($locale) {
        //     session()->put("app.locale", '1');
        //     session()->put("app.localeName", 'fa');
        //     App::setLocale('fa');
        // } else {
        //     App::setLocale(session()->get('app.localeName'));
        // }
        return $next($request);
    }
}
