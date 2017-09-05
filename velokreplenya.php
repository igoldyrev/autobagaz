<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); 
include ($_SERVER["DOCUMENT_ROOT"]."/arrays/velokreplenya_array.php"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<?php
$velokreplenya = $_GET['velokreplenya'];
if (!isset($velokreplenya)) {
	echo "<title> $titleconst"; echo $keywords[16][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[16][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[16][keywords]; echo "'/>";
	
	echo "<h1>Велокрепления</h1>";
	echo "<h3>Сколько велосипедов влезает в ваш автомобиль?</h3>";
	echo "<p>Велосипед, как средство передвижения, дает своему владельцу ни с чем не сравнимое чувство свободы – свободы от пробок, заправок, даже от дорог. Ведь любая тропинка в лесу, в парке, а иногда и бездорожье – для велосипедиста подчас лучше пыльной, забитой машинами, трассы. Тем не менее, любой велосипедист рано или поздно сталкивается с необходимостью перевозки двухколесного друга, в том числе, и на автомобиле. Ведь самый чистый воздух, самые интересные маршруты находятся вдали от города.</p>";
	echo "<p>Сразу оговоримся, что перевозка велосипеда в багажном отсеке, пусть даже большом – далеко не лучшее решение этой проблемы. Неудобно это, высока вероятность повредить, испачкать салон. Гораздо лучше воспользоваться специальными приспособлениями для транспортировки велосипеда – автомобильными велобагажниками, или, правильнее, автомобильными велокреплениями.</p>";
	echo "<p>Условно, все велокрепления можно разделить на несколько типов по способу их установки на автомобиль:</p>"; ?>
	<table class="links_catalog">
		<tr><td width="170px" class="links_catalog" align="center"><a href="/velokreplenya_na_kryshy"><img src="/images/velo/krysha/amos_1.jpg" alt="Велокрепления на крышу" width="150px"></a></td><td align="center" class="links_catalog"><a class="links_catalog" href="/velokreplenya_na_kryshy">Велокрепления на крышу</a></td></tr>
		<tr><td width="170px" class="links_catalog" align="center"><a href="/velokreplenya_na_farkop"><img src="/images/velo/farkop/Thule_Xpress_970_1.jpg" alt="Велокрепления на фаркоп" width="150px"></a></td><td class="links_catalog" align="center"><a class="links_catalog" href="/velokreplenya_na_farkop">Велокрепления на фаркоп</a></td></tr>
	</table> <?php
} elseif ($velokreplenya == 'velokreplenya_na_kryshy') {
	echo "<title> $titleconst"; echo $keywords[17][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[17][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[17][keywords]; echo "'/>";
	
	$_SESSION['velokrysha'] = $velokrysha; 
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	
	echo "<h1>Велокрепления на крышу</h1>";
	echo "<p>Пожалуй, самые распространенные в нашей стране. Сложилось это, скорее всего, исторически: перевозка велосипеда на верхнем багажнике – самый «древний» вариант транспортировки велосипедов; вторая причина в том, что многие считают этот вид креплений самым дешевым. Велокрепления этого типа присутствуют в линейке практически каждого производителя автомобильных багажников. Все они монтируются на стандартные поперечины, некоторые только на «классические» прямоугольные, некоторые – еще и на аэродинамические, при помощи хомутов или зажимов. Велосипед устанавливается колесами в специальный профиль, металлический или пластмассовый; колеса фиксируются в нем хомутами либо быстросъемными стропами от перемещения велосипеда вперед-назад и от выскакивания колес из профиля при тряске.</p>"; ?>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $velokrysha[0]['name']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $velokrysha[0]['img1']; echo $velokrysha[0]['img2']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $velokrysha[0]['desc']; ?></p>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<p><?php echo $velokrysha[0]['price']; ?></p>
			</div>
			<div class="button">
			<button class="buy_button"><a href="/buy/<?php echo $velokrysha[0]['id']; ?>">Заказать</a></button>
			<button class="prokat_button"><a href="/prokat/<?php echo $velokrysha[0]['id']; ?>">Взять в прокат</a></button>
			</div>
		</div>
	</div> 
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $velokrysha[1]['name']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $velokrysha[1]['img1']; echo $velokrysha[1]['img2']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $velokrysha[1]['desc']; ?></p>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<p><?php echo $velokrysha[1]['price']; ?></p>
			</div>
			<div class="button">
			<button class="buy_button"><a href="/buy/<?php echo $velokrysha[1]['id']; ?>">Заказать</a></button>
			<button class="prokat_button"><a href="/prokat/<?php echo $velokrysha[1]['id']; ?>">Взять в прокат</a></button>
			</div>
		</div>
	</div>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $velokrysha[2]['name']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $velokrysha[2]['img1']; echo $velokrysha[2]['img2']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $velokrysha[2]['desc']; ?></p>
			<ul>
				<li>Быстрозапираемый держатель рамы, подходит для большинства рам размером до 80 мм;</li>
				<li>Быстросъемные ремни с защитой колес надежно удерживают колеса в выбранном положении (регулируются под колеса разных размеров);</li>
				<li>Запирает на ключ велосипед на креплении, а крепление на багажнике (фиксаторы включены в комплект). Максимально допустимая масса одного велосипеда 17 кг;</li>
				<li>В комплект включены переходники T-Track (20x20 мм) для монтажа багажника велосипеда прямо на на Т-образные пазы рейлингов багажника автомобиля;</li>
				<li>Соответствие нормам City Crash.</li>
			</ul>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<p><?php echo $velokrysha[2]['price']; ?></p>
			</div>
			<div class="button">
			<button class="buy_button"><a href="/buy/<?php echo $velokrysha[2]['id']; ?>">Заказать</a></button>
			<button class="prokat_button"><a href="/prokat/<?php echo $velokrysha[2]['id']; ?>">Взять в прокат</a></button>
			</div>
		</div>
	</div>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $velokrysha[3]['name']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $velokrysha[3]['img1']; echo $velokrysha[3]['img2']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $velokrysha[3]['desc']; ?></p>
			<p>Особенности Thule ProRide 598:</p>
			<ul>
				<li>Саморегулирующийся держатель рамы велосипеда позволит легко закрепить велосипед на багажнике;</li>
				<li>Победитель теста;</li>
				<li>Система крепления расположена на удобной высоте;</li>
				<li>Крепежные ремни подходят для колес различных диаметров и надежно удерживают велосипед на месте;</li>
				<li>Изготовлен из алюминия, легкий и элегантный;</li>
				<li>Thule 591 может легко устанавливаться с любой стороны крыши автомобиля;</li>
				<li>Запирает на ключ велосипед и насадку на багажнике.</li>
			</ul>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<p><?php echo $velokrysha[3]['price']; ?></p>
			</div>
			<div class="button">
			<button class="buy_button"><a href="/buy/<?php echo $velokrysha[3]['id']; ?>">Заказать</a></button>
			<button class="prokat_button"><a href="/prokat/<?php echo $velokrysha[3]['id']; ?>">Взять в прокат</a></button>
			</div>
		</div>
	</div> <?php
	include ($_SERVER["DOCUMENT_ROOT"]."/frames/helpform.php");
} elseif ($velokreplenya == 'velokreplenya_na_farkop') {
	echo "<title> $titleconst"; echo $keywords[18][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[18][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[18][keywords]; echo "'/>";
	
	$_SESSION['velofarkop'] = $velofarkop; 
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	
	echo "<h1>Велокрепления на фаркоп</h1>";
	echo "<p>Крепление для велосипедов на фаркоп может быть подвесным или в виде платформы. Для не слишком далеких путешествий чаще всего используют подвесной вариант, который удерживает зафиксированный ремнями или специальными устройствами велосипед за раму. Это удобно и надежно. Существуют модели, позволяющие перевезти сразу 2 или 3 велосипеда. Крепление для велосипеда на фаркоп в виде платформы пригодится, когда ваши планы более масштабны. Для дальних поездок и большого количества велосипедов (до четырех) – это более удобный вариант. В данном случае велосипеды устанавливаются в специальные желоба на платформе и надежно закрепляются на ней. Багажник для велосипеда на фаркоп типа «платформа», кроме прочих преимуществ, позволяет свободно открывать дверь багажника автомобиля, а номерные знаки и фонари закрепляются на самом устройстве, что поможет избежать проблем с дорожной полицией.</p>"; ?>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $velofarkop[0]['name']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $velofarkop[0]['img1']; echo $velofarkop[0]['img2']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $velofarkop[0]['desc1']; ?></p>
			<p><?php echo $velofarkop[0]['desc2']; ?></p>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<p><?php echo $velofarkop[0]['price']; ?></p>
			</div>
			<div class="button">
			<button class="buy_button"><a href="/buy/<?php echo $velofarkop[0]['id']; ?>">Заказать</a></button>
			<button class="prokat_button"><a href="/prokat/<?php echo $velofarkop[0]['id']; ?>">Взять в прокат</a></button>
			</div>
		</div>
	</div>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $velofarkop[1]['name']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $velofarkop[1]['img1']; echo $velofarkop[1]['img2']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $velofarkop[1]['desc']; ?></p>
			<p>Технические характеристики:</p>
				<ul>
					<li>Грузоподъемность (велосипеды) - 2;</li>
					<li>Грузоподъемность (кг) - 30 kg;</li>
					<li>Соответствует размерам колеса - Все;</li>
					<li>Макс. вес велосипеда - 15 kg;</li>
					<li>Ширина (см) - 43 cm;</li>
					<li>Вес (кг) - 4.3 kg;</li>
					<li>Подходит для всех велосипедов, включая подростковые модели с колесами размером 20 дюймов;</li>
					<li>Подходит для большинства велосипедов с дисковыми тормозами;</li>
					<li>Необходим адаптер: Световая панель Thule 976;</li>
					<li>Соответствует стандартам City Crash;</li>
					<li>В комплект входит ремень для фиксации велосипедов;</li>
					<li>Запираемое крепление для автомобилей с навесным замком.</li>
				</ul>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<p><?php echo $velofarkop[1]['price']; ?></p>
			</div>
			<div class="button">
			<button class="buy_button"><a href="/buy/<?php echo $velofarkop[1]['id']; ?>">Заказать</a></button>
			<button class="prokat_button"><a href="/prokat/<?php echo $velofarkop[1]['id']; ?>">Взять в прокат</a></button>
			</div>
		</div>
	</div> <?php
	include ($_SERVER["DOCUMENT_ROOT"]."/frames/helpform.php");
} ?>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>