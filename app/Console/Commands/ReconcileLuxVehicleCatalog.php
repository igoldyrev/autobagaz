<?php

namespace App\Console\Commands;

use App\Models\VehicleBodyStyle;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Services\VehicleBodyTypeDetector;
use DOMDocument;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ReconcileLuxVehicleCatalog extends Command
{
    protected $signature = 'vehicles:reconcile-lux
        {--apply-body-styles : Заполнить отсутствующие типы кузова при однозначном сопоставлении}
        {--delay=150 : Задержка между запросами в миллисекундах}
        {--make=* : Проверить только указанные локальные slug марок}
        {--report=storage/app/reports/lux-vehicle-mapping.json : Путь к JSON-отчёту}';

    protected $description = 'Сопоставляет марки, модели и варианты кузова с подборщиком lux-company.ru';

    private const URL = 'https://lux-company.ru/';

    private float $lastRequestAt = 0;

    private int $requestCount = 0;

    public function handle(VehicleBodyTypeDetector $bodyTypeDetector): int
    {
        $requestedMakes = collect($this->option('make'))->filter();
        $localMakes = VehicleMake::query()
            ->with(['models' => fn ($query) => $query->with(['generations.configurations.bodyStyle'])])
            ->when($requestedMakes->isNotEmpty(), fn ($query) => $query->whereIn('slug', $requestedMakes))
            ->orderBy('name')
            ->get();
        $luxMakes = collect($this->parseOptions($this->get(), 'brand'))->keyBy(fn (array $option): string => $this->makeKey($option['name']));

        $report = [
            'source' => self::URL,
            'generated_at' => now()->toIso8601String(),
            'summary' => [
                'local_makes' => $localMakes->count(),
                'lux_makes' => $luxMakes->count(),
                'matched_makes' => 0,
                'local_models' => $localMakes->sum(fn (VehicleMake $make): int => $make->models->count()),
                'matched_models' => 0,
                'lux_bodyworks' => 0,
                'body_styles_filled' => 0,
            ],
            'unmatched_local_makes' => [],
            'matches' => [],
        ];

        foreach ($localMakes as $localMake) {
            $luxMake = $luxMakes->get($this->makeKey($localMake->name));
            if (! $luxMake) {
                $report['unmatched_local_makes'][] = $localMake->name;

                continue;
            }

            $report['summary']['matched_makes']++;
            $this->line("<info>{$localMake->name}</info>: сопоставляю модели");
            $luxModels = collect($this->parseOptions($this->post($luxMake['id']), 'model'))
                ->keyBy(fn (array $option): string => $this->key($option['name']));
            $makeReport = [
                'local' => ['id' => $localMake->id, 'name' => $localMake->name],
                'lux' => $luxMake,
                'unmatched_local_models' => [],
                'models' => [],
            ];

            foreach ($localMake->models as $localModel) {
                $luxModel = $luxModels->get($this->key($localModel->name));
                if (! $luxModel) {
                    $makeReport['unmatched_local_models'][] = $localModel->name;

                    continue;
                }

                $report['summary']['matched_models']++;
                $luxBodyworks = $this->parseOptions($this->post($luxModel['id']), 'bodywork');
                $report['summary']['lux_bodyworks'] += count($luxBodyworks);
                $filled = $this->fillBodyStyles($localModel, $luxBodyworks, $bodyTypeDetector);
                $report['summary']['body_styles_filled'] += $filled;
                $makeReport['models'][] = [
                    'local' => ['id' => $localModel->id, 'name' => $localModel->name],
                    'lux' => $luxModel,
                    'lux_bodyworks' => $luxBodyworks,
                    'body_styles_filled' => $filled,
                ];
            }

            $report['matches'][] = $makeReport;
        }

        $path = str_starts_with((string) $this->option('report'), '/')
            ? (string) $this->option('report')
            : base_path((string) $this->option('report'));
        File::ensureDirectoryExists(dirname($path));
        File::put($path, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).PHP_EOL);

        $summary = $report['summary'];
        $this->newLine();
        $this->info("Сопоставлено: марок {$summary['matched_makes']}/{$summary['local_makes']}, моделей {$summary['matched_models']}/{$summary['local_models']}.");
        $this->info("Получено вариантов кузова Lux: {$summary['lux_bodyworks']}. Заполнено типов кузова: {$summary['body_styles_filled']}.");
        $this->info("HTTP-запросов: {$this->requestCount}. Отчёт: {$path}");

        return self::SUCCESS;
    }

    /** @param array<int, array{id: int, name: string}> $luxBodyworks */
    private function fillBodyStyles(VehicleModel $model, array $luxBodyworks, VehicleBodyTypeDetector $detector): int
    {
        $variants = collect($luxBodyworks)->map(function (array $bodywork) use ($detector): array {
            return [
                ...$bodywork,
                'styles' => $detector->detectAll($bodywork['name']),
                'years' => $this->yearRange($bodywork['name']),
            ];
        });
        $globalStyles = $variants->flatMap(fn (array $variant): array => $variant['styles'])->unique()->values();
        $filled = 0;

        foreach ($model->generations->flatMap->configurations->whereNull('vehicle_body_style_id') as $configuration) {
            $from = $configuration->year_from ?: $configuration->generation->year_from;
            $to = $configuration->year_to ?: $configuration->generation->year_to;
            $matchingStyles = $variants
                ->filter(fn (array $variant): bool => $this->yearsOverlap($from, $to, $variant['years']))
                ->flatMap(fn (array $variant): array => $variant['styles'])
                ->unique()
                ->values();
            $styleName = $matchingStyles->count() === 1
                ? $matchingStyles->first()
                : ($globalStyles->count() === 1 ? $globalStyles->first() : null);

            if (! $styleName) {
                continue;
            }

            $filled++;
            if ($this->option('apply-body-styles')) {
                $style = VehicleBodyStyle::query()->firstOrCreate(
                    ['slug' => Str::slug($styleName)],
                    ['name' => $styleName, 'is_active' => true],
                );
                $configuration->update(['vehicle_body_style_id' => $style->id]);
            }
        }

        return $filled;
    }

    /** @return array{0: ?int, 1: ?int} */
    private function yearRange(string $label): array
    {
        $normalized = str_replace(['‑', '–', '—', '…'], ['-', '-', '-', ''], $label);
        if (preg_match('/((?:19|20)\d{2})\s*-\s*((?:19|20)\d{2})/u', $normalized, $matches)) {
            return [(int) $matches[1], (int) $matches[2]];
        }
        if (preg_match('/((?:19|20)\d{2})\s*-/u', $normalized, $matches)) {
            return [(int) $matches[1], null];
        }

        return [null, null];
    }

    /** @param array{0: ?int, 1: ?int} $external */
    private function yearsOverlap(?int $from, ?int $to, array $external): bool
    {
        [$externalFrom, $externalTo] = $external;
        if (! $from && ! $to || ! $externalFrom && ! $externalTo) {
            return false;
        }

        return max($from ?: 1900, $externalFrom ?: 1900) <= min($to ?: 2100, $externalTo ?: 2100);
    }

    /** @return array<int, array{id: int, name: string}> */
    private function parseOptions(string $html, string $selectName): array
    {
        $document = new DOMDocument;
        @$document->loadHTML('<?xml encoding="utf-8" ?>'.$html, LIBXML_NOERROR | LIBXML_NOWARNING);
        $nodes = (new DOMXPath($document))->query("//select[@name='{$selectName}']/option[@value != '0']");
        $options = [];

        foreach ($nodes as $node) {
            $options[] = ['id' => (int) $node->getAttribute('value'), 'name' => trim($node->textContent)];
        }

        return $options;
    }

    private function get(): string
    {
        return $this->request(fn ($http) => $http->accept('text/html')->get(self::URL)->throw()->body());
    }

    private function post(int $id): string
    {
        return $this->request(fn ($http) => $http->asForm()->accept('text/html')->post(self::URL, ['params' => $id])->throw()->body());
    }

    private function request(callable $callback): string
    {
        $delay = max(0, (int) $this->option('delay'));
        $remaining = $delay - (int) ((microtime(true) - $this->lastRequestAt) * 1000);
        if ($remaining > 0) {
            usleep($remaining * 1000);
        }
        $response = Http::retry(3, 500)->timeout(30);
        $this->requestCount++;
        $result = $callback($response);
        $this->lastRequestAt = microtime(true);

        return $result;
    }

    private function makeKey(string $value): string
    {
        $key = $this->key($value);
        $original = mb_strtolower($value);

        if (str_starts_with($key, 'lada')) {
            return 'lada';
        }
        if (str_contains($original, 'газ') || str_contains($key, 'gaz')) {
            return 'gaz';
        }
        if (str_replace(' ', '', $key) === 'ssangyong') {
            return 'ssangyong';
        }

        return $key;
    }

    private function key(string $value): string
    {
        $value = strtr(mb_strtolower($value), ['ё' => 'е', 'с' => 'c', 'а' => 'a', 'е' => 'e', 'о' => 'o', 'р' => 'p', 'х' => 'x']);

        return trim(preg_replace('/[^\p{L}\p{N}]+/u', ' ', $value));
    }
}
