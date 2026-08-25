<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_administrator_can_view_users(): void
    {
        $superAdmin = $this->superAdmin();

        $this->actingAs($superAdmin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Пользователи')
            ->assertSee($superAdmin->email);
    }

    public function test_last_login_time_is_displayed_in_yekaterinburg_timezone(): void
    {
        $superAdmin = $this->superAdmin();

        DB::table('users')->where('id', $superAdmin->id)->update([
            'last_login_at' => '2026-08-25 10:00:00',
        ]);

        $this->actingAs($superAdmin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('25.08.2026 15:00');
    }

    public function test_regular_administrator_cannot_manage_users(): void
    {
        $administrator = User::factory()->create([
            'is_admin' => true,
            'role' => User::ROLE_ADMINISTRATOR,
            'permissions' => User::roleDefaultPermissions()[User::ROLE_ADMINISTRATOR],
        ]);

        $this->actingAs($administrator)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_super_administrator_can_create_user_with_individual_permissions(): void
    {
        $this->actingAs($this->superAdmin())
            ->post(route('admin.users.store'), [
                'name' => 'Менеджер каталога',
                'email' => 'manager@example.com',
                'role' => User::ROLE_CONTENT_MANAGER,
                'permissions' => [User::PERMISSION_PRODUCTS],
                'password' => 'strong-password',
                'password_confirmation' => 'strong-password',
            ])
            ->assertRedirect(route('admin.users.index'));

        $manager = User::query()->where('email', 'manager@example.com')->firstOrFail();

        $this->assertTrue($manager->is_admin);
        $this->assertSame([User::PERMISSION_PRODUCTS], $manager->permissions);
        $this->assertTrue(Hash::check('strong-password', $manager->password));
    }

    public function test_individual_permissions_are_enforced(): void
    {
        $manager = User::factory()->create([
            'is_admin' => true,
            'role' => User::ROLE_CONTENT_MANAGER,
            'permissions' => [User::PERMISSION_PRODUCTS],
        ]);

        $this->actingAs($manager)
            ->get(route('admin.products.index'))
            ->assertOk();

        $this->actingAs($manager)
            ->get(route('admin.catalog-categories.index'))
            ->assertForbidden();
    }

    public function test_only_super_administrator_cannot_be_demoted(): void
    {
        $superAdmin = $this->superAdmin();

        $this->actingAs($superAdmin)
            ->from(route('admin.users.edit', $superAdmin))
            ->put(route('admin.users.update', $superAdmin), [
                'name' => $superAdmin->name,
                'email' => $superAdmin->email,
                'role' => User::ROLE_ADMINISTRATOR,
                'permissions' => User::roleDefaultPermissions()[User::ROLE_ADMINISTRATOR],
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertRedirect(route('admin.users.edit', $superAdmin))
            ->assertSessionHasErrors('role');

        $this->assertTrue($superAdmin->fresh()->isSuperAdmin());
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
