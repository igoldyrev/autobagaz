<?php

namespace App\Console\Commands;

use App\Services\AdminMonitoringReport;
use Illuminate\Console\Command;
use InvalidArgumentException;

class AdminMonitoringSummary extends Command
{
    protected $signature = 'monitoring:admin-summary {--date= : Date in YYYY-MM-DD format} {--limit=3 : Changes per administrator}';

    protected $description = 'Output a read-only administrator activity report as JSON';

    public function handle(AdminMonitoringReport $report): int
    {
        $limit = filter_var($this->option('limit'), FILTER_VALIDATE_INT);
        if ($limit === false || $limit < 1 || $limit > 10) {
            $this->components->error('The --limit value must be between 1 and 10.');

            return self::INVALID;
        }

        try {
            $payload = $report->build($this->option('date'), $limit);
        } catch (InvalidArgumentException $exception) {
            $this->components->error($exception->getMessage());

            return self::INVALID;
        }

        $this->line(json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return self::SUCCESS;
    }
}
