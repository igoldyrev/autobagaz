<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\User;
use App\Services\AdminActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UserSessionController extends Controller
{
    public function __invoke(Request $request, User $user, AdminActivityLogger $logger): RedirectResponse
    {
        abort_if($request->user()->is($user), 422, 'Нельзя завершить текущий сеанс этой кнопкой.');

        $invalidatedAt = now();
        $user->forceFill([
            'sessions_invalidated_at' => $invalidatedAt,
            'remember_token' => Str::random(60),
        ])->save();

        if (config('session.driver') === 'database' && Schema::hasTable(config('session.table'))) {
            DB::table(config('session.table'))->where('user_id', $user->id)->delete();
        }

        $logger->record(
            $request->user(),
            AdminActivityLog::ACTION_SESSIONS_TERMINATED,
            'Завершил все сеансы пользователя «'.$user->name.'»',
            'user',
            $user->id,
            $user->name,
        );

        return back()->with('success', 'Все сеансы пользователя «'.$user->name.'» завершены.');
    }
}
