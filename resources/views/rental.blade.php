@extends('layouts.catalog')

@section('title', 'Прокат багажников и боксов в Перми')
@section('meta_description', 'Прокат автобоксов, багажников, велокреплений и другого багажного оборудования в Перми.')

@section('content')
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594;
        <span class="breadcrumbs__text">Прокат багажников и боксов в Перми</span>
    </nav>

    <h1 class="title title-h1">Прокат багажников и боксов в Перми</h1>

    <p class="text">Случается так, что багажник, автобокс (бокс на крышу), велокрепление, лыжное крепление и другое багажное оборудование нужны разово или время от времени.</p>
    <p class="text">В этом случае удобно воспользоваться арендой багажного оборудования: быстро и надёжно закрепить лестницу или длинномерный груз, отправиться на отдых с автобоксом, перевезти велосипед либо установить лыжное крепление и защитить салон автомобиля от снега и грязи.</p>
    <p class="text">В сложных дорожных условиях, во время путешествия, охоты или рыбалки можно воспользоваться прокатом браслетов или цепей противоскольжения.</p>

    <p class="text">Чтобы воспользоваться услугами аренды, необходимо сделать несколько простых шагов:</p>
    <ol class="list list--decimal">
        <li>Забронируйте багажник, бокс или необходимый аксессуар по телефону <a class="link" href="tel:+73422889929">+7 342 288 99 29</a>.</li>
        <li>В день аренды приезжайте в пункт проката, взяв с собой:
            <ul class="list list__unsorted">
                <li>паспорт;</li>
                <li>залоговую сумму — полную стоимость товара, взятого в прокат.</li>
            </ul>
        </li>
        <li>В магазине-прокате мы оформим договор проката и квитанцию об оплате, после чего выдадим выбранное оборудование.</li>
        <li>Чтобы сократить время визита, заранее заполните <a class="link" href="{{ asset('content/prokat/Dogovor_prokata.doc') }}">договор</a> и отправьте его на <a class="link" href="mailto:autobagaz@yandex.ru">autobagaz@yandex.ru</a>.</li>
    </ol>

    <div class="prokat-docs">
        <div>
            <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i>
            <a class="link link--green-hover" href="{{ asset('content/prokat/Dogovor_prokata.doc') }}">Скачать договор проката</a>
        </div>
        <div>
            <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i>
            <a class="link link--green-hover" href="{{ asset('content/prokat/Pravila_ekspluatacii_avtoboksov.doc') }}">Скачать правила эксплуатации автобоксов</a>
        </div>
    </div>

    <p class="text">Стоимость дня проката определяется исходя из времени пользования оборудованием:</p>
    <table class="table">
        <thead class="table__header">
            <tr class="table__row">
                <th class="table__cell" scope="col">Срок проката</th>
                <th class="table__cell" scope="col">Дуги багажника, крепления для велосипеда на крышу, лыж, лодки, браслеты противоскольжения</th>
                <th class="table__cell" scope="col">Автобокс, велокрепление на фаркоп или заднюю дверь, цепи противоскольжения</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table__row">
                <td class="table__cell table__cell--price">От 0 до 14 дней</td>
                <td class="table__cell table__cell--price">130 рублей/день</td>
                <td class="table__cell table__cell--price">270 рублей/день</td>
            </tr>
            <tr class="table__row">
                <td class="table__cell table__cell--price">От 15 до 21 дня</td>
                <td class="table__cell table__cell--price">110 рублей/день</td>
                <td class="table__cell table__cell--price">240 рублей/день</td>
            </tr>
            <tr class="table__row">
                <td class="table__cell table__cell--price">От 21 дня</td>
                <td class="table__cell table__cell--price">90 рублей/день</td>
                <td class="table__cell table__cell--price">210 рублей/день</td>
            </tr>
        </tbody>
    </table>

    <p class="text">Время проката считается в календарных днях. Монтаж и демонтаж багажных систем выполняется арендатором либо оплачивается отдельно.</p>
    <p class="text">С общими правилами пользования багажным оборудованием можно ознакомиться <a class="link" href="{{ asset('content/prokat/Pravila_ekspluatacii_avtoboksov.doc') }}">здесь</a>.</p>
@endsection
