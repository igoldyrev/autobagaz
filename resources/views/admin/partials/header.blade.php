<header class="admin-header">
    <a class="admin-header__brand" href="{{ route('admin.dashboard') }}">Автобагаж</a>
    <nav class="admin-nav" aria-label="Навигация панели управления">
        <a href="{{ route('admin.dashboard') }}">Главная</a>
        @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_PRODUCTS))
            <a href="{{ route('admin.products.index') }}" @if (request()->routeIs('admin.products.*')) aria-current="page" @endif>Товары</a>
        @endif
        @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_CATEGORIES))
            <a href="{{ route('admin.catalog-categories.index') }}" @if (request()->routeIs('admin.catalog-categories.*')) aria-current="page" @endif>Разделы и категории</a>
        @endif
        @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_VEHICLES))
            <a href="{{ route('admin.vehicles.vehicle-makes.index') }}" @if (request()->routeIs('admin.vehicles.*')) aria-current="page" @endif>Автомобили</a>
            <a href="{{ route('admin.fitments.index') }}" @if (request()->routeIs('admin.fitments.*')) aria-current="page" @endif>Совместимость</a>
        @endif
        @if (auth()->user()->isSuperAdmin())
            <a href="{{ route('admin.users.index') }}" @if (request()->routeIs('admin.users.*')) aria-current="page" @endif>Пользователи</a>
        @endif
    </nav>
    <div class="admin-header__user">
        <details class="user-menu">
            <summary @if (request()->routeIs('admin.profile.*')) aria-current="page" @endif>
                <span class="user-menu__avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                <span>{{ auth()->user()->name }}</span>
                <span class="user-menu__chevron" aria-hidden="true">⌄</span>
            </summary>
            <div class="user-menu__dropdown">
                <div class="user-menu__identity">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>{{ auth()->user()->email }}</span>
                </div>
                <a href="{{ route('admin.profile.show') }}">Мой профиль</a>
                <a href="{{ route('admin.profile.settings.edit') }}">Настройки</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit">Выйти</button>
                </form>
            </div>
        </details>
    </div>
</header>
