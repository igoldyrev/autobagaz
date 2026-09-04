<?php

namespace App\Http\Middleware;

use App\Models\AdminActivityLog;
use App\Models\User;
use App\Services\AdminActivityLogger;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RecordAdminActivity
{
    /** @var array<int, array{prefix: string, parameter: string|null, type: string, noun: string}> */
    private const RESOURCES = [
        ['prefix' => 'admin.products.roof-racks.manufacturers.', 'parameter' => 'manufacturer', 'type' => 'roof_rack_manufacturer', 'noun' => 'производителя автобагажников'],
        ['prefix' => 'admin.products.auto-boxes.manufacturers.', 'parameter' => 'manufacturer', 'type' => 'auto_box_manufacturer', 'noun' => 'производителя автобоксов'],
        ['prefix' => 'admin.products.roof-racks.', 'parameter' => 'product', 'type' => 'roof_rack', 'noun' => 'автобагажник'],
        ['prefix' => 'admin.products.auto-boxes.', 'parameter' => 'product', 'type' => 'auto_box', 'noun' => 'автомобильный бокс'],
        ['prefix' => 'admin.catalog-categories.', 'parameter' => 'catalog_category', 'type' => 'catalog_category', 'noun' => 'раздел или категорию'],
        ['prefix' => 'admin.users.', 'parameter' => 'user', 'type' => 'user', 'noun' => 'пользователя'],
        ['prefix' => 'admin.vehicles.vehicle-makes.', 'parameter' => 'vehicle_make', 'type' => 'vehicle_make', 'noun' => 'марку автомобиля'],
        ['prefix' => 'admin.vehicles.vehicle-models.', 'parameter' => 'vehicle_model', 'type' => 'vehicle_model', 'noun' => 'модель автомобиля'],
        ['prefix' => 'admin.vehicles.vehicle-generations.', 'parameter' => 'vehicle_generation', 'type' => 'vehicle_generation', 'noun' => 'поколение автомобиля'],
        ['prefix' => 'admin.vehicles.vehicle-configurations.', 'parameter' => 'vehicle_configuration', 'type' => 'vehicle_configuration', 'noun' => 'конфигурацию автомобиля'],
        ['prefix' => 'admin.vehicles.vehicle-body-styles.', 'parameter' => 'vehicle_body_style', 'type' => 'vehicle_body_style', 'noun' => 'тип кузова'],
        ['prefix' => 'admin.vehicles.vehicle-roof-types.', 'parameter' => 'vehicle_roof_type', 'type' => 'vehicle_roof_type', 'noun' => 'тип крыши'],
        ['prefix' => 'admin.fitments.', 'parameter' => 'fitment', 'type' => 'fitment', 'noun' => 'группу применяемости'],
        ['prefix' => 'admin.compatibility-overrides.', 'parameter' => 'compatibility_override', 'type' => 'compatibility_override', 'noun' => 'ручное исключение'],
    ];

    public function __construct(private AdminActivityLogger $logger) {}

    public function handle(Request $request, Closure $next): Response
    {
        $actor = $request->user();
        $response = $next($request);

        if (! $actor || $response->getStatusCode() >= 400 || $request->session()->has('error') || $request->session()->has('errors')) {
            return $response;
        }

        $this->record($request, $actor);

        return $response;
    }

    private function record(Request $request, User $actor): void
    {
        $routeName = $request->route()?->getName();
        if (! $routeName || in_array($routeName, ['admin.logout', 'admin.users.sessions.destroy'], true)) {
            return;
        }

        if ($routeName === 'admin.profile.settings.update') {
            $this->logger->record($actor, AdminActivityLog::ACTION_UPDATED, 'Изменил личные данные', 'user', $actor->id, $actor->name);

            return;
        }

        if ($routeName === 'admin.profile.security.password.update') {
            $this->logger->record($actor, AdminActivityLog::ACTION_UPDATED, 'Изменил пароль своей учётной записи', 'user', $actor->id, $actor->name);

            return;
        }

        if ($routeName === 'admin.profile.security.sessions.destroy') {
            $this->logger->record($actor, AdminActivityLog::ACTION_SESSIONS_TERMINATED, 'Завершил свои другие сеансы', 'user', $actor->id, $actor->name);

            return;
        }

        if ($routeName === 'admin.fitments.configurations.update') {
            $this->recordFitmentConfigurations($request, $actor);

            return;
        }

        $operation = $this->operation($routeName);
        $resource = collect(self::RESOURCES)->first(fn (array $resource): bool => Str::startsWith($routeName, $resource['prefix']));
        if (! $operation || ! $resource) {
            return;
        }

        $subject = $resource['parameter'] ? $request->route($resource['parameter']) : null;
        $subjectId = $subject instanceof Model ? (int) $subject->getKey() : null;
        $subjectName = $this->subjectName($request, $subject);
        $description = $operation['verb'].' '.$resource['noun'].($subjectName ? ' «'.$subjectName.'»' : '');

        $this->logger->record($actor, $operation['action'], $description, $resource['type'], $subjectId, $subjectName);
    }

    /** @return array{action: string, verb: string}|null */
    private function operation(string $routeName): ?array
    {
        return match (true) {
            Str::endsWith($routeName, '.store') => ['action' => AdminActivityLog::ACTION_CREATED, 'verb' => 'Добавил'],
            Str::endsWith($routeName, '.update') => ['action' => AdminActivityLog::ACTION_UPDATED, 'verb' => 'Изменил'],
            Str::endsWith($routeName, '.destroy') => ['action' => AdminActivityLog::ACTION_DELETED, 'verb' => 'Удалил'],
            default => null,
        };
    }

    private function subjectName(Request $request, mixed $subject): ?string
    {
        if ($subject instanceof Model) {
            return (string) ($subject->getAttribute('name')
                ?? $subject->getAttribute('display_name')
                ?? ($subject->getKey() ? '#'.$subject->getKey() : null));
        }

        $name = $request->input('name') ?? $request->input('display_name');

        return filled($name) ? Str::limit((string) $name, 255, '') : null;
    }

    private function recordFitmentConfigurations(Request $request, User $actor): void
    {
        $fitment = $request->route('fitment');
        $count = count($request->input('configuration_ids', []));
        $description = match ($request->input('action')) {
            'add' => 'Добавил автомобили в группу применяемости',
            'remove' => 'Удалил автомобили из группы применяемости',
            'save_parameters' => 'Изменил монтажные параметры группы применяемости',
            default => 'Изменил автомобили группы применяемости',
        };
        $description .= ' «'.$fitment->name.'»'.($count > 0 ? ' ('.$count.')' : '');

        $this->logger->record(
            $actor,
            AdminActivityLog::ACTION_UPDATED,
            $description,
            'fitment',
            (int) $fitment->id,
            $fitment->name,
        );
    }
}
