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
        $debugbarParameter = config('production-debugbar.get_parameter');

        // 1. Check specifically if the request has the query parameter
        if ($request->get($debugbarParameter, null) === $debugbarKey) {
            //remove the parameter from the URL
            $redirect_url = $request->fullUrlWithQuery([
                $debugbarParameter => null,
            ]);
            // 2. Perform the redirect with the cookie
            return redirect($redirect_url)->withCookie(
                ProductionDebugbar::create()
            );
        }

        return $next($request);
    }
}