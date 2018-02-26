<?php
include($_SERVER["DOCUMENT_ROOT"] . "/backend/keywords/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
	echo "<title> $titleconst"; echo $keywords[9][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[9][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[9][keywords]; echo "'/>"; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <h1 class="title title-h1">Карта сайта</h1>
        <ul class="list list__unsorted">
            <li><a class="link link--green-hover" href="/" target="_parent">Каталог</a></li>
            <ul class="list">
                <li><a class="link page__link--sitemap" href="/autobagazhniki" target="_parent">Автобагажники</a></li>
                <li><a class="link link--green-hover" href="/autobox" target="_parent">Автомобильные боксы</a></li>
                <ul class="list list__unsorted">
                    <li><a class="link link--green-hover" href="/autobox/vetlan" target="_parent">Автобоксы Ветлан (Пермь)</a></li>
                    <li><a class="link link--green-hover" href="/autobox/atlant" target="_parent">Автобоксы Атлант</a></li>
                    <li><a class="link link--green-hover" href="/autobox/yuago" target="_parent">Автобоксы Yuago</a></li>
                    <li><a class="link link--green-hover" href="/autobox/turino" target="_parent">Автобоксы Турино</a></li>
                    <li><a class="link link--green-hover" href="/autobox/lux" target="_parent">Lux, Россия</a></li>
                </ul>
                <li><a class="link link--green-hover" href="/velokreplenya" target="_parent">Велокрепления</a></li>
                <ul class="list list__unsorted">
                    <li><a class="link link--green-hover" href="/velokreplenya/krysha" target="_parent">Велокрепления на крышу</a></li>
                    <li><a class="link link--green-hover" href="/velokreplenya/farkop" target="_parent">Велокрепления на фаркоп</a></li>
                </ul>
                <li><a class="link link--green-hover" href="/kreplenya-dlya-lyzh-shoubord"" target="_parent">Крепления для лыж и сноубордов</a></li>
                <li><a class="link link--green-hover" href="/reelings" target="_parent">Рейлинги</a></li>
                <ul class="list list__unsorted">
                    <li><a href="/reelings/lada" class="link link--green-hover" target="_parent">Рейлинги для автомобилей Lada</a></li>
                    <ul class="list list__unsorted">
                        <li><a href="/reelings/xray" class="link link--green-hover" target="_parent">Рейлинги АПС для Лада XRAY</a></li>
                        <li><a href="/reelings/largus" class="link link--green-hover" target="_parent">Рейлинги АПС для Лада LARGUS</a></li>
                        <li><a href="/reelings/granta-liftback" class="link link--green-hover" target="_parent">Рейлинги АПС для Лада GRANTA Лифтбек</a></li>
                        <li><a href="/reelings/granta-e" class="link link--green-hover" target="_parent">Рейлинги АПС для Лада GRANTA 'E'</a></li>
                        <li><a href="/reelings/granta-kalina-sedan" class="link link--green-hover" target="_parent">Рейлинги АПС для Лада Гранта / Калина Седан</a></li>
                        <li><a href="/reelings/kalina-xetchbek" class="link link--green-hover" target="_parent">Рейлинги АПС для Лада Калина Хэтчбек S</a></li>
                        <li><a href="/reelings/kalina-universal" class="link link--green-hover" target="_parent">Рейлинги АПС для Лада Калина Универсал M</a></li>
                        <li><a href="/reelings/4x4" class="link link--green-hover" target="_parent">Рейлинги АПС для Лада 4x4</a></li>
                        <li><a href="/reelings/l4x4" class="link link--green-hover" target="_parent">Рейлинги АПС для Лада 4x4 L</a></li>
                    </ul>
                    <li><a href="/reelings/chevrolet" class="link link--green-hover" target="_parent">Рейлинги для автомобилей Chevrolet</a></li>
                    <ul class="list list__unsorted">
                        <li><a href="/reelings/chevi-m" class="link link--green-hover" target="_parent">Рейлинги АПС для Chevrolet Niva M</a></li>
                        <li><a href="/reelings/chevi-l" class="link link--green-hover" target="_parent">Рейлинги АПС для Chevrolet Niva L</a></li>
                    </ul>
                    <li><a href="/reelings/renault" class="link link--green-hover" target="_parent">Рейлинги для автомобилей Renault</a></li>
                    <ul class="list list__unsorted">
                        <li><a href="/reelings/kaptur" class="link link--green-hover" target="_parent">Рейлинги АПС для Renault Kaptur</a></li>
                        <li><a href="/reelings/logan" class="link link--green-hover" target="_parent">Рейлинги АПС для Renault Logan (2004 - 2014)</a></li>
                        <li><a href="/reelings/new-logan" class="link link--green-hover" target="_parent">Рейлинги АПС для новый Renault Logan</a></li>
                        <li><a href="/reelings/sandero" class="link link--green-hover" target="_parent">Рейлинги АПС для Renault Sandero</a></li>
                        <li><a href="/reelings/new-sandero" class="link link--green-hover" target="_parent">Рейлинги АПС для новый Renault Sandero</a></li>
                    </ul>
                    <li><a href="/reelings/kia" class="link link--green-hover" target="_parent">Рейлинги для автомобилей KIA</a></li>
                    <ul class="list list__unsorted">
                        <li><a href="/reelings/ceed" class="link link--green-hover" target="_parent">Рейлинги АПС для Kia Ceed</a></li>
                        <li><a href="/reelings/new-ceed" class="link link--green-hover" target="_parent">Рейлинги АПС для новый Kia Ceed</a></li>
                    </ul>
                    <li><a href="/reelings/mazda" class="link link--green-hover" target="_parent">Рейлинги для автомобилей Mazda</a></li>
                    <ul class="list list__unsorted">
                        <li><a href="/reelings/three" class="link link--green-hover" target="_parent">Рейлинги АПС для Mazda 3</a></li>
                        <li><a href="/reelings/cx5-1" class="link link--green-hover" target="_parent">Рейлинги АПС для Mazda CX-5 I</a></li>
                        <li><a href="/reelings/cx5-2" class="link link--green-hover" target="_parent">Рейлинги АПС для Mazda CX-5 II</a></li>
                    </ul>
                    <li><a href="/reelings/hyundai" class="link link--green-hover" target="_parent">Рейлинги для автомобилей Hyundai</a></li>
                    <ul class="list list__unsorted">
                        <li><a href="/reelings/creta" class="link link--green-hover" target="_parent">Рейлинги АПС для Hyundai Creta</a></li>
                        <li><a href="/reelings/solaris" class="link link--green-hover" target="_parent">Рейлинги АПС для Hyundai Solaris</a></li>
                        <li><a href="/reelings/i30" class="link link--green-hover" target="_parent">Рейлинги АПС для Hyundai i30</a></li>
                    </ul>
                    <li><a href="/reelings/opel" class="link link--green-hover" target="_parent">Рейлинги для автомобилей Opel</a></li>
                    <ul class="list list__unsorted">
                        <li><a href="/reelings/astra" class="link link--green-hover" target="_parent">Рейлинги АПС для Opel Astra</a></li>
                    </ul>
                    <li><a href="/reelings/toyota" class="link link--green-hover" target="_parent">Рейлинги для автомобилей Toyota</a></li>
                    <ul class="list list__unsorted">
                        <li><a href="/reelings/rav4-3" class="link link--green-hover" target="_parent">Рейлинги АПС для Toyota RAV-4 III</a></li>
                        <li><a href="/reelings/rav4-4" class="link link--green-hover" target="_parent">Рейлинги АПС для Toyota RAV-4 IV</a></li>
                        <li><a href="/reelings/prado150" class="link link--green-hover" target="_parent">Рейлинги АПС для Toyota PRADO 150</a></li>
                    </ul>
                    <li><a href="/reelings/landrover" class="link link--green-hover" target="_parent">Рейлинги для автомобилей Land Rover</a></li>
                    <ul class="list list__unsorted">
                        <li><a href="/reelings/freelander2" class="link link--green-hover" target="_parent">Рейлинги АПС для Land Rover Freelander 2</a></li>
                    </ul>
                    <li><a href="/reelings/datsun" class="link link--green-hover" target="_parent">Рейлинги для автомобилей Datsun</a></li>
                    <ul class="list list__unsorted">
                        <li><a href="/reelings/on-do" class="link link--green-hover" target="_parent">Рейлинги АПС для Datsun ON-DO</a></li>
                        <li><a href="/reelings/mi-do" class="link link--green-hover" target="_parent">Рейлинги АПС для Datsun MI-DO</a></li>
                    </ul>
                </ul>
                <li><a class="link link--green-hover" href="/braslets" target="_parent">Браслеты противоскольжения</a></li>
                <li><a class="link link--green-hover" href="/farkops" target="_parent">Фаркопы</a></li>
                <li><a class="link link--green-hover" href="/inno" target="_parent">Багажные системы Inno</a></li>
                <ul class="list list__unsorted">
                    <li><a class="link link--green-hover" href="/inno/inno-basic">Базовые багажники</a></li>
                    <li><a class="link link--green-hover" href="/inno/inno-boxes">Автомобильные боксы</a></li>
                    <ul class="list list__unsorted">
                        <li><a class="link link--green-hover" href="/inno/new-shadow">Серия New Shadow</a></li>
                        <li><a class="link link--green-hover" href="/inno/roofbox">Серия Roofbox</a></li>
                    </ul>
                </ul>
                <li><a class="link link--green-hover" href="/takelazh" target="_parent">Такелажная продукция</a></li>
            </ul>
            <li><a class="link link--green-hover" href="/prokat" target="_parent">Прокат</a></li>
            <li><a class="link link--green-hover" href="/gallery" target="_parent">Галерея</a></li>
            <li><a class="link link--green-hover" href="/special-offers" target="_parent">Спецпредложения</a></li>
            <li><a class="link link--green-hover" href="/news" target="_parent">Новости и статьи</a></li>
            <li><a class="link link--green-hover" href="/guestbook" target="_parent">Обратная связь</a></li>
            <li><a class="link link--green-hover" href="/contacts" target="_parent">Контакты</a></li>
            <li><a class="link link--green-hover" href="/partners" target="_parent">Наши партнеры</a></li>
            <li><a class="link link--green-hover" href="sitemap" target="_parent">Карта сайта</a></li>
        </ul>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>