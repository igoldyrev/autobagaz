<nav class="profile-tabs" aria-label="Разделы профиля">
    <a href="{{ route('admin.profile.settings.edit') }}" @if (request()->routeIs('admin.profile.settings.*')) aria-current="page" @endif>Личные данные</a>
    <a href="{{ route('admin.profile.security.edit') }}" @if (request()->routeIs('admin.profile.security.*')) aria-current="page" @endif>Безопасность</a>
</nav>
