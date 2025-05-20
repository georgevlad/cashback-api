<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Accept-Language', config('app.locale'));

        if (in_array($locale, config('locales.supported'))) {
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.fallback_locale'));
        }

        return $next($request);
    }
}
