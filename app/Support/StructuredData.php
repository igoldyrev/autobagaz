<?php

namespace App\Support;

use App\Models\Product;

class StructuredData
{
    public function __construct(private Seo $seo) {}

    public function organization(): array
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return [
            '@type' => 'AutoPartsStore',
            '@id' => $this->seo->url().'#organization',
            'name' => 'Автобагаж',
            'url' => $this->seo->url(),
            'logo' => $this->seo->url('/src/common.blocks/header/img/logo.jpg'),
            'telephone' => '+73422889929',
            'email' => 'autobagaz@yandex.ru',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'ул. Дзержинского, 15',
                'addressLocality' => 'Пермь',
                'addressCountry' => 'RU',
            ],
            'openingHoursSpecification' => array_map(fn (array $hours) => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => array_map(fn (int $day) => 'https://schema.org/'.$days[$day - 1], $hours['days']),
                'opens' => $hours['opens'],
                'closes' => $hours['closes'],
            ], config('orders.response_time.schedule')),
        ];
    }

    public function product(Product $product): array
    {
        $url = $this->seo->url(route('products.show', $product, false));
        $data = [
            '@type' => 'Product',
            '@id' => $url.'#product',
            'url' => $url,
            'name' => $product->name,
            'offers' => [
                '@type' => 'Offer',
                'url' => $url,
                'price' => $product->price,
                'priceCurrency' => 'RUB',
                'availability' => 'https://schema.org/'.($product->stock > 0 ? 'InStock' : 'OutOfStock'),
                'seller' => ['@id' => $this->seo->url().'#organization'],
            ],
        ];

        $description = trim($product->description ?? '');
        if ($description !== '') {
            $data['description'] = $description;
        }

        $images = $product->images->pluck('path')->filter()->map(fn (string $path) => $this->seo->url($path))->values()->all();
        if ($images !== []) {
            $data['image'] = $images;
        }

        $manufacturer = $product->roofRack?->manufacturer?->name
            ?: ($product->autoBox?->manufacturer?->name
                ?: ($product->bikeRack?->manufacturer?->name
                    ?: ($product->skiRack?->manufacturer?->name ?: $product->manufacturer)));
        if (filled($manufacturer)) {
            $data['manufacturer'] = ['@type' => 'Organization', 'name' => $manufacturer];
        }
        if (filled($product->product_model)) {
            $data['model'] = $product->product_model;
        }

        return $data;
    }

    public function breadcrumbs(array $items): array
    {
        $elements = [];
        foreach (array_values($items) as $position => $item) {
            $element = ['@type' => 'ListItem', 'position' => $position + 1, 'name' => $item['name']];
            if (isset($item['url'])) {
                $element['item'] = $this->seo->url(parse_url($item['url'], PHP_URL_PATH) ?: '/');
            }
            $elements[] = $element;
        }

        return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $elements];
    }
}
