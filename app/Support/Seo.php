<?php

namespace App\Support;

use Illuminate\Http\Request;

class Seo
{
    public const PUBLIC_ROUTES = [
        'home', 'rental', 'installation', 'promotions.index', 'contacts',
        'delivery-payment', 'warranty', 'privacy-policy', 'personal-data-consent',
        'catalog.auto-boxes.index', 'catalog.bike-racks.index', 'catalog.ski-racks.index',
        'catalog.vehicle-fitment.index', 'catalog.autobagazhniki.*', 'products.show',
    ];

    public function url(string $path = '/'): string
    {
        return rtrim(config('seo.canonical_url'), '/').'/'.ltrim($path, '/');
    }

    public function indexingEnabled(Request $request): bool
    {
        return config('seo.indexing_enabled')
            && $request->getHost() === parse_url(config('seo.canonical_url'), PHP_URL_HOST);
    }

    public function robots(Request $request): string
    {
        if (! $this->indexingEnabled($request) || ! $request->routeIs(...self::PUBLIC_ROUTES)) {
            return 'noindex,nofollow';
        }

        // Tracking parameters do not create new pages; filters and sorting do.
        foreach (array_keys($request->query()) as $key) {
            if ($key !== 'page' && ! str_starts_with($key, 'utm_') && ! in_array($key, ['gclid', 'yclid', '_openstat'], true)) {
                return 'noindex,follow';
            }
        }

        return 'index,follow';
    }

    public function canonical(Request $request): ?string
    {
        if (! $request->routeIs(...self::PUBLIC_ROUTES)) {
            return null;
        }

        $url = $this->url($request->getPathInfo());
        $page = filter_var($request->query('page'), FILTER_VALIDATE_INT);

        if ($page > 1 && $request->routeIs('catalog.autobagazhniki.*', 'catalog.auto-boxes.index', 'catalog.bike-racks.index', 'catalog.ski-racks.index', 'promotions.index')) {
            $url .= '?page='.$page;
        }

        return $url;
    }
}
