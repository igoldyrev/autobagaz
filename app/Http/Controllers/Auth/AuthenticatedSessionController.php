<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Services\AdminActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request, AdminActivityLogger $activity): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => trans_choice(
                    'Слишком много попыток входа. Повторите через :count секунду.|Слишком много попыток входа. Повторите через :count секунды.|Слишком много попыток входа. Повторите через :count секунд.',
                    $seconds,
                    ['count' => $seconds],
                ),
            ]);
        }

        if (! Auth::attempt([...$credentials, 'is_admin' => true], $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);

            throw ValidationException::withMessages([
                'email' => 'Неверный адрес электронной почты или пароль.',
            ]);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();
        $loggedInAt = now();
        $request->user()->forceFill([
            'last_login_at' => $loggedInAt,
            'last_seen_at' => $loggedInAt,
        ])->save();
        $request->session()->put([
            'admin_authenticated_at' => $loggedInAt->timestamp,
            'admin_last_seen_recorded_at' => $loggedInAt->timestamp,
        ]);
        $activity->record(
            $request->user(),
            AdminActivityLog::ACTION_LOGIN,
            'Вошёл в панель управления',
            'user',
            $request->user()->id,
            $request->user()->name,
        );

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request, AdminActivityLogger $activity): RedirectResponse
    {
        $user = $request->user();
        if ($user) {
            $activity->record(
                $user,
                AdminActivityLog::ACTION_LOGOUT,
                'Вышел из панели управления',
                'user',
                $user->id,
                $user->name,
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower((string) $request->string('email'))).'|'.$request->ip();
    }
}
