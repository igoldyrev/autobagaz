<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoofRackProductRequest;
use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\RoofRackManufacturer;
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
            ->withCount(['categories', 'fitments'])
            ->when($request->string('search')->isNotEmpty(), function ($query) use ($request): void {
                $query->where('name', 'like', '%'.$request->string('search').'%');
            })
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status') === 'active'))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.create', $this->formData());
    }

    public function store(RoofRackProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $product = DB::transaction(function () use ($data, $request): Product {
            $product = Product::query()->create([
                ...Arr::except($data, [
                    'category_ids', 'images', 'remove_image_ids', ...self::CHARACTERISTIC_FIELDS,
                ]),
                'product_type_id' => ProductType::query()->where('code', 'roof_rack')->value('id'),
            ]);
            $product->roofRack()->create(Arr::only($data, self::CHARACTERISTIC_FIELDS));
            $this->syncCategories($product, $data['category_ids']);
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
        $product->load(['images', 'categories', 'roofRack.manufacturer', 'fitments']);

        return view('admin.products.edit', [...$this->formData(), 'product' => $product]);
    }

    public function update(RoofRackProductRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->roofRack()->exists(), 404);
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $product): void {
            $product->update(Arr::except($data, [
                'category_ids', 'images', 'remove_image_ids', ...self::CHARACTERISTIC_FIELDS,
            ]));
            $product->update(['product_type_id' => ProductType::query()->where('code', 'roof_rack')->value('id')]);
            $product->roofRack()->updateOrCreate([], Arr::only($data, self::CHARACTERISTIC_FIELDS));
            $this->syncCategories($product, $data['category_ids']);
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
            'roofRackManufacturers' => RoofRackManufacturer::query()->orderBy('name')->get(),
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
