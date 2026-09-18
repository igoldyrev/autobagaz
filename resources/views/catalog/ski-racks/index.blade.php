@extends('layouts.catalog')
@section('title',$section->meta_title ?: $section->name)
@section('meta_description',$section->meta_description ?: $section->description)
@section('content')
<nav class="breadcrumbs" aria-label="Хлебные крошки"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная страница</a>&#8594; <span class="breadcrumbs__text">{{ $section->name }}</span></nav><h1 class="title title-h1">{{ $section->name }}</h1>
@if($unfilteredProductCount>0)<div class="catalog-products-results--section">@include('catalog.ski-racks._filters',['horizontal'=>true])<div class="catalog-products-results">@include('catalog.products._toolbar')@if($products->isNotEmpty())@include('catalog.products._grid',['products'=>$products])@include('catalog.products._pagination',['paginator'=>$products])@else<div class="records-placeholder records-placeholder--list"><p>По выбранным параметрам товаров не найдено.</p></div>@endif</div></div>@else<div class="records-placeholder records-placeholder--list"><p>В этом разделе пока нет товаров.</p></div>@endif
<section class="catalog-selection-guide" aria-labelledby="ski-racks-selection-guide-title">
    <h2 class="title title-h3" id="ski-racks-selection-guide-title">Как выбрать крепление для лыж и сноубордов</h2>
    <dl class="catalog-selection-guide__options">
        <div><dt>Для 2–4 пар лыж</dt><dd>подойдёт компактное крепление для семейной поездки.</dd></div>
        <div><dt>Для 5–6 пар лыж</dt><dd>выбирайте широкую модель для большой компании.</dd></div>
        <div><dt>Для сноубордов</dt><dd>проверьте заявленную вместимость и ширину рабочей зоны.</dd></div>
    </dl>
    <p class="text">Крепления устанавливаются на поперечины. Учитывайте высоту крепления для лыж с высокими крепами и общую нагрузку на крышу автомобиля.</p>
    <a class="link-green catalog-selection-guide__action" href="{{ route('contacts') }}">Помочь с выбором</a>
</section>
@endsection
