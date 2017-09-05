<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<?php 
	echo "<title> $titleconst"; echo $keywords[20][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[20][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[20][keywords]; echo "'/>"; 
	
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	
	echo "<h1>Рейлинги</h1>";
	echo "<p>Автомобиль должен быть не только функциональным, но и красивым, должен радовать глаз. С этим утверждением сегодня согласится, наверное, каждый. Тем более сейчас, когда автомобилей на дорогах стало особенно много. Придать облику вашего авто законченность и спортивную элегантность, подчеркнуть его сдержанную энергию, полную внутренней силы, способна такая незначительная на первый взгляд деталь как рейлинги на крыше автомобиля. Редкий водитель доволен объемом багажного отделения своего автомобиля. Но - благодаря рейлингам - даже малолитражка (не говоря уже о внедорожниках или машинах «средней ценовой категории») может перевозить куда большие объемы груза, чем было заложено конструкторами. Таким образом, решительно для любого автомобиля рейлинги - это необходимость, а часто и одно из условий, позволяющее установить на авто багажники: как стандартные, так и герметичные удобные боксы.</p>";
	echo "<h2>Мы предлагаем рейлинги двух проихводителей: Voyager и Can (Турция)</h2>"; ?>
	
	<div class="img_div">
		<img class="img_main" src="/images/reelings/can.jpg" srcset="/images/reelings/can.jpg 300w" alt="Thule XTENDER" sizes="(max-width: 2000px) 150px, 300px, 350px">
		<img class="img_main" src="/images/reelings/voyager.jpg" srcset="/images/reelings/voyager.jpg 300w" alt="Thule XTENDER" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
	<p><b>Цена 12 500 рублей</b></p>
	<h2 align="center">Примерная совместимость рейлингов с моделями автомобилей:</h2>
	<p><b>Voyager, Турция</b></p>
		<p>Citroen Berlingo 1997-2007 гг<br> 
		Citroen Berlingo 2008 г - ... <br>
		Fiat Doblo I, короткая база <br>
		Ford C-Max, 2003-2010 гг <br>
		Ford Fusion <br>
		Ford S-Max, с 2006 г<br> 
		Hyundai H1 с 2007г <br>
		Hyundai Getz <br>
		Hyundai Starex с 1997г.- по наст.время<br> 
		Lada Largus <br>
		Land Rover Discovery 3, 2005-2009гг <br>
		Land Rover Discovery 4, с 2009г <br>
		Land Rover Free Lander 2, 2007г <br>
		Land Rover Free Lander I, 1996-2006гг <br>
		Mazda BT-50 до 2012г. <br>
		Mitsubishi ASX c 2010- г <br>
		Mitsubishi L200, 2006-2015 <br>
		Nissan Juke, с 2010- гг <br>
		Nissan Juke с 2012г <br>
		Nissan Navara c 2005г <br>
		Nissan NP300 c 2008г <br>
		Nissan Qashqai 2007-2013гг <br>
		Nissan Qashqai с 2014г <br>
		Opel Astra Н хетчбэк 2004-2009гг <br>
		Peugeot Partner 2008г <br>
		Porsche Cayenne 2003-2010 <br>
		Range Rover Sport, c 2005г <br>
		Range Rover Vogue, 2002-2012гг. <br>
		Range Rover Vogue, c 2013г <br>
		Renault Scenic II, 2006-2009 гг <br>
		Renault Traffic с 2001г-... короткая база <br>
		Renault Traffic с 2001г-... длинная база <br>
		Ssang Yong Actyon 2005-2011гг, <br>
		Ssang Yong Actyon Sport/Korando Sport 2005-2011гг <br>
		Ssang Yong Actyon Sports/Korando Sports пикап c 2012г <br>
		Suzuki Grand Vitara, c 2006г <br>
		Toyota Hilux 2005-2011гг <br>
		Toyota Hilux 2012-2014 <br>
		Toyota Hilux Vigo 2012-2014 <br>
		Toyota Hilux Revo c 2015 <br>
		Toyota Land Cruiser Prado 120, 2002-2009гг <br>
		Toyota Land Cruiser Prado 150, 2009г <br>
		Toyota RAV4, с 2006-2012 гг <br>
		Toyota RAV4 с 2013 г <br>
		Volkswagen Amarok <br>
		Volkswagen Caddy I, 2004-2009 гг <br>
		Volkswagen Caddy II 2010г <br>
		Volkswagen Caddy Maxi, 2008г <br>
		Volkswagen Touareg, 2003-2010 гг <br>
		Volkswagen Transporter T4, короткая база <br>
		Volkswagen Transporter T4, длинная база <br>
		Volkswagen Transporter T5, c 2003- г, длинная база <br>
		Volkswagen Transporter T5, c 2003- г, короткая база <br></p>
	<p><b>CAN, Турция</b></p>
		<p>Citroen Berlingo 2008 г - ... <br>
		Fiat Doblo I, короткая база <br>
		Fiat Doblo I, длинная база <br>
		Fiat Doblo II, короткая база <br>
		Fiat Doblo II, длинная база <br>
		Ford Connect короткая база 2003г <br>
		Honda CRV III 2007-2012гг <br>
		Mitsubishi ASX c 2010- г <br>
		Peugeot Partner 2008г <br>
		Porsche Cayenne 2003-2010 <br>
		Suzuki Grand Vitara 5дв. 2006г <br>
		Volkswagen Amarok <br>
		Volkswagen Caddy I, 2004-2009 гг <br>
		Volkswagen Caddy II 2010г <br>
		Volkswagen Caddy Maxi, 2008г <br>
		Volkswagen Touareg, 2003-2010 гг <br>
		Volkswagen Touareg 2010 <br>
		Volkswagen Transporter T5 2004г <br>
		Volkswagen Transporter T5 2004г- ... короткая база <br></p>

	<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/helpform.php"); ?>
</div>
<?php 
include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>