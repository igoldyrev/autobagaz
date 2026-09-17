<?php

namespace Tests\Feature;

use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_login_page_is_available_to_guests(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Вход администратора')
            ->assertSee('noindex,nofollow', escape: false);
    }

    public function test_guest_is_redirected_to_login_from_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_administrator_can_log_in_and_view_dashboard(): void
    {
        $queries = [];
        DB::listen(static function ($query) use (&$queries): void {
            $queries[] = $query->sql;
        });

        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'strong-password',
            'is_admin' => true,
        ]);

        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'strong-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
        $this->assertNotNull($admin->fresh()->last_login_at);
        $this->assertNotNull($admin->fresh()->last_seen_at);
        $this->assertDatabaseHas('admin_activity_logs', [
            'user_id' => $admin->id,
            'action' => AdminActivityLog::ACTION_LOGIN,
            'description' => 'Вошёл в панель управления',
        ]);

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee($admin->name);

        $fitmentQuery = collect($queries)->first(static fn (string $query): bool => str_contains($query, 'fitment_product'));
        $this->assertNotNull($fitmentQuery);
        $this->assertStringContainsString('fitment_product', $fitmentQuery);
        $this->assertStringNotContainsString('pivot', $fitmentQuery);
    }

    public function test_invalid_credentials_do_not_authenticate_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->from(route('login'))->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'incorrect-password',
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_non_admin_user_cannot_log_in_to_admin_panel(): void
    {
        $user = User::factory()->create([
            'password' => 'strong-password',
            'is_admin' => false,
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'strong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_non_admin_authenticated_user_receives_forbidden_response(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_login_attempts_are_rate_limited(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        foreach (range(1, 5) as $attempt) {
            $this->post(route('login.store'), [
                'email' => $admin->email,
                'password' => 'incorrect-password',
            ]);
        }

        $response = $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'incorrect-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString(
            'Слишком много попыток входа',
            session('errors')->first('email'),
        );

        $this->assertGuest();
    }

    public function test_administrator_can_log_out(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_administrator_can_view_profile_security_page(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'last_login_at' => now()->subHour(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.profile.security.edit'))
            ->assertOk()
            ->assertSee('Безопасность')
            ->assertSee('Личные данные');
    }

    public function test_administrator_sees_admin_toolbar_on_public_site(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'name' => 'Илья',
        ]);

        $this->actingAs($admin)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Панель администратора')
            ->assertSee('Администрирование')
            ->assertSee('Илья')
            ->assertSee(route('admin.dashboard'))
            ->assertSee(route('admin.profile.show'))
            ->assertSee(route('admin.profile.settings.edit'));
    }

    public function test_regular_user_does_not_see_admin_toolbar_on_public_site(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertDontSee('Панель администратора')
            ->assertDontSee('Администрирование');
    }

    public function test_administrator_can_view_profile_and_update_personal_data_in_settings(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'name' => 'Старое имя',
            'email' => 'old@example.com',
            'last_login_at' => now()->subHour(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.profile.show'))
            ->assertOk()
            ->assertSee('Мой профиль')
            ->assertSee('Последний вход')
            ->assertSee('Старое имя')
            ->assertSee('old@example.com')
            ->assertSee('Мой профиль')
            ->assertSee('Настройки');

        $this->actingAs($admin)
            ->get(route('admin.profile.settings.edit'))
            ->assertOk()
            ->assertSee('Настройки профиля')
            ->assertSee('Личные данные')
            ->assertSee('Безопасность');

        $this->actingAs($admin)
            ->put(route('admin.profile.settings.update'), [
                'name' => 'Новое имя',
                'email' => 'new@example.com',
                'phone' => '+7 900 123-45-67',
            ])
            ->assertRedirect(route('admin.profile.settings.edit'))
            ->assertSessionHas('success', 'Личные данные сохранены.');

        $admin->refresh();

        $this->assertSame('Новое имя', $admin->name);
        $this->assertSame('new@example.com', $admin->email);
        $this->assertSame('+7 900 123-45-67', $admin->phone);
    }

    public function test_profile_email_must_be_unique(): void
    {
        User::factory()->create(['email' => 'occupied@example.com']);
        $admin = User::factory()->create(['is_admin' => true, 'email' => 'admin@example.com']);

        $this->actingAs($admin)
            ->from(route('admin.profile.settings.edit'))
            ->put(route('admin.profile.settings.update'), [
                'name' => $admin->name,
                'email' => 'occupied@example.com',
                'phone' => '',
            ])
            ->assertRedirect(route('admin.profile.settings.edit'))
            ->assertSessionHasErrors('email');

        $this->assertSame('admin@example.com', $admin->fresh()->email);
    }

    public function test_administrator_can_change_password(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'password' => 'current-password',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.profile.security.password.update'), [
                'current_password' => 'current-password',
                'password' => 'new-strong-password',
                'password_confirmation' => 'new-strong-password',
            ])
            ->assertRedirect(route('admin.profile.security.edit'));

        $this->assertTrue(Hash::check('new-strong-password', $admin->fresh()->password));
    }

    public function test_password_change_requires_current_password(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'password' => 'current-password',
        ]);

        $this->actingAs($admin)
            ->from(route('admin.profile.security.edit'))
            ->put(route('admin.profile.security.password.update'), [
                'current_password' => 'incorrect-password',
                'password' => 'new-strong-password',
                'password_confirmation' => 'new-strong-password',
            ])
            ->assertRedirect(route('admin.profile.security.edit'))
            ->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('current-password', $admin->fresh()->password));
    }

    public function test_administrator_can_terminate_other_sessions(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'password' => 'current-password',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.profile.security.sessions.destroy'), [
                'current_password' => 'current-password',
            ])
            ->assertRedirect(route('admin.profile.security.edit'))
            ->assertSessionHas('success', 'Другие активные сеансы завершены.');
    }

    public function test_admin_create_command_creates_administrator(): void
    {
        $this->artisan('admin:create', ['email' => 'owner@example.com', '--name' => 'Владелец'])
            ->expectsQuestion('Пароль (не менее 12 символов)', 'very-strong-password')
            ->expectsQuestion('Повторите пароль', 'very-strong-password')
            ->expectsOutput('Администратор успешно создан.')
            ->assertSuccessful();

        $admin = User::query()->where('email', 'owner@example.com')->firstOrFail();

        $this->assertTrue($admin->is_admin);
        $this->assertSame('Владелец', $admin->name);
        $this->assertTrue(Hash::check('very-strong-password', $admin->password));
    }
}
