# Обновление зависимостей и проверка сервера 22 октября 2026

Исправленные зависимости и production-сборка опубликованы на
https://new.autobagaz.ru. Вопрос обновления самого PHP остаётся открытым:
владелец проверяет настройки хостинга самостоятельно.

## Зависимости

Повторные `composer audit --locked --format=json` и `npm audit --json`
подтвердили предупреждения от 20 октября; дополнительно npm обнаружил
уязвимости Vite 8.2.1. После обновления оба аудита возвращают ноль уязвимостей.
Исключения и подавление предупреждений не добавлялись.

| Пакет | До | После |
| --- | --- | --- |
| laravel/framework | 13.25.0 | 13.30.0 |
| league/commonmark | 2.10.0 | 2.10.2 |
| league/flysystem | 3.35.2 | 3.36.0 |
| symfony/http-foundation | 7.4.16 | 7.4.19 |
| concurrently | 9.2.4 | 9.2.5 |
| shell-quote | 1.9.0 | 1.12.0 |
| source-map-js | 1.2.1 | 1.2.2 |
| vite | 8.2.1 | 8.2.4 |

Сопутствующие изменения npm ограничены требованием Vite к Rolldown 1.2.4,
его платформенными пакетами и @oxc-project/types 0.144.0. Ограничения в
composer.json и package.json сохранены. Остальные версии PHP-пакетов сохранены.

PHP-зависимости обновлены командой:

```bash
composer update laravel/framework:13.30.0 league/commonmark:2.10.2 \
  league/flysystem:3.36.0 symfony/http-foundation:7.4.19 \
  --with-dependencies --minimal-changes
```

## Достижимость сценариев

- Symfony: разбор Cache-Control происходит при создании HTTP-запроса,
  до авторизации; это непосредственно доступный серверный сценарий.
  [Сообщение Symfony](https://symfony.com/cve-2026-108082).
- Laravel: XSS связан с debug-страницей. На сервере до и после публикации
  подтверждены APP_DEBUG=false в .env и app.debug=false в загруженной
  конфигурации Laravel.
  [Описание](https://github.com/advisories/GHSA-jh5r-qr3c-85q8).
- CommonMark: прямого преобразования пользовательского Markdown и использования
  уязвимых расширений в app, routes и resources не найдено. Пакет всё равно
  обновлён, поскольку входит в production-зависимости Laravel.
  [HTML](https://github.com/advisories/GHSA-97jj-33gv-5xf9),
  [таблицы](https://github.com/advisories/GHSA-3q6v-r5mr-hxv8).
- Flysystem: загрузки изображений проходят через административные обработчики,
  каталоги задаёт приложение, имена файлов генерирует UploadedFile::store.
  Прямой передачи произвольного пользовательского пути при загрузке не найдено.
  Это ограничивает известный сценарий, но не заменяет обновление.
  [Описание](https://github.com/advisories/GHSA-cxf4-7mrp-vvpr).
- shell-quote/concurrently, source-map-js и Vite — devDependencies,
  используемые при разработке и сборке. На сервер публикуются статические
  результаты сборки; public/hot отсутствует. Это не исключает риск для
  среды разработки, поэтому пакеты обновлены.
  [shell-quote](https://github.com/advisories/GHSA-pqg4-j6r4-53mv),
  [source-map-js](https://github.com/advisories/GHSA-68fv-2mgg-jv7q).

## Публикация и проверки

Перед обновлением серверный composer.lock совпадал с локальным побайтово;
все 77 установленных production-пакетов совпадали с lock-файлом.
Dev-зависимости Composer на сервере отсутствуют.

Обычный scripts/deploy-sftp.sh не обновляет vendor. Поэтому production-vendor
собран отдельно через composer install --no-dev --prefer-dist
--optimize-autoloader --no-scripts, с исходниками приложения для корректной
оптимизированной карты классов. Подготовлены vendor, composer.lock,
package.json, package-lock.json и public/build. Архив загружен по SFTP,
распакован вне public, все 6358 файлов проверены по SHA-256 до активации
и повторно после неё.

При замене использовано краткое maintenance-окно с резервной копией
прежних vendor, public/build, lock-файлов, package.json, bootstrap-кешей
и deploy-манифеста. Повторно выполнены package:discover, config:cache,
route:cache, view:cache — все с кодом 0. Миграции и изменения БД не выполнялись.
Временный обработчик защищён Bearer-токеном, затем удалён; его URL возвращает
404. Загруженный архив удалён. Резервная копия сохранена вне public:
`storage/app/deploy/security-2026-10-22/backup/`.

Проверки:

- composer validate --strict — успешно;
- composer audit --locked --format=json — 0 предупреждений;
- npm ci --ignore-scripts и npm audit --json — успешно, 0 уязвимостей;
- npm run build — успешно (Vite 8.2.4);
- vendor/bin/pint --test — успешно;
- php artisan test — 253 теста, 5766 утверждений, все успешно;
- git diff --check — успешно;
- после публикации все версии production-пакетов и хеши lock-файлов
  совпадают с локальными; app.debug=false, maintenance выключен;
- главная, /autobagazhniki, /autobox, /podbor-avto, /admin/login и ресурсы
  из Vite manifest — HTTP 200; отсутствующий URL — HTTP 404.

Локальные тесты выполнялись на PHP 8.5.12, серверные проверки — на PHP 8.4.24.
Сборка сообщает о необязательном пакете fontaine для оптимизации fallback-шрифтов;
это не ошибка сборки, новая зависимость не добавлялась.

## Незакрытый риск: PHP runtime

На сервере подтверждены PHP 8.4.24, SAPI litespeed,
memory_limit=256M, session.upload_progress.enabled=1.
Версия входит в затронутый диапазон CVE-2026-109618 и CVE-2026-109619,
опубликованных 21 октября. Наличие перенесённых хостером исправлений
не подтверждено. Доказательств недостижимости этих сценариев нет;
чистые аудиты Composer/npm и APP_DEBUG=false этого не подтверждают.

По [официальному сообщению PHP](https://www.php.net/archive/2026.php#2026-10-21-1),
исправлены версии 8.4.27, 8.3.36, 8.2.35 и 8.5.12. Нужны обновление
интерпретатора и перезапуск обработчиков либо подтверждение хостера
о перенесённых исправлениях обеих CVE. Частичные настройки снижения риска
не являются полным исправлением.

На аккаунте доступен SFTP, выполнение SSH-команд отклоняется хостингом.
Замена системного PHP через имеющийся деплой недоступна. Владелец взял
проверку настроек PHP на себя. Пункт 1 плана полностью не закрыт до
подтверждения исправления runtime и повторной проверки сайта.
