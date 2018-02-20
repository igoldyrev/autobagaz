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
		'id' => 'ab1',
		'name' => 'Багажник для рейлингов',
		'desc' => 'Рейлинги - продольные направляющие вдоль кузова автомобиля. Багажник для них представляет собой две поперечные дуги, которые крепятся с помощью зажимов с регулируемой шириной захвата.',
		'img1' => '<img class="img good__img" src="/content/autobagazhniki/img/reelings/krepysh1.jpg" alt="багажник для рейлингов">',
		'price' => 'Цена от 1500 рублей',
		],
		[
		'id' => 'ab2',
		'name' => 'Багажник в штатные места',
		'desc' => 'Такой багажник крепится в специально разработанные производителем посадочные места, как правило под резьбу М6-М8',
		'img1' => '<img class="img good__img" src="/content/autobagazhniki/img/2.jpg" alt="багажник в штатные места">',
		'img2' => '<img class="img good__img" src="/content/autobagazhniki/img/3.jpg" alt="багажник в штатные места">',
		'price' => 'Цена от 1800 рублей',
		],
		[
		'id' => 'ab3',
		'name' => 'Багажник на плоскую крышу',
		'desc' => 'Данный вид багажников крепится за проем в арках дверей, специально разработанным захватом, так называемый кит, который полностью повторяет геометрию крыши, защищенный специальным полимером, который не повредит ЛКП вашего автомобиля',
		'img1' => '<img class="img good__img" src="/content/autobagazhniki/img/4.jpg" alt="багажник на плоскую крышу">',
		'img2' => '<img class="img good__img" src="/content/autobagazhniki/img/5.jpg" alt="багажник на плоскую крышу">',
		'price' => 'Цена от 2500 рублей',
		],
		[
		'id' => 'ab4',
		'name' => 'Багажник для водостоков',
		'desc' => 'Водостоки - желобки, расположенные вдоль кузова автомобиля, как правило это у семейства автомобилей ВАЗ, ГАЗ, УАЗ',
		'img1' => '<img class="img good__img" src="/content/autobagazhniki/img/6.jpg" alt="багажник для водостоков">',
		'img2' => '<img class="img good__img" src="/content/autobagazhniki/img/7.jpg" alt="багажник для водостоков">',
		'price' => 'Цена от 1000 рублей',
		],
];

$reelings = [
    [
        'id' => 'reelingskrepysh',
        'name' => 'Багажник Крепыш для рейлингов',
        'img1' => '/content/autobagazhniki//img/reelings/krepysh1.jpg',
        'img2' => '/content/autobagazhniki//img/reelings/krepysh2.jpg',
        'desc' => 'Надёжный и недорогой багажник на рейлинги Крепыш. Универсальное крепление на многие виды рейлингов. Быстрая сборка и установка за 2 минуты.',
    ],
    [
        'id' => 'reelingsfavorit',
        'name' => 'Багажник Favorit для рейлингов',
        'img1' => '/content/autobagazhniki//img/reelings/favorit1.jpg',
        'img2' => '/content/autobagazhniki//img/reelings/favorit2.jpg',
        'img3' => '/content/autobagazhniki//img/reelings/favorit3.jpg',
        'desc' => 'Надёжный багажник на рейлинги. Крепится на рейлинги методом зажима. Быстрая сборка и установка за 2 минуты.',
    ],
    [
        'id' => 'reelingsduster',
        'name' => 'Багажник на рейлинги для Рено Дастер',
        'img1' => '/content/autobagazhniki//img/reelings/duster1.jpg',
        'img2' => '/content/autobagazhniki//img/reelings/duster2.jpg',
        'img3' => '/content/autobagazhniki//img/reelings/duster3.jpg',
        'desc' => 'Надёжный багажник на рейлинги для Рено Дастер. Крепится на рейлинги методом зажима.',
    ],
    [
        'id' => 'reelingseuro',
        'name' => 'Багажник Euro для рейлингов',
        'img1' => '/content/autobagazhniki//img/reelings/euro1.jpg',
        'img2' => '/content/autobagazhniki//img/reelings/euro2.jpg',
        'img3' => '/content/autobagazhniki//img/reelings/euro3.jpg',
        'img4' => '/content/autobagazhniki//img/reelings/euro4.jpg',
        'desc' => 'Надёжный багажник на рейлинги. Крепится на рейлинги методом зажима. Быстрая сборка и установка за 2 минуты.',
    ],
    [
        'id' => 'reelingslux',
        'name' => 'Багажник Lux для рейлингов',
        'img1' => '/content/autobagazhniki//img/reelings/lux1.jpg',
        'img2' => '/content/autobagazhniki//img/reelings/lux2.jpg',
        'img3' => '/content/autobagazhniki//img/reelings/lux3.jpg',
        'desc' => 'Надёжный багажник Lux для рейлингов. Крепится на рейлинги методом зажима. Быстрая сборка и установка за несколько минут.',
    ],
    [
        'id' => 'reelingsmontblanc',
        'name' => 'Багажник Mont Blanc для рейлингов',
        'img1' => '/content/autobagazhniki//img/reelings/montblanc1.jpg',
        'img2' => '/content/autobagazhniki//img/reelings/montblanc2.jpg',
        'img3' => '/content/autobagazhniki//img/reelings/montblanc3.jpg',
        'desc' => 'Надёжный багажник Mont Blanc для рейлингов. Крепится на рейлинги методом зажима. Быстрая сборка и установка за несколько минут.',
    ],
];