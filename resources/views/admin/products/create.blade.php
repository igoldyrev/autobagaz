@extends('layouts.admin')
@section('title', 'Новый автобагажник')
@section('body')
    <div class="admin-shell">
        @include('admin.partials.header')
        <main class="admin-content admin-content--form">
            @include('admin.partials.flash')
            <p class="eyebrow">Товары · Автобагажники</p>
            <h1>Добавить автобагажник</h1>

            @if ($fitmentCopyProducts->isNotEmpty())
                <form class="fitment-copy-panel" method="GET" action="{{ route('admin.products.roof-racks.create') }}">
                    <div class="fitment-copy-panel__heading">
                        <strong>Повторить марки и модели другого товара</strong>
                        <p>Будут подставлены только модели автомобилей и варианты кузова. Остальные поля останутся пустыми.</p>
                    </div>
                    <div class="fitment-copy-panel__controls">
                        <label class="visually-hidden" for="fitment-copy-search">Найти товар-образец</label>
                        <input
                            id="fitment-copy-search"
                            type="search"
                            placeholder="Найти товар-образец"
                            autocomplete="off"
                            data-select-search="fitment-copy-product"
                        >
                        <select id="fitment-copy-product" name="copy_fitment_from" required>
                            <option value="">Выберите товар</option>
                            @foreach ($fitmentCopyProducts as $copyProduct)
                                <option value="{{ $copyProduct->id }}" @selected($fitmentCopySource?->id === $copyProduct->id)>
                                    {{ $copyProduct->name }} — {{ $copyProduct->vehicle_models_count }} мод. / {{ $copyProduct->vehicle_body_types_count }} куз.
                                </option>
                            @endforeach
                        </select>
                        <button class="button button--secondary" type="submit">Подставить</button>
                    </div>
                    @if ($fitmentCopySource)
                        <p class="fitment-copy-panel__success">
                            Выбор скопирован из «{{ $fitmentCopySource->name }}»: {{ $fitmentCopySource->vehicleModels->count() }} моделей и {{ $fitmentCopySource->vehicleBodyTypes->count() }} вариантов кузова.
                        </p>
                    @endif
                </form>
            @endif

            <form class="admin-form" method="POST" action="{{ route('admin.products.roof-racks.store') }}" enctype="multipart/form-data">
                @include('admin.products._form')
            </form>
        </main>
    </div>
@endsection
