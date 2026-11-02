@props(['image', 'size' => 480, 'sizes' => null, 'alt' => null])
@php
    $variant = $image->variant($size);
    $srcset = $image->srcset($size === 160 ? 160 : 960);
@endphp
<img {{ $attributes }} src="{{ asset($variant['path'] ?? $image->path) }}" alt="{{ $alt ?? $image->alt ?? '' }}" @if ($srcset) srcset="{{ $srcset }}" @if ($sizes) sizes="{{ $sizes }}" @endif @endif @if ($variant) width="{{ $variant['width'] }}" height="{{ $variant['height'] }}" @endif>
