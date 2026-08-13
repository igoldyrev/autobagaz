<header class="admin-header">
    <a class="admin-header__brand" href="{{ route('admin.dashboard') }}">Автобагаж</a>
    <nav class="admin-nav" aria-label="Навигация панели управления">
        <a href="{{ route('admin.dashboard') }}">Главная</a>
        <a href="{{ route('admin.roof-racks.vehicle-makes.index') }}" @if (request()->routeIs('admin.roof-racks.*')) aria-current="page" @endif>Автобагажники</a>
    </nav>
    <div class="admin-header__user">
        <span>{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="button button--secondary" type="submit">Выйти</button>
        </form>
    </div>
</header>
