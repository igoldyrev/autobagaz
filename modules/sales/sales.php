<?php 
$sales = [
	[
		'id' => 's1',
		'name' => 'Велокрепление для одного велосипеда',
		'img' => '<img class="sale_img" src="/images/sales/velo-krysha.jpg" alt="Велокрепление на крышу для одного велосипеда">',
		'price' => '1500 рублей ',
		'strike_price' => '2000 рублей',
	],
	[
		'id' => 's2',
		'name' => 'Велокрепление на фаркоп',
		'img' => '<img class="sale_img" src="/images/sales/velo-farkop.jpg" alt="Велокрепление на фаркоп для трех велосипедов">',
		'price' => '3800 рублей ',
		'strike_price' => '4500 рублей',
	],
    [
        'id' => 's3',
        'name' => 'Ветлан 550М серый по специальной цене',
        'img' => '<img class="sale_img" src="/images/sales/vellan-550m-gray.jpg" alt="Ветлан 550М серый">',
        'price' => '12 000 рублей ',
        'strike_price' => '14 800 рублей',
    ],
];
$_SESSION['sales'] = $sales;
echo "<h2 class='page__title-h2 page__title-h2--sales'>Скидки в нашем магазине!</h2>"; ?>
<div class="sales">
    <?php foreach ($sales as $sale): ?>
    <div class="sales__item">
        <?php echo $sale['img']; ?>
        <div class="sales__description">
            <h3 class="page__title-h3"><?php echo $sale['name']; ?></h3>
            <div class="sales__item-price">
                <span class="price price__sale"><?php echo $sale['price']; ?></span><span class="price price__strike"><?php echo $sale['strike_price']; ?></span>
            </div>
            <div class="sales__item-button">
                <button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $sale['id']; ?>">Заказать</a></button>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>