<?php

namespace Tests\Feature;

use App\Models\CatalogCategory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCatalogCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_category_admin_is_protected(): void
    {
        $this->get(route('admin.catalog-categories.index'))->assertRedirect(route('login'));
    }

    public function test_administrator_can_create_nested_category(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $parent = CatalogCategory::query()->where('slug', 'autobagazhniki')->firstOrFail();

        $response = $this->actingAs($admin)->post(route('admin.catalog-categories.store'), [
            'parent_id' => $parent->id,
            'kind' => 'category',
            'name' => 'Новая категория',
            'slug' => '',
            'sort_order' => 10,
            'is_active' => '1',
        ]);

        $response->assertSessionDoesntHaveErrors();
        $category = CatalogCategory::query()->where('slug', 'novaia-kategoriia')->firstOrFail();
        $this->assertSame($parent->id, $category->parent_id);
        $this->assertTrue($category->is_active);
    }

    public function test_hiding_category_preserves_product_links(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = CatalogCategory::query()->where('slug', 'bagazhniki-aps')->firstOrFail();
        $product = Product::query()->create([
            'name' => 'Товар',
            'slug' => 'product',
            'price' => 100,
            'is_active' => true,
        ]);
        $product->categories()->attach($category);

        $this->actingAs($admin)->put(route('admin.catalog-categories.update', $category), [
            'parent_id' => $category->parent_id,
            'kind' => $category->kind,
            'name' => $category->name,
            'slug' => $category->slug,
            'sort_order' => $category->sort_order,
        ])->assertRedirect();

        $this->assertFalse($category->fresh()->is_active);
        $this->assertTrue($product->categories()->whereKey($category->id)->exists());
        $this->get(route('catalog.autobagazhniki.show', $category->slug))->assertNotFound();
    }

    public function test_category_cannot_be_moved_inside_its_descendant(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $parent = CatalogCategory::query()->where('slug', 'autobagazhniki')->firstOrFail();
        $child = CatalogCategory::query()->create([
            'parent_id' => $parent->id,
            'kind' => 'category',
            'name' => 'Child',
            'slug' => 'child',
        ]);

        $this->actingAs($admin)->put(route('admin.catalog-categories.update', $parent), [
            'parent_id' => $child->id,
            'kind' => 'section',
            'name' => $parent->name,
            'slug' => $parent->slug,
            'sort_order' => 0,
            'is_active' => '1',
        ])->assertSessionHasErrors('parent_id');

        $this->assertNull($parent->fresh()->parent_id);
    }
}
