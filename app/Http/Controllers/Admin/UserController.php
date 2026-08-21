<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateUser($request);
        $validated['is_admin'] = $validated['role'] !== User::ROLE_USER;
        $validated['permissions'] = $this->permissionsFor($validated);

        User::query()->create($validated);

        return to_route('admin.users.index')->with('success', 'Пользователь создан.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            ...$this->formData(),
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $this->validateUser($request, $user);

        if ($user->isSuperAdmin() && $validated['role'] !== User::ROLE_SUPER_ADMIN && User::superAdministrators()->count() === 1) {
            throw ValidationException::withMessages([
                'role' => 'Нельзя снять роль у единственного главного администратора.',
            ]);
        }

        $validated['is_admin'] = $validated['role'] !== User::ROLE_USER;
        $validated['permissions'] = $this->permissionsFor($validated);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $user->update($validated);

        return to_route('admin.users.edit', $user)->with('success', 'Пользователь обновлён.');
    }

    /** @return array<string, mixed> */
    private function validateUser(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'role' => ['required', Rule::in(array_keys(User::roleLabels()))],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => [Rule::in(array_keys(User::permissionLabels()))],
            'password' => [$user ? 'nullable' : 'required', 'confirmed', Password::min(12)],
        ]);
    }

    /** @param array<string, mixed> $validated */
    private function permissionsFor(array $validated): ?array
    {
        if (in_array($validated['role'], [User::ROLE_USER, User::ROLE_SUPER_ADMIN], true)) {
            return null;
        }

        return array_values($validated['permissions'] ?? []);
    }

    /** @return array<string, mixed> */
    private function formData(): array
    {
        return [
            'roles' => User::roleLabels(),
            'permissionLabels' => User::permissionLabels(),
            'roleDefaults' => User::roleDefaultPermissions(),
        ];
    }
}
