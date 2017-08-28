<?php 
$sales = [
	[
		'id' => 's1',
		'name' => 'Велокрепление для одного велосипеда',
		'img' => '<img itemprop="image" class="sale_img" src="/images/sales/velo-krysha.jpg" alt="Велокрепление на крышу для одного велосипеда">',
		'price' => '1500 рублей ',
		'strike_price' => '2000 рублей',
	],
	[
		'id' => 's2',
		'name' => 'Велокрепление на фаркоп',
		'img' => '<img itemprop="image" class="sale_img" src="/images/sales/velo-farkop.jpg" alt="Велокрепление на фаркоп для трех велосипедов">',
		'price' => '3800 рублей ',
		'strike_price' => '4500 рублей',
	],
];
$_SESSION['sales'] = $sales;
echo "<h2>Скидки в нашем магазине!</h2>"; ?>
<div class="sales">
	<?php foreach ($sales as $sale): ?>
	<div class="sale" itemscope itemtype="http://schema.org/Product">
	<?php echo $sale['img']; ?>
	<div class="description">
	<h3 itemprop="name"><?php echo $sale['name']; ?></h3>
	<div class="sale_price" itemscope itemtype="http://schema.org/Offer">
		<span class="sale_price" itemprop="price"><?php echo $sale['price']; ?></span><span class="strike_price"><?php echo $sale['strike_price']; ?></span>
  </div>
  <div class="sale_button">
    <form action="scripts/sale.php" method="post">
	<button><a href="/buy/<?php echo $sale['id']; ?>">Заказать</a></button>
	</form>
	</div>
  </div>
</div>
<?php endforeach ?>
</div>
