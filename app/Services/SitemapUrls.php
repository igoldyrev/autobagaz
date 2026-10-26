<?php

namespace App\Services;

use App\Models\CatalogCategory;
use App\Models\Product;
use App\Support\Seo;

class SitemapUrls
{
    /** @return list<string> */
    public function all(): array
    {
        $seo = app(Seo::class);
        $urls = [];
        $add = function (string $route, array $parameters = []) use (&$urls, $seo): void {
            $urls[] = $seo->url(route($route, $parameters, false));
        };

        foreach (Seo::PUBLIC_ROUTES as $route) {
            if ($route !== 'products.show' && ! str_contains($route, '*')) {
                $add($route);
            }
        }

        foreach (Product::query()->active()->select(['id', 'slug'])->lazyById(1000) as $product) {
            $add('products.show', ['product' => $product->slug]);
        }

        $root = CatalogCategory::query()->active()->whereNull('parent_id')->where('slug', 'autobagazhniki')->first();
        if ($root) {
            $add('catalog.autobagazhniki.index');

            foreach ($root->children()->active()->where('kind', 'special')->get() as $category) {
                $add('catalog.autobagazhniki.show', [$category->slug]);
            }

            $makes = $root->vehicleMakes()->active()->with([
                'models' => fn ($query) => $query->active(),
                'models.generations' => fn ($query) => $query->active(),
                'models.generations.configurations' => fn ($query) => $query->active(),
            ])->get();

            foreach ($makes as $make) {
                $add('catalog.autobagazhniki.show', [$make->slug]);
                foreach ($make->models as $model) {
                    $add('catalog.autobagazhniki.model.show', [$make->slug, $model->slug]);
                    foreach ($model->generations as $generation) {
                        $add('catalog.autobagazhniki.generation.show', [$make->slug, $model->slug, $generation->slug]);
                        foreach ($generation->configurations as $configuration) {
                            $add('catalog.autobagazhniki.configuration.show', [$make->slug, $model->slug, $generation->slug, $configuration->slug]);
                        }
                    }
                }
            }
        }

        return array_values(array_unique($urls));
    }
}
