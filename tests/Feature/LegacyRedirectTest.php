<?php

namespace Tests\Feature;

use App\Models\AutoBoxManufacturer;
use App\Models\CatalogCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegacyRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirmed_old_urls_redirect_once_to_the_correct_public_page(): void
    {
        config(['seo.canonical_url' => 'https://autobagaz.ru', 'seo.indexing_enabled' => true]);
        foreach (config('legacy_urls') as $path => $mapping) {
            $parameters = $mapping['parameters'] ?? [];
            if (isset($mapping['manufacturer'])) {
                $manufacturer = AutoBoxManufacturer::query()->whereRaw('LOWER(name) = ?', [mb_strtolower($mapping['manufacturer'])])->first()
                    ?? AutoBoxManufacturer::query()->create(['name' => $mapping['manufacturer'], 'is_active' => true]);
                $parameters['manufacturer'] = [$manufacturer->id];
            }
            $response = $this->get('https://autobagaz.ru'.$path.'?redirect=https://untrusted.example&manufacturer[0]=0');
            $response->assertStatus(301)->assertHeaderMissing('X-Robots-Tag');
            $target = route($mapping['route'], $parameters);
            $response->assertRedirect($target);
            $this->get($target)->assertOk();
            $this->assertStringNotContainsString('untrusted.example', $target);
        }
    }

    public function test_redirect_on_the_test_domain_stays_on_the_test_domain_and_is_not_indexed(): void
    {
        $this->get('https://new.autobagaz.ru/velokreplenya')
            ->assertRedirect('https://new.autobagaz.ru/velokrepleniya')
            ->assertStatus(301)->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_all_previously_unmapped_and_deferred_urls_redirect_home_on_the_test_domain(): void
    {
        $inventory = json_decode(file_get_contents(base_path('docs/releases/2026-10-26-url-mapping.json')), true, flags: JSON_THROW_ON_ERROR);
        $paths = array_column(array_filter($inventory['urls'], fn ($entry) => in_array($entry['decision'], ['no_equivalent_404', 'news_decision_deferred'], true)), 'path');
        $this->assertCount(148, $paths);

        foreach ($paths as $path) {
            $this->get('https://new.autobagaz.ru'.$path.'?redirect=https://untrusted.example')
                ->assertStatus(301)
                ->assertRedirect('https://new.autobagaz.ru')
                ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        }

        $this->get('https://new.autobagaz.ru')->assertOk();
    }

    public function test_manufacturer_filter_is_resolved_from_data_and_inactive_manufacturers_return_404(): void
    {
        $manufacturer = AutoBoxManufacturer::query()->create(['name' => 'SEO migration manufacturer', 'is_active' => true]);
        config(['legacy_urls./autobox/vetlan.manufacturer' => $manufacturer->name]);
        $this->get('/autobox/vetlan')->assertRedirectToRoute('catalog.auto-boxes.index', ['manufacturer' => [$manufacturer->id]], 301);
        $manufacturer->update(['is_active' => false]);
        $this->get('/autobox/vetlan')->assertNotFound();
    }

    public function test_inactive_category_and_unknown_old_pages_do_not_redirect_to_an_unrelated_page(): void
    {
        CatalogCategory::query()->where('slug', 'na-reylingi')->update(['is_active' => false]);
        $this->get('/autobagazhnik/reelings')->assertNotFound();
        foreach (['/unknown-old-page', '/news/unknown-article', '/autobox/unknown-manufacturer', '/velokreplenya/unknown-mount', '/buy/unknown-product'] as $path) {
            $this->get($path)->assertNotFound()->assertHeaderMissing('Location');
        }
    }
}
