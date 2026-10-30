<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_rental_page_is_available_at_its_original_address(): void
    {
        $this->get('/prokat')
            ->assertOk()
            ->assertSee('Прокат багажников и боксов в Перми')
            ->assertSee('130 рублей/день')
            ->assertSee('/prokat/documents/contract', escape: false)
            ->assertSee('/prokat/documents/rules', escape: false);
    }

    public function test_rental_documents_are_present(): void
    {
        $this->assertFileExists(public_path('content/prokat/Dogovor_prokata.doc'));
        $this->assertFileExists(public_path('content/prokat/Pravila_ekspluatacii_avtoboksov.doc'));
    }
}
