<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CatalogCategoryRequest;
use App\Models\CatalogCategory;
use App\Services\VehicleImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class CatalogCategoryController extends Controller
{
    public function __construct(private VehicleImageService $images) {}

    public function index(Request $request): View
    {
        $categories = CatalogCategory::query()
            ->with('parent')
            ->withCount(['children', 'products'])
            ->when($request->string('search')->isNotEmpty(), function ($query) use ($request): void {
                $search = '%'.$request->string('search').'%';
                $query->where(fn ($query) => $query->where('name', 'like', $search)->orWhere('slug', 'like', $search));
            })
            ->orderByRaw('parent_id IS NOT NULL')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(40)
            ->withQueryString();

        return view('admin.catalog-categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parents = $this->parentOptions();
        $nextSortOrder = ((int) CatalogCategory::query()->max('sort_order')) + 1;

        return view('admin.catalog-categories.create', compact('parents', 'nextSortOrder'));
    }

    public function store(CatalogCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $category = CatalogCategory::query()->create([
            ...Arr::except($data, ['image']),
            'image_path' => $this->images->store($request->file('image'), 'catalog-categories'),
        ]);

        return redirect()
            ->route('admin.catalog-categories.edit', $category)
            ->with('success', 'Раздел или категория добавлены.');
    }

    public function edit(CatalogCategory $catalogCategory): View
    {
        $parents = $this->parentOptions($catalogCategory);

        return view('admin.catalog-categories.edit', compact('catalogCategory', 'parents'));
    }

    public function update(CatalogCategoryRequest $request, CatalogCategory $catalogCategory): RedirectResponse
    {
        $data = $request->validated();

        if ($data['parent_id'] && in_array((int) $data['parent_id'], $this->descendantIds($catalogCategory), true)) {
            return back()->withInput()->withErrors(['parent_id' => 'Нельзя перенести категорию внутрь её дочерней категории.']);
        }

        $catalogCategory->update([
            ...Arr::except($data, ['image']),
            'image_path' => $this->images->store(
                $request->file('image'),
                'catalog-categories',
                $catalogCategory->image_path,
            ),
        ]);

        return back()->with('success', 'Изменения категории сохранены.');
    }

    private function parentOptions(?CatalogCategory $excluded = null)
    {
        $excludedIds = $excluded ? $this->descendantIds($excluded) : [];

        return CatalogCategory::query()
            ->when($excluded, fn ($query) => $query->whereKeyNot($excluded->id)->whereNotIn('id', $excludedIds))
            ->orderByRaw('parent_id IS NOT NULL')
            ->orderBy('name')
            ->get();
    }

    /** @return array<int> */
    private function descendantIds(CatalogCategory $category): array
    {
        $ids = [];
        $pending = [$category->id];

        while ($pending !== []) {
            $children = CatalogCategory::query()->whereIn('parent_id', $pending)->pluck('id')->all();
            $ids = [...$ids, ...$children];
            $pending = $children;
        }

        return $ids;
    }
}
