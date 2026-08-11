<?php

namespace Tests\Feature;

use DOMDocument;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_is_available(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Купить багажник в Перми теперь не проблема')
            ->assertSee('Нет записей')
            ->assertSee('/css/autobagaz.css', escape: false)
            ->assertDontSee('href="/news"', escape: false);

        $this->assertSame(2, substr_count($response->getContent(), 'Нет записей'));
    }

    public function test_home_page_has_no_links_to_unavailable_pages(): void
    {
        $response = $this->get('/');
        $document = new DOMDocument;

        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);

        $availableTargets = [
            route('home'),
            '#',
            '#mobile-menu',
            'mailto:autobagaz@yandex.ru',
            'tel:+73422889929',
            'https://vk.com/autobagaz',
        ];

        foreach ($document->getElementsByTagName('a') as $link) {
            $this->assertContains(
                $link->getAttribute('href'),
                $availableTargets,
                sprintf('Unexpected link target: %s', $link->getAttribute('href')),
            );
        }
    }

    public function test_home_page_images_are_available(): void
    {
        $response = $this->get('/');
        $document = new DOMDocument;

        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);

        foreach ($document->getElementsByTagName('img') as $image) {
            $path = parse_url($image->getAttribute('src'), PHP_URL_PATH);

            $this->assertFileExists(public_path(ltrim($path, '/')));
        }
    }
}
