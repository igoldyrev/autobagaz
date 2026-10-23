<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\CallbackRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderWorkflow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AdminOrderWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_assignee_must_be_unique_and_have_order_permission(): void
    {
        config(['orders.default_assignee_id' => null]);
        User::factory()->create(['name' => 'Максим', 'is_admin' => false]);
        User::factory()->create(['name' => 'Максим', 'is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER]);
        $workflow = app(OrderWorkflow::class);
        $this->assertNull($workflow->defaultAssigneeId());
        $maxim = $this->manager();
        $maxim->update(['name' => 'Максим']);
        $this->assertSame($maxim->id, $workflow->defaultAssigneeId());
        $duplicate = $this->manager();
        $duplicate->update(['name' => 'Максим']);
        $this->assertNull($workflow->defaultAssigneeId());
        config(['orders.default_assignee_id' => $maxim->id]);
        $this->assertSame($maxim->id, $workflow->defaultAssigneeId());
        $maxim->update(['permissions' => []]);
        $this->assertNull($workflow->defaultAssigneeId());
    }

    public function test_claim_assigns_current_manager_and_records_history_for_both_types(): void
    {
        $manager = $this->manager();
        foreach ($this->records() as $record) {
            $this->actingAs($manager)->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'new'])
                ->assertRedirect()->assertSessionDoesntHaveErrors();
            $this->assertSame($manager->id, $record->fresh()->assignee_id);
            $this->assertSame('in_progress', $record->fresh()->status);
            $this->assertDatabaseHas('admin_activity_logs', [
                'user_id' => $manager->id, 'subject_id' => $record->id,
                'subject_type' => $record instanceof Order ? 'order' : 'callback_request',
            ]);
            $this->get($this->url($record, 'show'))->assertOk()->assertSee('История изменений')
                ->assertSee('Ответственный: «Не назначен» → «'.$manager->name.'»');
        }
    }

    public function test_stale_claim_cannot_replace_first_manager(): void
    {
        $first = $this->manager();
        $second = $this->manager();
        foreach ($this->records() as $record) {
            $this->actingAs($first)->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'new'])->assertSessionDoesntHaveErrors();
            $this->actingAs($second)->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'new'])->assertSessionHasErrors('status');
            $this->assertSame($first->id, $record->fresh()->assignee_id);
        }
        $this->assertDatabaseCount('admin_activity_logs', 2);
    }

    public function test_transitions_are_enforced_and_completed_records_can_only_be_reopened_by_administrator(): void
    {
        $manager = $this->manager();
        foreach ($this->records() as $record) {
            $this->actingAs($manager)->put($this->url($record), ['status' => 'completed', 'expected_status' => 'new'])->assertSessionHasErrors('status');
            $this->put($this->url($record), ['status' => 'in_progress'])->assertSessionHasErrors('expected_status');
            $this->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'new'])->assertSessionDoesntHaveErrors();
            if ($record instanceof Order) {
                $this->put($this->url($record), ['status' => 'completed', 'expected_status' => 'in_progress'])->assertSessionHasErrors('status');
                $this->put($this->url($record), ['status' => 'confirmed', 'expected_status' => 'in_progress'])->assertSessionDoesntHaveErrors();
                $terms = $record->termsVersions()->make([
                    'version' => 1, 'created_by' => $manager->id, 'created_by_name' => $manager->name,
                    'items' => [], 'delivery_method' => 'pickup', 'delivery_cost' => '0.00',
                    'delivery_terms' => 'В магазине', 'payment_method' => 'cash', 'payment_terms' => 'В магазине',
                    'goods_total' => '1000.00', 'total' => '1000.00',
                ]);
                $terms->forceFill(['accepted_at' => now()])->save();
                $this->put($this->url($record), ['status' => 'ready', 'expected_status' => 'confirmed', 'expected_terms_version' => 1])->assertSessionDoesntHaveErrors();
            }
            $this->put($this->url($record), ['status' => 'completed', 'expected_status' => $record->fresh()->status, 'expected_terms_version' => 1, 'fulfillment_confirmed' => '1'])->assertSessionDoesntHaveErrors();
            $this->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'completed'])->assertSessionHasErrors('status');
            $this->get($this->url($record, 'show'))->assertOk()->assertDontSee('Вернуть в работу');
            $admin = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_ADMINISTRATOR]);
            $this->actingAs($admin)->get($this->url($record, 'show'))->assertOk()->assertSee('Вернуть в работу');
            $this->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'completed'])->assertSessionDoesntHaveErrors();
            $this->assertSame('in_progress', $record->fresh()->status);
            $this->assertSame($manager->id, $record->fresh()->assignee_id);
        }
    }

    public function test_cancellation_is_available_only_for_open_states(): void
    {
        $manager = $this->manager();
        foreach ($this->records() as $record) {
            $statuses = $record instanceof Order ? ['new', 'in_progress', 'confirmed', 'awaiting_supply', 'ready'] : ['new', 'in_progress'];
            foreach ($statuses as $status) {
                $record->update(['status' => $status]);
                $this->actingAs($manager)->put($this->url($record), ['status' => 'cancelled', 'expected_status' => $status, 'cancellation_reason' => 'Покупатель отказался'])->assertSessionDoesntHaveErrors();
                $this->assertSame('cancelled', $record->fresh()->status);
                $this->get($this->url($record, 'show'))->assertOk()->assertDontSee('name="status"', false);
                $this->put($this->url($record), ['status' => 'completed', 'expected_status' => 'cancelled'])->assertSessionHasErrors('status');
            }
        }
    }

    public function test_assignment_validates_permissions_and_does_not_change_status(): void
    {
        $manager = $this->manager();
        $other = $this->manager();
        $customer = User::factory()->create();
        $noPermission = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER]);
        foreach ($this->records() as $record) {
            foreach ([$customer, $noPermission] as $invalid) {
                $this->actingAs($manager)->put($this->url($record), ['assignee_id' => $invalid->id])->assertSessionHasErrors('assignee_id');
                $this->assertNull($record->fresh()->assignee_id);
            }
            $this->put($this->url($record), ['assignee_id' => $other->id])->assertSessionDoesntHaveErrors();
            $this->assertSame($other->id, $record->fresh()->assignee_id);
            $this->assertSame('new', $record->fresh()->status);
            $this->get($this->url($record, 'show'))->assertSee('Ответственный: «Не назначен» → «'.$other->name.'»');
        }
        $this->assertDatabaseCount('admin_activity_logs', 2);
    }

    public function test_lists_filter_by_assignee_mine_and_status_and_keep_filters_on_pagination(): void
    {
        $manager = $this->manager();
        $other = $this->manager();
        foreach ($this->records() as $record) {
            $record->update(['assignee_id' => $manager->id]);
            $foreign = $record->replicate()->fill($record instanceof Order ? ['number' => 'OTHER-ORDER', 'assignee_id' => $other->id] : ['name' => 'Другой клиент', 'assignee_id' => $other->id]);
            $foreign->save();
            $url = route('admin.'.($record instanceof Order ? 'orders' : 'callback-requests').'.index');
            $this->actingAs($manager)->get($url.'?mine=1&assignee_id='.$other->id.'&status=new')->assertOk()
                ->assertViewHas($record instanceof Order ? 'orders' : 'callbackRequests', fn ($list) => $list->total() === 1 && $list->first()->is($record));
            $this->get($url.'?assignee_id='.$other->id)->assertOk()
                ->assertViewHas($record instanceof Order ? 'orders' : 'callbackRequests', fn ($list) => $list->total() === 1 && $list->first()->is($foreign));
            for ($i = 0; $i < 30; $i++) {
                $copy = $record->replicate();
                if ($copy instanceof Order) {
                    $copy->number = 'PAGE-'.$i;
                }
                $copy->save();
            }
            $this->get($url.'?mine=1&status=new')->assertOk()->assertSee('mine=1&amp;status=new&amp;page=2', false);
        }
    }

    public function test_action_buttons_follow_current_status(): void
    {
        $manager = $this->manager();
        foreach ($this->records() as $record) {
            foreach (array_keys($record::statusLabels()) as $status) {
                $record->update(['status' => $status]);
                $response = $this->actingAs($manager)->get($this->url($record, 'show'))->assertOk();
                foreach (['in_progress', 'confirmed', 'awaiting_supply', 'ready', 'shipped', 'completed', 'cancelled'] as $target) {
                    $button = 'name="status" value="'.$target.'"';
                    if (array_key_exists($target, $record->availableActions())) {
                        $response->assertSee($button, false);
                    } else {
                        $response->assertDontSee($button, false);
                    }
                }
            }
        }
    }

    public function test_users_without_order_permission_cannot_read_or_modify_records(): void
    {
        $user = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER]);
        foreach ($this->records() as $record) {
            $this->actingAs($user)->get($this->url($record, 'show'))->assertForbidden();
            $this->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'new'])->assertForbidden();
            $this->put($this->url($record), ['assignee_id' => $user->id])->assertForbidden();
            $this->put($this->url($record), ['internal_comment' => 'Недоступная заметка'])->assertForbidden();
            $this->assertSame('new', $record->fresh()->status);
        }
        $this->get(route('admin.orders.index', ['search' => 'TEST']))->assertForbidden();
    }

    public function test_deleting_assignee_preserves_order_and_history(): void
    {
        $manager = $this->manager();
        $records = $this->records();
        foreach ($records as $record) {
            $this->actingAs($manager)->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'new'])->assertSessionDoesntHaveErrors();
        }
        $manager->delete();
        foreach ($records as $record) {
            $this->assertNull($record->fresh()->assignee_id);
        }
        $this->assertSame($manager->name, AdminActivityLog::query()->firstOrFail()->user_name);
    }

    public function test_internal_comments_are_private_signed_history_entries_without_status_changes_or_emails(): void
    {
        Mail::fake();
        $manager = $this->manager();
        $comment = "Позвонить завтра\n<script>alert('private')</script>";
        foreach ($this->records() as $record) {
            $this->actingAs($manager)->put($this->url($record), ['internal_comment' => $comment])
                ->assertRedirect()->assertSessionDoesntHaveErrors();
            $entry = AdminActivityLog::query()->where('subject_type', $record instanceof Order ? 'order' : 'callback_request')->sole();
            $this->assertSame($manager->id, $entry->user_id);
            $this->assertSame($manager->name, $entry->user_name);
            $this->assertNotNull($entry->created_at);
            $this->assertSame('Внутренний комментарий: '.$comment, $entry->description);
            $this->assertSame('new', $record->fresh()->status);
            $this->assertNull($record->fresh()->assignee_id);
            $this->get($this->url($record, 'show'))->assertOk()->assertSee($comment)->assertDontSee($comment, false);
            if ($record instanceof Order) {
                $this->get($record->customerUrl())->assertOk()->assertDontSee('Позвонить завтра');
                $this->assertNull($record->fresh()->comment);
            }
        }
        $this->assertDatabaseCount('order_notifications', 0);
        Mail::assertNothingSent();
    }

    public function test_comment_validation_and_invalid_combined_action_do_not_write_history(): void
    {
        $manager = $this->manager();
        foreach ($this->records() as $record) {
            foreach (['   ', str_repeat('я', 2001), ['not a string']] as $invalid) {
                $this->actingAs($manager)->put($this->url($record), ['internal_comment' => $invalid])->assertSessionHasErrors('internal_comment');
            }
            $this->put($this->url($record), ['internal_comment' => 'Не сохранять', 'status' => 'completed', 'expected_status' => 'new'])
                ->assertSessionHasErrors('status');
            $this->assertSame('new', $record->fresh()->status);
        }
        $this->assertDatabaseCount('admin_activity_logs', 0);
    }

    public function test_cancellation_requires_a_reason_and_preserves_each_reason_after_reopening(): void
    {
        Mail::fake();
        $admin = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_ADMINISTRATOR]);
        foreach ($this->records() as $record) {
            foreach ([null, '   ', str_repeat('я', 2001)] as $invalid) {
                $this->actingAs($admin)->put($this->url($record), ['status' => 'cancelled', 'expected_status' => 'new', 'cancellation_reason' => $invalid])
                    ->assertSessionHasErrors('cancellation_reason');
                $this->assertSame('new', $record->fresh()->status);
            }
            foreach (['Первый отказ клиента', 'Повторный отказ клиента'] as $reason) {
                $this->put($this->url($record), ['status' => 'cancelled', 'expected_status' => $record->fresh()->status, 'cancellation_reason' => $reason])
                    ->assertSessionDoesntHaveErrors();
                $this->assertSame('cancelled', $record->fresh()->status);
                $this->get($this->url($record, 'show'))->assertSee('Причина отмены: '.$reason);
                if ($record instanceof Order) {
                    $this->get($record->customerUrl())->assertOk()->assertDontSee($reason);
                }
                $this->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'cancelled'])->assertSessionDoesntHaveErrors();
            }
            $this->get($this->url($record, 'show'))->assertSee('Первый отказ клиента')->assertSee('Повторный отказ клиента');
        }
    }

    public function test_comments_can_be_added_after_closure_but_not_to_anonymized_callbacks(): void
    {
        $manager = $this->manager();
        foreach ($this->records() as $record) {
            $record->update(['status' => 'completed']);
            $this->actingAs($manager)->put($this->url($record), ['internal_comment' => 'Закрывающие документы переданы'])
                ->assertSessionDoesntHaveErrors();
            $this->assertSame('completed', $record->fresh()->status);
            if ($record instanceof CallbackRequest) {
                $record->forceFill(['anonymized_at' => now()])->save();
                $this->put($this->url($record), ['internal_comment' => 'Не сохранять'])->assertSessionHasErrors('status');
                $this->get($this->url($record, 'show'))->assertOk()->assertDontSee('name="internal_comment"', false);
            }
        }
        $this->assertDatabaseCount('admin_activity_logs', 2);
    }

    public function test_workflow_itself_rejects_cancellation_without_reason(): void
    {
        $manager = $this->manager();
        foreach ($this->records() as $record) {
            try {
                app(OrderWorkflow::class)->update($record, $manager, ['status' => 'cancelled', 'expected_status' => 'new']);
                $this->fail('Cancellation without a reason must be rejected.');
            } catch (ValidationException $exception) {
                $this->assertArrayHasKey('cancellation_reason', $exception->errors());
            }
            $this->assertSame('new', $record->fresh()->status);
        }
        $this->assertDatabaseCount('admin_activity_logs', 0);
        $this->assertDatabaseCount('order_notifications', 0);
    }

    public function test_orders_search_by_number_email_and_formatted_phone_and_treat_wildcards_literally(): void
    {
        $manager = $this->manager();
        [$order] = $this->records();
        $order->update(['number' => 'AB-2026-105', 'email' => 'Buyer_tag@example.test', 'phone' => '+7 (900) 123-45-67']);
        $other = $order->replicate()->fill(['number' => 'UNRELATED', 'email' => 'other@example.test', 'phone' => '89111234568']);
        $other->save();
        foreach (['ab-2026', 'BUYER_TAG', ' buyer_tag@example.test ', '9001234567', '+7 (900) 123-45-67', '8 900 123 45 67', '123-45-67', '_tag'] as $search) {
            $this->actingAs($manager)->get(route('admin.orders.index', ['search' => $search]))->assertOk()
                ->assertViewHas('orders', fn ($orders) => $orders->total() === 1 && $orders->first()->is($order));
        }
        foreach (['%', '_', '!', "' OR 1=1 --", '+ () -'] as $search) {
            $this->get(route('admin.orders.index', ['search' => $search]))->assertOk()
                ->assertViewHas('orders', fn ($orders) => $orders->total() === ($search === '_' ? 1 : 0));
        }
        $this->get(route('admin.orders.index', ['search' => '  ']))->assertViewHas('orders', fn ($orders) => $orders->total() === 2);
        $this->get(route('admin.orders.index', ['search' => '+7 911 123-45-68']))
            ->assertViewHas('orders', fn ($orders) => $orders->total() === 1 && $orders->first()->is($other));
    }

    public function test_order_search_combines_with_filters_and_survives_pagination(): void
    {
        $manager = $this->manager();
        $other = $this->manager();
        [$order] = $this->records();
        $order->update(['assignee_id' => $manager->id, 'email' => 'match@example.test']);
        for ($i = 0; $i < 32; $i++) {
            $copy = $order->replicate()->fill(['number' => 'SEARCH-'.$i]);
            if ($i === 30) {
                $copy->assignee_id = $other->id;
            } elseif ($i === 31) {
                $copy->status = 'completed';
            }
            $copy->save();
        }
        $params = ['search' => 'match@', 'mine' => 1, 'status' => 'new', 'assignee_id' => $other->id];
        $this->actingAs($manager)->get(route('admin.orders.index', $params))->assertOk()
            ->assertViewHas('orders', fn ($orders) => $orders->total() === 31 && $orders->hasMorePages())
            ->assertSee('search=match%40', false);
        $this->get(route('admin.orders.index', $params + ['page' => 2]))->assertOk()
            ->assertViewHas('orders', fn ($orders) => $orders->total() === 31 && $orders->count() === 1);
        foreach ([str_repeat('a', 121), ['array']] as $invalid) {
            $this->from(route('admin.orders.index'))->get(route('admin.orders.index', ['search' => $invalid]))->assertSessionHasErrors('search');
        }
    }

    private function manager(): User
    {
        return User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER, 'permissions' => [User::PERMISSION_ORDERS]]);
    }

    private function records(): array
    {
        return [
            Order::query()->create(['number' => 'TEST-001', 'customer_name' => 'Клиент', 'phone' => '+79000000000', 'delivery_method' => 'pickup', 'total' => 1000, 'status' => 'new']),
            CallbackRequest::query()->create(['name' => 'Клиент', 'phone' => '+79000000000', 'status' => 'new']),
        ];
    }

    private function url(Order|CallbackRequest $record, string $action = 'update'): string
    {
        return route('admin.'.($record instanceof Order ? 'orders' : 'callback-requests').'.'.$action, $record);
    }
}
