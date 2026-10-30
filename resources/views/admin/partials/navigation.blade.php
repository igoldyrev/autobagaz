<nav class="admin-section-nav" aria-label="Разделы панели управления">
    <a href="{{ route('admin.dashboard') }}" @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif>Главная</a>

    @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_PRODUCTS) || auth()->user()->hasPermission(App\Models\User::PERMISSION_CATEGORIES))
        <details class="admin-section-nav__group">
            <summary @class(['is-current' => request()->routeIs('admin.stock.*', 'admin.products.*', 'admin.catalog-categories.*')])>Каталог<span aria-hidden="true">⌄</span></summary>
            <div class="admin-section-nav__dropdown">
                @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_PRODUCTS))
                    <a href="{{ route('admin.stock.index') }}" @if (request()->routeIs('admin.stock.*')) aria-current="page" @endif>Остатки</a>
                    <a href="{{ route('admin.products.index') }}" @if (request()->routeIs('admin.products.*')) aria-current="page" @endif>Товары</a>
                @endif
                @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_CATEGORIES))
                    <a href="{{ route('admin.catalog-categories.index') }}" @if (request()->routeIs('admin.catalog-categories.*')) aria-current="page" @endif>Разделы и категории</a>
                @endif
            </div>
        </details>
    @endif

    @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_ORDERS))
        <details class="admin-section-nav__group">
            <summary @class(['is-current' => request()->routeIs('admin.orders.*', 'admin.rental-requests.*', 'admin.callback-requests.*')])>Продажи<span aria-hidden="true">⌄</span></summary>
            <div class="admin-section-nav__dropdown">
                <a href="{{ route('admin.orders.index') }}" @if (request()->routeIs('admin.orders.*')) aria-current="page" @endif>Заказы</a>
                <a href="{{ route('admin.rental-requests.index') }}" @if (request()->routeIs('admin.rental-requests.*')) aria-current="page" @endif>Заявки на прокат</a>
                <a href="{{ route('admin.callback-requests.index') }}" @if (request()->routeIs('admin.callback-requests.*')) aria-current="page" @endif>Обратные звонки</a>
            </div>
        </details>
    @endif

    @if (auth()->user()->hasPermission(App\Models\User::PERMISSION_VEHICLES))
        <details class="admin-section-nav__group">
            <summary @class(['is-current' => request()->routeIs('admin.vehicles.*', 'admin.fitments.*', 'admin.compatibility.*', 'admin.compatibility-overrides.*')])>Автомобили<span aria-hidden="true">⌄</span></summary>
            <div class="admin-section-nav__dropdown">
                <a href="{{ route('admin.vehicles.vehicle-makes.index') }}" @if (request()->routeIs('admin.vehicles.*')) aria-current="page" @endif>Автомобили</a>
                <a href="{{ route('admin.fitments.index') }}" @if (request()->routeIs('admin.fitments.*', 'admin.compatibility.*', 'admin.compatibility-overrides.*')) aria-current="page" @endif>Совместимость</a>
            </div>
        </details>
    @endif

    @if (auth()->user()->isSuperAdmin())
        <a href="{{ route('admin.users.index') }}" @if (request()->routeIs('admin.users.*')) aria-current="page" @endif>Пользователи</a>
    @endif
</nav>

@once
    @push('scripts')
        <script src="{{ asset('js/admin-navigation.js') }}?v={{ filemtime(public_path('js/admin-navigation.js')) }}" defer></script>
    @endpush
@endonce
