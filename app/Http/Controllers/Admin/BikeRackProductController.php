<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BikeRackProductRequest;
use App\Models\BikeRackManufacturer;
use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\ProductType;
use App\Services\ProductImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BikeRackProductController extends Controller
{
    private const CHARACTERISTIC_FIELDS = ['manufacturer_id', 'mounting_type', 'bike_capacity', 'load_capacity_kg'];

    public function __construct(private ProductImageService $images) {}

    public function index(Request $request): View
    {
        $products = Product::query()
            ->whereHas('bikeRack')
            ->with(['images', 'bikeRack.manufacturer'])
            ->when($request->string('search')->isNotEmpty(), fn ($query) => $query->where('name', 'like', '%'.$request->string('search').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status') === 'active'))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.bike-rack-products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.bike-rack-products.create', $this->formData());
    }

    public function store(BikeRackProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $product = DB::transaction(function () use ($data, $request): Product {
            $product = Product::query()->create([
                ...Arr::except($data, ['images', 'remove_image_ids', ...self::CHARACTERISTIC_FIELDS]),
                'product_type_id' => ProductType::query()->where('code', 'bike_rack')->value('id'),
            ]);
            $product->bikeRack()->create(Arr::only($data, self::CHARACTERISTIC_FIELDS));
            $product->categories()->sync([$this->rootCategory()->id]);
            $this->images->store($product, $request->file('images', []));

            return $product;
        });

        return redirect()->route('admin.products.bike-racks.edit', $product)->with('success', 'Велокрепление добавлено.');
    }

    public function edit(Product $product): View
    {
        abort_unless($product->bikeRack()->exists(), 404);
        $product->load(['images', 'bikeRack.manufacturer']);

        return view('admin.bike-rack-products.edit', [...$this->formData(), 'product' => $product]);
    }

    public function update(BikeRackProductRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->bikeRack()->exists(), 404);
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $product): void {
            $product->update(Arr::except($data, ['images', 'remove_image_ids', ...self::CHARACTERISTIC_FIELDS]));
            $product->update(['product_type_id' => ProductType::query()->where('code', 'bike_rack')->value('id')]);
            $product->bikeRack()->updateOrCreate([], Arr::only($data, self::CHARACTERISTIC_FIELDS));
            $product->categories()->sync([$this->rootCategory()->id]);
            $this->images->remove($product, $data['remove_image_ids']);
            $this->images->store($product, $request->file('images', []));
        });

        return back()->with('success', 'Изменения велокрепления сохранены.');
    }

    private function rootCategory(): CatalogCategory
    {
        return CatalogCategory::query()->whereNull('parent_id')->where('slug', 'velokrepleniya')->firstOrFail();
    }

    private function formData(): array
    {
        return ['bikeRackManufacturers' => BikeRackManufacturer::query()->orderBy('name')->get()];
    }
}
