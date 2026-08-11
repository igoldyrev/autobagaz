# Автобагаж

Новая версия сайта «Автобагаж» на Laravel 13.

## Локальный запуск

Требования: PHP 8.3+, Composer и Node.js с npm.

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan serve
```

После запуска главная страница доступна по адресу `http://127.0.0.1:8000`.

Для работы с базой данных установите драйвер PDO SQLite или укажите другое
подключение в `.env`, затем выполните:

```bash
php artisan migrate
```

## Разработка

```bash
composer run dev
```

Тесты и проверка форматирования:

```bash
php artisan test
vendor/bin/pint --test
```
