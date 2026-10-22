<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\CallbackRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderWorkflowTest extends TestCase
{
    use RefreshDatabase;

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
            }
            $this->put($this->url($record), ['status' => 'completed', 'expected_status' => $record->fresh()->status])->assertSessionDoesntHaveErrors();
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
            $statuses = $record instanceof Order ? ['new', 'in_progress', 'confirmed'] : ['new', 'in_progress'];
            foreach ($statuses as $status) {
                $record->update(['status' => $status]);
                $this->actingAs($manager)->put($this->url($record), ['status' => 'cancelled', 'expected_status' => $status])->assertSessionDoesntHaveErrors();
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
                foreach (['in_progress', 'confirmed', 'completed', 'cancelled'] as $target) {
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
            $this->assertSame('new', $record->fresh()->status);
        }
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
