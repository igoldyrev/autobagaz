<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); 
include ($_SERVER["DOCUMENT_ROOT"]."/arrays/autobox_array.php"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<?php
$autobox = $_GET['autobox'];
if (!isset($autobox)) {
	echo "<title> $titleconst"; echo $keywords[8][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[8][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[8][keywords]; echo "'/>";
	
	echo "<h1>Автомобильные боксы</h1>";
	echo "<p>Каким бы просторным ни был автомобиль, порой места в нем начинает не хватать. Поездка за город или возвращение из похода по магазинам превращается в акробатический номер с грузом на коленях и плотно упакованными пассажирами на задних сиденьях. А перевозка лыж или сноубордов вообще является ночным кошмаром автомобилиста. Добавить столь необходимый рабочий объем вашей машине могут автомобильные боксы.</p>";
	echo "<p>Автобоксы являются простым и надежным средством увеличения вместительности автомобиля, и абсолютно незаменимы при возникновении необходимости перевозки грузов, требующих бережного обращения и надежной защиты от влаги, пыли и прочих негативных факторов окружающей среды. Изготовленные из современных высококачественных материалов, автомобильные боксы сочетают в себе высокую надежность крепления, оптимальные условия фиксации груза и необычайную легкость базовой конструкции, а система центрального замка с двухсторонним открыванием и многоточечным запиранием гарантирует безопасную эксплуатацию и высокую защиту от несанкционированного проникновения в бокс.</p>";
	echo "<h2>Варианты автобоксов</h2>"; ?>
	<table class="links_catalog">
		<tr><td width="170px" class="links_catalog" align="center"><a href="/vetlan"><img src="/images/logos/vetlan.png" alt="vetlan" width="150px"></a></td><td align="center" class="links_catalog"><a class="links_catalog" href="/vetlan">Автобоксы Ветлан (Пермь)</a></td></tr>
		<tr><td width="170px" class="links_catalog" align="center"><a href="/atlant"><img src="/images/logos/atlant.png" alt="atlant" width="150px"></a></td><td class="links_catalog" align="center"><a class="links_catalog" href="/atlant">Автобоксы Атлант</a></td></tr>
		<tr><td width="170px" class="links_catalog" align="center"><a href="/yuago"><img src="/images/logos/yuago.png" alt="yuago" width="150px"></a></td><td class="links_catalog" align="center"><a href="/yuago">Автобоксы Yuago</a></td></tr>
		<tr><td width="170px" class="links_catalog" align="center"><a href="/turino"><img src="/images/logos/turino.jpg" alt="turino" width="150px"></a></td><td class="links_catalog" align="center"><a href="/turino">Автобоксы Турино</a></td></tr>
		<tr><td width="170px" class="links_catalog" align="center"><a href="/lux"><img src="/images/logos/lux.png" alt="lux" width="150px"></a></td><td class="links_catalog" align="center"><a href="/lux">Lux, Россия</a></td></tr>
	</table> <?php
} elseif ($autobox == 'yuago') {
	echo "<title> $titleconst"; echo $keywords[13][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[13][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[13][keywords]; echo "'/>";
	
	$_SESSION['yuago'] = $yuago; 
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	
	echo "<h1>"; echo $yuago[name]; echo "</h1>";
	echo "<p>Лучший выбор для лыжника! При длине бокса в 2180см перевозка лыж и сноубордов теперь становится легкой задачей, больше Вам не придется складывать сиденья, пачкать и царапать салон автомобиля.</p>";
	echo "<p>Автобокс Cosmo изготовлен из АБС-пластика. Материал автобокса устойчив к большинству видов химических реагентов: кислотам, щелочам и жирам. Важным фактором при ежедневной эксплуатации является повышенная жесткостью конструкции и устойчивость поверхности к царапинам.</p>"; ?>
	<table cellspacing="0" align="left">
		<tr><td class="producttable" align="left">Габариты</td><td class="producttable" align="left"><?php echo $yuago[size]; ?></td></tr>
		<tr><td class="producttable" align="left">Объем</td><td class="producttable" align="left"><?php echo $yuago[volume]; ?></td></tr>
		<tr><td class="producttable" align="left">Материал</td><td class="producttable" align="left"><?php echo $yuago[material]; ?></td></tr>
		<tr><td class="producttable" align="left">Цвета</td><td class="producttable" align="left"><?php echo $yuago[color]; ?></td></tr>
		<tr><td class="producttable" align="left">Замок</td><td class="producttable" align="left"><?php echo $yuago[lock]; ?></td></tr>
		<tr><td class="producttable" align="left">Погрузка багажа</td><td class="producttable" align="left"><?php echo $yuago[bagazh]; ?></td></tr>
	</table> 
	<div class="img_div"> <?php
	echo $yuago[img1]; ?>
	</div>
	<div class="price_info">
		<div class="price">
	<?php echo "<p>Цена "; echo $yuago[price]; echo "</p>";	?>
		</div>
		<div class="button">
		<button class="buy_button"><a href="/buy/<?php echo $yuago['id']; ?>">Заказать</a></button>		
		</div>
	</div> <?php 	
} elseif ($autobox == 'turino') {
	echo "<title> $titleconst"; echo $keywords[14][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[14][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[14][keywords]; echo "'/>";
	
	$_SESSION['turino'] = $turino; 
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	
	echo "<h1>"; echo $turino[name]; echo "</h1>";
	echo "<p>"; echo $turino[desc1]; echo "</p>";
	echo "<p>"; echo $turino[desc2]; echo "</p>"; ?>
	<div class="img_div"> <?php
	echo $turino[img1]; echo $turino[img2]; echo $turino[img3]; echo $turino[img4]; echo $turino[img5]; echo $turino[img6]; ?>
	</div>
	<div class="price_info">
		<div class="price">
	<?php echo "<p>"; echo $turino[price]; echo "</p>";	?>
		</div>
		<div class="button">
		<button class="buy_button"><a href="/buy/<?php echo $turino['id']; ?>">Заказать</a></button>		
		</div>
	</div> <?php
} elseif ($autobox == 'lux') {
	echo "<title> $titleconst"; echo $keywords[15][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[15][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[15][keywords]; echo "'/>";
	
	$_SESSION['lux'] = $lux; 
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	
	echo "<h1>Lux, Россия</h1>";
	echo "<p>Боксы на крышу LUX произведены в России, из высококачественного российского АБС пластика , с применением фурнитуры, разработанной, специально для наших суровых условий эксплуатации.</p>";
	echo "<p>Впервые в России, в багажных боксах использована система центрального замка с двухсторонним открыванием и многоточечным запиранием, полностью отечественного производства.</p>";
	echo "<p>Крепления бокса к багажнику, отличаются простотой, удобством и высочайшей надёжностью. Массивные крепёжные скобы, с внутренней шириной 82 мм, позволяют закрепить бокс LUX на поперечинах всех европейских производителей багажных систем.</p>";
	echo "<p>Грузоподъёмность боксов Люкс соответствует европейскому стандарту, и составляет 50 кг распределенного груза.</p>"; ?>
	<div class="img_div">
		<img class="img_main" src="/images/lux/lux_1.jpg" srcset="/images/lux/lux_1.jpg 300w" alt="Lux, Россия" sizes="(max-width: 2000px) 150px, 300px, 350px">
		<img class="img_main" src="/images/lux/lux_2.jpg" srcset="/images/lux/lux_2.jpg 300w" alt="Lux, Россия" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
	<table cellspacing="0" align="center">
		<tr><td class="producttablecaption" align="left">Наименование, характеристики</td><td class="producttablecaption" align="center">Цена</td><td class="producttablecaption"></td></tr>
		<tr><td class="producttable" align="left"><?php echo $lux[name1]; ?></td><td class="producttable" align="center"><?php echo $lux[price1]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $lux['id1']; ?>">Заказать</a></button></td></tr>
		<tr><td class="producttable" align="left"><?php echo $lux[name2]; ?></td><td class="producttable" align="center"><?php echo $lux[price2]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $lux['id2']; ?>">Заказать</a></button></td></tr>
		<tr><td class="producttable" align="left"><?php echo $lux[name3]; ?></td><td class="producttable" align="center"><?php echo $lux[price3]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $lux['id3']; ?>">Заказать</a></button></td></tr>
		<tr><td class="producttable" align="left"><?php echo $lux[name4]; ?></td><td class="producttable" align="center"><?php echo $lux[price4]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $lux['id4']; ?>">Заказать</a></button></td></tr>
		<tr><td class="producttable" align="left"><?php echo $lux[name5]; ?></td><td class="producttable" align="center"><?php echo $lux[price5]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $lux['id5']; ?>">Заказать</a></button></td></tr>
		<tr><td class="producttable" align="left"><?php echo $lux[name6]; ?></td><td class="producttable" align="center"><?php echo $lux[price6]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $lux['id6']; ?>">Заказать</a></button></td></tr>
	</table> <?php
} elseif ($autobox == 'atlant') {
	echo "<title> $titleconst"; echo $keywords[10][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[10][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[10][keywords]; echo "'/>";
	
	$_SESSION['discoveryclassic'] = $discoveryclassic; 
	$_SESSION['discoverysport'] = $discoverysport; 
	$_SESSION['dynamic'] = $dynamic; 
	$_SESSION['airtek'] = $airtek; 
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];

	echo "<h1>Автобоксы Атлант</h1>";
	echo "<p>Производитель: ООО «Атлант»,Россия, Спб<br>Производство: совместное Италия-Спб</p>";
	echo "<p>Давно зарекомендовавшая себя на рынке автобагажников в России компания Атлант представляет широкий спектр выбора боксов для вашего автомобиля по вашим потребностям!</p>";
	echo "<h2>Серия DISCOVERY, открывание одностороннее</h2>"; ?>
	<div class="img_div">
		<img class="img_main" src="/images/discovery/discovery_1.jpg"  srcset="/images/discovery/discovery_1.jpg 150w" alt="discovery" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
	<table align="center">
		<tr><td class="producttable"><?php echo $discoveryclassic[name1]; ?></td><td class="producttable"><?php echo $discoveryclassic[price1]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $discoveryclassic['id1']; ?>">Заказать</a></button></td></tr>
		<tr><td class="producttable"><?php echo $discoveryclassic[name2]; ?></td><td class="producttable"><?php echo $discoveryclassic[price2]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $discoveryclassic['id2']; ?>">Заказать</a></button></td></tr>
		<tr><td class="producttable"><?php echo $discoveryclassic[name3]; ?></td><td class="producttable"><?php echo $discoveryclassic[price3]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $discoveryclassic['id3']; ?>">Заказать</a></button></td></tr>
	</table> 
	<div class="img_div">
		<img class="img_main" src="/images/discovery/discovery_2.jpg"  srcset="/images/discovery/discovery_2.jpg 150w" alt="discovery" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
	<table align="center">
		<tr><td class="producttable"><?php echo $discoverysport[name1]; ?></td><td class="producttable"><?php echo $discoverysport[price1]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $discoverysport['id1']; ?>">Заказать</a></button></td></tr>
		<tr><td class="producttable"><?php echo $discoverysport[name2]; ?></td><td class="producttable"><?php echo $discoverysport[price2]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $discoverysport['id2']; ?>">Заказать</a></button></td></tr>
	</table> <?php
	echo "<h2>Серия Атлант, двухстороннее открывание, цвет металлик</h2>"; ?>
	<div class="img_div">
		<img class="img_main" src="/images/atlant/atlant_1.jpg"  srcset="/images/atlant/atlant_1.jpg 150w" alt="atlant" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
	<table align="center">
		<tr><td class="producttable"><?php echo $dynamic[name1]; ?></td><td class="producttable"><?php echo $dynamic[price1]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $dynamic['id1']; ?>">Заказать</a></button></td></tr>
		<tr><td class="producttable"><?php echo $dynamic[name2]; ?></td><td class="producttable"><?php echo $dynamic[price2]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $dynamic['id2']; ?>">Заказать</a></button></td></tr>
	</table> 
	<div class="img_div">
		<img class="img_main" src="/images/atlant/atlant_2.jpg"  srcset="/images/atlant/atlant_2.jpg 140w" alt="atlant" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
	<table align="center">
		<tr><td class="producttable"><?php echo $airtek[name1]; ?></td><td class="producttable"><?php echo $airtek[price1]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $airtek['id1']; ?>">Заказать</a></button></td></tr>
		<tr><td class="producttable"><?php echo $airtek[name2]; ?></td><td class="producttable"><?php echo $airtek[price2]; ?></td><td class="producttable"><button class="buy_button"><a href="/buy/<?php echo $airtek['id2']; ?>">Заказать</a></button></td></tr>
	</table> <?php
} elseif ($autobox == 'vetlan') {
	echo "<title> $titleconst"; echo $keywords[9][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[9][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[9][keywords]; echo "'/>";

	$_SESSION['vetlan'] = $vetlan; 
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	
	echo "<h1>Автомобильные боксы Vetlan (Пермь)</h1>";
	echo "<p>Автобоксы «VetlaN» рассчитаны на эксплуатацию в условиях, где жаркое лето сменяет холодная зима. Эти боксы, надежные настолько, насколько требует эксплуатация подобного устройства на наших неровных дорогах. Это – ваша безопасность и спокойствие во время длительных путешествий.</p>";
	echo "<p>Автобоксы изготовлены из качественного пластика – АБС (акрилонитрилбутадиенстирол). Материал отличается повышенной стойкостью к воздействию агрессивных веществ и не меняет цвета со временем. Эти автобагажники на крышу сделаны из пластика, которые выдержат практически любые дорожные нагрузки, сильный ветер и любую непогоду, включая дождь, град и снег. Автобоксы «VetlaN» обладают отличной аэродинамикой.</p>";
	echo "<p>С боксом «VetlaN» Вы забудете о нехватке места в багажнике вашего авто. Теперь собираясь в дальнюю поездку у Вас не будет болеть голова о том, куда складывать детские игрушки, матрасы и подушки, все для пикника и т.п. «VetlaN» - это лучший выбор.</p>"; ?>
	
	<div class="good" itemscope itemtype="http://schema.org/Product"> <?php
	echo "<h2 itemprop='name'>"; echo $vetlan[0]['title']; echo "</h2>"; ?>
	<div class="img_div" itemprop="image">
		<?php echo $vetlan[0]['img1']; echo $vetlan[0]['img2']; echo $vetlan[0]['img3']; echo $vetlan[0]['img4']; ?>
	</div>
		<table cellspacing="0" align="center">
			<tr><td class="producttablecaption" align="left">Характеристики</td><td class="producttablecaption" align="center">Значение</td><td class="producttablecaption"></td></tr>
			<tr><td class="producttable" align="left">Размер</td><td class="producttable" align="center"><?php echo $vetlan[0]['size']; ?></td></tr>
			<tr><td class="producttable" align="left">Литраж</td><td class="producttable" align="center"><?php echo $vetlan[0]['volume']; ?></td></tr>
			<tr><td class="producttable" align="left">Материал</td><td class="producttable" align="center"><?php echo $vetlan[0]['material']; ?></td></tr>
			<tr><td class="producttable" align="left">Крепление</td><td class="producttable" align="center"><?php echo $vetlan[0]['clamp']; ?></td></tr>
			<tr><td class="producttable" align="left">Замок</td><td class="producttable" align="center"><?php echo $vetlan[0]['lock']; ?></td></tr>
			<tr><td class="producttable" align="left">Варианты цветов</td><td class="producttable" align="center"><?php echo $vetlan[0]['color']; ?></td></tr>
		</table> 
		<div class="good_desc"  itemprop="description"> <?php 
	echo "<p>"; echo $vetlan[0]['desc1']; echo "</p>";
	echo "<p>"; echo $vetlan[0]['desc2']; echo "</p>"; ?></div>
	<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
				<table align="center">
				<tr><td class="producttable" align="left"><b><?php echo "Черный: "; echo $vetlan[0]['price_black']; ?></b></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $vetlan[0]['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $vetlan[0]['id1']; ?>">Взять в прокат</a></button></td></tr>
				<tr><td class="producttable" align="left"><b><?php echo "Серый: "; echo $vetlan[0]['price_gray']; ?></b></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $vetlan[0]['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $vetlan[0]['id2']; ?>">Взять в прокат</a></button></td></tr>
				<tr><td class="producttable" align="left"><b><?php echo "Белый: "; echo $vetlan[0]['price_white']; ?></b></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $vetlan[0]['id3']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $vetlan[0]['id3']; ?>">Взять в прокат</a></button></td></tr>
				</table>			
			</div></div></div> <?php
		
}
?>


</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>