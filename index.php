<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/keywords/keywords.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php
        $page = $_GET['page'];
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];

        if (!isset($page)) {
            echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[0][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>"; ?>

            <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/stock/stock.php");
            include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/index-message/index-message.php"); ?>

            <div class="catalog">
                <div class="catalog__item">
                    <a href="/autobagazhniki" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/index/img/catalog/1_autobagazniki.jpg" alt="autobagazhniki">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Автобагажники</p>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/autobox" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/index/img/catalog/2_autobox.jpg" alt="autobox">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Автомобильные боксы</p>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/velokreplenya" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/index/img/catalog/3_velokreplenya.jpg" alt="velokreplenya">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Велокрепления</p>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/kreplenya-dlya-lyzh-shoubord" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/index/img/catalog/4_lyzh_kreplenya.jpg" alt="lyzhnye kreplenya">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Крепления для лыж и сноубордов</p>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/reelings" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/index/img/catalog/6_reelings.jpg" alt="reelings">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Рейлинги</p>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/braslets" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/index/img/catalog/7_braslet.jpg" alt="braslet">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Браслеты противоскольжения</p>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/farkops" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/index/img/catalog/8_farkops.jpg" alt="farkops">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Фаркопы</p>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/inno" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/index/img/catalog/9_inno.jpg" alt="inno">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Багажные системы Inno</p>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/takelazh" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/index/img/catalog/10_textil.JPG" alt="такелажная продукция">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Такелажная продукция</p>
                    </div>
                </div>
            </div>

            <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/sales/sales.php"); ?>
            <a href="/special-offers" class="left-nav left-nav__link left-nav__link--rewiew">Все предложения</a>
            <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/newslist.php"); ?>


            <h2 class="title title-h2">Мы работаем со следующими брендами:</h2>
            <div class="brands__wrap">
                <div class="brands">
                    <img src="/content/index/img/logos/mont_blanc.jpg" alt="mont blanc" width="150px">
                    <img src="/content/index/img/logos/lux.png" alt="lux" width="150px">
                    <img src="/content/index/img/logos/atlant.png" alt="atlant" width="150px">
                    <img src="/content/index/img/logos/amos.jpg" alt="amos" width="150px">
                    <img src="/content/index/img/logos/yuago.png" alt="yuago" width="150px">
                </div>
                <div class="brands">
                    <img src="/content/index/img/logos/vetlan.png" alt="vetlan" width="150px">
                    <img src="/content/index/img/logos/turino.jpg" alt="turino" width="150px">
                    <img src="/content/index/img/logos/atera.png" alt="atera" width="150px">
                    <img src="/content/index/img/logos/menabo.jpg" alt="menabo" width="150px">
                    <img src="/content/index/img/logos/yakima.png" alt="yakima" width="150px">
                </div>
                <div class="brands">
                    <img src="/content/index/img/logos/myravei.png" alt="myravei" width="150px">
                    <img src="/content/index/img/logos/inno.jpg" alt="inno" width="150px">
                    <img src="/content/index/img/logos/whispbar.png" alt="whispbar" width="150px">
                </div>
            </div>
            <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/reviews.php"); ?>

            <p class="text">Для многих современных людей автомобиль является не только свидетельством жизненного успеха, но и незаменимым помощником для перевозки грузов. Имея личное авто можно без проблем осуществить перевозку вещей в загородный дом или дачу или же снаряжения при занятиях активным отдыхом. Так, для осуществления грузоперевозок на легковом автомобиле существует багажник, устанавливаемый на крышу авто. Это может быт как простая и эстетичная конструкция, состоящая из двух дуг, так и более сложная, к примеру, автобокс или багажник для лодки. Наш магазин предлагает вашему вниманию автобагажники от известных мировых брендов. Если вам необходимо перевезти вещи или вы занимаетесь активным отдыхом – то вы попали по назначению. У нас вы сможете подобрать именно то, что вам нужно: автомобильные багажники, автомобильные боксы, которые станут незаменимыми помощниками при перевозке вещей и спортивного снаряжения. А для того, чтобы обеспечить вам комфорт и безопасность передвижения по зимней трассе, мы предлагаем вашему вниманию цепи противоскольжения от мировых производителей.</p>
            <h3 class="title title-h3">Универсальные багажники</h3>
            <p class="text">В наиболее простом варианте такой автобагажник представляет собой две паралельные дуги. Благодаря простоте и функциональности, данная конструкция предназначена для перевозки любых грузов, позволяя надежно закрепить предметы. Кроме стандартных вариантов, существует также корзина для авто. Универсальные модели автобагажников в основном предназначаются для иномарок и современных российских авто. Потому, если вам нужно подобрать багажник для отечественного автомобиля, то придется буквально «примерять» различные модели, дабы подобрать наиболее удобную и подходящую.</p>
            <h3 class="title title-h3">Автобоксы</h3>
            <p class="text">Такие багажники представляют собой конструкции в виде кейсов, которые изготавливаются из прочного толстого пластика. Такая конструкция позволяет полностью обезопасить ваш груз от атмосферных осадков, уличной грязи и злоумышленников, поскольку устройство оснащается надежным замком.</p>
            <h3 class="title title-h3">Специальные приспособления</h3>
            <p class="text">К ним относится велокрепление, багажник для лодки и прочие всевозможные приспособления, специализированные под перевозку определённого вида грузов. Такие конструкции отлично подходят для тех, кто любит активный отдых или занимается определённым видом спорта. В данном случае, универсальный багажник окажется не очень удобным, а потому, современные производители разработали ряд специальных приспособлений и насадок к ним, обеспечивающих комфортную и безопасную перевозку конкретного вида снаряжения. Все большее количество людей в наши дни открывают для себя удобство и функциональность автобагажников. Современные конструкции совершенно не портят внешний вид вашего авто и выглядят эстетично, позволяя значительно расширить его функциональные возможности. К тому же у нас существует такая услуга, как прокат багажников и автобовков, что будет отличным вариантом в том случае, если автобагажник нужен вам единоразово и вы не видите прямой необходимости в его покупке.</p>
            <?php
        } elseif ($page == 'contacts') {
            echo "<title> $titleconst"; echo $keywords[6][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[6][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[6][keywords]; echo "'/>"; ?>

            <h3 class="title title-h3">Компания Автобагаж</h3>
            <p class="text">Контакты для связи:</p>
            <div class="contacts">
                <a onclick="yaCounter40650914.reachGoal('call_phone'); return true" href="tel:+73422889969" class="contacts__link">+7 (342) 288 99 69</a>
                <a onclick="yaCounter40650914.reachGoal('call_phone'); return true" href="tel:+79124897939" class="contacts__link">+7 912 489 79 39 Валентин Сарафанов</a>
                <a onclick="yaCounter40650914.reachGoal('call_phone'); return true" href="tel:+79655722628" class="contacts__link">+7 965 572 26 28 Илья Голдырев</a>
                <a onclick="yaCounter40650914.reachGoal('call_phone'); return true" href="tel:+79091004006" class="contacts__link">+7 909 100 40 06 Денис Зарубин (руководитель)</a>
                <a onclick="yaCounter40650914.reachGoal('write_mail'); return true" href="mailto:autobagaz@yandex.ru" class="contacts__link">autobagaz@yandex.ru</a>
            </div>
            <h3 class="title title-h3">Режим работы:</h3>
            <p class="text">Пн - Пт с 10:00 до 19:00</p>
            <p class="text">Сб - Вс с 10:00 до 18:00</p>
            <p class="text">Наш адрес: г.Пермь, Ул. Спешилова 102/29</p>
            <h3 class="title title-h3">Мы находимся здесь:</h3>
            <div class="img__wrap">
                <img class="img good__img" src="/content/index/img/contacts/shop_autobagaz_front.jpg" alt="autobagaz">
                <img class="img good__img" src="/content/index/img/contacts/shop_autobagaz_back.jpg" alt="autobagaz">
                <img class="img good__img" src="/content/index/img/contacts/logo_circle.jpg" alt="autobagaz">
            </div>
            <div><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=dPv1vaWzXDrNMJs9tlKwl_50qOYIqktt&amp;width=100%&amp;height=250&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script></div>
            <div class="contacts__inn">
                <p class="text">Индивидуальный предприниматель: Зарубин Денис Юрьевич</p>
                <p class="text">ИНН 590850700022 ОГРНИП 316595800158377</p>
                <p class="text">р/с 40802810149770015620 в Пермском отделении №6984 ПАО Сбербанк России</p>
                <p class="text">БИК 045773603 к/с № 30101810900000000603</p>
                <p class="text">Свидетельство о регистрации 59 004723382 от 17.11.2016</p>
            </div><?php
        } elseif ($page == 'podbor') {
            echo "<title> $titleconst"; echo $keywords[7][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[7][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[7][keywords]; echo "'/>"; ?>

            <h1 class="title title-h1">Как подобрать бокс на крышу автомобиля?</h1>
            <p class="text">Подобрать багажный автомобильный бокс не трудно! Главное это определить для себя приоритетные задачи, которые он будет выполнять. Ну, и конечно же, чтобы бокс, который вы выбрали, вам нравился!</p>
            <p class="text">Итак, первое - определитесь, что вы хотите перевозить - кучу вещей, сноуборд или лыжи, палатку или надувную лодку. При подборе бокса на крышу автомобиля необходимо помнить, что внутренние размеры у него меньше на 5-7см, чем указанные наружные. Это необходимо учитывать, например, при перевозке лыж или сноубордов – бокс должен как минимум на 6см быть длиннее.</p>   <p class="speech speech__left">Какие должны быть размеры бокса?</p>
            <p class="speech speech__right">Далее определяемся с размерами бокса. Можно отталкиваться от габаритов вашего автомобиля. Хотя, честно скажу, во многих случаях это не имеет никакого значения, на крышу большого автомобиля можно установить маленький бокс , а на маленький автомобиль можно установить большой бокс. Все дело только в эстетическом виде - кому-то нравится, а кому-то нет. Определяющим здесь может стать угол открытия вверх пятой двери у автомобилей с кузовами типа универсал или хетчбек. Нависание автобокса над лобовым стеклом на 20-30см с водительского места никак не ощущается. Из этого всего можно вывести основные рекомендации по установке бокса: для автомобилей с пятой дверью (если она открывается наверх) крайними точками будут: 1) открытая вверх до конца дверь; 2) кромка лобового стекла + 30см; для всех прочих авто определяющими критериями будут габариты багажа и эстетика внешнего вида.</p>
            <p class="speech speech__left">Как определиться с цветом бокса?</p>
            <p class="speech speech__right">Багажные боксы производятся в универсальной цветовой гамме: чёрные, серые или белые. Они могут быть матовые, либо глянцевые. Эти цвета настолько универсальны, что подойдут автомобилю любой расцветки. В крайнем случае, если вы хотите чего-то более экстравагантного, то всегда можно его перекрасить или приукрасить аэрографией.</p>
            <p class="speech speech__left">Как автобокс влияет на расход топлива?</p>
            <p class="speech speech__right">Чем больше габаритные размеры бокса, тем выше сопротивление воздуха при движении. Существуют автобоксы с улучшенной аэродинамикой, такие как Thule Dynamic, Thule Excellence, Hapro Zenith, Menabo Mania. Но в любом случае порядка 1 литра топлива на сотню к расходу надо будет добавить.<br><br>Удобство установки зависит от того, как бокс крепится к поперечинам базового багажника. Возможны разные варианты крепления: простейший - четырьмя скобами с 8-ю «барашками», на установку уйдет минут 15 и необходим помощник, который будет держать скобу, пока вы её прикручиваете; скобы с системой зажима Easy-Fit фирмы Hapro, на установку уйдет минут 5-7 и нужен помощник, удерживающий скобу, пока вы её затягиваете; «клешни» c системой затяжки Dual Force фирмы Thule, позволяющей зафиксировать бокс за 2-3 минуты, сделать это можно одному, без посторонней помощи.</p>
            <p class="speech speech__left">Какие бывают системы открывания крышек автобоксов?</p>
            <p class="speech speech__right">Таковых бывает три типа: открывание бокса сзади, сбоку и с обеих сторон. Сразу скажу, что двухстороннее открытие даёт преимущество при установке автобокса – не надо тянуться к дальним точкам фиксации обтирая пыльный автомобиль (в случае, если крыша высокая, бывает, что без стремянки не обойтись) и при распределении багажа внутри бокса + возможность достать его с любой стороны.</p>
            <p class="speech speech__left">Как выбрать бокс из наиболее качественного пластика?</p>
            <p class="speech speech__right">Качество пластика определяется устойчивостью к ультрафиолетовым лучам, ударопрочностью, отсутствием запаха. Имейте ввиду, что толстый пластик – это не всегда хорошо. Новейшие технологии производства позволяют использовать тонкий , эластичный и прочный пластик ABS , который даёт все выше перечисленные преимущества и в добавок он меньше весит. Из такого пластика делают свои багажные боксы все серьёзные производители.</p>
            <p class="speech speech__left">А как мне выбрать наиболее лучшего производителя?</p>
            <p class="speech speech__right">Чем известней бренд, тем выше качество и комфорт в эксплуатации. Такими брендами являются известные всем фирмы, такие как: Thule - Швеция (флагман в мире багажников для автомобилей), Mont Blanc – Швеция, Hapro – Голландия. И менее известные: Menabo – Италия, Farad – Италия. <br><br>Так же существуют китайские производители боксов, которые внешне копируют знаменитые бренды, но не всегда их качество соответствует необходимым параметрам. Замечу, что и у китайских производителей, есть достойные представители жанра, такие как, например, Nord.</p>
            <p class="speech speech__left">И все-таки, как мне выбрать такой бокс, чтобы он был совместим с моим багажником (поперечинами)?</p>
            <p class="speech speech__right">При выборе бокса на крышу уточняйте, насколько он будет совместим с перекладинами базового багажника. Перекладины бывают трёх видов:<br><br>Прямоугольные – на них устанавливаются все виды автобоксов с различными типами креплений.<br><br>Овальные аэродинамические – на них устанавливается 85% багажных боксов со своими креплениями. Для оставшихся 15% необходимо будет приобрести дополнительные переходники в Т-образный профиль.<br><br>Крыло (Thule WingBar и Yakima Whispbar) - на них устанавливается 65% боксов на крышу, для остальных приобретаются переходники. Смею заметить, что такой профиль является третьим поколением багажников на крышу и представляет собой полностью бесшумный профиль, он наиболее комфортен, его преимущество в том, что вам нет необходимости снимать его с автомобиля. И ко всему он придает вашему средству передвижения эстетический вид.</p>
            <?php
        } ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."backend/blocks/counters.html"); ?>


