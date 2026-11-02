<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderPayments;
use App\Services\OrderReservations;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class ConcurrentPartialOrderFulfillmentTest extends TestCase
{
    public function test_independent_processes_cannot_apply_the_same_partial_issue_twice(): void
    {
        if (PHP_VERSION_ID < 80400) {
            $this->markTestSkipped('SQLite IMMEDIATE transactions require PHP 8.4.');
        }
        $database = tempnam(sys_get_temp_dir(), 'partial-concurrent-');
        $previous = config('database.connections.sqlite.database');
        $processes = [];
        try {
            DB::purge('sqlite');
            config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => $database]);
            $this->artisan('migrate', ['--force' => true])->assertSuccessful();
            $product = Product::create(['name' => 'Товар', 'slug' => 'partial-test', 'price' => 100, 'stock' => 5, 'is_active' => true]);
            $order = Order::create(['customer_name' => 'Тест', 'phone' => '+79000000000', 'delivery_method' => 'pickup', 'status' => 'in_progress', 'total' => 500]);
            $order->items()->create(['product_id' => $product->id, 'product_name' => $product->name, 'unit_price' => 100, 'quantity' => 5, 'total' => 500]);
            $manager = User::factory()->create(['is_admin' => true]);
            app(OrderReservations::class)->create($order);
            app(OrderPayments::class)->confirm($order, 'yookassa', 'test', '500.00');
            $worker = <<<'PHP'
                require 'vendor/autoload.php';
                $app = require 'bootstrap/app.php';
                $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
                Illuminate\Support\Facades\DB::listen(function ($query) {
                    if (str_starts_with($query->sql, 'update "products"')) {
                        usleep(150000);
                    }
                });
                try {
                    app(App\Services\OrderReservations::class)->fulfillPart(App\Models\Order::findOrFail($argv[1]), App\Models\User::findOrFail($argv[2]), [
                        'expected_status' => 'in_progress', 'expected_terms_version' => 0, 'expected_fulfillment_version' => 0,
                        'quantities' => [$argv[3] => 1], 'fulfilled' => true,
                    ]);
                    echo 'ok';
                } catch (Illuminate\Validation\ValidationException) {
                    echo 'validation';
                }
                PHP;
            for ($i = 0; $i < 2; $i++) {
                $process = new Process([PHP_BINARY, '-r', $worker, (string) $order->id, (string) $manager->id, (string) $product->id], base_path(), [
                    'APP_ENV' => 'testing', 'DB_CONNECTION' => 'sqlite', 'DB_DATABASE' => $database, 'DB_URL' => '',
                    'APP_CONFIG_CACHE' => $database.'.config', 'CACHE_STORE' => 'array', 'MAIL_MAILER' => 'array',
                    'SESSION_DRIVER' => 'array', 'QUEUE_CONNECTION' => 'database', 'TELEGRAM_BOT_TOKEN' => '',
                ]);
                $process->setTimeout(15);
                $process->start();
                $processes[] = $process;
            }
            $results = [];
            foreach ($processes as $process) {
                $process->wait();
                $this->assertTrue($process->isSuccessful(), $process->getErrorOutput().$process->getOutput());
                $results[] = $process->getOutput();
            }
            sort($results);
            $this->assertSame(['ok', 'validation'], $results);
            $this->assertSame(4, $product->fresh()->stock);
            $this->assertSame(0, $product->fresh()->available_stock);
            $row = $order->reservations()->sole();
            $this->assertSame([4, 1, 'paid'], array_values($row->only(['quantity', 'fulfilled_quantity', 'state'])));
            $this->assertSame(1, $order->fresh()->fulfillment_version);
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
