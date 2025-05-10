<?php

namespace malzariey\ProductionDebugbar\Middleware;

use Closure;
use Illuminate\Http\Request;
use malzariey\ProductionDebugbar\ProductionDebugbar;
use Symfony\Component\HttpFoundation\Response;
use function App\Http\Middleware\redirect;

class Tester
{
    public function handle(Request $request, Closure $next): Response
    {
        dd(config('production-debugbar.url_key'));
        if (str_contains($request->fullUrl(),config('production-debugbar.url_key'))) {
            return redirect('/')->withCookie(
                ProductionDebugbar::create()
            );
        }

        return $next($request);
    }
}
