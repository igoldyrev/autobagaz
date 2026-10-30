<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderReservation;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class ConcurrentOrderReservationTest extends TestCase
{
    public function test_independent_processes_competing_for_the_last_unit_do_not_overreserve(): void
    {
        if (PHP_VERSION_ID < 80400) {
            $this->markTestSkipped('Laravel uses SQLite IMMEDIATE transactions starting with PHP 8.4.');
        }
        $database = tempnam(sys_get_temp_dir(), 'reservation-concurrent-');
        $previous = config('database.connections.sqlite.database');
        $processes = [];
        try {
            DB::purge('sqlite');
            config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => $database]);
            $this->artisan('migrate', ['--force' => true])->assertSuccessful();
            $product = Product::query()->create(['name' => 'Последняя единица', 'slug' => 'last-unit', 'price' => 100, 'stock' => 1, 'is_active' => true]);
            $ids = [];
            for ($i = 0; $i < 2; $i++) {
                $order = Order::query()->create(['customer_name' => 'Тест', 'phone' => '+79000000000', 'delivery_method' => 'pickup', 'total' => 100]);
                $order->items()->create(['product_id' => $product->id, 'product_name' => $product->name, 'unit_price' => 100, 'quantity' => 1, 'total' => 100]);
                $ids[] = $order->id;
            }
            $worker = <<<'PHP'
                require 'vendor/autoload.php';
                $app = require 'bootstrap/app.php';
                $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
                Illuminate\Support\Facades\DB::listen(function ($query) {
                    if (str_starts_with($query->sql, 'update "orders"')) {
                        usleep(150000);
                    }
                });
                app(App\Services\OrderReservations::class)->create(App\Models\Order::query()->findOrFail($argv[1]));
                PHP;
            foreach ($ids as $id) {
                $process = new Process([PHP_BINARY, '-r', $worker, (string) $id], base_path(), [
                    'APP_ENV' => 'testing', 'DB_CONNECTION' => 'sqlite', 'DB_DATABASE' => $database, 'DB_URL' => '',
                    'APP_CONFIG_CACHE' => $database.'.config', 'CACHE_STORE' => 'array', 'MAIL_MAILER' => 'array',
                    'SESSION_DRIVER' => 'array', 'TELEGRAM_BOT_TOKEN' => '',
                ]);
                $process->start();
                $processes[] = $process;
            }
            foreach ($processes as $process) {
                $process->wait();
                $this->assertTrue($process->isSuccessful(), substr($process->getErrorOutput().$process->getOutput(), 0, 1000));
            }
            $this->assertSame(1, (int) OrderReservation::query()->live()->sum('quantity'));
            $this->assertSame(1, OrderReservation::query()->count());
            $this->assertSame(1, $product->fresh()->stock);
            $this->assertSame(0, $product->fresh()->available_stock);
            $this->assertSame(2, Order::query()->whereNotNull('reservation_started_at')->count());
        } finally {
            foreach ($processes as $process) {
                if ($process->isRunning()) {
                    $process->stop();
                }
            }
            DB::purge('sqlite');
            config(['database.connections.sqlite.database' => $previous]);
            foreach ([$database, $database.'-wal', $database.'-shm', $database.'-journal'] as $file) {
                @unlink($file);
            }
        }
    }
}
