<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;

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
        // $locale = session("app.locale");
        if (is_null(session("app.locale"))) {
            session()->put("app.locale", '1');
            session()->put("app.localeName", 'Farsi');
        }
        return $next($request);
    }
}
