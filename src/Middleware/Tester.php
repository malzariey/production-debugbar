<?php

namespace malzariey\ProductionDebugbar\Middleware;

use Closure;
use Illuminate\Http\Request;
use malzariey\ProductionDebugbar\ProductionDebugbar;
use Symfony\Component\HttpFoundation\Response;

class Tester
{
    public function handle(Request $request, Closure $next): Response
    {
        ProductionDebugbar::check($request);

        $debugbarKey = config('production-debugbar.password');


        // 1. Check specifically if the request has the query parameter
        if ($request->has($debugbarKey)) {
            $redirect_url = str_replace($debugbarKey, "", $request->getUri());

            // 2. Perform the redirect with the cookie
            return redirect($redirect_url)->withCookie(
                ProductionDebugbar::create()
            );
        }


        return $next($request);
    }
}
