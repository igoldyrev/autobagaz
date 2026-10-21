<?php

namespace App\Http\Middleware;

use App\Services\TelegramSiteErrors;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class RecordServerErrors
{
    public const REPORTED_EXCEPTIONS = 'telegram.reported_exceptions';

    public function handle(Request $request, Closure $next): Response
    {
        $request->attributes->set(self::REPORTED_EXCEPTIONS, []);
        $response = $next($request);
        $status = $response->getStatusCode();

        if ($status >= 500 && $status <= 599) {
            $exception = ($response->exception ?? null) instanceof Throwable ? $response->exception : null;
            $alreadyReported = $exception && in_array($exception, $request->attributes->get(self::REPORTED_EXCEPTIONS, []), true);
            $route = $request->route();
            // Use the route template, never the requested URL or parameter values.
            $context = $route ? $request->method().' /'.$route->uri() : $request->method().' [unmatched route]';
            app(TelegramSiteErrors::class)->record(
                $exception ?? new HttpException($status),
                httpStatus: $status,
                route: $context,
                increment: ! $alreadyReported,
            );
        }

        return $response;
    }
}
