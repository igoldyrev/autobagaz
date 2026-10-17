# Дополнение автомобильного справочника 17 октября 2026

Добавлены 37 конфигураций из списка владельца. Перед изменениями проверены
локальный справочник и публичный подбор на https://new.autobagaz.ru/podbor-avto.

У Audi Q5, Geely Emgrand, Haval F7x/M6, Nissan Juke, Omoda C5,
Renault Kaptur и Jetour X90 Plus были модели без нужных конфигураций.
У Optima и Compass имелись только другие поколения. У Toyota Wish были
записи 2003–2008 и 2009–н.в. без указания крыши: добавлены запрошенные
конфигурации 2003–2009 и 2009–2017 с гладкой крышей.

Sorento III Prime 2015–2020 с интегрированными рейлингами сохранён.
По отдельному уточнению владельца добавлен Sorento III Prime 2018–2020
с гладкой крышей. Infinity и Fortuter нормализованы в Infiniti и Fortuner.
Годы перенесены из запроса владельца, а не скорректированы по сторонним источникам.

Данные и индивидуальные описания автомобилей находятся в
`database/data/requested_vehicles_2026_10_17.json`. Миграция
`2026_10_17_000000_add_requested_vehicle_configurations.php` сохраняет
существующие записи и пропускает совпадающие конфигурации, включая записи
того же поколения с более широким диапазоном лет. Неизвестный тип крыши не считается совпадением.
Новые марки включены в основной каталог; их карточки используют созданные изображения.
Совместимость с товарами не добавляется без данных о применяемости.

## Изображения

Использован встроенный ImageGen (навык imagegen). Финальные файлы:
`public/images/catalog/autobagazhniki/models/<make_slug>/<model_slug>-<year_from>-generated.webp`.
Полный перечень путей и Subject содержится в JSON. Изображения привязаны
к новым поколениям и новым моделям. Существующие изображения сохраняются.
Это сгенерированные каталожные иллюстрации, а не фотографии товаров.

Общий промпт для каждой записи; SUBJECT заменяется полем subject из JSON,
ROOF — строкой из следующего списка:

```text
Use case: product-mockup. Create ONE photorealistic automotive catalog illustration
for a Russian roof-rack shop. Subject: SUBJECT. Silver paint. Composition: entire
car front three-quarter view, nose pointing left, slightly elevated camera showing
roof, centered, wheels and mirrors fully visible, car fills 85 percent width,
landscape 3:2 canvas. Pure white seamless studio background, small soft gray
contact shadow, realistic lighting and accurate recognizable generation-specific
body, grille and headlights. ROOF. No roof rack, crossbars, cargo box, people,
scenery, captions or watermark; blank license plate.
```

- smooth: `Completely smooth bare roof, NO roof rails of any kind`
- integrated: `Two truly integrated FLUSH longitudinal roof rails seated directly on roof with NO open air gap under them. No raised rails`
- fixed: `Bare roof with discreet factory fixed mounting points, NO roof rails`

## Проверка

Feature-тесты проверяют доступность конфигураций в публичном подборе,
кузова, крепления, годы, четыре двери у пикапов, файлы изображений,
повторный импорт, сохранность изменений администратора и пропуск существующих
конфигураций с более широкими годами. Старый тест ограничен пакетом
2026-10-15, чтобы не считать новые записи частью старых 13 конфигураций.
