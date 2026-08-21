<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoofRackProductRequest;
use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\RoofRackManufacturer;
use App\Models\VehicleMake;
use App\Services\ProductImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RoofRackProductController extends Controller
{
    private const CHARACTERISTIC_FIELDS = [
        'manufacturer_id',
        'bar_length_cm',
        'load_capacity_kg',
        'installation_method',
        'bar_type',
        'rack_color',
    ];

    public function __construct(private ProductImageService $images) {}

    public function index(Request $request): View
    {
        $products = Product::query()
            ->whereHas('roofRack')
            ->with(['images', 'roofRack.manufacturer'])
            ->withCount(['categories', 'vehicleModels', 'vehicleBodyTypes'])
            ->when($request->string('search')->isNotEmpty(), function ($query) use ($request): void {
                $query->where('name', 'like', '%'.$request->string('search').'%');
            })
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status') === 'active'))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create(Request $request): View
    {
        $fitmentCopySource = null;

        if ($request->filled('copy_fitment_from')) {
            $fitmentCopySource = Product::query()
                ->whereHas('roofRack')
                ->with(['vehicleModels:id', 'vehicleBodyTypes:id'])
                ->findOrFail($request->integer('copy_fitment_from'));
        }

        $fitmentCopyProducts = Product::query()
            ->whereHas('roofRack')
            ->withCount(['vehicleModels', 'vehicleBodyTypes'])
            ->latest()
            ->get(['id', 'name', 'created_at']);

        return view('admin.products.create', [
            ...$this->formData(),
            'fitmentCopyProducts' => $fitmentCopyProducts,
            'fitmentCopySource' => $fitmentCopySource,
        ]);
    }

    public function store(RoofRackProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $product = DB::transaction(function () use ($data, $request): Product {
            $product = Product::query()->create(Arr::except($data, [
                'category_ids', 'vehicle_model_ids', 'vehicle_body_type_ids', 'compatibility_product_ids', 'images', 'remove_image_ids', ...self::CHARACTERISTIC_FIELDS,
            ]));
            $product->roofRack()->create(Arr::only($data, self::CHARACTERISTIC_FIELDS));
            $this->syncCategories($product, $data['category_ids']);
            $product->vehicleModels()->sync($data['vehicle_model_ids']);
            $product->vehicleBodyTypes()->sync($data['vehicle_body_type_ids']);
            $this->syncCompatibleAccessories($product, $data['compatibility_product_ids']);
            $this->images->store($product, $request->file('images', []));

            return $product;
        });

        return redirect()
            ->route('admin.products.roof-racks.edit', $product)
            ->with('success', 'Автобагажник добавлен.');
    }

    public function edit(Product $product): View
    {
        abort_unless($product->roofRack()->exists(), 404);
        $product->load(['images', 'categories', 'vehicleModels', 'vehicleBodyTypes', 'compatibleAccessories', 'roofRack.manufacturer']);

        return view('admin.products.edit', [...$this->formData(), 'product' => $product]);
    }

    public function update(RoofRackProductRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->roofRack()->exists(), 404);
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $product): void {
            $product->update(Arr::except($data, [
                'category_ids', 'vehicle_model_ids', 'vehicle_body_type_ids', 'compatibility_product_ids', 'images', 'remove_image_ids', ...self::CHARACTERISTIC_FIELDS,
            ]));
            $product->roofRack()->updateOrCreate([], Arr::only($data, self::CHARACTERISTIC_FIELDS));
            $this->syncCategories($product, $data['category_ids']);
            $product->vehicleModels()->sync($data['vehicle_model_ids']);
            $product->vehicleBodyTypes()->sync($data['vehicle_body_type_ids']);
            $this->syncCompatibleAccessories($product, $data['compatibility_product_ids']);
            $this->images->remove($product, $data['remove_image_ids']);
            $this->images->store($product, $request->file('images', []));
        });

        return back()->with('success', 'Изменения автобагажника сохранены.');
    }

    private function formData(): array
    {
        $rootCategory = $this->rootCategory();
        $categoryIds = $this->categoryTreeIds($rootCategory);

        return [
            'rootCategory' => $rootCategory,
            'categories' => CatalogCategory::query()->with('parent')->whereIn('id', $categoryIds)->orderBy('name')->get(),
            'vehicleMakes' => VehicleMake::query()
                ->with(['models' => fn ($query) => $query
                    ->orderBy('name')
                    ->with(['bodyTypes' => fn ($bodyTypes) => $bodyTypes->orderBy('sort_order')->orderBy('source_name')])])
                ->orderBy('name')
                ->get(),
            'roofRackManufacturers' => RoofRackManufacturer::query()->orderBy('name')->get(),
            'compatibleAccessories' => Product::query()
                ->whereHas('autoBox')
                ->with('autoBox.manufacturer')
                ->orderBy('name')
                ->get(),
        ];
    }

    /** @param array<int|string> $selectedIds */
    private function syncCategories(Product $product, array $selectedIds): void
    {
        $rootCategory = $this->rootCategory();
        $roofRackIds = $this->categoryTreeIds($rootCategory);
        $selectedRoofRackIds = array_values(array_intersect(array_map('intval', $selectedIds), $roofRackIds));
        $selectedRoofRackIds[] = $rootCategory->id;
        $otherCategoryIds = $product->categories()->whereNotIn('catalog_categories.id', $roofRackIds)->pluck('catalog_categories.id')->all();

        $product->categories()->sync(array_values(array_unique([...$otherCategoryIds, ...$selectedRoofRackIds])));
    }

    private function rootCategory(): CatalogCategory
    {
        return CatalogCategory::query()
            ->whereNull('parent_id')
            ->where('slug', 'autobagazhniki')
            ->firstOrFail();
    }

    /** @param array<int|string> $accessoryIds */
    private function syncCompatibleAccessories(Product $product, array $accessoryIds): void
    {
        $validIds = Product::query()
            ->whereIn('id', array_map('intval', $accessoryIds))
            ->whereHas('autoBox')
            ->pluck('id')
            ->all();

        $product->compatibleAccessories()->syncWithPivotValues($validIds, [
            'compatibility_type' => 'via_base_product',
        ]);
    }

    /** @return array<int> */
    private function categoryTreeIds(CatalogCategory $root): array
    {
        $ids = [$root->id];
        $pending = [$root->id];

        while ($pending !== []) {
            $children = CatalogCategory::query()->whereIn('parent_id', $pending)->pluck('id')->map(fn ($id): int => (int) $id)->all();
            $ids = [...$ids, ...$children];
            $pending = $children;
        }

        return $ids;
    }
}
