<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex,nofollow">
        <title>@yield('title', 'Панель управления') — Автобагаж</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    </head>
    <body>
        @yield('body')
        @stack('scripts')
    </body>
</html>
