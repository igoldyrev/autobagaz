<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <main class="home">
            <section class="home__content">
                <p class="home__eyebrow">Автобагаж</p>
                <h1>Новый сайт на Laravel</h1>
                <p class="home__description">
                    Базовый проект готов. Контент, вёрстка, стили и адреса страниц
                    будут перенесены из основной версии сайта.
                </p>
                <span class="home__status">Laravel {{ app()->version() }}</span>
            </section>
        </main>
    </body>
</html>
