<?php

use App\Http\Middleware\AuthenticateDailyBrief;
use App\Http\Middleware\EnsureUserHasPermission;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsSuperAdmin;
use App\Http\Middleware\RecordAdminActivity;
use App\Http\Middleware\ResolveVehicleConfiguration;
use App\Http\Middleware\TrackAdminPresence;
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
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
