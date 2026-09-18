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
            ->assertSee('Багажники и автобоксы для вашего автомобиля')
            ->assertSee('Популярные категории')
            ->assertSee('catalog-sidebar', escape: false)
            ->assertSee('☰ Категории')
            ->assertSee('Почему AutoBagaz')
            ->assertSee('Крепления для активного отдыха')
            ->assertSee('/css/autobagaz.css', escape: false)
            ->assertSee('/css/catalog.css', escape: false)
            ->assertDontSee('Панель администратора')
            ->assertDontSee('Администрирование')
            ->assertDontSee('Фото установок')
            ->assertDontSee('Пока нет опубликованных отзывов')
            ->assertDontSee('href="/news"', escape: false);

        $response->assertSee('Мы используем cookie');

        $this->assertSame(0, substr_count($response->getContent(), 'Нет записей'));
    }

    public function test_home_page_has_no_links_to_unavailable_pages(): void
    {
        $response = $this->get('/');
        $document = new DOMDocument;

        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);

        $availableTargets = [
            route('home'),
            route('home').'#popular-categories-title',
            route('catalog.vehicle-fitment.index'),
            route('rental'),
            route('installation'),
            route('promotions.index'),
            route('contacts'),
            route('delivery-payment'),
            route('warranty'),
            route('privacy-policy'),
            route('personal-data-consent'),
            route('catalog.autobagazhniki.index'),
            route('catalog.auto-boxes.index'),
            route('catalog.bike-racks.index'),
            route('catalog.ski-racks.index'),
            route('cart.index'),
            '#',
            '#vehicle-picker',
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

    public function test_information_pages_are_available(): void
    {
        $pages = [
            '/dostavka-i-oplata' => 'Доставка и оплата',
            '/garantiya' => 'Гарантия',
            '/politika-konfidentsialnosti' => 'Политика конфиденциальности',
            '/soglasie-na-obrabotku-personalnykh-dannykh' => 'Согласие на обработку персональных данных',
        ];

        foreach ($pages as $url => $title) {
            $this->get($url)
                ->assertOk()
                ->assertSee($title)
                ->assertDontSee('Публичная оферта');
        }
    }

    public function test_cookie_notice_is_not_shown_after_acceptance(): void
    {
        $this->withCookie('autobagaz_cookie_notice', 'accepted')
            ->get('/')
            ->assertOk()
            ->assertDontSee('Мы используем cookie');
    }

    public function test_home_page_images_are_available(): void
    {
        $response = $this->get('/');
        $document = new DOMDocument;

        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);

        foreach ($document->getElementsByTagName('img') as $image) {
            $source = $image->getAttribute('src');
            if (parse_url($source, PHP_URL_HOST) !== null) {
                continue;
            }

            $path = parse_url($source, PHP_URL_PATH);

            $this->assertFileExists(public_path(ltrim($path, '/')));
        }
    }
}
