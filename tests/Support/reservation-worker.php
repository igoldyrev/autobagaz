<?php

// Independent process for the opt-in MySQL concurrency suite. No production credentials.
require dirname(__DIR__, 2).'/vendor/autoload.php';

use App\Http\Controllers\CheckoutController;
use App\Http\Requests\CheckoutOrderRequest;
use App\Models\Order;
use App\Models\StockFileImport;
use App\Models\User;
use App\Services\CartService;
use App\Services\OrderNotifications;
use App\Services\OrderPayments;
use App\Services\OrderReservations;
use App\Services\OrderWorkflow;
use App\Services\StockFileService;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

$input = json_decode(file_get_contents($argv[1]), true, flags: JSON_THROW_ON_ERROR);
$app = require dirname(__DIR__, 2).'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
if (isset($input['now'])) {
    Date::setTestNow($input['now']);
}
try {
    $connection = DB::connection();
    $matched = false;
    $matches = static fn (string $sql): bool => str_contains($sql, 'from `'.$input['lock_table'].'`') && str_contains($sql, 'for update');
    if ($input['role'] === 'holder') {
        DB::listen(function ($query) use ($input, $matches, &$matched) {
            if ($matched || ! $matches($query->sql)) {
                return;
            }
            $matched = true;
            touch($input['directory'].'/locked');
            $deadline = microtime(true) + 15;
            while (! is_file($input['directory'].'/release')) {
                if (microtime(true) > $deadline) {
                    throw new RuntimeException('Timed out waiting for test release.');
                }
                usleep(10000);
            }
        });
    } else {
        $connection->beforeExecuting(function ($sql) use ($input, $matches, &$matched) {
            if (! $matched && $matches($sql)) {
                $matched = true;
                touch($input['directory'].'/waiting');
            }
        });
    }
    $id = $input['id'];
    switch ($input['operation']) {
        case 'reserve':
            app(OrderReservations::class)->create(Order::findOrFail($id));
            break;
        case 'pay':
            app(OrderPayments::class)->confirm(Order::findOrFail($id), 'yookassa', 'race-'.$id, '100.00');
            break;
        case 'expire':
            app(OrderReservations::class)->expireDue();
            break;
        case 'import':
            app(StockFileService::class)->apply(StockFileImport::findOrFail($id), User::findOrFail($input['user']), []);
            break;
        case 'issue':
            app(OrderWorkflow::class)->update(Order::findOrFail($id), User::findOrFail($input['user']), [
                'status' => 'completed', 'expected_status' => 'new', 'expected_terms_version' => 0, 'fulfillment_confirmed' => true,
            ]);
            break;
        case 'checkout':
            session()->start();
            session()->put(['cart.items' => [$input['product'] => 1], 'checkout.token' => $input['token']]);
            $request = CheckoutOrderRequest::create('/checkout', 'POST', $input['payload']);
            $request->setContainer($app)->setRedirector(app('redirect'));
            $request->setLaravelSession(session()->driver());
            $request->validateResolved();
            $response = app(CheckoutController::class)->store($request, app(CartService::class), app(OrderNotifications::class));
            if ($response->getTargetUrl() !== route('checkout.thanks')) {
                throw new RuntimeException('Checkout did not redirect to thanks.');
            }
            break;
        default:
            throw new RuntimeException('Unknown test operation.');
    }
    file_put_contents($input['result'], json_encode(['state' => 'ok']));
} catch (ValidationException $e) {
    file_put_contents($input['result'], json_encode(['state' => 'validation', 'errors' => $e->errors()]));
}
