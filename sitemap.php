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
            <ul class="page__list page__list--sitemap">
                <li><a class="page__link page page__link--sitemap" href="/" target="_parent">Каталог</a></li>
                <ul class="page__list page__list--sitemap">
                    <li><a class="page__link page__link--sitemap" href="/autobagazhniki" target="_parent">Автобагажники</a></li>
                    <li><a class="page__link page__link--sitemap" href="/autobox" target="_parent">Автомобильные боксы</a></li>
                    <ul class="page__list page__list--sitemap">
                        <li><a class="page__link page__link--sitemap" href="/autobox/vetlan" target="_parent">Автобоксы Ветлан (Пермь)</a></li>
                        <li><a class="page__link page__link--sitemap" href="/autobox/atlant" target="_parent">Автобоксы Атлант</a></li>
                        <li><a class="page__link page__link--sitemap" href="/autobox/yuago" target="_parent">Автобоксы Yuago</a></li>
                        <li><a class="page__link page__link--sitemap" href="/autobox/turino" target="_parent">Автобоксы Турино</a></li>
                        <li><a class="page__link page__link--sitemap" href="/autobox/lux" target="_parent">Lux, Россия</a></li>
                    </ul>
                    <li><a class="page__link page__link--sitemap" href="/velokreplenya" target="_parent">Велокрепления</a></li>
                    <ul class="page__list page__list--sitemap">
                        <li><a class="page__link page__link--sitemap" href="/velokreplenya/krysha" target="_parent">Велокрепления на крышу</a></li>
                        <li><a class="page__link page__link--sitemap" href="/velokreplenya/farkop" target="_parent">Велокрепления на фаркоп</a></li>
                    </ul>
                    <li><a class="page__link page__link--sitemap" href="/kreplenya-dlya-lyzh-shoubord"" target="_parent">Крепления для лыж и сноубордов</a></li>
                    <li><a class="page__link page__link--sitemap" href="/reelings" target="_parent">Рейлинги</a></li>
                    <ul class="page__list page__list--sitemap">
                        <li><a href="/reelings/lada" class="page__link page__link--sitemap" target="_parent">Рейлинги для автомобилей Lada</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a href="/reelings/xray" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Лада XRAY</a></li>
                            <li><a href="/reelings/largus" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Лада LARGUS</a></li>
                            <li><a href="/reelings/granta-liftback" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Лада GRANTA Лифтбек</a></li>
                            <li><a href="/reelings/granta-e" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Лада GRANTA 'E'</a></li>
                            <li><a href="/reelings/granta-kalina-sedan" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Лада Гранта / Калина Седан</a></li>
                            <li><a href="/reelings/kalina-xetchbek" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Лада Калина Хэтчбек S</a></li>
                            <li><a href="/reelings/kalina-universal" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Лада Калина Универсал M</a></li>
                            <li><a href="/reelings/4x4" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Лада 4x4</a></li>
                            <li><a href="/reelings/l4x4" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Лада 4x4 L</a></li>
                        </ul>
                        <li><a href="/reelings/chevrolet" class="page__link page__link--sitemap" target="_parent">Рейлинги для автомобилей Chevrolet</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a href="/reelings/chevi-m" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Chevrolet Niva M</a></li>
                            <li><a href="/reelings/chevi-l" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Chevrolet Niva L</a></li>
                        </ul>
                        <li><a href="/reelings/renault" class="page__link page__link--sitemap" target="_parent">Рейлинги для автомобилей Renault</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a href="/reelings/kaptur" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Renault Kaptur</a></li>
                            <li><a href="/reelings/logan" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Renault Logan (2004 - 2014)</a></li>
                            <li><a href="/reelings/new-logan" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для новый Renault Logan</a></li>
                            <li><a href="/reelings/sandero" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Renault Sandero</a></li>
                            <li><a href="/reelings/new-sandero" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для новый Renault Sandero</a></li>
                        </ul>
                        <li><a href="/reelings/kia" class="page__link page__link--sitemap" target="_parent">Рейлинги для автомобилей KIA</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a href="/reelings/ceed" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Kia Ceed</a></li>
                            <li><a href="/reelings/new-ceed" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для новый Kia Ceed</a></li>
                        </ul>
                        <li><a href="/reelings/mazda" class="page__link page__link--sitemap" target="_parent">Рейлинги для автомобилей Mazda</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a href="/reelings/three" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Mazda 3</a></li>
                            <li><a href="/reelings/cx5-1" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Mazda CX-5 I</a></li>
                            <li><a href="/reelings/cx5-2" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Mazda CX-5 II</a></li>
                        </ul>
                        <li><a href="/reelings/hyundai" class="page__link page__link--sitemap" target="_parent">Рейлинги для автомобилей Hyundai</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a href="/reelings/creta" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Hyundai Creta</a></li>
                            <li><a href="/reelings/solaris" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Hyundai Solaris</a></li>
                            <li><a href="/reelings/i30" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Hyundai i30</a></li>
                        </ul>
                        <li><a href="/reelings/opel" class="page__link page__link--sitemap" target="_parent">Рейлинги для автомобилей Opel</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a href="/reelings/astra" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Opel Astra</a></li>
                        </ul>
                        <li><a href="/reelings/toyota" class="page__link page__link--sitemap" target="_parent">Рейлинги для автомобилей Toyota</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a href="/reelings/rav4-3" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Toyota RAV-4 III</a></li>
                            <li><a href="/reelings/rav4-4" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Toyota RAV-4 IV</a></li>
                            <li><a href="/reelings/prado150" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Toyota PRADO 150</a></li>
                        </ul>
                        <li><a href="/reelings/landrover" class="page__link page__link--sitemap" target="_parent">Рейлинги для автомобилей Land Rover</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a href="/reelings/freelander2" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Land Rover Freelander 2</a></li>
                        </ul>
                        <li><a href="/reelings/datsun" class="page__link page__link--sitemap" target="_parent">Рейлинги для автомобилей Datsun</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a href="/reelings/on-do" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Datsun ON-DO</a></li>
                            <li><a href="/reelings/mi-do" class="page__link page__link--sitemap" target="_parent">Рейлинги АПС для Datsun MI-DO</a></li>
                        </ul>
                    </ul>
                    <li><a class="page__link page__link--sitemap" href="/braslets" target="_parent">Браслеты противоскольжения</a></li>
                    <li><a class="page__link page__link--sitemap" href="/farkops" target="_parent">Фаркопы</a></li>
                    <li><a class="page__link page__link--sitemap" href="/inno" target="_parent">Багажные системы Inno</a></li>
                    <ul class="page__list page__list--sitemap">
                        <li><a class="page__link page__link--sitemap" href="/inno/inno-basic">Базовые багажники</a></li>
                        <li><a class="page__link page__link--sitemap" href="/inno/inno-boxes">Автомобильные боксы</a></li>
                        <ul class="page__list page__list--sitemap">
                            <li><a class="page__link page__link--sitemap" href="/inno/new-shadow">Серия New Shadow</a></li>
                            <li><a class="page__link page__link--sitemap" href="/inno/roofbox">Серия Roofbox</a></li>
                        </ul>
                    </ul>
                    <li><a class="page__link page__link--sitemap" href="/takelazh" target="_parent">Такелажная продукция</a></li>
                </ul>
                <li><a class="page__link page__link--sitemap" href="/prokat" target="_parent">Прокат</a></li>
                <li><a class="page__link page__link--sitemap" href="/gallery" target="_parent">Галерея</a></li>
                <li><a class="page__link page__link--sitemap" href="/special-offers" target="_parent">Спецпредложения</a></li>
                <li><a class="page__link page__link--sitemap" href="/news" target="_parent">Новости и статьи</a></li>
                <li><a class="page__link page__link--sitemap" href="/guestbook" target="_parent">Обратная связь</a></li>
                <li><a class="page__link page__link--sitemap" href="/contacts" target="_parent">Контакты</a></li>
                <li><a class="page__link page__link--sitemap" href="sitemap" target="_parent">Карта сайта</a></li>
            </ul>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html");?>
</div>