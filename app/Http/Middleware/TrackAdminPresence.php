<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackAdminPresence
{
    private const UPDATE_INTERVAL_SECONDS = 300;

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            return $next($request);
        }

        $authenticatedAt = $request->session()->get('admin_authenticated_at');
        $invalidatedAt = $user->sessions_invalidated_at?->timestamp;

        if ($invalidatedAt !== null && ($authenticatedAt === null || (int) $authenticatedAt < $invalidatedAt)) {
            return $this->terminateSession($request);
        }

        if ($authenticatedAt === null) {
            $request->session()->put('admin_authenticated_at', now()->timestamp);
        }

        $lastRecordedAt = (int) $request->session()->get('admin_last_seen_recorded_at', 0);
        if ($lastRecordedAt <= now()->timestamp - self::UPDATE_INTERVAL_SECONDS) {
            $seenAt = now();
            DB::table('users')->where('id', $user->id)->update(['last_seen_at' => $seenAt]);
            $user->forceFill(['last_seen_at' => $seenAt]);
            $request->session()->put('admin_last_seen_recorded_at', $seenAt->timestamp);
        }

        return $next($request);
    }

    private function terminateSession(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withErrors([
            'email' => 'Ваш сеанс завершён Главным администратором. Войдите снова.',
        ]);
    }
}
