<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMonitoringReportTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        CarbonImmutable::setTestNow();

        parent::tearDown();
    }

    public function test_protected_endpoint_returns_admin_presence_and_changes_for_requested_day(): void
    {
        config(['services.daily_brief.token' => 'test-monitoring-token']);
        CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-09-04 12:00:00', 'Asia/Yekaterinburg'));

        $activeAdmin = User::factory()->create([
            'name' => 'Ирина',
            'is_admin' => true,
            'role' => User::ROLE_CONTENT_MANAGER,
            'last_login_at' => now()->subHours(3),
            'last_seen_at' => now()->subMinutes(18),
        ]);
        $idleAdmin = User::factory()->create([
            'name' => 'Алексей',
            'is_admin' => true,
            'role' => User::ROLE_ADMINISTRATOR,
            'last_seen_at' => now()->subHours(2),
        ]);
        User::factory()->create(['is_admin' => false]);

        $change = AdminActivityLog::query()->create([
            'user_id' => $activeAdmin->id,
            'user_name' => $activeAdmin->name,
            'action' => AdminActivityLog::ACTION_UPDATED,
            'subject_type' => 'auto_box',
            'subject_id' => 42,
            'subject_name' => 'Thule Motion XT',
            'description' => 'Изменил автомобильный бокс «Thule Motion XT»',
        ]);
        $change->forceFill(['created_at' => now()->subHour()])->saveQuietly();

        AdminActivityLog::query()->create([
            'user_id' => $activeAdmin->id,
            'user_name' => $activeAdmin->name,
            'action' => AdminActivityLog::ACTION_LOGIN,
            'description' => 'Вошёл в административную панель',
        ]);

        $response = $this->withToken('test-monitoring-token')->getJson(route(
            'internal.daily-brief.admin-activity',
            ['date' => '2026-09-04', 'limit' => 3],
        ));

        $response->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private')
            ->assertJsonPath('state', 'ok')
            ->assertJsonPath('period.timezone', 'Asia/Yekaterinburg')
            ->assertJsonCount(2, 'administrators')
            ->assertJsonPath('administrators.0.name', 'Ирина')
            ->assertJsonPath('administrators.0.changes_count', 1)
            ->assertJsonPath('administrators.0.changes.0.subject_name', 'Thule Motion XT')
            ->assertJsonPath('administrators.1.name', 'Алексей')
            ->assertJsonPath('administrators.1.changes_count', 0)
            ->assertJsonCount(0, 'administrators.1.changes');

        $this->assertNotNull($idleAdmin);
    }

    public function test_monitoring_endpoint_requires_configured_valid_token(): void
    {
        config(['services.daily_brief.token' => null]);
        $this->getJson(route('internal.daily-brief.admin-activity'))->assertServiceUnavailable();

        config(['services.daily_brief.token' => 'expected-token']);
        $this->getJson(route('internal.daily-brief.admin-activity'))->assertUnauthorized();
        $this->withToken('wrong-token')
            ->getJson(route('internal.daily-brief.admin-activity'))
            ->assertUnauthorized();
    }

    public function test_artisan_command_outputs_same_report_without_http_credentials(): void
    {
        User::factory()->create(['name' => 'Администратор', 'is_admin' => true]);

        $this->artisan('monitoring:admin-summary', ['--date' => now()->toDateString(), '--limit' => 1])
            ->expectsOutputToContain('"administrators"')
            ->assertSuccessful();
    }
}
