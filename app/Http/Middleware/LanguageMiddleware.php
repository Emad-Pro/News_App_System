<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // لو فيه لغة في السيشن استخدمها، وإلا خلي الافتراضية 'ar'
        $locale = session('locale', 'ar');

        // حدد اللغة الحالية
        App::setLocale($locale);

        // شارك الاتجاه واللغة مع كل الواجهات
        view()->share('dir', $locale === 'ar' ? 'rtl' : 'ltr');
        view()->share('lang', $locale);

        return $next($request);
    }
}
