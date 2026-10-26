<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\VehicleConfiguration;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StructuredDataTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.canonical_url' => 'https://autobagaz.ru']);
    }

    public function test_store_uses_public_contact_details_schedule_and_main_domain(): void
    {
        foreach (['/', '/contacts'] as $path) {
            $data = $this->schemas($this->get('https://new.autobagaz.ru'.$path)->assertOk()->getContent());
            $store = $data['AutoPartsStore'];
            $this->assertSame('https://autobagaz.ru/#organization', $store['@id']);
            $this->assertSame('https://autobagaz.ru/', $store['url']);
            $this->assertSame('Автобагаж', $store['name']);
            $this->assertSame('+73422889929', $store['telephone']);
            $this->assertSame('autobagaz@yandex.ru', $store['email']);
            $this->assertSame('Пермь', $store['address']['addressLocality']);
            $this->assertSame('ул. Дзержинского, 15', $store['address']['streetAddress']);
            $this->assertSame('19:00', $store['openingHoursSpecification'][0]['closes']);
            $this->assertCount(5, $store['openingHoursSpecification'][0]['dayOfWeek']);
            $this->assertSame('18:00', $store['openingHoursSpecification'][1]['closes']);
            $this->assertArrayNotHasKey('Product', $data);
        }
    }

    public function test_product_offer_matches_price_stock_images_and_public_data(): void
    {
        $product = $this->product(['price' => '12990.50', 'stock' => 3, 'manufacturer' => 'Производитель', 'product_model' => 'Модель 1', 'description' => 'Описание & характеристики']);
        $product->images()->create(['path' => 'images/seo-test.jpg', 'sort_order' => 1]);
        $response = $this->get('https://new.autobagaz.ru/products/'.$product->slug)->assertOk()->assertSee('12 990,50 ₽');
        $schemas = $this->schemas($response->getContent());
        $data = $schemas['Product'];

        $this->assertSame($product->name, $data['name']);
        $this->assertSame('12990.50', $data['offers']['price']);
        $this->assertSame('RUB', $data['offers']['priceCurrency']);
        $this->assertSame('https://schema.org/InStock', $data['offers']['availability']);
        $this->assertSame('https://autobagaz.ru/products/structured-data-test', $data['offers']['url']);
        $this->assertSame($schemas['AutoPartsStore']['@id'], $data['offers']['seller']['@id']);
        $this->assertSame(['https://autobagaz.ru/images/seo-test.jpg'], $data['image']);
        $this->assertSame('Производитель', $data['manufacturer']['name']);
        $this->assertSame('Модель 1', $data['model']);
        $this->assertSame('Описание & характеристики', $data['description']);
        $this->assertArrayNotHasKey('aggregateRating', $data);
        $this->assertArrayNotHasKey('review', $data);
        $this->assertArrayNotHasKey('priceValidUntil', $data['offers']);
    }

    public function test_zero_stock_does_not_claim_availability_or_invent_missing_fields(): void
    {
        $product = $this->product(['stock' => 0]);
        $response = $this->get('/products/'.$product->slug)->assertOk()->assertSee('Под заказ');
        $data = $this->schemas($response->getContent())['Product'];

        $this->assertSame('https://schema.org/OutOfStock', $data['offers']['availability']);
        foreach (['image', 'manufacturer', 'model', 'description'] as $field) {
            $this->assertArrayNotHasKey($field, $data);
        }
        $product->update(['is_active' => false]);
        $response = $this->get('/products/'.$product->slug)->assertNotFound();
        $this->assertSame([], $this->schemas($response->getContent()));
    }

    public function test_json_ld_safely_encodes_quotes_and_closing_script_tags(): void
    {
        $name = 'Бокс "Тест" </script><script>alert("test")</script> & багажник';
        $product = $this->product(['name' => $name]);
        $response = $this->get('/products/'.$product->slug)->assertOk();
        $this->assertSame($name, $this->schemas($response->getContent())['Product']['name']);
        $response->assertDontSee('</script><script>alert(', false);
    }

    public function test_breadcrumb_schema_matches_visible_labels_and_links_on_public_pages(): void
    {
        $product = $this->product();
        $configuration = VehicleConfiguration::query()->active()
            ->whereHas('generation.vehicleModel.make', fn ($query) => $query->where('slug', 'lada-vaz'))
            ->whereHas('generation.vehicleModel', fn ($query) => $query->where('slug', 'vesta'))
            ->with('generation.vehicleModel.make')->firstOrFail();
        $generation = $configuration->generation;
        $model = $generation->vehicleModel;
        $base = '/autobagazhniki/'.$model->make->slug.'/'.$model->slug;
        $paths = ['/contacts', '/prokat', '/ustanovka', '/akcii', '/dostavka-i-oplata', '/garantiya', '/politika-konfidentsialnosti', '/soglasie-na-obrabotku-personalnykh-dannykh', '/podbor-avto', '/autobox', '/velokrepleniya', '/krepleniya-dlya-lyzh-i-snoubordov', '/autobagazhniki', '/autobagazhniki/'.$model->make->slug, $base, $base.'/'.$generation->slug, $base.'/'.$generation->slug.'/'.$configuration->slug, '/products/'.$product->slug];

        foreach ($paths as $path) {
            $html = $this->get('https://new.autobagaz.ru'.$path)->assertOk()->getContent();
            $items = $this->schemas($html)['BreadcrumbList']['itemListElement'];
            $document = new DOMDocument;
            $document->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new DOMXPath($document);
            $visible = $xpath->query('//nav[@class="breadcrumbs"]/*');
            $this->assertCount($visible->length, $items, $path);
            if ($path === '/podbor-avto') {
                $next = $xpath->query('//nav[@class="breadcrumbs"]/following-sibling::*[1]')->item(0);
                $this->assertSame('vehicle-picker', $next->getAttribute('id'));
            }
            foreach ($items as $index => $item) {
                $node = $visible->item($index);
                $this->assertSame(trim($node->textContent), $item['name'], $path);
                $this->assertSame($index + 1, $item['position']);
                if ($node->nodeName === 'a') {
                    $this->assertSame('https://autobagaz.ru'.(parse_url($node->getAttribute('href'), PHP_URL_PATH) ?: '/'), $item['item']);
                }
            }
        }
    }

    public function test_service_pages_do_not_receive_store_or_product_schemas(): void
    {
        foreach (['/cart', '/admin/login'] as $path) {
            $response = $this->get($path)->assertOk();
            $this->assertSame([], $this->schemas($response->getContent()));
        }
    }

    private function product(array $attributes = []): Product
    {
        return Product::query()->create(array_merge(['name' => 'Тестовый товар', 'slug' => 'structured-data-test', 'price' => '1000.00', 'stock' => 1, 'is_active' => true], $attributes));
    }

    private function schemas(string $html): array
    {
        preg_match_all('~<script type="application/ld\+json">(.*?)</script>~s', $html, $matches);
        $schemas = [];
        foreach ($matches[1] as $json) {
            $data = json_decode($json, true, flags: JSON_THROW_ON_ERROR);
            $this->assertSame('https://schema.org', $data['@context']);
            foreach ($data['@graph'] ?? [$data] as $item) {
                $this->assertArrayNotHasKey($item['@type'], $schemas);
                $schemas[$item['@type']] = $item;
            }
        }

        return $schemas;
    }
}
