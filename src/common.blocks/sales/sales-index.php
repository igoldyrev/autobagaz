<?php
$sales = [
    [
        'id' => 's1',
        'name' => 'Ветлан 550М серый по специальной цене',
        'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/vellan-550m-gray.jpg" alt="Ветлан 550М серый">',
        'price' => '12 000 рублей ',
        'strike_price' => '14 800 рублей',
    ],
    [
        'id' => 's2',
        'name' => 'Лыжное крепление Amos для 3-4 пар лыж со скидкой',
        'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/amos.jpg" alt="amos">',
        'price' => 'Скидка 20%',
        'strike_price' => '2700 рублей',
    ],
    [
        'id' => 's3',
        'name' => 'Лыжное крепление Mont Blanc для 3-4 пар лыж со скидкой',
        'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/mont_blanc.jpg" alt="mont blanc">',
        'price' => 'Скидка 20%',
        'strike_price' => '7000 рублей',
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