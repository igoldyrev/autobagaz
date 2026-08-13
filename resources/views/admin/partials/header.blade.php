<header class="admin-header">
    <a class="admin-header__brand" href="{{ route('admin.dashboard') }}">Автобагаж</a>
    <nav class="admin-nav" aria-label="Навигация панели управления">
        <a href="{{ route('admin.dashboard') }}">Главная</a>
        <a href="{{ route('admin.products.index') }}" @if (request()->routeIs('admin.products.*')) aria-current="page" @endif>Товары</a>
        <a href="{{ route('admin.catalog-categories.index') }}" @if (request()->routeIs('admin.catalog-categories.*')) aria-current="page" @endif>Разделы и категории</a>
        <a href="{{ route('admin.vehicles.vehicle-makes.index') }}" @if (request()->routeIs('admin.vehicles.*')) aria-current="page" @endif>Марки и модели</a>
    </nav>
    <div class="admin-header__user">
        <span>{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="button button--secondary" type="submit">Выйти</button>
        </form>
    </div>
</header>
