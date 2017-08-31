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
	
}




?>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>