<?php

namespace Tests\Feature;

use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\User;
use App\Models\VehicleConfiguration;
use App\Models\VehicleMake;
use App\Services\SitemapUrls;
use App\Support\Seo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.indexing_enabled' => true, 'seo.canonical_url' => 'https://autobagaz.ru']);
    }

    public function test_public_page_uses_the_main_domain_and_removes_tracking_from_canonical(): void
    {
        $this->get('https://autobagaz.ru/contacts?utm_source=test&yclid=123')
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag')
            ->assertSee('<meta name="robots" content="index,follow">', false)
            ->assertSee('<link rel="canonical" href="https://autobagaz.ru/contacts">', false);
    }

    public function test_test_domain_is_not_indexed_and_does_not_expose_a_sitemap(): void
    {
        $this->get('https://new.autobagaz.ru/contacts')
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertSee('<meta name="robots" content="noindex,nofollow">', false)
            ->assertSee('href="https://autobagaz.ru/contacts"', false);
        $this->get('https://new.autobagaz.ru/robots.txt')
            ->assertOk()->assertSee("Disallow: /\n", false)->assertDontSee('Sitemap:');
        $this->get('https://new.autobagaz.ru/sitemap.xml')->assertNotFound();
        $this->get('https://new.autobagaz.ru/sitemaps/1.xml')->assertNotFound();
    }

    public function test_indexing_can_be_disabled_on_the_main_domain(): void
    {
        config(['seo.indexing_enabled' => false]);
        $this->get('https://autobagaz.ru/contacts')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->get('https://autobagaz.ru/robots.txt')->assertSee("Disallow: /\n", false);
        $this->get('https://autobagaz.ru/sitemap.xml')->assertNotFound();
    }

    public function test_admin_login_redirects_and_service_pages_are_not_indexed(): void
    {
        foreach (['/admin/login', '/admin', '/cart', '/checkout', '/checkout/thanks', '/checkout/open-order', '/internal/monitoring/project-snapshot', '/podbor-avto/models', '/missing-page'] as $path) {
            $this->get('https://autobagaz.ru'.$path)->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        }

        $this->get('https://autobagaz.ru/admin/login')->assertSee('content="noindex,nofollow"', false);
        $this->get('https://autobagaz.ru/cart')
            ->assertOk()->assertSee('content="noindex,nofollow"', false)->assertDontSee('rel="canonical"', false);
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->get('https://autobagaz.ru/admin')->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_pagination_keeps_its_canonical_but_filters_are_not_indexed(): void
    {
        $this->get('https://autobagaz.ru/autobox?page=2&utm_source=test')
            ->assertOk()->assertHeaderMissing('X-Robots-Tag')
            ->assertSee('rel="canonical" href="https://autobagaz.ru/autobox?page=2"', false);
        $this->get('https://autobagaz.ru/autobox?page=1')
            ->assertOk()->assertSee('rel="canonical" href="https://autobagaz.ru/autobox"', false);
        $this->get('https://autobagaz.ru/autobox?sort=price_asc&price_from=1000')
            ->assertOk()->assertHeader('X-Robots-Tag', 'noindex, follow')
            ->assertSee('content="noindex,follow"', false);
    }

    public function test_canonical_does_not_trust_the_request_host_or_include_secret_parameters(): void
    {
        $request = Request::create('https://unexpected.example/contacts?token=secret&page[]=2');
        $request->setRouteResolver(fn () => app('router')->getRoutes()->getByName('contacts'));
        $seo = app(Seo::class);

        $this->assertSame('https://autobagaz.ru/contacts', $seo->canonical($request));
        $this->assertSame('noindex,nofollow', $seo->robots($request));
    }

    public function test_robots_advertises_the_main_sitemap_and_allows_reading_noindex(): void
    {
        $this->get('https://autobagaz.ru/robots.txt')
            ->assertOk()->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee("Disallow:\n", false)
            ->assertSee('Sitemap: https://autobagaz.ru/sitemap.xml', false)
            ->assertDontSee('Disallow: /admin', false);
        $this->assertFileDoesNotExist(public_path('robots.txt'));
    }

    public function test_sitemap_contains_only_public_active_urls_and_valid_xml(): void
    {
        $active = Product::query()->create(['name' => 'SEO & товар', 'slug' => 'seo-active', 'price' => 100, 'stock' => 0, 'is_active' => true]);
        Product::query()->create(['name' => 'Скрытый', 'slug' => 'seo-inactive', 'price' => 100, 'stock' => 1, 'is_active' => false]);
        $root = CatalogCategory::query()->where('slug', 'autobagazhniki')->firstOrFail();
        $make = $root->vehicleMakes()->active()->firstOrFail();
        $makeUrl = 'https://autobagaz.ru/autobagazhniki/'.$make->slug;
        $hidden = VehicleMake::query()->create(['name' => 'SEO скрытая марка', 'slug' => 'seo-hidden', 'is_active' => false]);
        $root->vehicleMakes()->attach($hidden);

        $response = $this->get('https://autobagaz.ru/sitemap.xml')->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $index = simplexml_load_string($response->getContent());
        $this->assertNotFalse($index);
        $this->assertSame('sitemapindex', $index->getName());
        $urls = [];
        foreach ($index->sitemap as $entry) {
            $part = $this->get((string) $entry->loc)->assertOk();
            $xml = simplexml_load_string($part->getContent());
            $this->assertNotFalse($xml);
            $this->assertSame('urlset', $xml->getName());
            $this->assertLessThanOrEqual(1000, count($xml->url));
            foreach ($xml->url as $url) {
                $urls[] = (string) $url->loc;
            }
        }

        $this->assertContains('https://autobagaz.ru/products/'.$active->slug, $urls);
        $this->assertContains($makeUrl, $urls);
        $this->assertContains('https://autobagaz.ru/', $urls);
        $this->assertContains('https://autobagaz.ru/autobagazhniki', $urls);
        $this->assertCount(count(array_unique($urls)), $urls);
        foreach ($urls as $url) {
            $this->assertStringStartsWith('https://autobagaz.ru/', $url);
            $this->assertDoesNotMatchRegularExpression('~seo-inactive|seo-hidden|/admin|/cart|/checkout|/internal|\?~', $url);
        }
        $this->get('https://autobagaz.ru/sitemaps/999999.xml')->assertNotFound();
    }

    public function test_sitemap_excludes_descendants_of_inactive_catalog_records(): void
    {
        $configuration = VehicleConfiguration::query()->active()
            ->whereHas('generation', fn ($query) => $query->active()
                ->whereHas('vehicleModel', fn ($query) => $query->active()
                    ->whereHas('make', fn ($query) => $query->active()->whereHas('catalogCategories', fn ($query) => $query->where('slug', 'autobagazhniki')))))
            ->with('generation.vehicleModel.make')->firstOrFail();
        $generation = $configuration->generation;
        $model = $generation->vehicleModel;
        $parameters = [$model->make->slug, $model->slug, $generation->slug];
        $seo = app(Seo::class);
        $generationUrl = $seo->url(route('catalog.autobagazhniki.generation.show', $parameters, false));
        $configurationUrl = $seo->url(route('catalog.autobagazhniki.configuration.show', [...$parameters, $configuration->slug], false));
        $modelUrl = $seo->url(route('catalog.autobagazhniki.model.show', array_slice($parameters, 0, 2), false));
        $sitemap = app(SitemapUrls::class);

        $this->assertContains($configurationUrl, $sitemap->all());
        $generation->update(['is_active' => false]);
        $urls = $sitemap->all();
        $this->assertNotContains($configurationUrl, $urls);
        $this->assertNotContains($generationUrl, $urls);
        $this->assertContains($modelUrl, $urls);
        $model->update(['is_active' => false]);
        $this->assertNotContains($modelUrl, $sitemap->all());
    }
}
