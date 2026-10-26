<?php

return [
    '/velokreplenya' => ['route' => 'catalog.bike-racks.index'],
    '/kreplenya-dlya-lyzh-shoubord' => ['route' => 'catalog.ski-racks.index'],
    '/special-offers' => ['route' => 'promotions.index'],
    '/velokreplenya/krysha' => ['route' => 'catalog.bike-racks.index', 'parameters' => ['mounting_type' => ['На крышу']]],
    '/velokreplenya/farkop' => ['route' => 'catalog.bike-racks.index', 'parameters' => ['mounting_type' => ['На фаркоп']]],
    '/autobagazhnik/reelings' => ['route' => 'catalog.autobagazhniki.show', 'parameters' => ['category' => 'na-reylingi']],
    '/autobagazhnik/shtatnye' => ['route' => 'catalog.autobagazhniki.show', 'parameters' => ['category' => 'v-shtatnoe-mesto']],
    '/autobox/vetlan' => ['route' => 'catalog.auto-boxes.index', 'manufacturer' => 'VetlaN'],
    '/autobox/atlant' => ['route' => 'catalog.auto-boxes.index', 'manufacturer' => 'Atlant'],
    '/autobox/yuago' => ['route' => 'catalog.auto-boxes.index', 'manufacturer' => 'Yuago'],
    '/autobox/turino' => ['route' => 'catalog.auto-boxes.index', 'manufacturer' => 'Turino'],
    '/autobox/lux' => ['route' => 'catalog.auto-boxes.index', 'manufacturer' => 'Lux'],
    '/autobox/inmax' => ['route' => 'catalog.auto-boxes.index', 'manufacturer' => 'Inmax'],
    '/autobox/terradrive' => ['route' => 'catalog.auto-boxes.index', 'manufacturer' => 'Terra Drive'],
    '/autobox/bonus' => ['route' => 'catalog.auto-boxes.index', 'manufacturer' => 'Koffer Bonus'],
    '/autobox/nobu' => ['route' => 'catalog.auto-boxes.index', 'manufacturer' => 'Nobu'],
];
