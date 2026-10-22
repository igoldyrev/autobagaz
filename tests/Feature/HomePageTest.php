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
            ->assertSee('Мы работаем с такими брендами')
            ->assertSee('Крепления для активного отдыха')
            ->assertSee('/css/autobagaz.css', escape: false)
            ->assertSee('/css/catalog.css', escape: false)
            ->assertDontSee('Панель администратора')
            ->assertDontSee('Администрирование')
            ->assertDontSee('Фото установок')
            ->assertDontSee('Пока нет опубликованных отзывов')
            ->assertDontSee('href="/news"', escape: false);

        $response->assertSee('Мы используем cookie, чтобы сайт работал корректно и становился удобнее.');

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
            route('privacy-policy').'#analytics',
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
            '/politika-konfidentsialnosti' => 'Политика обработки персональных данных',
            '/soglasie-na-obrabotku-personalnykh-dannykh' => 'Согласие на обработку персональных данных',
        ];

        foreach ($pages as $url => $title) {
            $this->get($url)
                ->assertOk()
                ->assertSee($title)
                ->assertDontSee('Публичная оферта');
        }
    }

    public function test_old_cookie_notice_acceptance_does_not_enable_analytics(): void
    {
        $this->withCookie('autobagaz_cookie_notice', 'accepted')
            ->get('/')
            ->assertOk()
            ->assertSee('data-analytics-accept', false)
            ->assertSee('data-analytics-reject', false)
            ->assertDontSee('https://mc.yandex.ru');
    }

    public function test_disabled_counter_has_no_analytics_controls_or_remote_pixel(): void
    {
        config(['services.yandex_metrika.counter_id' => 0]);
        $this->get('/')->assertOk()
            ->assertDontSee('metrika-config', false)
            ->assertDontSee('data-analytics-accept', false)
            ->assertDontSee('data-analytics-settings', false)
            ->assertDontSee('https://mc.yandex.ru');
    }

    public function test_home_page_images_are_available(): void
    {
        $response = $this->get('/')->assertOk();
        $document = new DOMDocument;

        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);

        $assetHost = parse_url(asset('/'), PHP_URL_HOST);
        $checkedImages = 0;

        foreach ($document->getElementsByTagName('img') as $image) {
            $source = $image->getAttribute('src');
            $host = parse_url($source, PHP_URL_HOST);
            if ($host !== null && $host !== $assetHost) {
                continue;
            }

            $path = parse_url($source, PHP_URL_PATH);

            $this->assertFileExists(public_path(ltrim($path, '/')), 'Изображение недоступно: '.$source);
            $checkedImages++;
        }

        $this->assertGreaterThan(0, $checkedImages, 'На главной странице не найдено изображений для проверки.');
    }
}
