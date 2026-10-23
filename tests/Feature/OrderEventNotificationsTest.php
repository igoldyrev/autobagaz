<?php

namespace Tests\Feature;

use App\Jobs\SendOrderNotification;
use App\Mail\OrderStatusChanged;
use App\Models\CallbackRequest;
use App\Models\Order;
use App\Models\OrderNotification;
use App\Models\OrderTermsVersion;
use App\Models\User;
use App\Services\OrderWorkflow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\TestResponse;
use RuntimeException;
use Tests\TestCase;

class OrderEventNotificationsTest extends TestCase
{
    use RefreshDatabase;

    private User $manager;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        config(['queue.default' => 'sync']);
        $this->manager = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_ADMINISTRATOR]);
    }

    public function test_real_status_transitions_send_all_four_events_and_repeat_submission_does_not_duplicate_them(): void
    {
        $order = $this->order('delivery');
        foreach (['confirmed', 'ready', 'shipped'] as $target) {
            $this->transition($order, $target);
            $this->postStatus($order, ['status' => $target, 'expected_status' => $target === 'confirmed' ? 'in_progress' : ($target === 'ready' ? 'confirmed' : 'ready')])
                ->assertSessionHasErrors('status');
        }
        $this->assertSame('shipped', $order->fresh()->status);
        $cancelled = $this->order();
        $this->transition($cancelled, 'cancelled', ['cancellation_reason' => 'Внутренняя причина отказа']);
        $this->assertDatabaseCount('order_notifications', 4);
        Mail::assertSent(OrderStatusChanged::class, 4);
        foreach (OrderNotification::query()->get() as $notification) {
            $this->assertNotNull($notification->sent_at);
            $this->assertSame('buyer@example.test', $notification->recipient);
            (new SendOrderNotification($notification->id))->handle();
            $this->assertArrayNotHasKey('payload', $notification->toArray());
            $this->assertStringNotContainsString('Внутренняя причина отказа', json_encode($notification->payload, JSON_UNESCAPED_UNICODE));
            if ($notification->type === 'order_cancelled') {
                $mail = new OrderStatusChanged($notification->type, $notification->payload, $cancelled->customerUrl());
                $this->assertStringNotContainsString('Внутренняя причина отказа', $mail->render());
            }
        }
        Mail::assertSent(OrderStatusChanged::class, 4);
        Mail::assertSent(OrderStatusChanged::class, function (OrderStatusChanged $mail) use ($order) {
            if ($mail->event !== 'order_shipped') {
                return false;
            }
            $html = $mail->render();

            return str_contains($html, 'Заказ передан службе доставки') && str_contains($html, $order->customerUrl());
        });
    }

    public function test_ready_pickup_and_delivery_emails_have_the_correct_receiving_instructions(): void
    {
        foreach (['pickup', 'delivery'] as $method) {
            $order = $this->order($method, 'confirmed');
            $this->transition($order, 'ready');
            Mail::assertSent(OrderStatusChanged::class, function (OrderStatusChanged $mail) use ($order, $method) {
                if ($mail->snapshot['number'] !== $order->number) {
                    return false;
                }
                $html = $mail->render();

                return str_contains($html, $method === 'delivery' ? 'готов к отправке' : 'готов к выдаче')
                    && str_contains($html, $method === 'delivery' ? 'После передачи мы сообщим' : 'Дзержинского, 15');
            });
        }
    }

    public function test_assignment_processing_supply_completion_and_callbacks_do_not_send_order_event_emails(): void
    {
        $order = $this->order('pickup', 'new');
        $this->postStatus($order, ['assignee_id' => $this->manager->id])->assertSessionDoesntHaveErrors();
        $this->transition($order, 'in_progress');
        $order->update(['status' => 'confirmed']);
        $this->transition($order, 'awaiting_supply');
        $order->update(['status' => 'ready']);
        $this->transition($order, 'completed', ['fulfillment_confirmed' => '1']);
        $callback = CallbackRequest::query()->create(['name' => 'Покупатель', 'phone' => '+79000000000']);
        app(OrderWorkflow::class)->update($callback, $this->manager, ['status' => 'in_progress', 'expected_status' => 'new']);
        app(OrderWorkflow::class)->update($callback->fresh(), $this->manager, ['status' => 'completed', 'expected_status' => 'in_progress']);
        $this->assertDatabaseCount('order_notifications', 0);
        Mail::assertNothingSent();
    }

    public function test_notifications_are_dispatched_only_after_the_outer_transaction_commits(): void
    {
        $order = $this->order();
        DB::beginTransaction();
        app(OrderWorkflow::class)->update($order, $this->manager, ['status' => 'confirmed', 'expected_status' => 'in_progress']);
        $this->assertDatabaseCount('order_notifications', 1);
        $this->assertNull(OrderNotification::query()->sole()->queued_at);
        Mail::assertNothingSent();
        DB::commit();
        Mail::assertSent(OrderStatusChanged::class, 1);
    }

    public function test_rollback_discards_the_status_history_and_notification(): void
    {
        $order = $this->order();
        DB::beginTransaction();
        app(OrderWorkflow::class)->update($order, $this->manager, ['status' => 'confirmed', 'expected_status' => 'in_progress']);
        DB::rollBack();
        $this->assertSame('in_progress', $order->fresh()->status);
        $this->assertDatabaseCount('order_notifications', 0);
        $this->assertDatabaseCount('admin_activity_logs', 0);
        Mail::assertNothingSent();
    }

    public function test_queue_failure_does_not_rollback_the_status_and_scheduler_recovers_the_event(): void
    {
        $order = $this->order();
        $fail = true;
        Bus::shouldReceive('dispatch')->twice()->andReturnUsing(function (SendOrderNotification $job) use (&$fail) {
            if ($fail) {
                throw new RuntimeException('Queue unavailable');
            }
            $job->handle();
        });
        $this->transition($order, 'confirmed');
        $this->assertSame('confirmed', $order->fresh()->status);
        $notification = OrderNotification::query()->sole();
        $this->assertNull($notification->queued_at);
        $this->assertNull($notification->sent_at);
        $fail = false;
        $this->artisan('orders:dispatch-notifications')->assertSuccessful();
        $this->assertNotNull($notification->fresh()->sent_at);
        Mail::assertSent(OrderStatusChanged::class, 1);
    }

    public function test_delayed_delivery_uses_the_accepted_snapshot_even_after_conditions_and_order_change(): void
    {
        Bus::fake();
        $order = $this->order();
        $terms = $this->acceptedTerms($order);
        $this->transition($order, 'confirmed');
        $notification = OrderNotification::query()->sole();
        $this->assertSame(1, $notification->payload['terms_version']);
        $this->assertSame('220.35', $notification->payload['terms']['total']);
        $terms->forceFill(['goods_total' => '999.00', 'total' => '999.00', 'delivery_address' => 'Другой адрес', 'payment_terms' => 'Другой порядок оплаты'])->save();
        $order->update(['customer_name' => 'Другое имя', 'total' => '999.00']);
        (new SendOrderNotification($notification->id))->handle();
        Mail::assertSent(OrderStatusChanged::class, function (OrderStatusChanged $mail) use ($order) {
            $html = $mail->render();

            return str_contains($html, 'Согласованные условия № 1') && str_contains($html, 'Адрес из согласованной версии')
                && str_contains($html, '220,35') && str_contains($html, 'Предоплата переводом')
                && str_contains($html, $order->customerUrl()) && ! str_contains($html, 'Другой адрес')
                && ! str_contains($html, 'Другой порядок оплаты') && ! str_contains($html, 'Другое имя');
        });
    }

    public function test_unaccepted_proposal_is_not_presented_as_agreed_in_confirmation_or_cancellation(): void
    {
        $order = $this->order();
        $accepted = $this->acceptedTerms($order);
        $proposal = $accepted->replicate();
        $proposal->version = 2;
        $proposal->forceFill(['accepted_at' => null, 'delivery_address' => 'Ещё не согласованный адрес', 'payment_terms' => 'Ещё не согласованная оплата']);
        $proposal->save();
        $this->transition($order, 'confirmed');
        $this->transition($order, 'cancelled', ['cancellation_reason' => 'Внутренняя причина отказа']);
        Mail::assertSent(OrderStatusChanged::class, 2);
        foreach (OrderNotification::query()->get() as $notification) {
            $this->assertSame(1, $notification->payload['terms_version']);
            $this->assertSame(2, $notification->payload['pending_terms_version']);
            $mail = new OrderStatusChanged($notification->type, $notification->payload, $order->customerUrl());
            $html = $mail->render();
            $this->assertStringContainsString('Они пока не подтверждены вами', $html);
            $this->assertStringContainsString('Адрес из согласованной версии', $html);
            $this->assertStringNotContainsString('Ещё не согласованный адрес', $html);
        }
    }

    public function test_initial_request_snapshot_keeps_unknown_delivery_distinct_from_free_delivery(): void
    {
        Bus::fake();
        $order = $this->order('delivery');
        $this->transition($order, 'confirmed');
        $notification = OrderNotification::query()->sole();
        $order->items()->update(['product_name' => 'Позже изменённый товар']);
        $order->update(['checkout_terms' => ['notices' => ['Позже изменённые правила']]]);
        $mail = new OrderStatusChanged($notification->type, $notification->payload, $order->customerUrl());
        $html = $mail->render();
        $this->assertStringContainsString('Исходная заявка', $html);
        $this->assertStringContainsString('Исходный автобокс', $html);
        $this->assertStringContainsString('Стоимость доставки: ещё не рассчитана', $html);
        $this->assertStringContainsString('Условия, показанные при оформлении', $html);
        $this->assertStringNotContainsString('Позже изменённые правила', $html);
        $this->assertNull($notification->payload['terms']['total']);
        $this->assertStringContainsString('Оно не подтверждает оплату или возврат', $html);
    }

    public function test_orders_without_customer_email_do_not_break_manager_actions(): void
    {
        $order = $this->order();
        $order->update(['email' => null]);
        $this->transition($order, 'confirmed');
        $this->assertSame('confirmed', $order->fresh()->status);
        $this->assertDatabaseCount('order_notifications', 0);
        Mail::assertNothingSent();
    }

    public function test_a_genuine_second_confirmation_sends_a_new_event(): void
    {
        $order = $this->order();
        $this->transition($order, 'confirmed');
        $this->transition($order, 'in_progress');
        $this->transition($order, 'confirmed');
        $this->assertDatabaseCount('order_notifications', 2);
        Mail::assertSent(OrderStatusChanged::class, 2);
    }

    private function order(string $delivery = 'pickup', string $status = 'in_progress'): Order
    {
        $order = Order::query()->create([
            'number' => 'AB-'.(Order::query()->count() + 1), 'customer_name' => 'Покупатель', 'phone' => '+79000000000',
            'email' => 'buyer@example.test', 'delivery_method' => $delivery, 'delivery_address' => $delivery === 'delivery' ? 'Первоначальный адрес' : null,
            'total' => '200.30', 'status' => $status, 'checkout_terms' => ['notices' => ['Условия, показанные при оформлении']],
        ]);
        $order->items()->create(['product_name' => 'Исходный автобокс', 'unit_price' => '100.15', 'quantity' => 2, 'total' => '200.30']);

        return $order;
    }

    private function acceptedTerms(Order $order): OrderTermsVersion
    {
        $terms = $order->termsVersions()->make([
            'version' => 1, 'created_by' => $this->manager->id, 'created_by_name' => $this->manager->name,
            'items' => [['product_name' => 'Согласованный автобокс', 'unit_price' => '200.30', 'quantity' => 1, 'total' => '200.30', 'supply_terms' => 'До 30.10.2026']],
            'delivery_method' => 'delivery', 'delivery_address' => 'Адрес из согласованной версии',
            'delivery_terms' => 'Одна отправка до 31.10.2026', 'delivery_cost' => '20.05',
            'goods_total' => '200.30', 'total' => '220.35', 'payment_method' => 'bank_transfer', 'payment_terms' => 'Предоплата переводом',
        ]);
        $terms->forceFill(['accepted_at' => now()])->save();

        return $terms;
    }

    private function postStatus(Order $order, array $data): TestResponse
    {
        return $this->actingAs($this->manager)->put(route('admin.orders.update', $order), $data);
    }

    private function transition(Order $order, string $status, array $extra = []): void
    {
        $this->postStatus($order, array_replace([
            'status' => $status, 'expected_status' => $order->fresh()->status,
            'expected_terms_version' => (int) $order->termsVersions()->max('version'),
        ], $extra))->assertRedirect()->assertSessionDoesntHaveErrors();
    }
}
