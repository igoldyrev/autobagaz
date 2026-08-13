<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee($admin->name);
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
