@php
    $selectedRole = old('role', $user->role ?? App\Models\User::ROLE_CONTENT_MANAGER);
    $selectedPermissions = old(
        'permissions',
        isset($user) ? ($user->permissions ?? ($roleDefaults[$user->role] ?? [])) : $roleDefaults[$selectedRole]
    );
@endphp

@include('admin.partials.help', ['title' => 'Настройка пользователя', 'text' => 'Сначала выберите роль — форма подставит типовой набор прав. Затем при необходимости скорректируйте отдельные разрешения. Для существующего пользователя пустое поле нового пароля сохраняет текущий пароль.', 'items' => ['Главный администратор получает все права независимо от отмеченных флажков.', 'Контент-менеджеру обычно достаточно доступа к его рабочим разделам.', 'Роль «без доступа» используйте для безопасного отключения учётной записи.']])

<div class="form-grid">
    <div class="field">
        <label for="name">Имя</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}" autocomplete="name" required>
    </div>
    <div class="field">
        <label for="email">Электронная почта</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}" autocomplete="username" required>
    </div>
    <div class="field field--wide">
        <label for="role">Роль</label>
        <select id="role" name="role" required>
            @foreach ($roles as $value => $label)
                <option value="{{ $value }}" @selected($selectedRole === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <p class="field__hint">Главный администратор всегда имеет все права. Роль «без доступа» запрещает вход в админку.</p>
    </div>

    <fieldset class="permissions-panel field--wide">
        <legend>Права доступа</legend>
        <p class="field__hint">Для администратора и контент-менеджера можно задать индивидуальный набор прав.</p>
        <div class="permissions-list">
            @foreach ($permissionLabels as $permission => $label)
                <label class="checkbox permission-option">
                    <input type="checkbox" name="permissions[]" value="{{ $permission }}" @checked(in_array($permission, $selectedPermissions, true))>
                    <span>{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </fieldset>

    <div class="field">
        <label for="password">{{ isset($user) ? 'Новый пароль' : 'Пароль' }}</label>
        <input id="password" name="password" type="password" autocomplete="new-password" @required(! isset($user))>
        @isset($user)<p class="field__hint">Оставьте пустым, чтобы не менять пароль.</p>@endisset
    </div>
    <div class="field">
        <label for="password_confirmation">Подтверждение пароля</label>
        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" @required(! isset($user))>
    </div>
</div>

<div class="form-actions">
    <button class="button button--primary button--inline" type="submit">{{ $submitLabel }}</button>
    <a class="button button--secondary button--inline" href="{{ route('admin.users.index') }}">Отмена</a>
</div>

@push('scripts')
    <script>
        (() => {
            const role = document.getElementById('role');
            const checkboxes = [...document.querySelectorAll('.permissions-list input')];
            const defaults = @json($roleDefaults);

            role.addEventListener('change', () => {
                const selected = defaults[role.value] || [];
                checkboxes.forEach((checkbox) => checkbox.checked = selected.includes(checkbox.value));
            });
        })();
    </script>
@endpush
