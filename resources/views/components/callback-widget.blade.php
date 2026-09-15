@php($hasErrors = $errors->callback->isNotEmpty())

@if (session('callback_success'))
    <p class="callback-notice" role="status">{{ session('callback_success') }}</p>
@endif

<div class="callback-widget__overlay {{ $hasErrors ? 'is-open' : '' }}" data-callback-overlay></div>
<section class="callback-widget {{ $hasErrors ? 'is-open' : '' }}" data-callback-modal role="dialog" aria-modal="true" aria-labelledby="callback-title" aria-hidden="{{ $hasErrors ? 'false' : 'true' }}">
    <button class="callback-widget__close" type="button" data-callback-close aria-label="Закрыть">×</button>
    <h2 class="callback-widget__title" id="callback-title">Заказать обратный звонок</h2>
    <p class="callback-widget__lead">Оставьте контакты — менеджер перезвонит вам в ближайшее время.</p>

    <form method="POST" action="{{ route('callback.store') }}" class="callback-widget__form">
        @csrf
        <div class="callback-widget__field">
            <label for="callback-name">Ваше имя</label>
            <input id="callback-name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" maxlength="120" required>
            @error('name', 'callback')<p class="callback-widget__error">{{ $message }}</p>@enderror
        </div>
        <div class="callback-widget__field">
            <label for="callback-phone">Телефон</label>
            <input id="callback-phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" maxlength="32" placeholder="+7 999 123-45-67" required>
            @error('phone', 'callback')<p class="callback-widget__error">{{ $message }}</p>@enderror
        </div>
        <div class="callback-widget__honeypot" aria-hidden="true">
            <label for="callback-website">Сайт</label>
            <input id="callback-website" name="website" type="text" tabindex="-1" autocomplete="off">
        </div>
        <button class="callback-widget__submit" type="submit">Жду звонка</button>
    </form>
</section>

<button class="callback-widget__trigger" type="button" data-callback-open aria-label="Заказать обратный звонок">
    <i class="fa fa-comments-o" aria-hidden="true"></i>
    <span>Перезвонить</span>
</button>
