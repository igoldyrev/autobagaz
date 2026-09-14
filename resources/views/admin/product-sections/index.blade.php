@extends('layouts.admin')

@section('title', 'Товары')

@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')

        <main class="admin-content">
            <p class="eyebrow">Каталог</p>
            <h1>Типы товаров</h1>
            <p class="admin-content__lead">Каждый тип товаров управляется отдельно и хранит свои особенные характеристики в собственной таблице.</p>

            @include('admin.partials.help', ['title' => 'С чего начать', 'text' => 'Выберите нужный тип товара: у багажников, автобоксов и велокреплений разные характеристики и правила совместимости. Создавайте товар сразу в правильном разделе — перенос между типами не предусмотрен.', 'items' => ['В карточке товара заполните общие данные, профильные характеристики и фотографии.', 'Производители багажников и автобоксов ведутся в отдельных справочниках.', 'Совместимость багажников с автомобилями настраивается через группы применяемости; автобоксы и велокрепления универсальны.']])

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

                <a class="product-section-card" href="{{ route('admin.products.bike-racks.index') }}">
                    <div>
                        <span class="product-section-card__eyebrow">Доступен</span>
                        <h2>Велокрепления</h2>
                        <p>Тип крепления, вместимость и грузоподъёмность.</p>
                        <p><code>{{ $productTypes['bike_rack']->compatibility_strategy }}</code></p>
                    </div>
                    <span class="product-section-card__count">{{ $bikeRackProductsCount }} товаров</span>
                </a>
                <a class="product-section-card" href="{{ route('admin.products.ski-racks.index') }}"><div><span class="product-section-card__eyebrow">Доступен</span><h2>Крепления для лыж и сноубордов</h2><p>Вместимость для лыж и сноубордов.</p><p><code>{{ $productTypes['ski_rack']->compatibility_strategy }}</code></p></div><span class="product-section-card__count">{{ $skiRackProductsCount }} товаров</span></a>
            </div>
        </main>
    </div>
@endsection
