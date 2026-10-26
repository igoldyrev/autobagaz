@inject('seo', 'App\Support\Seo')
<meta name="robots" content="{{ $seo->robots(request()) }}">
@if ($canonical = $seo->canonical(request()))
    <link rel="canonical" href="{{ $canonical }}">
@endif
