<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkiRackProductRequest;
use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\SkiRackManufacturer;
use App\Services\ProductImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SkiRackProductController extends Controller
{
    private const FIELDS = ['manufacturer_id', 'ski_pairs_capacity', 'snowboard_capacity'];

    public function __construct(private ProductImageService $images) {}

    public function index(Request $request): View
    {
        $products = Product::query()->whereHas('skiRack')->with(['images', 'skiRack.manufacturer'])->when($request->string('search')->isNotEmpty(), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))->when($request->filled('status'), fn ($q) => $q->where('is_active', $request->string('status') === 'active'))->latest()->paginate(30)->withQueryString();

        return view('admin.ski-rack-products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.ski-rack-products.create', $this->formData());
    }

    public function store(SkiRackProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $product = DB::transaction(function () use ($data, $request) {
            $p = Product::query()->create([...Arr::except($data, ['images', 'remove_image_ids', ...self::FIELDS]), 'product_type_id' => ProductType::query()->where('code', 'ski_rack')->value('id')]);
            $p->skiRack()->create(Arr::only($data, self::FIELDS));
            $p->categories()->sync([$this->root()->id]);
            $this->images->store($p, $request->file('images', []));

            return $p;
        });

        return redirect()->route('admin.products.ski-racks.edit', $product)->with('success', 'Крепление добавлено.');
    }

    public function edit(Product $product): View
    {
        abort_unless($product->skiRack()->exists(), 404);
        $product->load(['images', 'skiRack.manufacturer']);

        return view('admin.ski-rack-products.edit', [...$this->formData(), 'product' => $product]);
    }

    public function update(SkiRackProductRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->skiRack()->exists(), 404);
        $data = $request->validated();
        DB::transaction(function () use ($data, $request, $product): void {
            $product->update(Arr::except($data, ['images', 'remove_image_ids', ...self::FIELDS]));
            $product->update(['product_type_id' => ProductType::query()->where('code', 'ski_rack')->value('id')]);
            $product->skiRack()->updateOrCreate([], Arr::only($data, self::FIELDS));
            $product->categories()->sync([$this->root()->id]);
            $this->images->remove($product, $data['remove_image_ids']);
            $this->images->store($product, $request->file('images', []));
        });

        return back()->with('success', 'Изменения крепления сохранены.');
    }

    private function root(): CatalogCategory
    {
        return CatalogCategory::query()->whereNull('parent_id')->where('slug', 'krepleniya-dlya-lyzh-i-snoubordov')->firstOrFail();
    }

    private function formData(): array
    {
        return ['skiRackManufacturers' => SkiRackManufacturer::query()->orderBy('name')->get()];
    }
}
