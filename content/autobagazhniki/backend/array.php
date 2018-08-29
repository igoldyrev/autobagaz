<?php
/* Массив с данными для страницы Автобагажники
id - номер товара, редактировать НЕ НУЖНО
name - название товара на странице, редактировать МОЖНО
desc - описание товара, которое отображается на странице, редактировать МОЖНО
img - адреса изображений, которые отображаются под описаниями
price - цены, редактировать МОЖНО
*/

$autobagazhniki = [
  [
    'id' => 'reelings',
    'name' => 'Багажник для рейлингов',
    'desc' => 'Рейлинги - продольные направляющие вдоль кузова автомобиля. Багажник для них представляет собой две поперечные дуги, которые крепятся с помощью зажимов с регулируемой шириной захвата.',
    'img1' => '<img class="img good__img" src="/content/autobagazhniki/img/reelings/krepysh1.jpg" alt="багажник для рейлингов">',
    'price' => 'Цена от 1500 рублей',
  ],
  [
    'id' => 'shtatnye',
    'name' => 'Багажник в штатные места',
    'desc' => 'Такой багажник крепится в специально разработанные производителем посадочные места, как правило под резьбу М6-М8',
    'img1' => '<img class="img good__img" src="/content/autobagazhniki/img/shtatnye/c15-1.JPG" alt="багажник в штатные места">',
    'price' => 'Цена от 1800 рублей',
  ],
  [
    'id' => 'smooth',
    'name' => 'Багажник на плоскую крышу',
    'desc' => 'Данный вид багажников крепится за проем в арках дверей, специально разработанным захватом, так называемый кит, который полностью повторяет геометрию крыши, защищенный специальным полимером, который не повредит ЛКП вашего автомобиля',
    'img1' => '<img class="img good__img" src="/content/autobagazhniki/img/smooth/d1-1.JPG" alt="багажник на плоскую крышу">',
    'price' => 'Цена от 2500 рублей',
  ],
  [
    'id' => 'vodostok',
		'name' => 'Багажник для водостоков',
		'desc' => 'Водостоки - желобки, расположенные вдоль кузова автомобиля, как правило это у семейства автомобилей ВАЗ, ГАЗ, УАЗ',
		'img1' => '<img class="img good__img" src="/content/autobagazhniki/img/vodostok/atlant-1.JPG" alt="багажник для водостоков">',
		'price' => 'Цена от 1000 рублей',
		],
];

$reelings = [
  [
    'id' => 'reelingskrepysh',
    'name' => 'Багажник Крепыш для рейлингов',
    'img1' => '/content/autobagazhniki/img/reelings/krepysh1.jpg',
    'img2' => '/content/autobagazhniki/img/reelings/krepysh2.jpg',
    'desc' => 'Надёжный и недорогой багажник на рейлинги Крепыш. Универсальное крепление на многие виды рейлингов. Быстрая сборка и установка за 2 минуты.',
  ],
  [
    'id' => 'reelingsfavorit',
    'name' => 'Багажник Favorit для рейлингов',
    'img1' => '/content/autobagazhniki/img/reelings/favorit1.jpg',
    'img2' => '/content/autobagazhniki/img/reelings/favorit2.jpg',
    'img3' => '/content/autobagazhniki/img/reelings/favorit3.jpg',
    'desc' => 'Надёжный багажник на рейлинги. Крепится на рейлинги методом зажима. Быстрая сборка и установка за 2 минуты.',
  ],
  [
    'id' => 'reelingsduster',
    'name' => 'Багажник на рейлинги для Рено Дастер',
    'img1' => '/content/autobagazhniki/img/reelings/duster1.jpg',
    'img2' => '/content/autobagazhniki/img/reelings/duster2.jpg',
    'img3' => '/content/autobagazhniki/img/reelings/duster3.jpg',
    'desc' => 'Надёжный багажник на рейлинги для Рено Дастер. Крепится на рейлинги методом зажима.',
  ],
  [
    'id' => 'reelingseuro',
    'name' => 'Багажник Euro для рейлингов',
    'img1' => '/content/autobagazhniki/img/reelings/euro1.jpg',
    'img2' => '/content/autobagazhniki/img/reelings/euro2.jpg',
    'img3' => '/content/autobagazhniki/img/reelings/euro3.jpg',
    'img4' => '/content/autobagazhniki/img/reelings/euro4.jpg',
    'desc' => 'Надёжный багажник на рейлинги. Крепится на рейлинги методом зажима. Быстрая сборка и установка за 2 минуты.',
  ],
  [
    'id' => 'reelingslux',
    'name' => 'Багажник Lux для рейлингов',
    'img1' => '/content/autobagazhniki/img/reelings/lux1.jpg',
    'img2' => '/content/autobagazhniki/img/reelings/lux2.jpg',
    'img3' => '/content/autobagazhniki/img/reelings/lux3.jpg',
    'desc' => 'Надёжный багажник Lux для рейлингов. Крепится на рейлинги методом зажима. Быстрая сборка и установка за несколько минут.',
  ],
  [
    'id' => 'reelingsmontblanc',
    'name' => 'Багажник Mont Blanc для рейлингов',
    'img1' => '/content/autobagazhniki/img/reelings/montblanc1.jpg',
    'img2' => '/content/autobagazhniki/img/reelings/montblanc2.jpg',
    'img3' => '/content/autobagazhniki/img/reelings/montblanc3.jpg',
    'desc' => 'Надёжный багажник Mont Blanc для рейлингов. Крепится на рейлинги методом зажима. Быстрая сборка и установка за несколько минут.',
  ],
];

