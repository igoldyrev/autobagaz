<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBreadcrumbsTest extends TestCase
{
    use RefreshDatabase;

    public function test_breadcrumbs_are_shown_on_an_internal_admin_page(): void
    {
        $admin = $this->superAdmin();

        $this->actingAs($admin)
            ->get(route('admin.profile.settings.edit'))
            ->assertOk()
            ->assertSee('admin-global-breadcrumbs', false)
            ->assertSee('admin-section-nav', false)
            ->assertSee('Главная')
            ->assertSee('Профиль');
    }

    public function test_breadcrumbs_are_hidden_on_the_admin_dashboard(): void
    {
        $this->actingAs($this->superAdmin())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Статистика по товарам')
            ->assertSee('Требует внимания')
            ->assertSee('Быстрые действия')
            ->assertSee('Последние изменения')
            ->assertDontSee('admin-global-breadcrumbs', false);
    }

    public function test_product_manufacturer_breadcrumbs_link_to_the_product_section(): void
    {
        $this->actingAs($this->superAdmin())
            ->get(route('admin.products.ski-racks.manufacturers.index'))
            ->assertOk()
            ->assertSee('Лыжные крепления')
            ->assertSee(route('admin.products.ski-racks.index'), false)
            ->assertSee('Производители');
    }

    private function superAdmin(): User
    {
        return User::factory()->create([
            'is_admin' => true,
            'role' => User::ROLE_SUPER_ADMIN,
            'permissions' => null,
        ]);
    }
}
