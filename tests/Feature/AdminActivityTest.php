<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\User;
use App\Models\VehicleBodyStyle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_view_activity_log_but_cannot_terminate_user_sessions(): void
    {
        $administrator = User::factory()->create([
            'is_admin' => true,
            'role' => User::ROLE_ADMINISTRATOR,
            'permissions' => User::roleDefaultPermissions()[User::ROLE_ADMINISTRATOR],
        ]);
        $target = User::factory()->create(['is_admin' => true]);

        $this->actingAs($administrator)->get(route('admin.activity.index'))->assertOk();
        $this->actingAs($administrator)->delete(route('admin.users.sessions.destroy', $target))->assertForbidden();
    }

    public function test_admin_presence_is_recorded_and_throttled(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $firstSeenAt = $admin->fresh()->last_seen_at;

        $this->assertNotNull($firstSeenAt);

        $this->get(route('admin.dashboard'))->assertOk();
        $this->assertTrue($admin->fresh()->last_seen_at->equalTo($firstSeenAt));
    }

    public function test_successful_admin_change_is_written_to_activity_log(): void
    {
        $admin = $this->superAdmin();

        $this->actingAs($admin)->post(route('admin.vehicles.vehicle-body-styles.store'), [
            'name' => 'Тестовый кузов',
            'slug' => 'test-body',
            'sort_order' => 1,
            'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();

        $style = VehicleBodyStyle::query()->where('slug', 'test-body')->firstOrFail();
        $this->assertDatabaseHas('admin_activity_logs', [
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => AdminActivityLog::ACTION_CREATED,
            'subject_type' => 'vehicle_body_style',
            'subject_name' => 'Тестовый кузов',
            'description' => 'Добавил тип кузова «Тестовый кузов»',
        ]);

        $this->actingAs($admin)->put(route('admin.vehicles.vehicle-body-styles.update', $style), [
            'name' => 'Обновлённый кузов',
            'slug' => 'test-body',
            'sort_order' => 1,
            'is_active' => '1',
        ])->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('admin_activity_logs', [
            'action' => AdminActivityLog::ACTION_UPDATED,
            'subject_id' => $style->id,
            'subject_name' => 'Обновлённый кузов',
            'description' => 'Изменил тип кузова «Обновлённый кузов»',
        ]);
    }

    public function test_activity_log_can_be_filtered_and_is_visible_in_users_section(): void
    {
        $admin = $this->superAdmin();
        $other = User::factory()->create(['is_admin' => true, 'name' => 'Другой сотрудник']);
        AdminActivityLog::query()->create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => AdminActivityLog::ACTION_CREATED,
            'subject_type' => 'roof_rack',
            'subject_name' => 'Нужная запись',
            'description' => 'Добавил автобагажник «Нужная запись»',
        ]);
        AdminActivityLog::query()->create([
            'user_id' => $other->id,
            'user_name' => $other->name,
            'action' => AdminActivityLog::ACTION_DELETED,
            'subject_type' => 'catalog_category',
            'subject_name' => 'Лишняя запись',
            'description' => 'Удалил категорию «Лишняя запись»',
        ]);

        $this->actingAs($admin)->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Журнал действий')
            ->assertSee('Последняя активность');

        $this->get(route('admin.activity.index', [
            'user_id' => $admin->id,
            'action' => AdminActivityLog::ACTION_CREATED,
            'subject_type' => 'roof_rack',
        ]))
            ->assertOk()
            ->assertSee('Нужная запись')
            ->assertDontSee('Лишняя запись')
            ->assertSee('Что попадает в журнал');
    }

    public function test_super_administrator_can_terminate_another_users_sessions(): void
    {
        $admin = $this->superAdmin();
        $target = User::factory()->create([
            'is_admin' => true,
            'name' => 'Контент-менеджер',
            'remember_token' => 'old-token',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.users.sessions.destroy', $target))
            ->assertRedirect()
            ->assertSessionHas('success');

        $target->refresh();
        $this->assertNotNull($target->sessions_invalidated_at);
        $this->assertNotSame('old-token', $target->remember_token);
        $this->assertDatabaseHas('admin_activity_logs', [
            'action' => AdminActivityLog::ACTION_SESSIONS_TERMINATED,
            'subject_id' => $target->id,
            'description' => 'Завершил все сеансы пользователя «Контент-менеджер»',
        ]);

        $this->actingAs($target)
            ->withSession(['admin_authenticated_at' => now()->subMinute()->timestamp])
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_super_administrator_cannot_terminate_current_session_from_user_card(): void
    {
        $admin = $this->superAdmin();

        $this->actingAs($admin)
            ->delete(route('admin.users.sessions.destroy', $admin))
            ->assertUnprocessable();
    }

    public function test_old_activity_records_can_be_pruned_after_retention_period(): void
    {
        $admin = $this->superAdmin();
        $old = AdminActivityLog::query()->create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => AdminActivityLog::ACTION_UPDATED,
            'description' => 'Старая запись',
        ]);
        $recent = AdminActivityLog::query()->create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'action' => AdminActivityLog::ACTION_UPDATED,
            'description' => 'Свежая запись',
        ]);
        $old->forceFill(['created_at' => now()->subDays(181)])->saveQuietly();

        AdminActivityLog::query()->olderThanRetentionPeriod()->delete();

        $this->assertDatabaseMissing('admin_activity_logs', ['id' => $old->id]);
        $this->assertDatabaseHas('admin_activity_logs', ['id' => $recent->id]);
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
