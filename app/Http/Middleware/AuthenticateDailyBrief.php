<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateDailyBrief
{
    public function handle(Request $request, Closure $next): Response
    {
        $expectedToken = config('services.daily_brief.token');
        if (! is_string($expectedToken) || $expectedToken === '') {
            abort(Response::HTTP_SERVICE_UNAVAILABLE);
        }

        $providedToken = $request->bearerToken();
        if (! is_string($providedToken) || ! hash_equals($expectedToken, $providedToken)) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
