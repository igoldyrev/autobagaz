<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");

include ($_SERVER["DOCUMENT_ROOT"]."/arrays/autobox_array.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php");?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html");?>
        <div class="content">
            <?php
            $autobox = $_GET['autobox'];
            if (!isset($autobox)) {
            echo "<title> $titleconst"; echo $keywords[8][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[8][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[8][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Автомобильные боксы</h1>";
            echo "<p class='page__text'>Каким бы просторным ни был автомобиль, порой места в нем начинает не хватать. Поездка за город или возвращение из похода по магазинам превращается в акробатический номер с грузом на коленях и плотно упакованными пассажирами на задних сиденьях. А перевозка лыж или сноубордов вообще является ночным кошмаром автомобилиста. Добавить столь необходимый рабочий объем вашей машине могут автомобильные боксы.</p>";
            echo "<p class='page__text'>Автобоксы являются простым и надежным средством увеличения вместительности автомобиля, и абсолютно незаменимы при возникновении необходимости перевозки грузов, требующих бережного обращения и надежной защиты от влаги, пыли и прочих негативных факторов окружающей среды. Изготовленные из современных высококачественных материалов, автомобильные боксы сочетают в себе высокую надежность крепления, оптимальные условия фиксации груза и необычайную легкость базовой конструкции, а система центрального замка с двухсторонним открыванием и многоточечным запиранием гарантирует безопасную эксплуатацию и высокую защиту от несанкционированного проникновения в бокс.</p>";
            echo "<h2 class='page__title-h2'>Варианты автобоксов</h2>"; ?>
            <div class="catalog">
                 <div class="catalog__item">
                    <a href="/autobox/vetlan" class="catalog__item-link"></a>
                    <div class="item__image">
                        <a href="/autobox/vetlan"><img class="item__image-img" src="/images/logos/vetlan.png" alt="vetlan"></a>
                    </div>
                    <div class="item__link">
                        <a href="/autobox/vetlan">Автобоксы Ветлан (Пермь)</a>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/autobox/atlant" class="catalog__item-link"></a>
                    <div class="item__image">
                        <a href="/autobox/atlant"><img class="item__image-img" src="/images/logos/atlant.png" alt="atlant"></a>
                    </div>
                    <div class="item__link">
                        <a href="/autobox/atlant">Автобоксы Атлант</a>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/autobox/yuago" class="catalog__item-link"></a>
                    <div class="item__image">
                        <a href="/autobox/yuago"><img class="item__image-img" src="/images/logos/yuago.png" alt="yuago"></a>
                    </div>
                    <div class="item__link">
                        <a href="/autobox/yuago">Автобоксы Yuago</a>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="/autobox/turino" class="catalog__item-link"></a>
                    <div class="item__image">
                        <a href="/autobox/turino"><img class="item__image-img" src="/images/logos/turino.jpg" alt="turino"></a>
                    </div>
                    <div class="item__link">
                        <a href="/autobox/turino">Автобоксы Турино</a>
                    </div>
                </div>
                <div class="catalog__item">
                        <a href="/autobox/lux" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/autobox/lux"><img class="item__image-img" src="/images/logos/lux.png" alt="lux"></a>
                        </div>
                        <div class="item__link">
                            <a href="/autobox/lux">Автобоксы Lux, Россия</a>
                        </div>
                </div>
                <div class="catalog__item">
                    <a href="/inno/inno-boxes" class="catalog__item-link"></a>
                    <div class="item__image">
                        <a href="/inno/inno-boxes"><img class="item__image-img" src="/images/logos/inno.jpg" alt="Inno"></a>
                    </div>
                    <div class="item__link">
                        <a href="/inno/inno-boxes">Автобоксы Inno</a>
                    </div>
                </div>
            </div>
        <?php }
        elseif ($autobox == 'yuago') {
	echo "<title> $titleconst"; echo $keywords[13][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[13][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[13][keywords]; echo "'/>";

	$_SESSION['yuago'] = $yuago;
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];

	echo "<h1 class='page__title-h1'>"; echo $yuago[name]; echo "</h1>";
	echo "<p class='page__text'>Лучший выбор для лыжника! При длине бокса в 2180см перевозка лыж и сноубордов теперь становится легкой задачей, больше Вам не придется складывать сиденья, пачкать и царапать салон автомобиля.</p>";
	echo "<p class='page__text'>Автобокс Cosmo изготовлен из АБС-пластика. Материал автобокса устойчив к большинству видов химических реагентов: кислотам, щелочам и жирам. Важным фактором при ежедневной эксплуатации является повышенная жесткостью конструкции и устойчивость поверхности к царапинам.</p>"; ?>
    <div class="table">
        <div class="table__column"></div>
        <ul class="table__header">
            <li class="table__cell">Характеристики</li>
            <li class="table__cell">Значение</li>
        </ul>
        <ul class="table__row">
            <li class="table__cell">Габариты</li>
            <li class="table__cell"><?php echo $yuago[size]; ?></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell">Объем</li>
            <li class="table__cell"><?php echo $yuago[volume]; ?></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell">Материал</li>
            <li class="table__cell"><?php echo $yuago[material]; ?></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell">Цвета</li>
            <li class="table__cell"><?php echo $yuago[color]; ?></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell">Замок</li>
            <li class="table__cell"><?php echo $yuago[lock]; ?></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell">Погрузка багажа</li>
            <li class="table__cell"><?php echo $yuago[bagazh]; ?></li>
        </ul>
    </div>
	<div class="img_div"> <?php
	echo $yuago[img1]; ?>
	</div>
	<div class="good__price">
		<div class="good__price-info">
	<?php echo "<p class='page__text'><strong>Цена "; echo $yuago[price]; echo "</strong></p>";	?>
		</div>
		<div class="good__price-button">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $yuago['id']; ?>" class="button button__buy" >Заказать</a>
		</div>
	</div> <?php
	include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
} elseif ($autobox == 'turino') {
	echo "<title> $titleconst"; echo $keywords[14][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[14][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[14][keywords]; echo "'/>";

	$_SESSION['turino'] = $turino;
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];

	echo "<h1 class='page__title-h1'>"; echo $turino[name]; echo "</h1>";
	echo "<p class='page__text'>"; echo $turino[desc1]; echo "</p>";
	echo "<p class='page__text'>"; echo $turino[desc2]; echo "</p>"; ?>
	<div class="img_div"> <?php
	echo $turino[img1]; echo $turino[img2]; echo $turino[img3]; echo $turino[img4]; echo $turino[img5]; echo $turino[img6]; ?>
	</div>
	<div class="good__price">
		<div class="good__price-info">
            <p class="page__text">Цена <strong><?php echo $turino[price]; ?></strong>(матовый/глянцевый)</p>
		</div>
		<div class="good__price-button">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $turino['id']; ?>" class="button button__buy" >Заказать</a>
		</div>
	</div> <?php
	include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
} elseif ($autobox == 'lux') {
	echo "<title> $titleconst"; echo $keywords[15][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[15][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[15][keywords]; echo "'/>";

	$_SESSION['lux'] = $lux;
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];

	echo "<h1 class='page__title-h1'>Lux, Россия</h1>";
	echo "<p class='page__text'>Боксы на крышу LUX произведены в России, из высококачественного российского АБС пластика , с применением фурнитуры, разработанной, специально для наших суровых условий эксплуатации.</p>";
	echo "<p class='page__text'>Впервые в России, в багажных боксах использована система центрального замка с двухсторонним открыванием и многоточечным запиранием, полностью отечественного производства.</p>";
	echo "<p class='page__text'>Крепления бокса к багажнику, отличаются простотой, удобством и высочайшей надёжностью. Массивные крепёжные скобы, с внутренней шириной 82 мм, позволяют закрепить бокс LUX на поперечинах всех европейских производителей багажных систем.</p>";
	echo "<p class='page__text'>Грузоподъёмность боксов Люкс соответствует европейскому стандарту, и составляет 50 кг распределенного груза.</p>"; ?>
	<div class="img_div">
		<img class="img_main" src="/images/lux/lux_1.jpg" srcset="/images/lux/lux_1.jpg 300w" alt="Lux, Россия" sizes="(max-width: 2000px) 150px, 300px, 350px">
		<img class="img_main" src="/images/lux/lux_2.jpg" srcset="/images/lux/lux_2.jpg 300w" alt="Lux, Россия" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
    <div class="table table--buttons">
        <ul class="table__header">
            <li class="table__cell">Наименование, характеристики</li>
            <li class="table__cell">Цена</li>
            <li class="table__cell"></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $lux[name1]; ?></li>
            <li class="table__cell table__cell--price"><?php echo $lux[price1]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lux['id1']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $lux[name2]; ?></li>
            <li class="table__cell table__cell--price"><?php echo $lux[price2]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lux['id2']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $lux[name3]; ?></li>
            <li class="table__cell table__cell--price"><?php echo $lux[price3]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lux['id3']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $lux[name4]; ?></li>
            <li class="table__cell table__cell--price"><?php echo $lux[price4]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lux['id4']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $lux[name5]; ?></li>
            <li class="table__cell table__cell--price"><?php echo $lux[price5]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lux['id5']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $lux[name6]; ?></li>
            <li class="table__cell table__cell--price"><?php echo $lux[price6]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lux['id6']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
    </div>
	<?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
} elseif ($autobox == 'atlant') {
	echo "<title> $titleconst"; echo $keywords[10][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[10][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[10][keywords]; echo "'/>";

	$_SESSION['discoveryclassic'] = $discoveryclassic;
	$_SESSION['discoverysport'] = $discoverysport;
	$_SESSION['dynamic'] = $dynamic;
	$_SESSION['airtek'] = $airtek;
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];

	echo "<h1 class='page__title-h1'>Автобоксы Атлант</h1>";
	echo "<p class='page__text'>Производитель: ООО «Атлант»,Россия, Спб<br>Производство: совместное Италия-Спб</p>";
	echo "<p class='page__text'>Давно зарекомендовавшая себя на рынке автобагажников в России компания Атлант представляет широкий спектр выбора боксов для вашего автомобиля по вашим потребностям!</p>";
	echo "<h2 class='page__title-h2'>Серия DISCOVERY, открывание одностороннее</h2>"; ?>
	<div class="img_div">
		<img class="img_main" src="/images/discovery/discovery_1.jpg"  srcset="/images/discovery/discovery_1.jpg 150w" alt="discovery" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
    <div class="table table--buttons">
        <ul class="table__row">
            <li class="table__cell"><?php echo $discoveryclassic[name1]; ?></li>
            <li class="table__cell"><?php echo $discoveryclassic[price1]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $discoveryclassic['id1']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $discoveryclassic[name2]; ?></li>
            <li class="table__cell"><?php echo $discoveryclassic[price2]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $discoveryclassic['id2']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $discoveryclassic[name3]; ?></li>
            <li class="table__cell"><?php echo $discoveryclassic[price3]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $discoveryclassic['id3']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
    </div>
	<div class="img_div">
		<img class="img_main" src="/images/discovery/discovery_2.jpg"  srcset="/images/discovery/discovery_2.jpg 150w" alt="discovery" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
    <div class="table table--buttons">
        <ul class="table__row">
            <li class="table__cell"><?php echo $discoverysport[name1]; ?></li>
            <li class="table__cell"><?php echo $discoverysport[price1]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $discoverysport['id1']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $discoverysport[name2]; ?></li>
            <li class="table__cell"><?php echo $discoverysport[price2]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $discoverysport['id2']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
    </div><?php
	echo "<h2 class='page__title-h2'>Серия Атлант, двухстороннее открывание, цвет металлик</h2>"; ?>
	<div class="img_div">
		<img class="img_main" src="/images/atlant/atlant_1.jpg"  srcset="/images/atlant/atlant_1.jpg 150w" alt="atlant" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
    <div class="table table--buttons">
        <ul class="table__row">
            <li class="table__cell"><?php echo $dynamic[name1]; ?></li>
            <li class="table__cell"><?php echo $dynamic[price1]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $dynamic['id1']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $dynamic[name2]; ?></li>
            <li class="table__cell"><?php echo $dynamic[price2]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $dynamic['id2']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
    </div>
	<div class="img_div">
		<img class="img_main" src="/images/atlant/atlant_2.jpg"  srcset="/images/atlant/atlant_2.jpg 140w" alt="atlant" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div>
    <div class="table table--buttons">
        <ul class="table__row">
            <li class="table__cell"><?php echo $airtek[name1]; ?></li>
            <li class="table__cell"><?php echo $airtek[price1]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $airtek['id1']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
        <ul class="table__row">
            <li class="table__cell"><?php echo $airtek[name2]; ?></li>
            <li class="table__cell"><?php echo $airtek[price2]; ?></li>
            <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $airtek['id2']; ?>" class="button button__buy button--cell" >Заказать</a></li>
        </ul>
    </div><?php
	include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
} elseif ($autobox == 'vetlan') {
                echo "<title> $titleconst"; echo $keywords[9][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[9][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[9][keywords]; echo "'/>";

                $_SESSION['vetlan'] = $vetlan;
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                echo "<h1 class='page__title-h1'>Автомобильные боксы Vetlan (Пермь)</h1>";
                echo "<p class='page__text'>Автобоксы «VetlaN» рассчитаны на эксплуатацию в условиях, где жаркое лето сменяет холодная зима. Эти боксы, надежные настолько, насколько требует эксплуатация подобного устройства на наших неровных дорогах. Это – ваша безопасность и спокойствие во время длительных путешествий.</p>";
                echo "<p class='page__text'>Автобоксы изготовлены из качественного пластика – АБС (акрилонитрилбутадиенстирол). Материал отличается повышенной стойкостью к воздействию агрессивных веществ и не меняет цвета со временем. Эти автобагажники на крышу сделаны из пластика, которые выдержат практически любые дорожные нагрузки, сильный ветер и любую непогоду, включая дождь, град и снег. Автобоксы «VetlaN» обладают отличной аэродинамикой.</p>";
                echo "<p class='page__text'>С боксом «VetlaN» Вы забудете о нехватке места в багажнике вашего авто. Теперь собираясь в дальнюю поездку у Вас не будет болеть голова о том, куда складывать детские игрушки, матрасы и подушки, все для пикника и т.п. «VetlaN» - это лучший выбор.</p>"; ?>

               <div class="good"> <?php
                    echo "<h2 class='good__name'>"; echo $vetlan[0]['title']; echo "</h2>"; ?>
                    <div class="img_div">
                        <?php echo $vetlan[0]['img1']; echo $vetlan[0]['img2']; echo $vetlan[0]['img3']; echo $vetlan[0]['img4']; ?>
                    </div>
                   <div class="table">
                       <div class="table__column"></div>
                       <ul class="table__header">
                           <li class="table__cell">Характеристики</li>
                           <li class="table__cell">Значение</li>
                       </ul>
                       <ul class="table__row">
                           <li class="table__cell">Размер</li>
                           <li class="table__cell"><?php echo $vetlan[0]['size']; ?></li>
                       </ul>
                       <ul class="table__row">
                           <li class="table__cell">Литраж</li>
                           <li class="table__cell"><?php echo $vetlan[0]['volume']; ?></li>
                       </ul>
                       <ul class="table__row">
                           <li class="table__cell">Материал</li>
                           <li class="table__cell"><?php echo $vetlan[0]['material']; ?></li>
                       </ul>
                       <ul class="table__row">
                           <li class="table__cell">Крепление</li>
                           <li class="table__cell"><?php echo $vetlan[0]['clamp']; ?></li>
                       </ul>
                       <ul class="table__row">
                           <li class="table__cell">Замок</li>
                           <li class="table__cell"><?php echo $vetlan[0]['lock']; ?></li>
                       </ul>
                       <ul class="table__row">
                           <li class="table__cell">Варианты цветов</li>
                           <li class="table__cell"><?php echo $vetlan[0]['color']; ?></li>
                       </ul>
                   </div>
                    <div class="good__description"> <?php
                        echo "<p class='page__text'>"; echo $vetlan[0]['desc1']; echo "</p>";
                        echo "<p class='page__text'>"; echo $vetlan[0]['desc2']; echo "</p>"; ?></div>
                    <div class="good__price">
                        <div class="good__price-info">
                            <p class="page__text"><?php echo "Черный: <strong>"; echo $vetlan[0]['price_black']; ?></strong></p>
                        </div>
                        <div class="good__price-button">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $vetlan[0]['id1']; ?>" class="button button__buy" >Заказать</a>
                            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $vetlan[0]['id1']; ?>" class="button button__buy button__buy--prokat" >Взять в прокат</a>
                        </div>
                    </div>
                   <div class="good__price">
                       <div class="good__price-info">
                           <p class="page__text"><?php echo "Серый: <strong>"; echo $vetlan[0]['price_gray']; ?></strong></p>
                       </div>
                       <div class="good__price-button">
                           <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $vetlan[0]['id2']; ?>" class="button button__buy" >Заказать</a>
                           <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $vetlan[0]['id2']; ?>" class="button button__buy button__buy--prokat" >Взять в прокат</a>
                       </div>
                   </div>
                   <div class="good__price">
                       <div class="good__price-info">
                           <p class="page__text"><?php echo "Белый: <strong>"; echo $vetlan[0]['price_white']; ?></strong></p>
                       </div>
                       <div class="good__price-button">
                           <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $vetlan[0]['id3']; ?>" class="button button__buy" >Заказать</a>
                           <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $vetlan[0]['id3']; ?>" class="button button__buy button__buy--prokat" >Взять в прокат</a>
                       </div>
                   </div>
               </div>
                <div class="good"> <?php
                    echo "<h2 class='good__name'>"; echo $vetlan[1]['title']; echo "</h2>"; ?>
                    <div class="img_div">
                        <?php echo $vetlan[1]['img1']; echo $vetlan[1]['img2']; echo $vetlan[1]['img3']; echo $vetlan[1]['img4']; ?>
                    </div>
                    <div class="table">
                        <div class="table__column"></div>
                        <ul class="table__header">
                            <li class="table__cell">Характеристики</li>
                            <li class="table__cell">Значение</li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Размер</li>
                            <li class="table__cell"><?php echo $vetlan[1]['size']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Литраж</li>
                            <li class="table__cell"><?php echo $vetlan[1]['volume']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Материал</li>
                            <li class="table__cell"><?php echo $vetlan[1]['material']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Крепление</li>
                            <li class="table__cell"><?php echo $vetlan[1]['clamp']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Замок</li>
                            <li class="table__cell"><?php echo $vetlan[1]['lock']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Варианты цветов</li>
                            <li class="table__cell"><?php echo $vetlan[1]['color']; ?></li>
                        </ul>
                    </div>
                    <div class="good__description"> <?php
                        echo "<p class='page__text'>"; echo $vetlan[1]['desc1']; echo "</p>";
                        echo "<p class='page__text'>"; echo $vetlan[1]['desc2']; echo "</p>"; ?></div>
                    <div class="good__price">
                        <div class="good__price-info">
                            <p class="page__text"><?php echo "Черный: <strong>"; echo $vetlan[1]['price_black']; ?></strong></p>
                        </div>
                        <div class="good__price-button">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $vetlan[1]['id1']; ?>" class="button button__buy" >Заказать</a>
                            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $vetlan[1]['id1']; ?>" class="button button__buy button__buy--prokat" >Взять в прокат</a>
                        </div>
                    </div>
                    <div class="good__price">
                        <div class="good__price-info">
                            <p class="page__text"><?php echo "Серый: <strong>"; echo $vetlan[1]['price_gray']; ?></strong></p>
                        </div>
                        <div class="good__price-button">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $vetlan[1]['id2']; ?>" class="button button__buy" >Заказать</a>
                            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $vetlan[1]['id2']; ?>" class="button button__buy button__buy--prokat" >Взять в прокат</a>
                        </div>
                    </div>
                    <div class="good__price">
                        <div class="good__price-info">
                            <p class="page__text"><?php echo "Белый: <strong>"; echo $vetlan[1]['price_white']; ?></strong></p>
                        </div>
                        <div class="good__price-button">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $vetlan[1]['id3']; ?>" class="button button__buy" >Заказать</a>
                            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $vetlan[1]['id3']; ?>" class="button button__buy button__buy--prokat" >Взять в прокат</a>
                        </div>
                    </div>
                </div>

                <div class="good"> <?php
                    echo "<h2 class='good__name'>"; echo $vetlan[2]['title']; echo "</h2>"; ?>
                    <div class="img_div">
                        <?php echo $vetlan[2]['img1']; echo $vetlan[2]['img2']; echo $vetlan[2]['img3']; echo $vetlan[2]['img4']; ?>
                    </div>
                    <div class="table">
                        <div class="table__column"></div>
                        <ul class="table__header">
                            <li class="table__cell">Характеристики</li>
                            <li class="table__cell">Значение</li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Размер</li>
                            <li class="table__cell"><?php echo $vetlan[2]['size']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Литраж</li>
                            <li class="table__cell"><?php echo $vetlan[2]['volume']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Материал</li>
                            <li class="table__cell"><?php echo $vetlan[2]['material']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Крепление</li>
                            <li class="table__cell"><?php echo $vetlan[2]['clamp']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Замок</li>
                            <li class="table__cell"><?php echo $vetlan[2]['lock']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Варианты цветов</li>
                            <li class="table__cell"><?php echo $vetlan[2]['color']; ?></li>
                        </ul>
                    </div>
                    <div class="good__description"> <?php
                        echo "<p class='page__text'>"; echo $vetlan[2]['desc1']; echo "</p>";
                        echo "<p class='page__text'>"; echo $vetlan[2]['desc2']; echo "</p>"; ?></div>
                    <div class="good__price">
                        <div class="good__price-info">
                            <p class="page__text"><?php echo "Черный: <strong>"; echo $vetlan[2]['price_black']; ?></strong></p>
                        </div>
                        <div class="good__price-button">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $vetlan[2]['id1']; ?>" class="button button__buy" >Заказать</a>
                            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $vetlan[2]['id1']; ?>" class="button button__buy button__buy--prokat" >Взять в прокат</a>
                        </div>
                    </div>
                    <div class="good__price">
                        <div class="good__price-info">
                            <p class="page__text"><?php echo "Серый: <strong>"; echo $vetlan[2]['price_gray']; ?></strong></p>
                        </div>
                        <div class="good__price-button">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $vetlan[2]['id2']; ?>" class="button button__buy" >Заказать</a>
                            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $vetlan[2]['id2']; ?>" class="button button__buy button__buy--prokat" >Взять в прокат</a>
                        </div>
                    </div>
                    <div class="good__price">
                        <div class="good__price-info">
                            <p class="page__text"><?php echo "Белый: <strong>"; echo $vetlan[2]['price_white']; ?></strong></p>
                        </div>
                        <div class="good__price-button">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $vetlan[2]['id3']; ?>" class="button button__buy" >Заказать</a>
                            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $vetlan[2]['id3']; ?>" class="button button__buy button__buy--prokat" >Взять в прокат</a>
                        </div>
                    </div>
                </div> <?php
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } ?>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>