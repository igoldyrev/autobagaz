<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); 
include ($_SERVER["DOCUMENT_ROOT"]."/arrays/velokreplenya_array.php"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content"> <?php
	echo "<title> $titleconst"; echo $keywords[19][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[19][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[19][keywords]; echo "'/>";
	
	$_SESSION['lyzhi'] = $lyzhi; 
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	
	echo "<h1>Крепления для лыж и сноубордов</h1>";
	echo "<p>Каждый любитель активного зимнего отдыха неминуемо сталкивается с проблемой транспортировки своего инвентаря. Торчащие изо всех окон лыжи и палки — это, конечно, романтично и очень по-советски, однако вряд ли такой способ перевозки можно назвать удобным, а тем более — оптимальным.</p>";
	echo "<p>Стандартная длина лыж и сноуборда — около полутора метров, даже в самом просторном салоне перевозить такие большие предметы — значит лишиться комфорта на все время поездки. Стоит ли лишать себя удобства поездки на горнолыжный курорт или просто за город с друзьями? Вовсе нет, если в вашей машине есть специальный багажник для сноуборда или крепление лыж.</p>";
	echo "<p>Эта простая, но крайне надежная конструкция, будет крепко держать ваш спортивный инвентарь. Лыжи любой фирмы производителя можно установить в крепления за считанные секунды. Багажники для сноуборда устроены таким образом, что сноуборд будет надежно закреплен и не будет колебаться даже на большой скорости и резких поворотах.</p>";
	echo "<p>Мы предлагаем крепления для лыж и сноубордов следующих производителей:</p>"; ?>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $lyzhi[0]['title']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $lyzhi[0]['img']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $lyzhi[0]['desc']; ?></p>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<table align="center">
				<tr><td class="producttable" align="left"><?php echo $lyzhi[0]['desc34']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[0]['price34']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $lyzhi[0]['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $lyzhi[0]['id1']; ?>">Взять в прокат</a></button></td></tr>	
				<tr><td class="producttable" align="left"><?php echo $lyzhi[0]['desc56']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[0]['price56']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $lyzhi[0]['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $lyzhi[0]['id2']; ?>">Взять в прокат</a></button></td></tr>	
			</table>
			</div>
		</div>
	</div>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $lyzhi[1]['title']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $lyzhi[1]['img']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $lyzhi[1]['desc']; ?></p>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<table align="center">
				<tr><td class="producttable" align="left"><?php echo $lyzhi[1]['desc34']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[1]['price34']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $lyzhi[1]['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $lyzhi[1]['id1']; ?>">Взять в прокат</a></button></td></tr>	
				<tr><td class="producttable" align="left"><?php echo $lyzhi[1]['desc56']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[1]['price56']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $lyzhi[1]['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $lyzhi[1]['id2']; ?>">Взять в прокат</a></button></td></tr>	
			</table>
			</div>
		</div>
	</div>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $lyzhi[2]['title']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $lyzhi[2]['img']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $lyzhi[2]['desc']; ?></p>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<table align="center">
				<tr><td class="producttable" align="left"><?php echo $lyzhi[2]['desc34']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[2]['price34']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $lyzhi[2]['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $lyzhi[2]['id1']; ?>">Взять в прокат</a></button></td></tr>	
				<tr><td class="producttable" align="left"><?php echo $lyzhi[2]['desc56']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[2]['price56']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $lyzhi[2]['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $lyzhi[2]['id2']; ?>">Взять в прокат</a></button></td></tr>	
			</table>
			</div>
		</div>
	</div>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $lyzhi[3]['title']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $lyzhi[3]['img']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $lyzhi[3]['desc']; ?></p>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<table align="center">
				<tr><td class="producttable" align="left"><?php echo $lyzhi[3]['desc34']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[3]['price34']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $lyzhi[3]['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $lyzhi[3]['id1']; ?>">Взять в прокат</a></button></td></tr>	
				<tr><td class="producttable" align="left"><?php echo $lyzhi[3]['desc56']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[3]['price56']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $lyzhi[3]['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $lyzhi[3]['id2']; ?>">Взять в прокат</a></button></td></tr>	
			</table>
			</div>
		</div>
	</div>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $lyzhi[4]['name']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $lyzhi[4]['img1']; echo $lyzhi[4]['img2']; echo $lyzhi[4]['img3']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $lyzhi[4]['desc']; ?></p>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<p><?php echo $lyzhi[4]['price']; ?></p>
			</div>
			<div class="button">
			<button class="buy_button"><a href="/buy/<?php echo $lyzhi[4]['id']; ?>">Заказать</a></button>
			<button class="prokat_button"><a href="/prokat/<?php echo $lyzhi[4]['id']; ?>">Взять в прокат</a></button>
			</div>
		</div>
	</div> <?php
	include ($_SERVER["DOCUMENT_ROOT"]."/frames/helpform.php"); ?>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>