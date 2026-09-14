@php
    $routeName = request()->route()?->getName() ?? '';
    $items = [['label' => 'Главная', 'url' => route('admin.dashboard')]];

    if (str_starts_with($routeName, 'admin.products.')) {
        $items[] = ['label' => 'Товары', 'url' => route('admin.products.index')];

        $productSections = [
            'admin.products.roof-racks.' => ['label' => 'Автобагажники', 'url' => route('admin.products.roof-racks.index')],
            'admin.products.auto-boxes.' => ['label' => 'Автомобильные боксы', 'url' => route('admin.products.auto-boxes.index')],
            'admin.products.bike-racks.' => ['label' => 'Велокрепления', 'url' => route('admin.products.bike-racks.index')],
            'admin.products.ski-racks.' => ['label' => 'Лыжные крепления', 'url' => route('admin.products.ski-racks.index')],
        ];

        foreach ($productSections as $prefix => $section) {
            if (str_starts_with($routeName, $prefix)) {
                $items[] = $section;

                if (str_contains($routeName, '.manufacturers.')) {
                    $items[] = ['label' => 'Производители', 'url' => route($prefix.'manufacturers.index')];
                }

                break;
            }
        }
    } elseif (str_starts_with($routeName, 'admin.catalog-categories.')) {
        $items[] = ['label' => 'Разделы и категории', 'url' => route('admin.catalog-categories.index')];
    } elseif (str_starts_with($routeName, 'admin.vehicles.')) {
        $items[] = ['label' => 'Автомобили', 'url' => route('admin.vehicles.vehicle-makes.index')];

        $vehicleSections = [
            'admin.vehicles.vehicle-body-styles.' => ['Кузова', 'admin.vehicles.vehicle-body-styles.index'],
            'admin.vehicles.vehicle-roof-types.' => ['Типы крыши', 'admin.vehicles.vehicle-roof-types.index'],
            'admin.vehicles.vehicle-makes.vehicle-models.vehicle-generations.vehicle-configurations.' => ['Комплектации', null],
            'admin.vehicles.vehicle-makes.vehicle-models.vehicle-generations.' => ['Поколения', null],
            'admin.vehicles.vehicle-makes.vehicle-models.' => ['Модели', null],
            'admin.vehicles.vehicle-makes.' => ['Марки автомобилей', 'admin.vehicles.vehicle-makes.index'],
        ];

        foreach ($vehicleSections as $prefix => [$label, $indexRoute]) {
            if (str_starts_with($routeName, $prefix)) {
                $items[] = ['label' => $label, 'url' => $indexRoute ? route($indexRoute) : null];
                break;
            }
        }
    } elseif (str_starts_with($routeName, 'admin.fitments.')) {
        $items[] = ['label' => 'Совместимость', 'url' => route('admin.fitments.index')];
    } elseif ($routeName === 'admin.compatibility.preview') {
        $items[] = ['label' => 'Совместимость', 'url' => route('admin.fitments.index')];
        $items[] = ['label' => 'Проверка совместимости', 'url' => null];
    } elseif (str_starts_with($routeName, 'admin.compatibility-overrides.')) {
        $items[] = ['label' => 'Совместимость', 'url' => route('admin.fitments.index')];
        $items[] = ['label' => 'Исключения совместимости', 'url' => route('admin.compatibility-overrides.index')];
    } elseif (str_starts_with($routeName, 'admin.users.')) {
        $items[] = ['label' => 'Пользователи', 'url' => route('admin.users.index')];
    } elseif ($routeName === 'admin.activity.index') {
        $items[] = ['label' => 'Пользователи', 'url' => route('admin.users.index')];
        $items[] = ['label' => 'Журнал действий', 'url' => null];
    } elseif (str_starts_with($routeName, 'admin.profile.')) {
        $items[] = ['label' => 'Профиль', 'url' => route('admin.profile.show')];
    }

    if (str_ends_with($routeName, '.create')) {
        $items[] = ['label' => 'Создание', 'url' => null];
    } elseif (str_ends_with($routeName, '.edit')) {
        $items[] = ['label' => 'Редактирование', 'url' => null];
    } elseif (str_ends_with($routeName, '.configurations')) {
        $items[] = ['label' => 'Комплектации', 'url' => null];
    } elseif (str_starts_with($routeName, 'admin.fitments.') && str_ends_with($routeName, '.preview')) {
        $items[] = ['label' => 'Проверка', 'url' => null];
    }
@endphp

<nav class="admin-breadcrumbs admin-global-breadcrumbs" aria-label="Хлебные крошки">
    @foreach ($items as $index => $item)
        @if ($index > 0)
            <span aria-hidden="true">/</span>
        @endif

        @if ($loop->last || empty($item['url']))
            <span aria-current="page">{{ $item['label'] }}</span>
        @else
            <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
        @endif
    @endforeach
</nav>
