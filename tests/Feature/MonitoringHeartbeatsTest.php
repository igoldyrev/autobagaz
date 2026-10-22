<?php

namespace Tests\Feature;

use App\Models\OrderNotification;
use App\Services\MonitoringHeartbeats;
use App\Services\OrderNotifications;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonitoringHeartbeatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_detects_missing_stale_and_recovered_tasks_without_refreshing_them(): void
    {
        config(['services.daily_brief.token' => 'test-token']);
        $this->freezeTime();
        $url = route('internal.monitoring.project-snapshot');
        $this->withToken('test-token')->getJson($url)->assertOk()
            ->assertJsonPath('state', 'degraded')
            ->assertJsonPath('scheduled_tasks.tasks.scheduler.state', 'never');
        $this->assertDatabaseCount('monitoring_heartbeats', 0);

        $this->succeedAll();
        $this->withToken('test-token')->getJson($url)->assertOk()->assertJsonPath('state', 'ok');
        $this->travel(180)->seconds();
        $this->withToken('test-token')->getJson($url)->assertOk()
            ->assertJsonPath('state', 'degraded')
            ->assertJsonPath('scheduled_tasks.tasks.scheduler.state', 'stale')
            ->assertJsonPath('scheduled_tasks.tasks.notification_monitor.state', 'ok');
        $this->succeedAll();
        $this->withToken('test-token')->getJson($url)->assertOk()->assertJsonPath('state', 'ok');
    }

    public function test_only_successful_dispatch_updates_heartbeat(): void
    {
        $this->artisan('orders:dispatch-notifications')->assertSuccessful();
        $previous = app(MonitoringHeartbeats::class)->snapshot()['tasks']['dispatch_notifications']['last_succeeded_at'];
        $this->travel(5)->minutes();
        OrderNotification::query()->create(['type' => 'order_created', 'recipient' => 'private@example.test']);
        $this->mock(OrderNotifications::class)->shouldReceive('dispatchPending')->once()->andReturn(0);
        $this->artisan('orders:dispatch-notifications')->assertFailed();
        $this->assertSame($previous, app(MonitoringHeartbeats::class)->snapshot()['tasks']['dispatch_notifications']['last_succeeded_at']);
    }

    public function test_scheduler_records_its_own_heartbeat(): void
    {
        $events = collect(app(Schedule::class)->events());
        $event = $events->first(fn ($event) => $event->description === 'monitoring:scheduler-heartbeat');
        $this->assertNotNull($event);
        $event->run($this->app);
        $this->assertSame('ok', app(MonitoringHeartbeats::class)->snapshot()['tasks']['scheduler']['state']);
    }

    public function test_delivery_summary_counts_sent_notifications_for_requested_day(): void
    {
        config(['services.daily_brief.token' => 'test-token']);
        $this->travelTo(Carbon::parse('2026-10-22T12:00:00+05:00'));
        foreach (['order_created', 'order_created', 'order_confirmation', 'callback_requested'] as $type) {
            OrderNotification::query()->create(['type' => $type, 'recipient' => 'private@example.test', 'sent_at' => now()]);
        }
        OrderNotification::query()->create(['type' => 'order_created', 'recipient' => 'private@example.test', 'sent_at' => now()->subDay()]);
        OrderNotification::query()->create(['type' => 'order_created', 'recipient' => 'private@example.test']);
        $response = $this->withToken('test-token')->getJson(route('internal.monitoring.project-snapshot'));
        $response->assertOk()->assertJsonPath('delivery.sent_for_day.total', 4)
            ->assertJsonPath('delivery.sent_for_day.order_created', 2)
            ->assertJsonPath('delivery.sent_for_day.callback_requested', 1)
            ->assertJsonPath('delivery.last_sent_at', '2026-10-22T07:00:00+00:00');
        $this->assertStringNotContainsString('private@example.test', $response->getContent());
        $this->withToken('test-token')->getJson(route('internal.monitoring.project-snapshot', ['date' => '2026-10-21']))
            ->assertOk()->assertJsonPath('delivery.sent_for_day.total', 1);
    }

    private function succeedAll(): void
    {
        foreach (array_keys(MonitoringHeartbeats::TASKS) as $task) {
            app(MonitoringHeartbeats::class)->succeed($task);
        }
    }
}
