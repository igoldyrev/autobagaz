<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AutoBoxProductRequest;
use App\Models\AutoBoxManufacturer;
use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\ProductType;
use App\Services\ProductImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AutoBoxProductController extends Controller
{
    private const CHARACTERISTIC_FIELDS = [
        'manufacturer_id',
        'length_cm',
        'width_cm',
        'height_cm',
        'volume_l',
        'load_capacity_kg',
        'opening_type',
        'mounting_type',
        'box_color',
    ];

    public function __construct(private ProductImageService $images) {}

    public function index(Request $request): View
    {
        $products = Product::query()
            ->whereHas('autoBox')
            ->with(['images', 'autoBox.manufacturer'])
            ->when($request->string('search')->isNotEmpty(), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status') === 'active'))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.auto-box-products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.auto-box-products.create', $this->formData());
    }

    public function store(AutoBoxProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $product = DB::transaction(function () use ($data, $request): Product {
            $product = Product::query()->create([
                ...Arr::except($data, ['images', 'remove_image_ids', ...self::CHARACTERISTIC_FIELDS]),
                'product_type_id' => ProductType::query()->where('code', 'roof_box')->value('id'),
            ]);
            $product->autoBox()->create(Arr::only($data, self::CHARACTERISTIC_FIELDS));
            $product->categories()->sync([$this->rootCategory()->id]);
            $this->images->store($product, $request->file('images', []));

            return $product;
        });

        return redirect()->route('admin.products.auto-boxes.edit', $product)->with('success', 'Автомобильный бокс добавлен.');
    }

    public function edit(Product $product): View
    {
        abort_unless($product->autoBox()->exists(), 404);
        $product->load(['images', 'autoBox.manufacturer']);

        return view('admin.auto-box-products.edit', [...$this->formData(), 'product' => $product]);
    }

    public function update(AutoBoxProductRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->autoBox()->exists(), 404);
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $product): void {
            $product->update(Arr::except($data, ['images', 'remove_image_ids', ...self::CHARACTERISTIC_FIELDS]));
            $product->update(['product_type_id' => ProductType::query()->where('code', 'roof_box')->value('id')]);
            $product->autoBox()->updateOrCreate([], Arr::only($data, self::CHARACTERISTIC_FIELDS));
            $product->categories()->sync([$this->rootCategory()->id]);
            $this->images->remove($product, $data['remove_image_ids']);
            $this->images->store($product, $request->file('images', []));
        });

        return back()->with('success', 'Изменения автомобильного бокса сохранены.');
    }

    private function rootCategory(): CatalogCategory
    {
        return CatalogCategory::query()->whereNull('parent_id')->where('slug', 'autobox')->firstOrFail();
    }

    private function formData(): array
    {
        return [
            'autoBoxManufacturers' => AutoBoxManufacturer::query()->orderBy('name')->get(),
        ];
    }
}
