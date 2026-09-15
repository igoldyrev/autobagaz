@extends('layouts.admin')

@section('title', 'Условия в карточках товаров')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Товары</p>
            <h1>Условия в карточках товаров</h1>
            <p class="admin-content__lead">Эти тексты выводятся одинаково во всех карточках товаров во вкладках «Доставка», «Оплата» и «Гарантия».</p>
            @include('admin.partials.help', ['title' => 'Черновики условий', 'text' => 'Проверьте и утвердите формулировки перед публикацией: они содержат общую информацию для покупателей и не заменяют фактические правила магазина.', 'items' => ['Используйте пустую строку, чтобы разделить текст на абзацы.', 'Не указывайте стоимость, сроки или способы оплаты, пока они не подтверждены.']])

            <form class="admin-form" method="POST" action="{{ route('admin.products.information.update') }}">
                @csrf
                @method('PUT')

                <div class="field field--wide">
                    <label for="delivery_content">Доставка</label>
                    <textarea id="delivery_content" name="delivery_content" rows="8" required>{{ old('delivery_content', $information->delivery_content) }}</textarea>
                    @error('delivery_content')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <div class="field field--wide">
                    <label for="payment_content">Оплата</label>
                    <textarea id="payment_content" name="payment_content" rows="6" required>{{ old('payment_content', $information->payment_content) }}</textarea>
                    @error('payment_content')<p class="field__error">{{ $message }}</p>@enderror
                </div>
                <div class="field field--wide">
                    <label for="warranty_content">Гарантия</label>
                    <textarea id="warranty_content" name="warranty_content" rows="6" required>{{ old('warranty_content', $information->warranty_content) }}</textarea>
                    @error('warranty_content')<p class="field__error">{{ $message }}</p>@enderror
                </div>

                <div class="form-actions">
                    <button class="button button--primary button--inline" type="submit">Сохранить</button>
                    <a class="button button--secondary" href="{{ route('admin.products.index') }}">Назад к товарам</a>
                </div>
            </form>
        </main>
    </div>
@endsection
