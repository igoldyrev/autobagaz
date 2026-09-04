@extends('layouts.admin')

@section('title', 'Пользователи')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--wide">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">Доступ</p>
                    <h1>Пользователи</h1>
                    <p class="admin-content__lead">Роли и права сотрудников, имеющих доступ к панели управления.</p>
                </div>
                <a class="button button--primary button--inline" href="{{ route('admin.users.create') }}">Добавить пользователя</a>
            </div>

            @include('admin.partials.flash')

            @include('admin.partials.help', ['title' => 'Управление доступом', 'text' => 'Каждому сотруднику назначается роль и набор разрешений. Выдавайте только те права, которые нужны для работы: изменения пользователя начинают действовать при следующем запросе в админке.', 'items' => ['Главный администратор всегда имеет полный доступ.', 'Роль «без доступа» запрещает вход, не удаляя учётную запись.', 'Дата последнего входа помогает заметить неиспользуемые или подозрительные учётные записи.']])

            <div class="table-wrap users-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Пользователь</th>
                            <th>Роль</th>
                            <th>Права</th>
                            <th>Последний вход</th>
                            <th><span class="visually-hidden">Действия</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->name }}</strong><br>
                                    <span class="table-secondary">{{ $user->email }}</span>
                                </td>
                                <td><span class="role-badge role-badge--{{ $user->role }}">{{ $user->roleLabel() }}</span></td>
                                <td>
                                    @if ($user->isSuperAdmin())
                                        Все права
                                    @elseif (! $user->is_admin)
                                        Нет доступа
                                    @else
                                        <div class="permission-summary">
                                            @foreach (App\Models\User::permissionLabels() as $permission => $label)
                                                @if ($user->hasPermission($permission))
                                                    <span>{{ $label }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="table-secondary">
                                    {{ $user->last_login_at?->timezone(config('app.display_timezone'))->format('d.m.Y H:i') ?? 'Не входил' }}
                                </td>
                                <td class="row-actions">
                                    <a class="text-link" href="{{ route('admin.users.edit', $user) }}">Настроить</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="empty-state" colspan="5">Пользователей пока нет.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.partials.pagination', ['paginator' => $users])
        </main>
    </div>
@endsection
