<?php

use App\Http\Middleware\AuthenticateDailyBrief;
use App\Http\Middleware\EnsureUserHasPermission;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsSuperAdmin;
use App\Http\Middleware\RecordAdminActivity;
use App\Http\Middleware\RecordServerErrors;
use App\Http\Middleware\ResolveVehicleConfiguration;
use App\Http\Middleware\TrackAdminPresence;
use App\Services\TelegramSiteErrors;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\AuthenticateSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prepend(RecordServerErrors::class);
        $middleware->encryptCookies(except: ['autobagaz_cookie_notice']);
        $middleware->web(append: [ResolveVehicleConfiguration::class]);

        $middleware->alias([
            'daily_brief.token' => AuthenticateDailyBrief::class,
            'admin' => EnsureUserIsAdmin::class,
            'admin.activity' => RecordAdminActivity::class,
            'admin.presence' => TrackAdminPresence::class,
            'auth.session' => AuthenticateSession::class,
            'permission' => EnsureUserHasPermission::class,
            'super_admin' => EnsureUserIsSuperAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (Throwable $exception): void {
            app(TelegramSiteErrors::class)->record($exception);
            if (app()->bound('request')) {
                $request = app('request');
                if ($request->attributes->has(RecordServerErrors::REPORTED_EXCEPTIONS)) {
                    $reported = $request->attributes->get(RecordServerErrors::REPORTED_EXCEPTIONS, []);
                    $reported[] = $exception;
                    $request->attributes->set(RecordServerErrors::REPORTED_EXCEPTIONS, $reported);
                }
            }
        });

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
