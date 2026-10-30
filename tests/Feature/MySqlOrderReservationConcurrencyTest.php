<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderReservation;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use App\Services\OrderPayments;
use App\Services\OrderReservations;
use App\Services\StockFileService;
use App\Support\PersonalDataConsent;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDO;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class MySqlOrderReservationConcurrencyTest extends TestCase
{
    private ?PDO $server = null;

    private string $database;

    private string $directory;

    private array $processes = [];

    protected function setUp(): void
    {
        parent::setUp();
        $socket = getenv('RESERVATION_MYSQL_TEST_SOCKET');
        if (! $socket) {
            $this->markTestSkipped('Set RESERVATION_MYSQL_TEST_SOCKET to an isolated test server; a new database is created for each test.');
        }
        // Deliberately ignore DB_HOST/DB_DATABASE and all application credentials.
        $this->server = new PDO('mysql:unix_socket='.$socket, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $this->database = 'reservation_test_'.bin2hex(random_bytes(8));
        $this->directory = sys_get_temp_dir().'/'.$this->database;
        mkdir($this->directory, 0700);
        $this->server->exec('CREATE DATABASE `'.$this->database.'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        config(['database.default' => 'mysql', 'database.connections.mysql.url' => null,
            'database.connections.mysql.unix_socket' => $socket, 'database.connections.mysql.database' => $this->database,
            'database.connections.mysql.username' => 'root', 'database.connections.mysql.password' => '',
            'queue.default' => 'database']);
        DB::purge('mysql');
        $this->artisan('migrate', ['--force' => true])->assertSuccessful();
        $isolation = DB::selectOne("SHOW VARIABLES WHERE Variable_name IN ('transaction_isolation', 'tx_isolation')");
        $this->assertSame('REPEATABLE-READ', $isolation->Value);
    }

    protected function tearDown(): void
    {
        foreach ($this->processes as $process) {
            if ($process->isRunning()) {
                $process->stop();
            }
        }
        if ($this->server) {
            DB::purge('mysql');
            $this->server->exec('DROP DATABASE `'.$this->database.'`');
            foreach (glob($this->directory.'/*') as $path) {
                unlink($path);
            }
            rmdir($this->directory);
        }
        parent::tearDown();
    }

    public function test_last_unit_is_only_reserved_once(): void
    {
        $product = $this->product();
        $a = $this->order($product);
        $b = $this->order($product);
        $this->assertSame(['ok', 'ok'], $this->race(['reserve', $a->id], ['reserve', $b->id]));
        $this->assertSame(1, (int) OrderReservation::live()->sum('quantity'));
        $this->assertSame(1, OrderReservation::count());
        $this->assertSame(1, $product->fresh()->stock);
        $this->assertSame(0, $product->fresh()->available_stock);
    }

    public function test_repeated_checkout_creates_one_order_and_one_reservation(): void
    {
        $product = $this->product();
        session()->put('cart.items', [$product->id => 1]);
        $token = (string) Str::uuid();
        $extra = ['token' => $token, 'product' => $product->id, 'payload' => [
            'checkout_token' => $token,
            'checkout_snapshot' => Crypt::encryptString(json_encode(['token' => $token, 'items' => app(CartService::class)->checkoutSnapshot()])),
            'customer_name' => 'Concurrency test', 'phone' => '+79000000000', 'email' => 'race@example.test',
            'delivery_method' => 'pickup', 'personal_data_consent' => '1', 'consent_version' => PersonalDataConsent::VERSION,
        ]];
        $this->assertSame(['ok', 'ok'], $this->race(['checkout', 0], ['checkout', 0], extra: $extra));
        $this->assertSame(1, Order::where('checkout_token', $token)->count());
        $this->assertSame(1, OrderReservation::count());
        $this->assertSame(1, DB::table('order_items')->count());
        $this->assertSame(1, $product->fresh()->stock);
    }

    public static function paymentRaces(): array
    {
        return [['pay', true], ['expire', true], ['pay', false]];
    }

    #[DataProvider('paymentRaces')]
    public function test_payment_and_expiry_are_serialized(string $first, bool $expired): void
    {
        $product = $this->product();
        $order = $this->order($product);
        app(OrderReservations::class)->create($order);
        $deadline = $expired ? now()->subSecond() : now()->addMinutes(5);
        $order->update(['reservation_expires_at' => $deadline]);
        $order->reservations()->update(['expires_at' => $deadline]);
        // Let payment win the order lock before the deadline; cleanup sees time after it.
        if (! $expired) {
            $this->assertSame(['ok', 'ok'], $this->race(['pay', $order->id, now()->toDateTimeString()], ['expire', $order->id, now()->addMinutes(6)->toDateTimeString()], 'orders'));
            $this->assertSame(0, app(OrderReservations::class)->expireDue());
        } else {
            $second = $first === 'pay' ? 'expire' : 'pay';
            $this->assertSame(['ok', 'ok'], $this->race([$first, $order->id], [$second, $order->id], 'orders'));
        }
        $this->assertSame('paid', $order->fresh()->payment_status);
        $this->assertSame($expired ? 'expired' : 'paid', $order->reservations()->sole()->state);
        $this->assertSame(1, DB::table('order_payment_events')->count());
        $other = $this->order($product);
        app(OrderReservations::class)->create($other);
        $this->assertSame($expired ? 1 : 0, $other->reservations()->count());
        $this->assertSame(1, $product->fresh()->stock);
    }

    public static function importRaces(): array
    {
        return [['reserve', true], ['reserve', false], ['issue', true], ['issue', false]];
    }

    #[DataProvider('importRaces')]
    public function test_import_and_reservation_or_issue_preserve_stock(string $operation, bool $importFirst): void
    {
        $product = $this->product();
        $user = User::factory()->create(['is_admin' => true]);
        $order = $this->order($product);
        if ($operation === 'issue') {
            app(OrderReservations::class)->create($order);
            app(OrderPayments::class)->confirm($order, 'yookassa', 'setup', '100.00');
        }
        $service = app(StockFileService::class);
        $export = $service->export($user);
        $import = $service->preview($user, 'race.xlsx', ['export_id' => $export->id, 'rows' => [
            ['id' => $product->id, 'stock' => $operation === 'reserve' ? 0 : 2, 'price' => null, 'location' => 'Test!A2'],
        ]]);
        $operations = [['import', $import->id], [$operation, $order->id]];
        if (! $importFirst) {
            $operations = array_reverse($operations);
        }
        $states = $this->race(...$operations, extra: ['user' => $user->id]);
        if ($operation === 'reserve') {
            $this->assertSame($importFirst ? ['ok', 'ok'] : ['ok', 'validation'], $states);
            $this->assertSame($importFirst ? 0 : 1, $product->fresh()->stock);
            $this->assertSame($importFirst ? 0 : 1, (int) OrderReservation::live()->sum('quantity'));
        } else {
            $this->assertSame($importFirst ? ['ok', 'ok'] : ['ok', 'validation'], $states);
            $this->assertSame($importFirst ? 1 : 0, $product->fresh()->stock);
            $this->assertSame('consumed', $order->reservations()->sole()->state);
            $this->assertSame('completed', $order->fresh()->status);
            $this->assertSame(0, (int) OrderReservation::live()->sum('quantity'));
        }
        $this->assertSame($importFirst, $import->fresh()->applied_at !== null);
        $this->assertGreaterThanOrEqual(0, $product->fresh()->available_stock);
    }

    private function race(array $holder, array $contender, string $lockTable = 'products', array $extra = []): array
    {
        $a = $this->worker($holder, 'holder', $lockTable, $extra);
        $this->waitFor('locked', $a);
        $b = $this->worker($contender, 'contender', $lockTable, $extra);
        $this->waitFor('waiting', $b);
        usleep(150000);
        $this->assertTrue($b->isRunning(), 'The second operation must wait for the first lock.');
        touch($this->directory.'/release');
        $states = [];
        foreach ([$a, $b] as $i => $process) {
            $process->wait();
            $this->assertTrue($process->isSuccessful(), $process->getErrorOutput().$process->getOutput());
            $result = json_decode(file_get_contents($this->directory.'/result-'.$i), true, flags: JSON_THROW_ON_ERROR);
            $states[] = $result['state'];
        }

        return $states;
    }

    private function worker(array $operation, string $role, string $lockTable, array $extra): Process
    {
        $index = count($this->processes);
        $input = $this->directory.'/input-'.$index;
        file_put_contents($input, json_encode($extra + ['operation' => $operation[0], 'id' => $operation[1],
            'now' => $operation[2] ?? null, 'role' => $role, 'lock_table' => $lockTable, 'directory' => $this->directory, 'result' => $this->directory.'/result-'.$index]));
        $process = new Process([PHP_BINARY, base_path('tests/Support/reservation-worker.php'), $input], base_path(), [
            'APP_ENV' => 'testing', 'APP_KEY' => config('app.key'), 'APP_CONFIG_CACHE' => $this->directory.'/config.php',
            'DB_CONNECTION' => 'mysql', 'DB_SOCKET' => getenv('RESERVATION_MYSQL_TEST_SOCKET'), 'DB_URL' => '',
            'DB_DATABASE' => $this->database, 'DB_USERNAME' => 'root', 'DB_PASSWORD' => '',
            'CACHE_STORE' => 'array', 'MAIL_MAILER' => 'array', 'SESSION_DRIVER' => 'array',
            'QUEUE_CONNECTION' => 'database', 'TELEGRAM_BOT_TOKEN' => '',
        ]);
        $process->setTimeout(25);
        $process->start();
        $this->processes[] = $process;

        return $process;
    }

    private function waitFor(string $file, Process $process): void
    {
        $deadline = microtime(true) + 10;
        while (! is_file($this->directory.'/'.$file)) {
            $this->assertTrue($process->isRunning(), $process->getErrorOutput().$process->getOutput());
            $this->assertLessThan($deadline, microtime(true), 'Timed out waiting for '.$file);
            usleep(10000);
        }
    }

    private function product(): Product
    {
        return Product::create(['name' => 'Race test', 'slug' => 'race-test', 'stock' => 1, 'price' => 100, 'is_active' => true]);
    }

    private function order(Product $product): Order
    {
        $order = Order::create(['customer_name' => 'Race test', 'phone' => '+79000000000', 'delivery_method' => 'pickup', 'total' => 100]);
        $order->items()->create(['product_id' => $product->id, 'product_name' => $product->name, 'unit_price' => 100, 'quantity' => 1, 'total' => 100]);

        return $order;
    }
}
