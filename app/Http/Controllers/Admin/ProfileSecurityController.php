<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileSecurityController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile.security', ['user' => $request->user()]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(12)],
        ]);

        $request->user()->update(['password' => $validated['password']]);

        return to_route('admin.profile.security.edit')
            ->with('success', 'Пароль успешно изменён.');
    }

    public function destroyOtherSessions(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
        ]);

        Auth::logoutOtherDevices($validated['current_password']);

        return to_route('admin.profile.security.edit')
            ->with('success', 'Другие активные сеансы завершены.');
    }
}
