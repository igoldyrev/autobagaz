@auth
    @if (auth()->user()->is_admin)
        <aside class="site-admin-bar" aria-label="Панель администратора">
            <div class="site-admin-bar__inner">
                <a class="site-admin-bar__logo" href="{{ route('home') }}" aria-label="Автобагаж — главная">
                    <img src="{{ asset('src/common.blocks/header/img/logo.jpg') }}" alt="Автобагаж">
                </a>
                <a class="site-admin-bar__admin-link" href="{{ route('admin.dashboard') }}">Администрирование</a>

                <details class="site-admin-menu">
                    <summary>
                        <span class="site-admin-menu__avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="site-admin-menu__name">{{ auth()->user()->name }}</span>
                        <span class="site-admin-menu__chevron" aria-hidden="true">⌄</span>
                    </summary>
                    <div class="site-admin-menu__dropdown">
                        <div class="site-admin-menu__identity">
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
        </aside>
    @endif
@endauth
