@props(['product' => null])
@inject('structuredData', 'App\Support\StructuredData')
@if (request()->routeIs(...App\Support\Seo::PUBLIC_ROUTES))
    @php
        $graph = [$structuredData->organization()];
        if ($product?->is_active && request()->routeIs('products.show')) {
            $graph[] = $structuredData->product($product);
        }
    @endphp
    <x-json-ld :data="['@context' => 'https://schema.org', '@graph' => $graph]" />
@endif
