<?php

namespace Tests\Feature;

use App\Services\AdminMonitoringReport;
use App\Services\MonitoringHeartbeats;
use App\Services\MonitoringInfrastructure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonitoringInfrastructureTest extends TestCase
{
    use RefreshDatabase;

    private string $statusPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->freezeTime();
        $this->statusPath = sys_get_temp_dir().'/backup-status-'.bin2hex(random_bytes(8)).'.json';
        config(['monitoring.backup_status_path' => $this->statusPath]);
    }

    protected function tearDown(): void
    {
        if (is_file($this->statusPath)) {
            unlink($this->statusPath);
        }
        parent::tearDown();
    }

    public function test_missing_stale_and_recovered_backup_changes_overall_report_state(): void
    {
        foreach (array_keys(MonitoringHeartbeats::TASKS) as $task) {
            app(MonitoringHeartbeats::class)->succeed($task);
        }
        $this->disk(2 * 1024 ** 3);
        $report = app(AdminMonitoringReport::class)->build();
        $this->assertSame('degraded', $report['state']);
        $this->assertSame('never', $report['infrastructure']['backup']['state']);
        $this->writeStatus(now()->subHours(36)->toIso8601String());
        $this->assertSame('stale', app(MonitoringInfrastructure::class)->snapshot()['backup']['state']);
        $this->writeStatus(now()->subHour()->toIso8601String());
        $this->assertSame('ok', app(AdminMonitoringReport::class)->build()['state']);
    }

    public function test_low_and_unreadable_disk_are_not_reported_as_healthy(): void
    {
        $this->writeStatus(now()->toIso8601String());
        foreach ([0 => 'low', 1024 ** 3 => 'ok'] as $bytes => $expected) {
            $this->disk($bytes);
            $this->assertSame($expected, app(MonitoringInfrastructure::class)->snapshot()['disk']['state']);
        }
        $this->disk(null);
        $this->assertSame('degraded', app(MonitoringInfrastructure::class)->snapshot()['state']);
        $this->assertSame('unknown', app(MonitoringInfrastructure::class)->snapshot()['disk']['state']);
    }

    public function test_invalid_and_future_timestamps_are_not_reported_as_a_recent_backup(): void
    {
        foreach (['invalid json', '{}', json_encode(['snapshot_at' => 'yesterday', 'last_verified_at' => 'today']), json_encode(['snapshot_at' => now()->addHour()->toIso8601String(), 'last_verified_at' => now()->toIso8601String()]), json_encode(['snapshot_at' => now()->toIso8601String(), 'last_verified_at' => now()->addHour()->toIso8601String()])] as $json) {
            file_put_contents($this->statusPath, $json);
            $this->assertSame('invalid', app(MonitoringInfrastructure::class)->snapshot()['backup']['state']);
        }
    }

    private function writeStatus(string $snapshotAt): void
    {
        file_put_contents($this->statusPath, json_encode(['snapshot_at' => $snapshotAt, 'last_verified_at' => now()->toIso8601String()]));
    }

    private function disk(?int $bytes): void
    {
        $this->partialMock(MonitoringInfrastructure::class, fn ($mock) => $mock->shouldAllowMockingProtectedMethods()->shouldReceive('freeDiskBytes')->andReturn($bytes));
    }
}
