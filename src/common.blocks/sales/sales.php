<?php
$sales = [
    [
        'id' => 's1',
        'name' => 'Ветлан 550М черный после проката',
        'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/vellan-550m-black.jpg" alt="Ветлан 550М черный">',
        'price' => '11 000 рублей ',
        'strike_price' => '14 500 рублей',
    ],
    [
        'id' => 's2',
        'name' => 'Автобокс на крышу INMAX Space 460 со скидкой',
        'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/inmax-space.jpg" alt="nmax">',
        'price' => '15 500 рублей',
        'strike_price' => '17 000 рублей',
    ],
    [
        'id' => 's3',
        'name' => 'Лыжное крепление Amos для 3-4 пар лыж со скидкой',
        'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/amos.jpg" alt="amos">',
        'price' => 'Скидка 20%',
        'strike_price' => '2700 рублей',
    ],
    [
        'id' => 's4',
        'name' => 'Лыжное крепление Amos для 5-6 пар лыж со скидкой',
        'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/amos.jpg" alt="amos">',
        'price' => 'Скидка 20%',
        'strike_price' => '3700 рублей',
    ],
    [
        'id' => 's5',
        'name' => 'Лыжное крепление Атлант для 3-4 пар лыж со скидкой',
        'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/atlant.jpg" alt="atlant">',
        'price' => 'Скидка 20%',
        'strike_price' => '4200 рублей',
    ],
    [
        'id' => 's6',
        'name' => 'Лыжное крепление Атлант для 5-6 пар лыж со скидкой',
        'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/atlant.jpg" alt="atlant">',
        'price' => 'Скидка 20%',
        'strike_price' => '5200 рублей',
    ],
    [
        'id' => 's7',
        'name' => 'Лыжное крепление Mont Blanc для 3-4 пар лыж со скидкой',
        'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/mont_blanc.jpg" alt="mont blanc">',
        'price' => 'Скидка 20%',
        'strike_price' => '7000 рублей',
    ],
    [
        'id' => 's8',
        'name' => 'Лыжное крепление Mont Blanc для 5-6 пар лыж со скидкой',
        'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/mont_blanc.jpg" alt="mont blanc">',
        'price' => 'Скидка 20%',
        'strike_price' => '8000 рублей',
    ],
    [
        'id' => 's9',
        'name' => 'Лыжное крепление Thule для 3-4 пар лыж со скидкой',
        'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/thule.jpg" alt="thule">',
        'price' => 'Скидка 20%',
        'strike_price' => '7000 рублей',
    ],
    [
        'id' => 's10',
        'name' => 'Лыжное крепление Thule для 5-6 пар лыж со скидкой',
        'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/thule.jpg" alt="thule">',
        'price' => 'Скидка 20%',
        'strike_price' => '8000 рублей',
    ],
];
$_SESSION['sales'] = $sales;
echo "<h2 class='title title-h2'>Специальные предложения</h2>"; ?>
<div class="sales">
    <?php foreach ($sales as $sale):?>
        <div class="sales__item">
            <?php echo $sale['img']; ?>
            <div class="sales__description">
                <h4 class="title title-h4"><?php echo $sale['name']; ?></h4>
                <div class="sales__item-price">
                    <p>
                        <span class="text">Новая цена: </span><span class="sales__price"><?php echo $sale['price']; ?></span>
                    </p>
                    <p>
                        <span class="text">Старая цена: </span><span class="sales__price sales__price--strike"><?php echo $sale['strike_price']; ?></span>
                    </p>
                </div>
                <div class="sales__item-button">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $sale['id']; ?>" class="button button__buy" >Заказать</a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
