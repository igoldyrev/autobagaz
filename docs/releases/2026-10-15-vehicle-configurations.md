# Дополнение автомобильного справочника

Миграция `2026_10_15_000000_add_requested_vehicle_configurations.php` добавляет
13 конфигураций по списку владельца сайта. Годы и крепления перенесены из запроса:
12 вариантов с интегрированными рейлингами, Niva Legend — со штатными местами.
Применяемость товаров не добавляется без отдельных данных о совместимости.
Повторный запуск сохраняет существующие записи и изменения администратора.

## Изображения

Созданы встроенным инструментом ImageGen. Файлы находятся в
`public/images/catalog/autobagazhniki/models/<марка>/<модель>-<год>-generated.webp`.
Изображения привязаны к добавленным поколениям и новым моделям; существующие
фотографии моделей сохраняются. В админке изображение доступно в форме поколения.
Это сгенерированные иллюстрации автомобилей, а не фотографии конкретного товара.

Общий промпт для каждого файла:

```text
Use case: product-mockup. Create ONE photorealistic automotive catalog image
for a Russian roof-rack shop. Subject: [subject below]. Equipped with integrated
flush roof rails (except Niva: no roof rails). Composition: full car in front
three-quarter view, nose pointing to the left, slightly elevated camera showing
the roof, centered, all wheels and mirrors fully visible, car fills about
85 percent of width, landscape 3:2 canvas. Seamless pure white studio background
with soft small gray contact shadow, clean realistic lighting, crisp details,
matching small car catalog thumbnails. No roof rack, no crossbars, no cargo box,
no people, no scenery, no captions, no watermark; license plate blank.
```

| Файл (относительно models/) | Subject |
| --- | --- |
| chery/tiggo-7-pro-2020-generated.webp | Silver Chery Tiggo 7 Pro, original 2020 model, recognizable correct grille and body |
| chevrolet/orlando-2010-generated.webp | Silver Chevrolet Orlando first generation 2010-2015, distinctive tall compact MPV body and correct Chevrolet grille |
| datsun/mi-do-2014-generated.webp | Silver Datsun mi-DO 2014-2020, compact FIVE DOOR HATCHBACK with correct Datsun hexagonal grille |
| datsun/on-do-2014-generated.webp | Silver Datsun on-DO 2014-2020, compact FOUR DOOR SEDAN with a separate trunk, correct Datsun hexagonal grille |
| exeed/txl-2020-generated.webp | Silver EXEED TXL original 2020 version, recognizable correct premium SUV body and grille |
| exeed/vx-2021-generated.webp | Silver EXEED VX original 2021 version, recognizable correct large three-row SUV body and grille |
| geely/atlas-2017-generated.webp | Silver Geely Atlas FIRST generation 2017-2022, original rounded SUV body with concentric Geely grille, NOT Atlas Pro and NOT second generation |
| geely/monjaro-2021-generated.webp | Silver Geely Monjaro original 2021 model, recognizable large SUV with vertical grille bars |
| geely/tugella-2020-generated.webp | Silver Geely Tugella original 2020 model, recognizable sporty coupe SUV with sloping rear roofline |
| haval/h6-2014-generated.webp | Silver Haval H6 first generation 2014 model, recognizable original conservative SUV body and correct grille, NOT recent redesigned H6 |
| lada-vaz/2121-2131-niva-2021-generated.webp | Silver Lada Niva Legend 2021, iconic classic compact THREE DOOR off-roader VAZ 2121 with round headlights. Bare roof with factory fixed mounting points, NO roof rails |
| lexus/rx-2015-generated.webp | Silver Lexus RX FOURTH generation original 2015 model AL20, correct sharp body and large spindle grille |
| lifan/x70-2017-generated.webp | Silver Lifan X70 original 2017-2020, correct compact SUV body and Lifan grille |

Для Datsun mi-Do, Datsun on-Do, Chevrolet Orlando, Haval H6 и Lifan X70
дополнительно уточнены рейлинги следующим промптом редактирования:

```text
Use case: precise-object-edit. Edit ONLY the two roof rails of this silver car
catalog illustration. Replace the raised rails with truly INTEGRATED FLUSH ROOF
RAILS: low solid longitudinal strips seated directly on the roof along their
entire length, with NO OPEN AIR GAP underneath, no elevated arches, no supports,
no holes between rail and roof. Keep the exact car identity, body shape, grille,
lights, wheels, silver color, blank number plate, white background, soft shadow,
view angle and framing unchanged. No crossbars or rack. The rails must look
physically solid and directly connected to the roof from front to back.
```
