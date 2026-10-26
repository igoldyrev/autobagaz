@props(['items'])
@inject('structuredData', 'App\Support\StructuredData')
<x-json-ld :data="$structuredData->breadcrumbs($items)" />
<nav class="breadcrumbs" aria-label="Хлебные крошки">
    @foreach ($items as $item)
        @if (isset($item['url']))
            <a class="breadcrumbs__link" href="{{ $item['url'] }}">{{ $item['name'] }}</a>&#8594;
        @else
            <span class="breadcrumbs__text">{{ $item['name'] }}</span>
        @endif
    @endforeach
</nav>
