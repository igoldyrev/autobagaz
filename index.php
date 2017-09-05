<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<?php
$page = $_GET['page'];

if (!isset($page)) {
	echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[0][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";
	include ($_SERVER["DOCUMENT_ROOT"]."/frames/newslist.php"); ?>
	
	<div class="catalog">
		<div class="menu_item">
			<div class="item_image">
			<a href="/autobagazhniki"><img src="/images/index/1_autobagazniki.jpg" alt="autobagazhniki" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/autobagazhniki">Автобагажники</a>
			</div>
		</div>
		<div class="menu_item">
			<div class="item_image">
			<a href="/autobox"><img src="/images/index/2_autobox.jpg" alt="autobox" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/autobox">Автомобильные боксы</a>
			</div>
		</div>
		<div class="menu_item">
			<div class="item_image">
			<a href="/velokreplenya"><img src="/images/index/3_velokreplenya.jpg" alt="velokreplenya" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/velokreplenya">Велокрепления</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/kreplenya-dlya-lyzh-shoubord"><img src="/images/index/4_lyzh_kreplenya.jpg" alt="lyzhnye kreplenya" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/kreplenya-dlya-lyzh-shoubord">Крепления для лыж и сноубордов</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/reelings"><img src="/images/index/6_reelings.jpg" alt="reelings" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/reelings">Рейлинги</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/braslets"><img src="/images/index/7_braslet.jpg" alt="braslet" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/braslets">Браслеты противоскольжения</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/farkops"><img src="/images/index/8_farkops.jpg" alt="farkops" width="125px"></a>
			</div>
			<div class="item_link">
			<a href="/farkops">Фаркопы</a>
			</div>
	</div></div>
	<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/sales.php"); ?>

	<h2>Наши бренды:</h2>
		<div align="center" class="brands">
			<img src="/images/logos/mont_blanc.jpg" alt="mont blanc" width="150px">
			<img src="/images/logos/lux.png" alt="lux" width="150px">
			<img src="/images/logos/atlant.png" alt="atlant" width="150px">
			<img src="/images/logos/amos.jpg" alt="amos" width="150px">
		</div>
		<div align="center" class="brands">
			<img src="/images/logos/yuago.png" alt="yuago" width="150px">
			<img src="/images/logos/atera.png" alt="atera" width="150px">
			<img src="/images/logos/menabo.jpg" alt="menabo" width="150px">
			<img src="/images/logos/yakima.png" alt="yakima" width="150px">
		</div>
		<div align="center" class="brands">
			<img src="/images/logos/vetlan.png" alt="vetlan" width="150px">
			<img src="/images/logos/turino.jpg" alt="turino" width="150px">
			<img src="/images/logos/inno.jpg" alt="inno" width="150px">
			<img src="/images/logos/whispbar.png" alt="whispbar" width="150px">
		</div>
		<div align="center" class="brands">
			<img src="/images/logos/myravei.png" alt="myravei" width="150px">
		</div>

		<p>Для многих современных людей автомобиль является не только свидетельством жизненного успеха, но и незаменимым помощником для перевозки грузов. Имея личное авто можно без проблем осуществить перевозку вещей в загородный дом или дачу или же снаряжения при занятиях активным отдыхом. Так, для осуществления грузоперевозок на легковом автомобиле существует багажник, устанавливаемый на крышу авто. Это может быт как простая и эстетичная конструкция, состоящая из двух дуг, так и более сложная, к примеру, автобокс или багажник для лодки. Наш магазин предлагает вашему вниманию автобагажники от известных мировых брендов. Если вам необходимо перевезти вещи или вы занимаетесь активным отдыхом – то вы попали по назначению. У нас вы сможете подобрать именно то, что вам нужно: автомобильные багажники, автомобильные боксы, которые станут незаменимыми помощниками при перевозке вещей и спортивного снаряжения. А для того, чтобы обеспечить вам комфорт и безопасность передвижения по зимней трассе, мы предлагаем вашему вниманию цепи противоскольжения от мировых производителей.</p>
	<h3>Универсальные багажники</h3>
		<p>В наиболее простом варианте такой автобагажник представляет собой две паралельные дуги. Благодаря простоте и функциональности, данная конструкция предназначена для перевозки любых грузов, позволяя надежно закрепить предметы. Кроме стандартных вариантов, существует также корзина для авто. Универсальные модели автобагажников в основном предназначаются для иномарок и современных российских авто. Потому, если вам нужно подобрать багажник для отечественного автомобиля, то придется буквально «примерять» различные модели, дабы подобрать наиболее удобную и подходящую.</p>
	<h3>Автобоксы</h3>
		<p>Такие багажники представляют собой конструкции в виде кейсов, которые изготавливаются из прочного толстого пластика. Такая конструкция позволяет полностью обезопасить ваш груз от атмосферных осадков, уличной грязи и злоумышленников, поскольку устройство оснащается надежным замком.</p>
	<h3>Специальные приспособления</h3>
		<p>К ним относится велокрепление, багажник для лодки и прочие всевозможные приспособления, специализированные под перевозку определённого вида грузов. Такие конструкции отлично подходят для тех, кто любит активный отдых или занимается определённым видом спорта. В данном случае, универсальный багажник окажется не очень удобным, а потому, современные производители разработали ряд специальных приспособлений и насадок к ним, обеспечивающих комфортную и безопасную перевозку конкретного вида снаряжения. Все большее количество людей в наши дни открывают для себя удобство и функциональность автобагажников. Современные конструкции совершенно не портят внешний вид вашего авто и выглядят эстетично, позволяя значительно расширить его функциональные возможности. К тому же у нас существует такая услуга, как прокат багажников и автобовков, что будет отличным вариантом в том случае, если автобагажник нужен вам единоразово и вы не видите прямой необходимости в его покупке.</p>
	<p class="brands" align="center">Mont Blanc (Монблан) Lux (Люкс) Atlant (Атлант) Amos (Амос) Yuago (ЯГО) Atera (Атера) Menabo (Менабо) Yakima (Якима) Turino (Турино) Inno (Инно) Whispbar (Виспбар) Myravei (Муравей) Vetlan (Ветлан)</p> <?php

	} elseif ($page == 'contacts') {
	echo "<title> $titleconst"; echo $keywords[6][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[6][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[6][keywords]; echo "'/>";

	echo "<p>Компания <b>Автобагаж</b></p>";
	echo "<p>Контакты для связи:</p>";
	echo "<p style='padding: 5px;line-height:2'>+7 (342) 288 99 69<br>+7 912 489 79 39 Валентин Сарафанов<br>+7 965 572 26 28 Илья Голдырев<br>+7 909 100 40 06 Денис Зарубин (руководитель)</p>";
	echo "<a href='mailto:autobagaz@yandex.ru'>autobagaz@yandex.ru</a>";
	echo "<p align='center'><b>Режим работы:</b></p>";
	echo "<p><b>Пн - Пт с 10:00 до 19:00</b></p>";
	echo "<p><b>Сб - Вс с 10:00 до 18:00</b></p>";
	echo "<p>Наш адрес: г.Пермь, Ул. Спешилова 102/29</p>";
	echo "<p align='center'><b>Мы находимся здесь:</b></p>"; ?>
	<div class="img_div">
		<img class="img_main" src="/images/contacts/shop_autobagaz_poster.jpg" srcset="
		/images/contacts/shop_autobagaz_poster.jpg 2100w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="autobagaz">
		<img class="img_main" src="/images/contacts/shop_autobagaz_back.jpg" srcset="
		/images/contacts/shop_autobagaz_back.jpg 2100w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="autobagaz">
		<img class="img_main" src="/images/logo_circle.jpg" srcset="
		/images/logo_circle.jpg 200w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="autobagaz">
	</div>
	<div><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=dPv1vaWzXDrNMJs9tlKwl_50qOYIqktt&amp;width=100%&amp;height=250&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script></div> <?php	
	echo "<p>Индивидуальный предприниматель: Зарубин Денис Юрьевич<br>ИНН 590850700022 ОГРНИП 316595800158377<br>
	р/с 40802810149770015620 в Пермском отделении №6984 ПАО Сбербанк России<br>
	БИК 045773603 к/с № 30101810900000000603<br>
	Свидетельство о регистрации 59 004723382 от 17.11.2016</p>";
	} elseif ($page == 'gallery') {
	echo "<title> $titleconst"; echo $keywords[3][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[3][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[3][keywords]; echo "'/>";

	echo "<h1>Здесь будет размещена галерея</h1>";
	} elseif ($page == 'komissionka') {
	echo "<title> $titleconst"; echo $keywords[5][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[5][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[5][keywords]; echo "'/>";

	echo "<h1>Это будет страница комиссионных товаров</h1>";
	} elseif ($page == 'podbor') {
	echo "<title> $titleconst"; echo $keywords[1][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[1][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[1][keywords]; echo "'/>";

	echo "<h1>Это будет страница с каким-нибудь справочным материалом</h1>";
	}
?>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>