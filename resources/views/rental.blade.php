@extends('layouts.catalog')
@section('title', $service->name)
@section('meta_description', 'Прокат автобоксов, багажников, велокреплений и другого багажного оборудования в Перми.')
@section('content')
    <x-breadcrumbs :items="[['name' => 'Главная страница', 'url' => route('home')], ['name' => $service->name]]" />
    <h1 class="title title-h1">{{ $service->name }}</h1>
    @foreach(preg_split('/\R\s*\R/u', $service->description) as $paragraph)
        <p class="text rental-text">{{ $paragraph }}</p>
    @endforeach

    <h2 class="title title-h2">Как взять оборудование напрокат</h2>
    <ol class="list list--decimal">
        <li>@if($service->is_available)Оставьте <a class="link" href="#rental-request">заявку</a> или позвоните@else Позвоните@endif по телефону <a class="link" href="tel:+73422889929">+7 342 288 99 29</a>.</li>
        <li>Согласуйте с менеджером оборудование, даты, стоимость и залог.</li>
        <li>Приезжайте с паспортом и залогом. Оформите договор, оплатите аренду и заберите оборудование.</li>
        <li>Верните оборудование в срок и получите залог после проверки. Хотите оставить товар себе — согласуйте выкуп.</li>
    </ol>
    <p class="text">Для быстрого оформления можно заранее заполнить <a class="link" href="{{ $service->documentUrl('contract') }}">договор</a> и отправить его на <a class="link" href="mailto:autobagaz@yandex.ru">autobagaz@yandex.ru</a>.</p>
    <div class="prokat-docs">
        <div><i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i><a class="link link--green-hover" href="{{ $service->documentUrl('contract') }}">Скачать договор проката</a></div>
        <div><i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i><a class="link link--green-hover" href="{{ $service->documentUrl('rules') }}">Скачать правила эксплуатации автобоксов</a></div>
    </div>
    <p class="text">Стоимость дня проката за единицу оборудования:</p>
    <div class="rental-table-wrap"><table class="table">
        <thead class="table__header"><tr class="table__row"><th class="table__cell" scope="col">Срок проката</th>@foreach($service->groups as $group)<th class="table__cell" scope="col">{{ $group }}</th>@endforeach</tr></thead>
        <tbody>@foreach($service->rates as $rate)<tr class="table__row"><td class="table__cell table__cell--price">От {{ $rate['min_days'] }}{{ $rate['max_days'] ? ' до '.$rate['max_days'] : '' }} дней</td>@foreach($rate['prices'] as $price)<td class="table__cell table__cell--price">{{ number_format((float) $price, fmod((float) $price, 1) == 0 ? 0 : 2, ',', ' ') }} рублей/день</td>@endforeach</tr>@endforeach</tbody>
    </table></div>
    <p class="text rental-text">{{ $service->conditions }}</p>
    <section class="rental-request" id="rental-request">
        <h2 class="title">Заявка на прокат</h2>
        @if(session('rental_success'))
            <div class="order-flash order-flash--success rental-request__success" id="rental-success" role="status">
                <p class="text"><strong>Заявка отправлена!</strong></p>
                <p class="text">{{ session('rental_success') }}</p>
            </div>
        @endif
        @if($service->is_available)
            @if($errors->any())<div role="alert"><ul class="list">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form class="rental-form" method="POST" action="{{ route('rental.store') }}">
                @csrf
                <input type="hidden" name="submission_token" value="{{ $submissionToken }}">
                <div class="rental-honeypot" aria-hidden="true"><label>Сайт<input name="website" tabindex="-1" autocomplete="off"></label></div>
                <label class="field">Имя<input name="name" autocomplete="name" maxlength="120" value="{{ old('name') }}" required></label>
                <label class="field">Телефон<input name="phone" type="tel" autocomplete="tel" maxlength="32" value="{{ old('phone') }}" required></label>
                <label class="field field--wide">Оборудование<select name="group" required>@foreach($service->groups as $i => $group)<option value="{{ $i }}" @selected((string) old('group', '0') === (string) $i)>{{ $group }}</option>@endforeach</select></label>
                <label class="field">Количество<input name="quantity" type="number" min="1" max="100" value="{{ old('quantity', 1) }}" required></label>
                <label class="field">Автомобиль<input name="vehicle" maxlength="255" placeholder="Марка, модель, год, тип крыши" value="{{ old('vehicle') }}"></label>
                <label class="field">Дата получения<input name="starts_on" type="date" min="{{ now(config('app.display_timezone'))->toDateString() }}" value="{{ old('starts_on') }}" required></label>
                <label class="field">Дата возврата<input name="ends_on" type="date" min="{{ now(config('app.display_timezone'))->toDateString() }}" value="{{ old('ends_on') }}" required></label>
                <label class="field field--wide">Комментарий<textarea name="comment" rows="3" maxlength="2000" placeholder="Укажите нужное оборудование и пожелания">{{ old('comment') }}</textarea></label>
                <div class="field--wide"><x-personal-data-consent id="rental-consent" /></div>
                <p class="text field--wide">День получения и день возврата включаются в срок аренды. Итоговые условия подтвердит менеджер.</p>
                <button class="button button__buy" type="submit">Отправить заявку</button>
            </form>
        @else<p class="text">Приём заявок на прокат временно отключён.</p>@endif
    </section>
@endsection