$shtatnye = [
  [
    'id' => 'statnyec15',
    'name' => 'Багажник C-15 для штатных мест',
    'img1' => '/content/autobagazhniki/img/shtatnye/c15-1.JPG',
    'img2' => '/content/autobagazhniki/img/shtatnye/c15-2.JPG',
    'img3' => '/content/autobagazhniki/img/shtatnye/c15-3.JPG',
    'desc' => 'Надёжный багажник C-15 для автомобиля. Устанавливается в штатные места на кузове авто.',
  ],
  [
    'id' => 'statnyelux',
    'name' => 'Багажник Lux для штатных мест',
    'img1' => '/content/autobagazhniki/img/shtatnye/lux-1.JPG',
    'img2' => '/content/autobagazhniki/img/shtatnye/lux-2.JPG',
    'img3' => '/content/autobagazhniki/img/shtatnye/lux-3.JPG',
    'desc' => 'Надёжный багажник Lux для автомобиля. Устанавливается в штатные места на кузове авто.',
  ],
  [
    'id' => 'statnyeatlant',
    'name' => 'Багажник Atlant для штатных мест',
    'img1' => '/content/autobagazhniki/img/shtatnye/atlant-1.JPG',
    'img2' => '/content/autobagazhniki/img/shtatnye/atlant-2.JPG',
    'desc' => 'Надёжный багажник Atlant для автомобиля. Устанавливается в штатные места на кузове авто.',
  ],
];

$smooth = [
  [
    'id' => 'smoothd1',
    'name' => 'Багажник Д-1 для гладких крыш',
    'img1' => '/content/autobagazhniki/img/smooth/d1-1.JPG',
    'img2' => '/content/autobagazhniki/img/smooth/d1-2.JPG',
    'img3' => '/content/autobagazhniki/img/smooth/d1-3.JPG',
    'desc' => 'Надёжный багажник Д-1 для автомобиля. Устанавливается на гладкую поверхность крыши, что позволяет использовать это устройство на разных машинах.',
  ],
  [
    'id' => 'smoothlux',
    'name' => 'Багажник Lux для гладких крыш',
    'img1' => '/content/autobagazhniki/img/smooth/lux-1.JPG',
    'img2' => '/content/autobagazhniki/img/smooth/lux-2.JPG',
    'img3' => '/content/autobagazhniki/img/smooth/lux-3.JPG',
    'desc' => 'Надёжный багажник Lux для автомобиля. Устанавливается на гладкую поверхность крыши, что позволяет использовать это устройство на разных машинах.',
  ],
  [
    'id' => 'smoothmontblanc',
    'name' => 'Багажник Mont Blanc для гладких крыш',
    'img1' => '/content/autobagazhniki/img/smooth/montblanc-1.JPG',
    'img2' => '/content/autobagazhniki/img/smooth/montblanc-2.JPG',
    'desc' => 'Надёжный багажник Mont Blanc для автомобиля. Устанавливается на гладкую поверхность крыши, что позволяет использовать это устройство на разных машинах.',
  ],
];

$vodostok = [
  [
    'id' => 'vodostokatlant',
    'name' => 'Багажник Atlant для водостоков',
    'img1' => '/content/autobagazhniki/img/vodostok/atlant-1.JPG',
    'img2' => '/content/autobagazhniki/img/vodostok/atlant-2.JPG',
    'img3' => '/content/autobagazhniki/img/vodostok/atlant-3.JPG',
    'desc' => 'Надёжный багажник Atlant для автомобиля. Способ установки багажника на крышу автомобиля - крепление за водостоки с использованием прижимов.',
  ],
];
