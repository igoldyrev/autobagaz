<?php

namespace Tests\Feature;

use App\Models\CallbackRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderResponseTime;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderResponseTimeTest extends TestCase
{
    use RefreshDatabase;

    public function test_deadlines_use_the_contact_page_hours_and_pause_overnight(): void
    {
        $calendar = app(OrderResponseTime::class);
        foreach ([
            ['2026-10-23 09:00:00', '2026-10-23 11:00:00'],
            ['2026-10-23 10:00:00', '2026-10-23 11:00:00'],
            ['2026-10-23 18:00:00', '2026-10-23 19:00:00'],
            ['2026-10-23 18:30:00', '2026-10-24 10:30:00'],
            ['2026-10-23 19:00:00', '2026-10-24 11:00:00'],
            ['2026-10-23 20:00:00', '2026-10-24 11:00:00'],
            ['2026-10-24 17:00:00', '2026-10-24 18:00:00'],
            ['2026-10-24 17:30:00', '2026-10-25 10:30:00'],
            ['2026-10-25 18:00:00', '2026-10-26 11:00:00'],
        ] as [$from, $expected]) {
            $this->assertTrue($this->local($expected)->equalTo($calendar->deadline($this->local($from)->utc())), $from);
        }
        $this->assertSame(60, $calendar->workingMinutesBetween($this->local('2026-10-23 18:30'), $this->local('2026-10-24 10:30')));
        $this->assertSame(0, $calendar->workingMinutesBetween($this->local('2026-10-23 19:00'), $this->local('2026-10-24 09:59')));
        $this->assertSame(5, $calendar->workingMinutesBetween($this->local('2026-10-24 18:00'), $this->local('2026-10-25 10:05')));
        $this->get(route('contacts'))->assertOk()->assertSee('Пн–Пт: 10:00–19:00')->assertSee('Сб–Вс: 10:00–18:00');
    }

    public function test_deadline_is_saved_and_assignment_status_and_notes_do_not_count_as_contact(): void
    {
        Mail::fake();
        $this->travelTo($this->local('2026-10-23 18:30'));
        $manager = $this->manager();
        foreach ($this->records() as $record) {
            $this->assertTrue($record->response_due_at->equalTo($this->local('2026-10-24 10:30')));
            $this->actingAs($manager)->put($this->url($record), ['assignee_id' => $manager->id])->assertSessionDoesntHaveErrors();
            $this->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'new'])->assertSessionDoesntHaveErrors();
            $this->put($this->url($record), ['internal_comment' => 'Проверяю наличие'])->assertSessionDoesntHaveErrors();
            if ($record instanceof Order) {
                $this->put($this->url($record), ['status' => 'confirmed', 'expected_status' => 'in_progress'])->assertSessionDoesntHaveErrors();
            }
            $this->assertNull($record->fresh()->first_response_at);
            $this->assertTrue($record->fresh()->response_due_at->equalTo($this->local('2026-10-24 10:30')));
        }
        config(['orders.response_time.minutes' => 120]);
        $this->assertTrue(Order::query()->sole()->response_due_at->equalTo($this->local('2026-10-24 10:30')));
    }

    public function test_unsuccessful_attempt_does_not_stop_tracking_and_first_contact_can_be_outside_hours(): void
    {
        Mail::fake();
        $this->travelTo($this->local('2026-10-23 18:30'));
        $manager = $this->manager();
        $second = $this->manager();
        $records = $this->records();
        $this->travelTo($this->local('2026-10-23 20:00'));
        foreach ($records as $record) {
            $this->actingAs($manager)->put($this->url($record), ['contact_result' => 'not_reached', 'internal_comment' => 'Не берёт трубку'])
                ->assertSessionDoesntHaveErrors();
            $this->assertNull($record->fresh()->first_response_at);
            $this->assertFalse($record->fresh()->responseWasLate());
            $this->actingAs($second)->put($this->url($record), ['contact_result' => 'reached', 'internal_comment' => 'Обсудили условия по телефону'])
                ->assertSessionDoesntHaveErrors();
            $fresh = $record->fresh();
            $this->assertTrue($fresh->first_response_at->equalTo(now()));
            $this->assertSame($second->id, $fresh->first_response_by);
            $this->assertSame($second->name, $fresh->first_response_by_name);
            $this->assertSame('new', $fresh->status);
            $this->assertFalse($fresh->responseWasLate());
            $this->assertArrayNotHasKey('first_response_by_name', $fresh->toArray());
            $this->put($this->url($record), ['contact_result' => 'reached', 'internal_comment' => 'Повтор старой формы'])->assertSessionHasErrors('contact_result');
            $this->get($this->url($record, 'show'))->assertOk()->assertSee('Не берёт трубку')->assertSee('Первый контакт с покупателем состоялся')->assertSee($second->name);
        }
        $this->assertDatabaseCount('admin_activity_logs', 4);
        $second->delete();
        foreach ($records as $record) {
            $this->assertNull($record->fresh()->first_response_by);
            $this->assertSame($second->name, $record->fresh()->first_response_by_name);
        }
        Mail::assertNothingSent();
    }

    public function test_overdue_filters_and_lateness_are_consistent_for_both_record_types(): void
    {
        $this->travelTo($this->local('2026-10-23 18:30'));
        $manager = $this->manager();
        $records = $this->records();
        $this->travelTo($this->local('2026-10-24 10:30'));
        foreach ($records as $record) {
            $this->assertFalse($record->fresh()->responseWasLate());
        }
        $this->travelTo($this->local('2026-10-24 10:45'));
        foreach ($records as $record) {
            $this->assertSame(15, $record->fresh()->responseDelayMinutes());
            $type = $record instanceof Order ? 'orders' : 'callbackRequests';
            $index = route('admin.'.($record instanceof Order ? 'orders' : 'callback-requests').'.index');
            foreach (['overdue', 'waiting'] as $state) {
                $this->actingAs($manager)->get($index.'?response='.$state)->assertOk()->assertSee('Срок ответа истёк')
                    ->assertViewHas($type, fn ($list) => $list->total() === 1);
            }
            $this->put($this->url($record), ['contact_result' => 'reached', 'internal_comment' => 'Связались с опозданием'])->assertSessionDoesntHaveErrors();
            $this->get($index.'?response=overdue')->assertViewHas($type, fn ($list) => $list->total() === 0);
            $this->get($index.'?response=waiting')->assertViewHas($type, fn ($list) => $list->total() === 0);
            $this->get($index.'?response=answered')->assertViewHas($type, fn ($list) => $list->total() === 1)->assertSee('с опозданием');
        }
        $this->travelTo($this->local('2026-10-26 15:00'));
        foreach ($records as $record) {
            $this->assertSame(15, $record->fresh()->responseDelayMinutes());
        }
    }

    public function test_closure_stops_waiting_without_erasing_lateness_and_reopening_keeps_original_deadline(): void
    {
        Mail::fake();
        $this->travelTo($this->local('2026-10-23 10:00'));
        $admin = $this->manager();
        $records = $this->records();
        $this->travelTo($this->local('2026-10-23 11:20'));
        foreach ($records as $record) {
            $this->actingAs($admin)->put($this->url($record), ['status' => 'cancelled', 'expected_status' => 'new', 'cancellation_reason' => 'Отказ'])
                ->assertSessionDoesntHaveErrors();
            $this->assertNull($record->fresh()->first_response_at);
            $this->assertTrue($record->fresh()->response_stopped_at->equalTo(now()));
            $this->assertSame(20, $record->fresh()->responseDelayMinutes());
            $this->get($this->url($record, 'show'))->assertSee('Закрыт без первого ответа')->assertSee('срок был нарушен');
        }
        $this->travelTo($this->local('2026-10-24 12:00'));
        foreach ($records as $record) {
            $this->assertSame(20, $record->fresh()->responseDelayMinutes());
            $this->actingAs($admin)->put($this->url($record), ['status' => 'in_progress', 'expected_status' => 'cancelled'])->assertSessionDoesntHaveErrors();
            $this->assertNull($record->fresh()->response_stopped_at);
            $this->assertTrue($record->fresh()->response_due_at->equalTo($this->local('2026-10-23 11:00')));
            $this->assertTrue($record->fresh()->responseWasLate());
        }
    }

    public function test_contact_requires_a_comment_and_permission_and_rejects_closed_and_anonymized_records(): void
    {
        $manager = $this->manager();
        foreach ($this->records() as $record) {
            $this->actingAs($manager)->put($this->url($record), ['contact_result' => 'reached'])->assertSessionHasErrors('internal_comment');
            $this->put($this->url($record), ['contact_result' => 'unknown', 'internal_comment' => 'Текст'])->assertSessionHasErrors('contact_result');
            $record->update(['status' => 'cancelled']);
            $this->put($this->url($record), ['contact_result' => 'reached', 'internal_comment' => 'Текст'])->assertSessionHasErrors('contact_result');
            if ($record instanceof CallbackRequest) {
                $record->forceFill(['status' => 'new', 'anonymized_at' => now()])->save();
                $this->put($this->url($record), ['contact_result' => 'reached', 'internal_comment' => 'Текст'])->assertSessionHasErrors('status');
            }
            $this->assertNull($record->fresh()->first_response_at);
            $user = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER]);
            $this->actingAs($user)->put($this->url($record), ['contact_result' => 'reached', 'internal_comment' => 'Текст'])->assertForbidden();
        }
        $this->assertDatabaseCount('admin_activity_logs', 0);
    }

    public function test_legacy_records_have_no_artificial_deadline_and_customer_does_not_see_tracking(): void
    {
        $manager = $this->manager();
        foreach ($this->records() as $record) {
            $record->forceFill(['response_due_at' => null])->save();
            $this->assertFalse($record->fresh()->responseWasLate());
            $this->actingAs($manager)->get($this->url($record, 'show'))->assertOk()->assertSee('Срок ответа не установлен для старой заявки');
            if ($record instanceof Order) {
                $this->get($record->customerUrl())->assertOk()->assertDontSee('Срок первого ответа')->assertDontSee('Связался с покупателем');
            }
        }
    }

    public function test_response_filters_combine_with_other_filters_and_pagination(): void
    {
        $this->travelTo($this->local('2026-10-23 10:00'));
        $manager = $this->manager();
        $other = $this->manager();
        foreach ($this->records() as $record) {
            $record->update(['assignee_id' => $manager->id]);
            for ($i = 0; $i < 33; $i++) {
                $copy = $record->replicate();
                if ($copy instanceof Order) {
                    $copy->number = 'RESPONSE-'.$i;
                }
                if ($i === 30) {
                    $copy->assignee_id = $other->id;
                } elseif ($i === 31) {
                    $copy->status = 'completed';
                } elseif ($i === 32) {
                    $copy->first_response_at = now();
                }
                $copy->save();
            }
        }
        $this->travelTo($this->local('2026-10-23 11:05'));
        foreach ([['orders', 'orders'], ['callback-requests', 'callbackRequests']] as [$route, $key]) {
            $index = route('admin.'.$route.'.index');
            $params = ['response' => 'overdue', 'mine' => 1, 'status' => 'new'];
            if ($route === 'orders') {
                $params['search'] = 'RESPONSE-';
            }
            $this->actingAs($manager)->get($index.'?'.http_build_query($params))->assertOk()
                ->assertViewHas($key, fn ($list) => $list->total() === 31 && $list->hasMorePages())
                ->assertSee('response=overdue', false);
            $this->get($index.'?'.http_build_query($params + ['page' => 2]))->assertOk()
                ->assertViewHas($key, fn ($list) => $list->total() === 31 && $list->count() === 1);
            foreach (['invalid', ['array']] as $invalid) {
                $this->from($index)->get($index.'?'.http_build_query(['response' => $invalid]))->assertSessionHasErrors('response');
            }
        }
    }

    private function local(string $date): CarbonImmutable
    {
        return CarbonImmutable::parse($date, 'Asia/Yekaterinburg');
    }

    private function manager(): User
    {
        return User::factory()->create(['is_admin' => true, 'role' => User::ROLE_ADMINISTRATOR]);
    }

    private function records(): array
    {
        return [
            Order::query()->create(['number' => 'RESPONSE-001', 'customer_name' => 'Клиент', 'phone' => '+79000000000', 'delivery_method' => 'pickup', 'total' => 1000, 'status' => 'new']),
            CallbackRequest::query()->create(['name' => 'Клиент', 'phone' => '+79000000000', 'status' => 'new']),
        ];
    }

    private function url(Order|CallbackRequest $record, string $action = 'update'): string
    {
        return route('admin.'.($record instanceof Order ? 'orders' : 'callback-requests').'.'.$action, $record);
    }
}
