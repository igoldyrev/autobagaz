<?php

namespace Tests\Feature;

use App\Jobs\SendOrderNotification;
use App\Mail\CallbackRequested;
use App\Models\AdminActivityLog;
use App\Models\CallbackRequest;
use App\Models\OrderNotification;
use App\Models\User;
use App\Support\PersonalDataConsent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CallbackArchiveAndConsentTest extends TestCase
{
    use RefreshDatabase;

    public function test_archive_removes_contacts_consent_history_and_notifications_at_90_day_boundary(): void
    {
        $this->travelTo(now()->startOfSecond());
        $manager = User::factory()->create(['is_admin' => true]);
        $records = [];
        foreach (['new', 'in_progress', 'completed', 'cancelled'] as $status) {
            $record = CallbackRequest::query()->create([
                'name' => 'Клиент', 'phone' => '+79000000000', 'status' => $status,
                'assignee_id' => $manager->id, ...PersonalDataConsent::attributes(),
            ]);
            $record->forceFill(['created_at' => now()->subDays(90)])->save();
            AdminActivityLog::query()->create([
                'user_id' => $manager->id, 'user_name' => $manager->name, 'action' => 'updated',
                'subject_type' => 'callback_request', 'subject_id' => $record->id,
                'subject_name' => 'Клиент', 'description' => 'Позвонить +79000000000',
            ]);
            OrderNotification::query()->create([
                'callback_request_id' => $record->id, 'type' => 'callback_requested', 'recipient' => 'manager@example.com',
            ]);
            $records[] = $record;
        }
        $recent = CallbackRequest::query()->create(['name' => 'Новая заявка', 'phone' => '+79000000001']);
        $recent->forceFill(['created_at' => now()->subDays(90)->addSecond()])->save();

        $this->artisan('callbacks:archive')->assertSuccessful();
        foreach ($records as $record) {
            $archived = $record->fresh();
            $this->assertTrue($archived->archived_at->equalTo(now()));
            foreach (['status', 'assignee_id', 'created_at'] as $field) {
                $this->assertEquals($record->$field, $archived->$field);
            }
            $this->assertSame('Контактные данные удалены', $archived->name);
            $this->assertSame('', $archived->phone);
            $this->assertNull($archived->consent_accepted_at);
            $this->assertNull($archived->consent_version);
            $this->assertNull($archived->consent_text);
            $this->assertTrue($archived->anonymized_at->equalTo(now()));
        }
        $this->assertDatabaseCount('admin_activity_logs', 0);
        $this->assertDatabaseCount('order_notifications', 0);
        $this->assertSame('+79000000001', $recent->fresh()->phone);
        $this->assertNull($recent->fresh()->archived_at);
        $this->travel(1)->seconds();
        $this->artisan('callbacks:archive')->assertSuccessful();
        $this->assertTrue($recent->fresh()->archived_at->equalTo(now()));
        $this->assertTrue($records[0]->fresh()->archived_at->equalTo(now()->subSecond()));
        $this->assertDatabaseCount('callback_requests', 5);
    }

    public function test_archive_is_separate_filterable_and_keeps_existing_access_permissions(): void
    {
        $manager = User::factory()->create(['is_admin' => true]);
        $active = CallbackRequest::query()->create(['name' => 'Активная заявка', 'phone' => '+79000000000']);
        $archived = CallbackRequest::query()->create(['name' => 'Архивная заявка', 'phone' => '+79000000001', 'assignee_id' => $manager->id]);
        $archived->forceFill(['created_at' => now()->subDays(91), 'archived_at' => now()->subDay()])->save();
        $this->artisan('callbacks:archive')->assertSuccessful();
        $url = route('admin.callback-requests.index');

        $this->actingAs($manager)->get($url)->assertOk()
            ->assertViewHas('callbackRequests', fn ($list) => $list->total() === 1 && $list->first()->is($active));
        $this->get($url.'?archived=1&mine=1&status=new')->assertOk()
            ->assertViewHas('callbackRequests', fn ($list) => $list->total() === 1 && $list->first()->is($archived));
        $this->get(route('admin.dashboard'))->assertOk()->assertViewHas('attentionItems',
            fn ($items) => collect($items)->firstWhere('label', 'новых заявок на обратный звонок')['count'] === 1);
        $this->get(route('admin.callback-requests.show', $archived))->assertOk()
            ->assertSee('Контактные данные удалены')->assertDontSee($archived->phone)
            ->assertDontSee('name="status"', false);
        $this->put(route('admin.callback-requests.update', $archived), ['status' => 'in_progress', 'expected_status' => 'new'])
            ->assertSessionHasErrors('status');

        $restricted = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER]);
        $this->actingAs($restricted)->get($url.'?archived=1')->assertForbidden();
        $this->get(route('admin.callback-requests.show', $archived))->assertForbidden();
    }

    public function test_callback_requires_current_explicit_consent_and_saves_server_evidence(): void
    {
        Mail::fake();
        $this->travelTo(now()->startOfSecond());
        $data = ['name' => 'Клиент', 'phone' => '+79000000000', 'consent_version' => PersonalDataConsent::VERSION];
        foreach ([null, '0', 'false'] as $value) {
            $this->post(route('callback.store'), $data + ['personal_data_consent' => $value])
                ->assertSessionHasErrors('personal_data_consent', errorBag: 'callback');
        }
        foreach ([null, 'outdated'] as $version) {
            $this->post(route('callback.store'), array_replace($data, ['personal_data_consent' => '1', 'consent_version' => $version]))
                ->assertSessionHasErrors('consent_version', errorBag: 'callback');
        }
        $this->assertDatabaseCount('callback_requests', 0);
        $this->post(route('callback.store'), $data + ['personal_data_consent' => '1', 'consent_text' => 'Forged', 'consent_accepted_at' => '2000-01-01'])
            ->assertSessionHas('callback_success');
        $record = CallbackRequest::query()->sole();
        $this->assertSame(PersonalDataConsent::VERSION, $record->consent_version);
        $this->assertTrue($record->consent_accepted_at->equalTo(now()));
        $this->assertSame(PersonalDataConsent::attributes()['consent_text'], $record->consent_text);
    }

    public function test_published_documents_and_callback_form_describe_contact_removal(): void
    {
        $this->get(route('home'))->assertOk()->assertSee('id="callback-consent"', false);
        $this->get(route('personal-data-consent'))->assertOk()->assertSee('2026-10-22')
            ->assertSee('Архив контактных данных не формируется.')
            ->assertSee('autobagaz@yandex.ru');
        $this->get(route('privacy-policy'))->assertOk()
            ->assertSee('В админке сохраняется запись без контактных данных:')
            ->assertSee('Политика обработки персональных данных');
    }

    public function test_expired_pending_notification_is_not_sent_and_new_mail_contains_only_a_link(): void
    {
        Mail::fake();
        $record = CallbackRequest::query()->create(['name' => 'Секретное имя', 'phone' => '+79999999999']);
        $body = (new CallbackRequested($record))->render();
        $this->assertStringNotContainsString($record->name, $body);
        $this->assertStringNotContainsString($record->phone, $body);
        $this->assertStringContainsString(route('admin.callback-requests.show', $record), $body);
        $record->forceFill(['created_at' => now()->subDays(90)])->save();
        $notification = OrderNotification::query()->create([
            'callback_request_id' => $record->id, 'type' => 'callback_requested', 'recipient' => 'manager@example.com',
        ]);
        (new SendOrderNotification($notification->id))->handle();
        Mail::assertNothingSent();
        $this->assertDatabaseMissing('order_notifications', ['id' => $notification->id]);
    }
}
