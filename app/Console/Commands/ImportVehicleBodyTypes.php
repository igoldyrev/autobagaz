<?php

namespace App\Console\Commands;

use App\Models\CatalogCategory;
use App\Models\VehicleBodyType;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Services\VehicleBodyTypeDetector;
use App\Services\VehicleFitmentParser;
use DOMDocument;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class ImportVehicleBodyTypes extends Command
{
    protected $signature = 'vehicles:import-body-types
        {--make=* : Импортировать только указанные локальные slug марок}
        {--delay=1000 : Задержка между запросами в миллисекундах}
        {--dry-run : Не изменять БД и файлы}
        {--reparse : Повторно разобрать годы и крепления без обращения к источнику}
        {--refresh-images : Загрузить изображения повторно}';

    protected $description = 'Импортирует марки, модели и типы кузова с bagaznik-darom.ru';

    private const BASE_URL = 'https://bagaznik-darom.ru';

    private float $lastRequestAt = 0;

    private int $requestCount = 0;

    /** @var array<string, array<string, array<string, array<string, mixed>>>> */
    private array $manifest = [];

    public function handle(VehicleBodyTypeDetector $detector, VehicleFitmentParser $fitmentParser): int
    {
        if ($this->option('reparse')) {
            return $this->reparseExisting($fitmentParser);
        }

        $root = CatalogCategory::query()
            ->whereNull('parent_id')
            ->where('slug', 'autobagazhniki')
            ->firstOrFail();
        $requestedMakes = collect($this->option('make'))->filter()->values();

        if ($requestedMakes->isNotEmpty()) {
            $this->loadExistingManifest();
        }

        $makeCards = $this->categoryCards($this->get('/bagazhniki'));
        $makesImported = 0;
        $modelsImported = 0;
        $bodyTypesImported = 0;

        foreach ($makeCards as $makeIndex => $makeCard) {
            $make = $this->resolveMake($makeCard, $root, $makeIndex + 1);

            if (! $make || ($requestedMakes->isNotEmpty() && ! $requestedMakes->contains($make->slug))) {
                continue;
            }

            $makesImported++;
            $this->line("<info>{$make->name}</info>: получаю модели");
            $modelCards = $this->categoryCards($this->get($makeCard['path']));

            foreach ($modelCards as $modelIndex => $modelCard) {
                $model = $this->resolveModel($make, $modelCard, $modelIndex + 1);

                if (! $model) {
                    continue;
                }

                $modelsImported++;
                $variantCards = $this->categoryCards($this->get($modelCard['path']));
                $keptSlugs = [];
                $this->manifest[$make->slug][$model->slug] = [];

                foreach ($variantCards as $variantIndex => $variantCard) {
                    $bodyTypeNames = $detector->detectAll($variantCard['name']);
                    $sourceSlug = $this->sourceSlug($variantCard['path']);
                    $keptSlugs[] = $sourceSlug;
                    $imagePath = $this->downloadImage(
                        $variantCard['image_url'],
                        "images/catalog/autobagazhniki/body-types/{$make->slug}/{$model->slug}",
                    );
                    $attributes = [
                        'name' => $bodyTypeNames === [] ? 'Кузов не указан' : implode(' / ', $bodyTypeNames),
                        'source_name' => $variantCard['name'],
                        'year_label' => $fitmentParser->years($variantCard['name'], $sourceSlug),
                        'mounting_type' => $fitmentParser->mountingType($variantCard['name'], $sourceSlug),
                        'image_path' => $imagePath,
                        'image_alt' => $variantCard['image_alt'] ?: $variantCard['name'],
                        'source_url' => self::BASE_URL.$variantCard['path'],
                        'sort_order' => $variantIndex + 1,
                        'is_active' => true,
                    ];

                    if (! $this->option('dry-run')) {
                        VehicleBodyType::query()->updateOrCreate(
                            ['vehicle_model_id' => $model->id, 'slug' => $sourceSlug],
                            $attributes,
                        );
                    }

                    $this->manifest[$make->slug][$model->slug][$sourceSlug] = [
                        'name' => $attributes['name'],
                        'slug' => $sourceSlug,
                        ...$attributes,
                    ];
                    $bodyTypesImported++;
                }

                if (! $this->option('dry-run')) {
                    $model->bodyTypes()->whereNotIn('slug', array_values(array_unique($keptSlugs)))->delete();
                }
            }
        }

        if (! $this->option('dry-run')) {
            $this->writeManifest();
        }

        $this->newLine();
        $this->info("Готово: марок {$makesImported}, моделей {$modelsImported}, вариантов применимости {$bodyTypesImported}, HTTP-запросов {$this->requestCount}.");

        return self::SUCCESS;
    }

    /** @param array{name: string, path: string, image_url: ?string, image_alt: ?string} $card */
    private function resolveMake(array $card, CatalogCategory $root, int $sortOrder): ?VehicleMake
    {
        $sourceSlug = $this->sourceSlug($card['path']);
        $sourceSlug = ['iveso' => 'iveco'][$sourceSlug] ?? $sourceSlug;

        if (in_array($sourceSlug, ['bagazhniki-aps', 'v-shtatnoe-mesto', 'bagazhniki-na-reylingi'], true)) {
            return null;
        }

        $make = VehicleMake::query()->get()->first(fn (VehicleMake $make): bool => $make->slug === $sourceSlug || $this->key($make->name) === $this->key($card['name'])
        );

        if (! $make) {
            if ($this->option('dry-run')) {
                $this->warn("Новая марка пропущена в dry-run: {$card['name']}");

                return null;
            }

            $make = VehicleMake::query()->create([
                'name' => $card['name'],
                'slug' => $sourceSlug,
                'image_path' => $this->downloadImage($card['image_url'], 'images/catalog/autobagazhniki/brands'),
                'image_alt' => $card['image_alt'] ?: $card['name'],
                'is_active' => true,
            ]);
        } elseif ($this->shouldImportImage($make->image_path)) {
            $imagePath = $this->downloadImage($card['image_url'], 'images/catalog/autobagazhniki/brands');

            if ($imagePath) {
                $make->update([
                    'image_path' => $imagePath,
                    'image_alt' => $card['image_alt'] ?: $make->image_alt,
                ]);
            }
        }

        if (! $this->option('dry-run') && ! $root->vehicleMakes()->whereKey($make->id)->exists()) {
            $root->vehicleMakes()->attach($make->id, ['sort_order' => $sortOrder]);
        }

        return $make;
    }

    /** @param array{name: string, path: string, image_url: ?string, image_alt: ?string} $card */
    private function resolveModel(VehicleMake $make, array $card, int $sortOrder): ?VehicleModel
    {
        $sourceSlug = $this->sourceSlug($card['path']);
        $model = $make->models()->get()->first(fn (VehicleModel $model): bool => $model->slug === $sourceSlug || $this->key($model->name) === $this->key($card['name'])
        );

        if ($model) {
            return $model;
        }

        if ($this->option('dry-run')) {
            $this->warn("  Новая модель пропущена в dry-run: {$make->name} {$card['name']}");

            return null;
        }

        return $make->models()->create([
            'name' => $card['name'],
            'slug' => $sourceSlug,
            'image_path' => $this->downloadImage(
                $card['image_url'],
                "images/catalog/autobagazhniki/models/{$make->slug}",
            ),
            'image_alt' => $card['image_alt'] ?: "{$make->name} {$card['name']}",
            'sort_order' => $sortOrder,
            'is_active' => true,
        ]);
    }

    /**
     * @return array<int, array{name: string, path: string, image_url: ?string, image_alt: ?string}>
     */
    private function categoryCards(string $html): array
    {
        $document = new DOMDocument;
        @$document->loadHTML('<?xml encoding="utf-8" ?>'.$html, LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new DOMXPath($document);
        $nodes = $xpath->query("//a[contains(concat(' ', normalize-space(@class), ' '), ' thumbnail-small-link-centered ')]");
        $cards = [];

        foreach ($nodes ?: [] as $node) {
            $href = trim($node->getAttribute('href'));

            if (! str_starts_with($href, '/bagazhniki/')) {
                continue;
            }

            $image = $xpath->query('.//img', $node)?->item(0);
            $name = preg_replace('/\s+/u', ' ', trim($node->textContent));

            if (! $name) {
                continue;
            }

            $cards[] = [
                'name' => $name,
                'path' => parse_url($href, PHP_URL_PATH),
                'image_url' => $image?->getAttribute('src') ?: null,
                'image_alt' => $image?->getAttribute('alt') ?: null,
            ];
        }

        return $cards;
    }

    private function get(string $path): string
    {
        $response = $this->request()->get(Str::startsWith($path, 'http') ? $path : self::BASE_URL.$path);

        if (! $response->successful()) {
            throw new RuntimeException("Источник вернул HTTP {$response->status()} для {$path}");
        }

        return $response->body();
    }

    private function downloadImage(?string $source, string $directory): ?string
    {
        if (! $source) {
            return null;
        }

        $filename = basename(rawurldecode(parse_url($source, PHP_URL_PATH)));

        if (in_array(mb_strtolower($filename), ['no_image.png', 'no-image.png'], true)) {
            return null;
        }

        $filename = preg_replace('/[^A-Za-z0-9._-]+/', '-', $filename);
        $relativePath = trim($directory, '/').'/'.$filename;
        $destination = public_path($relativePath);

        if (! $this->option('refresh-images') && File::exists($destination)) {
            return $relativePath;
        }

        if ($this->option('dry-run')) {
            return $relativePath;
        }

        $response = $this->request()->get(Str::startsWith($source, 'http') ? $source : self::BASE_URL.$source);

        if (! $response->successful()) {
            $this->warn("  Не удалось загрузить изображение {$source}: HTTP {$response->status()}");

            return null;
        }

        File::ensureDirectoryExists(dirname($destination));
        File::put($destination, $response->body());

        return $relativePath;
    }

    private function request(): PendingRequest
    {
        $delay = max(0, (int) $this->option('delay'));
        $elapsed = (microtime(true) - $this->lastRequestAt) * 1000;

        if ($this->lastRequestAt > 0 && $elapsed < $delay) {
            usleep((int) (($delay - $elapsed) * 1000));
        }

        $this->lastRequestAt = microtime(true);
        $this->requestCount++;

        return Http::withUserAgent('Autobagaz directory importer/1.0')
            ->accept('text/html,image/*')
            ->timeout(30)
            ->retry(3, 1000);
    }

    private function shouldImportImage(?string $path): bool
    {
        return ! $path
            || str_ends_with($path, 'category-background.webp')
            || ! File::exists(public_path($path));
    }

    private function sourceSlug(string $path): string
    {
        return str_replace('_', '-', basename($path));
    }

    private function key(string $value): string
    {
        return preg_replace('/[^\p{L}\p{N}]+/u', '', mb_strtolower(str_replace('ё', 'е', $value)));
    }

    private function writeManifest(): void
    {
        ksort($this->manifest, SORT_NATURAL | SORT_FLAG_CASE);

        foreach ($this->manifest as &$models) {
            ksort($models, SORT_NATURAL | SORT_FLAG_CASE);
            foreach ($models as &$bodyTypes) {
                ksort($bodyTypes, SORT_NATURAL | SORT_FLAG_CASE);
                $bodyTypes = array_values($bodyTypes);
            }
        }

        File::put(
            database_path('data/vehicle_body_types.json'),
            json_encode($this->manifest, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR)."\n",
        );
    }

    private function loadExistingManifest(): void
    {
        $path = database_path('data/vehicle_body_types.json');

        if (! File::exists($path)) {
            return;
        }

        $manifest = json_decode(File::get($path), true, flags: JSON_THROW_ON_ERROR);

        foreach ($manifest as $makeSlug => $models) {
            foreach ($models as $modelSlug => $bodyTypes) {
                foreach ($bodyTypes as $bodyType) {
                    $this->manifest[$makeSlug][$modelSlug][$bodyType['slug']] = $bodyType;
                }
            }
        }
    }

    private function reparseExisting(VehicleFitmentParser $fitmentParser): int
    {
        $this->loadExistingManifest();
        $updated = 0;

        foreach ($this->manifest as $makeSlug => &$models) {
            $make = VehicleMake::query()->where('slug', $makeSlug)->firstOrFail();

            foreach ($models as $modelSlug => &$bodyTypes) {
                $model = $make->models()->where('slug', $modelSlug)->firstOrFail();
                $collapsed = [];

                foreach (collect($bodyTypes)->groupBy(fn (array $bodyType): string => $bodyType['source_url'] ?: $bodyType['slug']) as $group) {
                    $bodyType = $group->first();
                    $slug = $bodyType['source_url']
                        ? $this->sourceSlug(parse_url($bodyType['source_url'], PHP_URL_PATH))
                        : $bodyType['slug'];
                    $names = $group->pluck('name')->reject(fn (string $name): bool => $name === 'Кузов не указан')->unique()->values();
                    $bodyType['name'] = $names->isEmpty() ? 'Кузов не указан' : $names->implode(' / ');
                    $bodyType['slug'] = $slug;
                    $bodyType['year_label'] = $fitmentParser->years($bodyType['source_name'], $slug);
                    $bodyType['mounting_type'] = $fitmentParser->mountingType($bodyType['source_name'], $slug);
                    $collapsed[$slug] = $bodyType;
                }

                $model->bodyTypes()->delete();

                foreach ($collapsed as $slug => $bodyType) {
                    $model->bodyTypes()->create($bodyType);
                    $updated++;
                }

                $bodyTypes = $collapsed;
            }
        }

        $this->writeManifest();
        $this->info("Повторно обработано вариантов: {$updated}.");

        return self::SUCCESS;
    }
}
