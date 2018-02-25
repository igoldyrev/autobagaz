<?php 
$sales = [
    [
        'id' => 's1',
        'name' => 'Велокрепление на фаркоп',
        'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/velo-farkop.jpg" alt="Велокрепление на фаркоп для трех велосипедов">',
        'price' => '3800 рублей ',
        'strike_price' => '4500 рублей',
    ],
    [
		'id' => 's2',
		'name' => 'Велокрепление для одного велосипеда',
		'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/velo-krysha.jpg" alt="Велокрепление на крышу для одного велосипеда">',
		'price' => '1500 рублей ',
		'strike_price' => '2000 рублей',
	],
    [
        'id' => 's3',
        'name' => 'Ветлан 550М серый по специальной цене',
        'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/vellan-550m-gray.jpg" alt="Ветлан 550М серый">',
        'price' => '12 000 рублей ',
        'strike_price' => '14 800 рублей',
    ],
];
$_SESSION['sales'] = $sales;
echo "<h2 class='title title-h2'>Специальные предложения</h2>"; ?>
<div class="sales">
    <?php foreach ($sales as $sale): ?>
    <div class="sales__item">
        <?php echo $sale['img']; ?>
        <div class="sales__description">
            <h4 class="title title-h4"><?php echo $sale['name']; ?></h4>
            <div class="sales__item-price">
                <span class="sales__price"><?php echo $sale['price']; ?></span><span class="sales__price sales__price--strike"><?php echo $sale['strike_price']; ?></span>
            </div>
            <div class="sales__item-button">
                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $sale['id']; ?>" class="button button__buy" >Заказать</a>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>
<a href="/special-offers" class="link-green">Все предложения</a>