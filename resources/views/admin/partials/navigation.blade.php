<nav class="admin-section-nav" aria-label="Разделы панели управления">
    <div class="admin-section-nav__group">
        <a href="{{ route('admin.dashboard') }}" @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif>Главная</a>
    </div>

    @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_PRODUCTS) || auth()->user()->hasPermission(App\Models\User::PERMISSION_CATEGORIES))
        <div class="admin-section-nav__group" role="group" aria-label="Каталог">
            @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_PRODUCTS))
                <a href="{{ route('admin.products.index') }}" @if (request()->routeIs('admin.products.*')) aria-current="page" @endif>Товары</a>
            @endif
            @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_CATEGORIES))
                <a href="{{ route('admin.catalog-categories.index') }}" @if (request()->routeIs('admin.catalog-categories.*')) aria-current="page" @endif>Разделы и категории</a>
            @endif
        </div>
    @endif

    @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_VEHICLES))
        <div class="admin-section-nav__group" role="group" aria-label="Автомобили и совместимость">
            <a href="{{ route('admin.vehicles.vehicle-makes.index') }}" @if (request()->routeIs('admin.vehicles.*')) aria-current="page" @endif>Автомобили</a>
            <a href="{{ route('admin.fitments.index') }}" @if (request()->routeIs('admin.fitments.*', 'admin.compatibility.*', 'admin.compatibility-overrides.*')) aria-current="page" @endif>Совместимость</a>
        </div>
    @endif

    @if (auth()->user()->isSuperAdmin())
        <div class="admin-section-nav__group" role="group" aria-label="Администрирование">
            <a href="{{ route('admin.users.index') }}" @if (request()->routeIs('admin.users.*')) aria-current="page" @endif>Пользователи</a>
        </div>
    @endif
</nav>
