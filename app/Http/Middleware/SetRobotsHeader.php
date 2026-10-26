<?php

namespace App\Http\Middleware;

use App\Support\Seo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetRobotsHeader
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $robots = app(Seo::class)->robots($request);

        if ($response->getStatusCode() >= 400) {
            $robots = 'noindex,nofollow';
        }

        if ($robots !== 'index,follow') {
            $response->headers->set('X-Robots-Tag', str_replace(',', ', ', $robots));
        }

        return $response;
    }
}
