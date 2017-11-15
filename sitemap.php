<?php
include($_SERVER["DOCUMENT_ROOT"] . "/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");
	echo "<title> $titleconst"; echo $keywords[23][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[23][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[23][keywords]; echo "'/>"; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php");?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html");?>
        <div class="content">
            <h1 class="page__title-h1">Карта сайта</h1>
            <ul class="page__list">
                <li><a class="page__link" href="/" target="_parent">Каталог</a></li>
                <ul>
                    <li><a class="page__link" href="/autobagazhniki" target="_parent">Автобагажники</a></li>
                    <li><a class="page__link" href="/autobox" target="_parent">Автомобильные боксы</a></li>
                    <ul class="page__list">
                        <li><a class="page__link" href="/vetlan" target="_parent">Автобоксы Ветлан (Пермь)</a></li>
                        <li><a class="page__link" href="/atlant" target="_parent">Автобоксы Атлант</a></li>
                        <li><a class="page__link" href="/yuago" target="_parent">Автобоксы Yuago</a></li>
                        <li><a class="page__link" href="/turino" target="_parent">Автобоксы Турино</a></li>
                        <li><a class="page__link" href="/lux" target="_parent">Lux, Россия</a></li>
                    </ul>
                    <li><a class="page__link" href="/velokreplenya" target="_parent">Велокрепления</a></li>
                    <ul class="page__list">
                        <li><a class="page__link" href="/velokreplenya_na_kryshy" target="_parent">Велокрепления на крышу</a></li>
                        <li><a class="page__link" href="/velokreplenya_na_farkop" target="_parent">Велокрепления на фаркоп</a></li>
                    </ul>
                    <li><a class="page__link" href="/kreplenya-dlya-lyzh-shoubord"" target="_parent">Крепления для лыж и сноубордов</a></li>
                    <li><a class="page__link" href="/reelings" target="_parent">Рейлинги</a></li>
                    <li><a class="page__link" href="/braslets" target="_parent">Браслеты противоскольжения</a></li>
                    <li><a class="page__link" href="/farkops" target="_parent">Фаркопы</a></li>
                </ul>
                <li><a class="page__link" href="/prokat" target="_parent">Прокат</a></li>
                <li><a class="page__link" href="/gallery" target="_parent">Галерея</a></li>
                <li><a class="page__link" href="/komissionka" target="_parent">Комиссионка</a></li>
                <li><a class="page__link" href="/podbor" target="_parent">Вопрос - ответ</a></li>
                <li><a class="page__link" href="/guestbook" target="_parent">Обратная связь</a></li>
                <li><a class="page__link" href="/contacts" target="_parent">Контакты</a></li>
                <li><a class="page__link" href="/news" target="_parent">Архив новостей</a></li>
                <li><a class="page__link" href="sitemap" target="_parent">Карта сайта</a></li>
            </ul>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html");?>
</div>