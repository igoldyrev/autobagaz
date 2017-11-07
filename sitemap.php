<?php
include($_SERVER["DOCUMENT_ROOT"] . "/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");
	echo "<title> $titleconst"; echo $keywords[23][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[23][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[23][keywords]; echo "'/>";

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<h1>Карта сайта</h1>
<ul>
<li><a href="/" target="_parent">Каталог</a></li>
	<ul>
		<li><a href="/autobagazhniki" target="_parent">Автобагажники</a></li>
		<li><a href="/autobox" target="_parent">Автомобильные боксы</a></li>
			<ul>
				<li><a href="/vetlan" target="_parent">Автобоксы Ветлан (Пермь)</a></li>
				<li><a href="/atlant" target="_parent">Автобоксы Атлант</a></li>
				<li><a href="/yuago" target="_parent">Автобоксы Yuago</a></li>
				<li><a href="/turino" target="_parent">Автобоксы Турино</a></li>
				<li><a href="/lux" target="_parent">Lux, Россия</a></li>			
			</ul>	
		<li><a href="/velokreplenya" target="_parent">Велокрепления</a></li>
			<ul>
				<li><a href="/velokreplenya_na_kryshy" target="_parent">Велокрепления на крышу</a></li>
				<li><a href="/velokreplenya_na_farkop" target="_parent">Велокрепления на фаркоп</a></li>
			</ul>
		<li><a href="/kreplenya-dlya-lyzh-shoubord"" target="_parent">Крепления для лыж и сноубордов</a></li>
		<li><a href="/reelings" target="_parent">Рейлинги</a></li>
		<li><a href="/braslets" target="_parent">Браслеты противоскольжения</a></li>
		<li><a href="/farkops" target="_parent">Фаркопы</a></li>
	</ul>
<li><a href="/prokat" target="_parent">Прокат</a></li>
<li><a href="/gallery" target="_parent">Галерея</a></li>
<li><a href="/komissionka" target="_parent">Комиссионка</a></li>
<li><a href="/podbor" target="_parent">Вопрос - ответ</a></li>
<li><a href="/guestbook" target="_parent">Обратная связь</a></li>
<li><a href="/contacts" target="_parent">Контакты</a></li>
<li><a href="/news" target="_parent">Архив новостей</a></li>
<li><a href="sitemap" target="_parent">Карта сайта</a></li>
</ul></div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");?>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html");?>