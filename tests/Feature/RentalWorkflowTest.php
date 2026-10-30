<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\RentalRequest;
use App\Models\RentalService;
use App\Models\User;
use App\Support\PersonalDataConsent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class RentalWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private function manager(): User
    {
        return User::factory()->create(['is_admin' => true, 'role' => User::ROLE_ADMINISTRATOR]);
    }

    private function payload(array $overrides = []): array
    {
        return [...[
            'submission_token' => (string) Str::uuid(), 'name' => 'Покупатель', 'phone' => '+7 (900) 123-45-67',
            'group' => 0, 'quantity' => 2, 'starts_on' => now()->addDay()->toDateString(), 'ends_on' => now()->addDays(3)->toDateString(),
            'personal_data_consent' => 1, 'consent_version' => PersonalDataConsent::VERSION,
        ], ...$overrides];
    }

    private function rental(array $overrides = []): RentalRequest
    {
        return RentalRequest::query()->create([
            ...PersonalDataConsent::attributes(), 'submission_token' => (string) Str::uuid(), 'name' => 'Покупатель', 'phone' => '+79001234567',
            'equipment' => 'Автобокс', 'quantity' => 1, 'starts_on' => now()->toDateString(), 'ends_on' => now()->addDays(2)->toDateString(),
            'daily_price' => 100, 'rental_total' => 300, 'buyout_price' => 10000,
            'deposit_type' => 'money', 'deposit_required' => 10000, 'status' => 'confirmed',
            'original_request' => ['equipment' => 'Автобокс', 'quantity' => 1, 'starts_on' => now()->toDateString(), 'ends_on' => now()->addDays(2)->toDateString(), 'daily_price' => 100],
            ...$overrides,
        ]);
    }

    private function action(RentalRequest $rental, string $action, array $data = [])
    {
        return $this->put(route('admin.rental-requests.update', $rental), [
            'version' => $rental->fresh()->version, 'action' => $action, 'confirmed' => 1, ...$data,
        ]);
    }

    public function test_public_form_creates_only_one_request_with_price_snapshot_and_consent(): void
    {
        $manager = $this->manager();
        config(['orders.default_assignee_id' => $manager->id]);
        $this->get('/prokat')->assertOk()->assertSee('Заявка на прокат');
        $payload = $this->payload(['submission_token' => session('rental_submission_token')]);
        $this->post('/prokat', [...$payload, 'rental_total' => 1])->assertRedirect('/prokat#rental-success')->assertSessionHasNoErrors()->assertSessionHas('rental_success');
        $this->post('/prokat', $payload)->assertRedirect('/prokat#rental-success')->assertSessionHasNoErrors()->assertSessionHas('rental_success');
        $this->assertDatabaseCount('rental_requests', 1);
        $r = RentalRequest::query()->firstOrFail();
        $this->assertSame('780.00', $r->rental_total);
        $this->assertSame('130.00', $r->daily_price);
        $this->assertSame('0.00', $r->rental_paid);
        $this->assertSame($manager->id, $r->assignee_id);
        $this->assertNotNull($r->response_due_at);
        $this->assertNotNull($r->consent_accepted_at);
        $this->assertSame(PersonalDataConsent::VERSION, $r->consent_version);
        RentalService::current()->update(['rates' => [['min_days' => 1, 'max_days' => null, 'prices' => [999, 999]]]]);
        $this->assertSame('130.00', $r->fresh()->daily_price);
        $this->get('/prokat')->assertOk()
            ->assertSee('Заявка отправлена!')
            ->assertSee('Заявка на прокат №'.$r->id.' принята.')
            ->assertSee('id="rental-success"', false);
        $this->assertNotSame($payload['submission_token'], session('rental_submission_token'));
    }

    public function test_public_validation_rejects_bad_dates_consent_spam_and_forged_token(): void
    {
        $payload = $this->payload();
        $this->withSession(['rental_submission_token' => $payload['submission_token']]);
        foreach ([['ends_on' => '2020-01-01'], ['personal_data_consent' => 0], ['website' => 'spam'], ['group' => 8], ['quantity' => 0], ['consent_version' => 'old']] as $invalid) {
            $this->post('/prokat', [...$payload, ...$invalid])->assertSessionHasErrors();
        }
        $this->post('/prokat', [...$payload, 'submission_token' => (string) Str::uuid()])->assertStatus(419);
        $this->assertDatabaseCount('rental_requests', 0);
    }

    public function test_disabled_service_keeps_prices_and_documents_but_rejects_requests(): void
    {
        RentalService::current()->update(['is_available' => false]);
        $this->get('/prokat')->assertOk()->assertSee('Приём заявок на прокат временно отключён')->assertDontSee('name="submission_token"', false);
        $payload = $this->payload(['submission_token' => session('rental_submission_token')]);
        $this->post('/prokat', $payload)->assertStatus(422);
        $this->get(route('rental.document', 'contract'))->assertDownload('Dogovor_prokata.doc');
        $this->get(route('rental.document', 'invalid'))->assertNotFound();
    }

    public function test_large_price_and_quantity_cannot_overflow_stored_total(): void
    {
        RentalService::current()->update(['rates' => [['min_days' => 1, 'max_days' => null, 'prices' => [1000000, 1000000]]]]);
        $payload = $this->payload(['quantity' => 100, 'ends_on' => now()->addDays(200)->toDateString()]);
        $this->withSession(['rental_submission_token' => $payload['submission_token']])->post('/prokat', $payload)->assertSessionHasErrors('quantity');
        $this->assertDatabaseCount('rental_requests', 0);
    }

    public function test_tariff_boundaries_have_no_overlap(): void
    {
        $s = RentalService::current();
        foreach ([1 => '130.00', 14 => '130.00', 15 => '110.00', 21 => '110.00', 22 => '90.00'] as $days => $price) {
            $this->assertSame($price, $s->dailyPrice(0, $days));
        }
    }

    public function test_settings_and_document_replacement_are_used_on_public_page(): void
    {
        Storage::fake('local');
        $this->actingAs($this->manager());
        $service = RentalService::current();
        $data = $service->only(['name', 'description', 'conditions', 'is_available', 'groups', 'rates']);
        $data['rates'][0]['prices'][0] = 155;
        $data['contract'] = UploadedFile::fake()->createWithContent('contract.pdf', "%PDF-1.4\nTest document\n%%EOF");
        $this->get(route('admin.products.rental-service.edit'))->assertOk();
        $this->put(route('admin.products.rental-service.update'), $data)->assertSessionHasNoErrors();
        $path = $service->fresh()->contract_path;
        Storage::disk('local')->assertExists($path);
        $this->get('/prokat')->assertOk()->assertSee('155 рублей/день');
        $this->get(route('rental.document', 'contract'))->assertDownload('Dogovor_prokata.pdf');
        $data['contract'] = UploadedFile::fake()->createWithContent('new.pdf', "%PDF-1.4\nReplacement\n%%EOF");
        $this->put(route('admin.products.rental-service.update'), $data)->assertSessionHasNoErrors();
        Storage::disk('local')->assertMissing($path);
        $this->assertNotSame($path, $service->fresh()->contract_path);
    }

    public function test_invalid_tariff_ranges_and_files_are_rejected(): void
    {
        $this->actingAs($this->manager());
        $data = RentalService::current()->only(['name', 'description', 'conditions', 'groups', 'rates']);
        $data['rates'][2]['min_days'] = 21;
        $this->put(route('admin.products.rental-service.update'), $data)->assertSessionHasErrors('rates');
        $data['rates'][2]['min_days'] = 22;
        $data['rules'] = UploadedFile::fake()->create('script.php', 1, 'text/x-php');
        $this->put(route('admin.products.rental-service.update'), $data)->assertSessionHasErrors('rules');
        $this->assertSame(22, RentalService::current()->rates[2]['min_days']);
    }

    public function test_admin_permissions_are_separate_for_content_and_order_processing(): void
    {
        $r = $this->rental();
        $this->get(route('admin.rental-requests.index'))->assertRedirect();
        $content = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER]);
        $this->actingAs($content)->get(route('admin.products.rental-service.edit'))->assertOk();
        $this->get(route('admin.rental-requests.index'))->assertForbidden();
        $this->action($r, 'issue')->assertForbidden();
        $processor = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_CONTENT_MANAGER, 'permissions' => [User::PERMISSION_ORDERS]]);
        $this->actingAs($processor)->get(route('admin.rental-requests.index'))->assertOk();
        $this->get(route('admin.products.rental-service.edit'))->assertForbidden();
    }

    public function test_cards_render_forms_for_each_stage_and_require_operation_confirmation(): void
    {
        $this->actingAs($this->manager());
        foreach (['new', 'in_progress', 'confirmed', 'rented', 'returned', 'completed', 'purchased', 'cancelled'] as $status) {
            $r = $this->rental(['status' => $status]);
            $this->get(route('admin.rental-requests.show', $r))->assertOk()->assertSee($r->statusLabel());
        }
        $r = $this->rental();
        $this->action($r, 'receive_deposit', ['amount' => 10000, 'confirmed' => 0])->assertSessionHasErrors('confirmed');
        $this->assertNull($r->fresh()->deposit_received_at);
        $this->action($r, 'rental_payment', ['amount' => 301])->assertSessionHasErrors('action');
        $this->assertSame('0.00', $r->fresh()->rental_paid);
    }

    public function test_money_deposit_return_and_completion_require_settled_balances(): void
    {
        $this->actingAs($this->manager());
        $r = $this->rental();
        $this->action($r, 'issue')->assertSessionHasErrors('action');
        $this->action($r, 'receive_deposit', ['amount' => 9000])->assertSessionHasErrors('action');
        $this->action($r, 'receive_deposit', ['amount' => 10000])->assertSessionHasNoErrors();
        $this->action($r, 'issue')->assertSessionHasNoErrors();
        $this->action($r, 'cancel', ['note' => 'Причина'])->assertSessionHasErrors('action');
        $this->action($r, 'return_deposit', ['amount' => 10000])->assertSessionHasErrors('action');
        $this->action($r, 'return_equipment')->assertSessionHasNoErrors();
        $this->action($r, 'complete')->assertSessionHasErrors('action');
        $this->action($r, 'rental_payment', ['amount' => 300])->assertSessionHasNoErrors();
        $this->action($r, 'complete')->assertSessionHasErrors('action');
        $this->action($r, 'return_deposit', ['amount' => 9000])->assertSessionHasNoErrors();
        $this->action($r, 'withhold_deposit', ['amount' => 1000, 'note' => 'Повреждение'])->assertSessionHasNoErrors();
        $this->action($r, 'complete')->assertSessionHasNoErrors();
        $this->assertSame('completed', $r->fresh()->status);
        $this->assertSame(0, $r->fresh()->depositBalance());
        $this->assertNotNull($r->fresh()->issued_at);
        $this->assertNotNull($r->fresh()->returned_at);
        $this->assertNotNull($r->fresh()->response_stopped_at);
    }

    public function test_buyout_records_deposit_application_and_actual_supplement(): void
    {
        $this->actingAs($this->manager());
        foreach ([8000, 10000, 12000] as $deposit) {
            $r = $this->rental(['deposit_required' => $deposit]);
            $this->action($r, 'receive_deposit', ['amount' => $deposit])->assertSessionHasNoErrors();
            $this->action($r, 'issue')->assertSessionHasNoErrors();
            $this->action($r, 'purchase', ['buyout_paid' => max(0, 10000 - $deposit)])->assertSessionHasErrors('action');
            $this->action($r, 'rental_payment', ['amount' => 300])->assertSessionHasNoErrors();
            $this->action($r, 'purchase', ['buyout_paid' => 999])->assertSessionHasErrors('action');
            $this->action($r, 'purchase', ['buyout_paid' => max(0, 10000 - $deposit)])->assertSessionHasNoErrors();
            $r->refresh();
            $this->assertSame('purchased', $r->status);
            $this->assertSame(min($deposit, 10000) * 100, RentalRequest::cents($r->deposit_applied));
            $this->assertSame(max(0, $deposit - 10000) * 100, RentalRequest::cents($r->deposit_returned));
            $this->assertSame(0, $r->depositBalance());
            $this->assertNull($r->returned_at);
        }
    }

    public function test_document_terms_do_not_require_money_and_money_terms_require_positive_amount(): void
    {
        $this->actingAs($this->manager());
        $r = $this->rental(['status' => 'in_progress', 'deposit_type' => null]);
        $terms = [
            'equipment' => 'Автобокс', 'quantity' => 1,
            'starts_on' => $r->starts_on->toDateString(), 'ends_on' => $r->ends_on->toDateString(),
            'daily_price' => 100, 'buyout_price' => 10000,
            'deposit_type' => 'document', 'deposit_document' => 'Документ по договору',
        ];
        $this->action($r, 'terms', [...$terms, 'deposit_type' => 'money'])->assertSessionHasErrors('deposit_required');
        $this->action($r, 'terms', [...$terms, 'deposit_type' => 'money', 'deposit_required' => 0])->assertSessionHasErrors('deposit_required');
        $this->action($r, 'terms', [...$terms, 'deposit_document' => ''])->assertSessionHasErrors('deposit_document');
        foreach ([[], ['deposit_required' => ''], ['deposit_required' => 5000]] as $amount) {
            $this->action($r, 'terms', [...$terms, ...$amount])->assertSessionHasNoErrors();
            $this->assertSame('document', $r->fresh()->deposit_type);
            $this->assertSame('0.00', $r->fresh()->deposit_required);
        }
        $this->action($r, 'confirm')->assertSessionHasNoErrors();
        $this->action($r, 'receive_deposit', ['amount' => 0])->assertSessionHasNoErrors();
        $this->action($r, 'issue')->assertSessionHasNoErrors();
        $this->assertSame('rented', $r->fresh()->status);
    }

    public function test_document_deposit_must_be_returned_and_is_not_applied_to_buyout(): void
    {
        $this->actingAs($this->manager());
        $r = $this->rental(['deposit_type' => 'document', 'deposit_document' => 'Документ по договору', 'deposit_required' => 0]);
        $this->action($r, 'receive_deposit', ['amount' => 0])->assertSessionHasNoErrors();
        $this->action($r, 'issue')->assertSessionHasNoErrors();
        $this->action($r, 'rental_payment', ['amount' => 300])->assertSessionHasNoErrors();
        $this->action($r, 'purchase', ['buyout_paid' => 0])->assertSessionHasErrors('action');
        $this->action($r, 'purchase', ['buyout_paid' => 10000])->assertSessionHasNoErrors();
        $this->assertNotNull($r->fresh()->deposit_returned_at);
        $this->assertSame('0.00', $r->fresh()->deposit_applied);
        $second = $this->rental(['deposit_type' => 'document', 'deposit_document' => 'Документ', 'deposit_required' => 0]);
        $this->action($second, 'receive_deposit', ['amount' => 0])->assertSessionHasNoErrors();
        $this->action($second, 'issue')->assertSessionHasNoErrors();
        $this->action($second, 'return_equipment')->assertSessionHasNoErrors();
        $this->action($second, 'rental_payment', ['amount' => 300])->assertSessionHasNoErrors();
        $this->action($second, 'complete')->assertSessionHasErrors('action');
        $this->action($second, 'return_deposit', ['amount' => 0])->assertSessionHasNoErrors();
        $this->action($second, 'complete')->assertSessionHasNoErrors();
    }

    public function test_cancel_before_issue_requires_refund_and_reason(): void
    {
        $this->actingAs($this->manager());
        $r = $this->rental();
        $this->action($r, 'receive_deposit', ['amount' => 10000])->assertSessionHasNoErrors();
        $this->action($r, 'rental_payment', ['amount' => 300])->assertSessionHasNoErrors();
        $this->action($r, 'cancel', ['note' => 'Отмена клиентом'])->assertSessionHasErrors('action');
        $this->action($r, 'return_deposit', ['amount' => 10000])->assertSessionHasNoErrors();
        $this->action($r, 'rental_refund', ['amount' => 300])->assertSessionHasNoErrors();
        $this->action($r, 'cancel')->assertSessionHasErrors('note');
        $this->action($r, 'cancel', ['note' => 'Отмена клиентом'])->assertSessionHasNoErrors();
        $this->assertSame('cancelled', $r->fresh()->status);
    }

    public function test_stale_or_duplicate_financial_operations_cannot_apply_twice(): void
    {
        $this->actingAs($this->manager());
        $r = $this->rental();
        $version = $r->fresh()->version;
        $this->action($r, 'receive_deposit', ['amount' => 10000])->assertSessionHasNoErrors();
        $this->action($r, 'receive_deposit', ['amount' => 10000, 'version' => $version])->assertSessionHasErrors('action');
        $this->action($r, 'receive_deposit', ['amount' => 10000])->assertSessionHasErrors('action');
        $this->assertSame('10000.00', $r->fresh()->deposit_received);
        $this->assertSame(1, AdminActivityLog::query()->where('subject_type', 'rental_request')->count());
    }

    public function test_confirmation_without_deposit_guides_manager_to_terms_before_confirming(): void
    {
        $this->actingAs($this->manager());
        $r = $this->rental(['status' => 'in_progress', 'deposit_type' => null]);
        $this->get(route('admin.rental-requests.show', $r))->assertOk()
            ->assertSee('Как работать с прокатом')
            ->assertSee('Заполнить условия и залог')
            ->assertSee('href="#rental-terms"', false);
        $this->action($r, 'confirm')->assertSessionHasErrors([
            'action' => 'Откройте блок «Условия проката и залога», выберите тип залога, укажите сумму или документ и нажмите «Сохранить условия». Затем подтвердите заявку.',
        ]);
        $this->assertSame('in_progress', $r->fresh()->status);
        $this->action($r, 'terms', [
            'equipment' => 'Автобокс', 'quantity' => 1,
            'starts_on' => $r->starts_on->toDateString(), 'ends_on' => $r->ends_on->toDateString(),
            'daily_price' => 100, 'buyout_price' => 10000,
            'deposit_type' => 'money', 'deposit_required' => 10000,
        ])->assertSessionHasNoErrors();
        $this->get(route('admin.rental-requests.show', $r))->assertOk()->assertDontSee('Заполнить условия и залог');
        $this->action($r, 'confirm')->assertSessionHasNoErrors();
        $this->assertSame('confirmed', $r->fresh()->status);
    }

    public function test_terms_recalculate_total_and_become_locked_after_confirmation(): void
    {
        $this->actingAs($this->manager());
        $r = $this->rental(['status' => 'new', 'deposit_type' => null]);
        $terms = ['equipment' => 'Бокс Thule', 'quantity' => 2, 'starts_on' => now()->toDateString(), 'ends_on' => now()->addDays(4)->toDateString(), 'daily_price' => '120.50', 'buyout_price' => 20000, 'deposit_type' => 'money', 'deposit_required' => 20000];
        $this->action($r, 'terms', $terms)->assertSessionHasNoErrors();
        $this->assertSame('1205.00', $r->fresh()->rental_total);
        $this->action($r, 'start')->assertSessionHasNoErrors();
        $this->action($r, 'confirm')->assertSessionHasNoErrors();
        $this->action($r, 'terms', $terms)->assertSessionHasErrors('action');
        $this->action($r, 'revise')->assertSessionHasNoErrors();
        $this->action($r, 'terms', [...$terms, 'daily_price' => '100.00'])->assertSessionHasNoErrors();
        $this->assertSame('1000.00', $r->fresh()->rental_total);
    }

    public function test_contact_comments_history_filters_and_closed_request_immutability(): void
    {
        $manager = $this->manager();
        $this->actingAs($manager);
        $r = $this->rental(['status' => 'in_progress', 'assignee_id' => $manager->id]);
        $this->action($r, 'contact_failed', ['note' => 'Не ответил'])->assertSessionHasNoErrors();
        $this->assertNull($r->fresh()->first_response_at);
        $this->action($r, 'contact', ['note' => 'Условия согласованы по телефону'])->assertSessionHasNoErrors();
        $at = $r->fresh()->first_response_at;
        $this->travel(10)->minutes();
        $this->action($r, 'contact', ['note' => 'Повторный звонок'])->assertSessionHasNoErrors();
        $this->assertTrue($at->equalTo($r->fresh()->first_response_at));
        $this->action($r, 'cancel', ['note' => 'Клиент передумал'])->assertSessionHasNoErrors();
        $this->action($r, 'assign', ['assignee_id' => $manager->id])->assertSessionHasErrors('action');
        $this->action($r, 'comment', ['note' => 'Комментарий после закрытия'])->assertSessionHasNoErrors();
        $this->get(route('admin.rental-requests.show', $r))->assertOk()->assertSee('История изменений')->assertSee('Комментарий после закрытия');
        $this->get(route('admin.rental-requests.index', ['search' => '+7 (900) 123-45-67', 'mine' => 1, 'response' => 'answered']))->assertOk()->assertSee('№'.$r->id);
    }

    public function test_overdue_return_and_extension_use_saved_tariff(): void
    {
        $this->actingAs($this->manager());
        $r = $this->rental(['status' => 'rented', 'starts_on' => now()->subDays(5)->toDateString(), 'ends_on' => now()->subDay()->toDateString()]);
        $this->assertTrue($r->isOverdue());
        $this->get(route('admin.rental-requests.index', ['overdue' => 1]))->assertOk()->assertSee('№'.$r->id);
        $this->action($r, 'extend', ['ends_on' => now()->addDay()->toDateString(), 'note' => 'Согласовано с клиентом'])->assertSessionHasNoErrors();
        $this->assertSame('700.00', $r->fresh()->rental_total);
        $this->assertFalse($r->fresh()->isOverdue());
        $this->get(route('admin.rental-requests.show', $r))->assertOk()->assertSee('Продлить прокат');
    }
}
