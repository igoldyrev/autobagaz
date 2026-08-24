@extends('layouts.admin')

@section('title', 'Товары')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content">
            <p class="eyebrow">Каталог</p>
            <h1>Типы товаров</h1>
            <p class="admin-content__lead">Каждый тип товаров управляется отдельно и хранит свои особенные характеристики в собственной таблице.</p>

            <div class="product-section-grid">
                <a class="product-section-card" href="{{ route('admin.products.roof-racks.index') }}">
                    <div>
                        <span class="product-section-card__eyebrow">Доступен</span>
                        <h2>Автобагажники</h2>
                        <p>Длина и тип дуги, нагрузка, способ установки и цвет.</p>
                        <p><code>{{ $productTypes['roof_rack']->compatibility_strategy }}</code></p>
                    </div>
                    <span class="product-section-card__count">{{ $roofRackProductsCount }} товаров</span>
                </a>

                <a class="product-section-card" href="{{ route('admin.products.auto-boxes.index') }}">
                    <div>
                        <span class="product-section-card__eyebrow">Доступен</span>
                        <h2>Автомобильные боксы</h2>
                        <p>Габариты, объём, нагрузка, открывание, крепление и цвет.</p>
                        <p><code>{{ $productTypes['roof_box']->compatibility_strategy }}</code></p>
                    </div>
                    <span class="product-section-card__count">{{ $autoBoxProductsCount }} товаров</span>
                </a>

                <div class="product-section-card product-section-card--disabled">
                    <div>
                        <span class="product-section-card__eyebrow">Будущий раздел</span>
                        <h2>Велокрепления</h2>
                        <p>Будет добавлен отдельным модулем каталога.</p>
                        <p>Для универсальных аксессуаров доступна стратегия <code>{{ $productTypes['universal']->compatibility_strategy }}</code>.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
