<?php

namespace App\Common\Http\Middleware;

use Closure;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('lang') && in_array(session()->get('lang'), AppLanguages())) {
            app()->setLocale(session()->get('lang'));
        } else {
            session()->put('lang', GetDefaultLang());
            app()->setLocale(GetDefaultLang());
        }
        return $next($request);
    }
}
