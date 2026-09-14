<header class="admin-header">
    <a class="admin-header__brand" href="{{ route('admin.dashboard') }}">Автобагаж</a>
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

@unless (request()->routeIs('admin.dashboard'))
    @include('admin.partials.breadcrumbs')
@endunless

@include('admin.partials.navigation')
