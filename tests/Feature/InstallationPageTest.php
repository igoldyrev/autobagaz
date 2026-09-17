<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstallationPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_installation_page_displays_available_service_and_booking_action(): void
    {
        $this->get(route('installation'))
            ->assertOk()
            ->assertSee('Установка багажных систем')
            ->assertSee('Установка в магазине')
            ->assertSee('2 500 ₽')
            ->assertSee('data-metrika-goal="installation_booking_opened"', escape: false);
    }
}
