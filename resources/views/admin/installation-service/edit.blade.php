@extends('layouts.admin')

@section('title', 'Услуга установки')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Товары</p>
            <h1>Услуга установки</h1>
            <p class="admin-content__lead">Настройки используются в карточках товаров, комплекте, корзине и оформленном заказе.</p>

            <form class="admin-form" method="POST" action="{{ route('admin.products.installation-service.update') }}">
                @csrf
                @method('PUT')

                <div class="field field--wide">
                    <label for="name">Название услуги</label>
                    <input id="name" name="name" value="{{ old('name', $installationService->name) }}" maxlength="255" required>
                    @error('name')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label for="price">Стоимость, ₽</label>
                    <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $installationService->price) }}" required>
                    <p class="field__hint">Стоимость фиксируется в заказе на момент его оформления.</p>
                    @error('price')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <div class="field field--wide">
                    <label for="description">Короткое пояснение</label>
                    <textarea id="description" name="description" rows="3" maxlength="500">{{ old('description', $installationService->description) }}</textarea>
                    <p class="field__hint">Например: «По предварительной записи».</p>
                    @error('description')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <label class="checkbox field--wide">
                    <input type="checkbox" name="is_available" value="1" @checked(old('is_available', $installationService->is_available))>
                    <span>Услуга доступна</span>
                    <span class="field__hint">При отключении она не предлагается покупателям и не может быть добавлена в комплект.</span>
                </label>

                <div class="form-actions">
                    <button class="button button--primary button--inline" type="submit">Сохранить</button>
                    <a class="button button--secondary" href="{{ route('admin.products.index') }}">Назад к товарам</a>
                </div>
            </form>
        </main>
    </div>
@endsection
