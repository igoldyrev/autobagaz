<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactsPageTest extends TestCase
{
    public function test_contacts_page_is_available_and_contains_current_contact_details(): void
    {
        $this->get(route('contacts'))
            ->assertOk()
            ->assertSee('Магазин «Автобагаж»')
            ->assertSee('+7 (342) 288-99-29')
            ->assertSee('autobagaz@yandex.ru')
            ->assertSee('/content/contacts/shop_autobagaz_dzerzhinskogo-5.jpg', escape: false)
            ->assertSee('catalog-sidebar', escape: false)
            ->assertSee('☰ Категории')
            ->assertSee('112719345');
    }
}
