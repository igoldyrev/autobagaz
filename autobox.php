<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatags.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/header.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/proposition/proposition.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation/navigation.html");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/breadcrumbs/breadcrumbs.php");
include($_SERVER["DOCUMENT_ROOT"] . "/content/autobox/backend/keywords.php");

include($_SERVER["DOCUMENT_ROOT"] . "/content/autobox/backend/array.php"); ?>

<div class="wrapper">
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/left-nav/left-nav.html"); ?>
  <div class="wrapper__content">
    <?php
    $autobox = $_GET['autobox'];
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];

    if (!isset($autobox)) {
      echo "<title> $titleconst";
      echo $keywords[0][title];
      echo "</title>";
      echo "<meta name='description' content='";
      echo $keywords[0][description];
      echo "'/>";
      echo "<meta name='keywords' content='";
      echo $keywords[0][keywords];
      echo "'/>";

      echo "<h1 class='title title-h1'>Автомобильные боксы</h1>";
      echo "<p class='text'>Каким бы просторным ни был автомобиль, порой места в нем начинает не хватать. Поездка за город или возвращение из похода по магазинам превращается в акробатический номер с грузом на коленях и плотно упакованными пассажирами на задних сиденьях. А перевозка лыж или сноубордов вообще является ночным кошмаром автомобилиста. Добавить столь необходимый рабочий объем вашей машине могут автомобильные боксы.</p>";
      echo "<p class='text'>Автобоксы являются простым и надежным средством увеличения вместительности автомобиля, и абсолютно незаменимы при возникновении необходимости перевозки грузов, требующих бережного обращения и надежной защиты от влаги, пыли и прочих негативных факторов окружающей среды. Изготовленные из современных высококачественных материалов, автомобильные боксы сочетают в себе высокую надежность крепления, оптимальные условия фиксации груза и необычайную легкость базовой конструкции, а система центрального замка с двухсторонним открыванием и многоточечным запиранием гарантирует безопасную эксплуатацию и высокую защиту от несанкционированного проникновения в бокс.</p>";
      echo "<h2 class='title title-h2'>Варианты автобоксов</h2>"; ?>
      <div class="catalog">
        <div class="catalog__item">
          <a href="/autobox/vetlan" class="catalog__item-link"></a>
          <div class="catalog__image-wrap">
            <img class="catalog__image" src="/content/autobox/img/logo/vetlan.png" alt="vetlan">
          </div>
          <div class="catalog__text">
            <p class="text">Автобоксы Ветлан (Пермь)</p>
          </div>
        </div>
        <div class="catalog__item">
          <a href="/autobox/atlant" class="catalog__item-link"></a>
          <div class="catalog__image-wrap">
            <img class="catalog__image" src="/content/autobox/img/logo/atlant.png" alt="atlant">
          </div>
          <div class="catalog__text">
            <p class="text">Автобоксы Атлант</p>
          </div>
        </div>
        <div class="catalog__item">
          <a href="/autobox/yuago" class="catalog__item-link"></a>
          <div class="catalog__image-wrap">
            <img class="catalog__image" src="/content/autobox/img/logo/yuago.png" alt="yuago">
          </div>
          <div class="catalog__text">
            <p class="text">Автобоксы Yuago</p>
          </div>
        </div>
        <div class="catalog__item">
          <a href="/autobox/turino" class="catalog__item-link"></a>
          <div class="catalog__image-wrap">
            <img class="catalog__image" src="/content/autobox/img/logo/turino.jpg" alt="turino">
          </div>
          <div class="catalog__text">
            <p class="text">Автобоксы Турино</p>
          </div>
        </div>
        <div class="catalog__item">
          <a href="/autobox/lux" class="catalog__item-link"></a>
          <div class="catalog__image-wrap">
            <img class="catalog__image" src="/content/autobox/img/logo/lux.png" alt="lux">
          </div>
          <div class="catalog__text">
            <p class="text">Автобоксы Lux, Россия</p>
          </div>
        </div>
        <div class="catalog__item">
          <a href="/autobox/inmax" class="catalog__item-link"></a>
          <div class="catalog__image-wrap">
            <img class="catalog__image" src="/content/autobox/img/logo/inmax.png" alt="lux">
          </div>
          <div class="catalog__text">
            <p class="text">Автомобильные боксы INMAX</p>
          </div>
        </div>
        <div class="catalog__item">
          <a href="/inno/inno-boxes" class="catalog__item-link"></a>
          <div class="catalog__image-wrap">
            <img class="catalog__image" src="/content/autobox/img/logo/inno.jpg" alt="Inno">
          </div>
          <div class="catalog__text">
            <p class="text">Автобоксы Inno</p>
          </div>
        </div>
      </div>
    <?php } elseif ($autobox == 'yuago') {
      echo "<title> $titleconst";
      echo $keywords[3][title];
      echo "</title>";
      echo "<meta name='description' content='";
      echo $keywords[3][description];
      echo "'/>";
      echo "<meta name='keywords' content='";
      echo $keywords[3][keywords];
      echo "'/>";

      $_SESSION['yuago'] = $yuago;
      $_SESSION['url'] = $_SERVER['REQUEST_URI'];

      echo "<h1 class='title title-h1'>";
      echo $yuago[name];
      echo "</h1>";
      echo "<p class='text'>Лучший выбор для лыжника! При длине бокса в 2180см перевозка лыж и сноубордов теперь становится легкой задачей, больше Вам не придется складывать сиденья, пачкать и царапать салон автомобиля.</p>";
      echo "<p class='text'>Автобокс Cosmo изготовлен из АБС-пластика. Материал автобокса устойчив к большинству видов химических реагентов: кислотам, щелочам и жирам. Важным фактором при ежедневной эксплуатации является повышенная жесткостью конструкции и устойчивость поверхности к царапинам.</p>"; ?>
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
      <div class="img__wrap"> <?php
        echo $yuago[img1]; ?>
      </div>
      <div class="good__price">
        <div class="good__price-info">
          <?php echo "<p class='text' echo $stylepriceautobox><strong>Цена ";
          echo $yuago[price];
          echo "</strong></p>"; ?>
        </div>
        <div class="good__buttons">
          <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $yuago['id']; ?>"
             class="button button__buy">Заказать</a>
        </div>
      </div> <?php
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } elseif ($autobox == 'turino') {
      echo "<title> $titleconst";
      echo $keywords[4][title];
      echo "</title>";
      echo "<meta name='description' content='";
      echo $keywords[4][description];
      echo "'/>";
      echo "<meta name='keywords' content='";
      echo $keywords[4][keywords];
      echo "'/>";

      $_SESSION['turino'] = $turino;
      $_SESSION['url'] = $_SERVER['REQUEST_URI'];

      echo "<h1 class='title title-h1'>";
      echo $turino[name];
      echo "</h1>";
      echo "<p class='text'>";
      echo $turino[desc1];
      echo "</p>";
      echo "<p class='text'>";
      echo $turino[desc2];
      echo "</p>"; ?>
      <div class="img__wrap"> <?php
        echo $turino[img1];
        echo $turino[img2];
        echo $turino[img3];
        echo $turino[img4];
        echo $turino[img5];
        echo $turino[img6]; ?>
      </div>
      <div class="good__price">
        <div class="good__price-info">
          <p class="text" <?php echo $stylepriceautobox ?>>Цена <strong><?php echo $turino[price]; ?></strong>(матовый/глянцевый)
          </p>
        </div>
        <div class="good__buttons">
          <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $turino['id']; ?>"
             class="button button__buy">Заказать</a>
        </div>
      </div> <?php
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } elseif ($autobox == 'lux') {
      echo "<title> $titleconst";
      echo $keywords[5][title];
      echo "</title>";
      echo "<meta name='description' content='";
      echo $keywords[5][description];
      echo "'/>";
      echo "<meta name='keywords' content='";
      echo $keywords[5][keywords];
      echo "'/>";

      $_SESSION['lux'] = $lux;
      $_SESSION['url'] = $_SERVER['REQUEST_URI'];

      echo "<h1 class='title title-h1'>Lux, Россия</h1>";
      echo "<p class='text'>Боксы на крышу LUX произведены в России, из высококачественного российского АБС пластика , с применением фурнитуры, разработанной, специально для наших суровых условий эксплуатации.</p>";
      echo "<p class='text'>Впервые в России, в багажных боксах использована система центрального замка с двухсторонним открыванием и многоточечным запиранием, полностью отечественного производства.</p>";
      echo "<p class='text'>Крепления бокса к багажнику, отличаются простотой, удобством и высочайшей надёжностью. Массивные крепёжные скобы, с внутренней шириной 82 мм, позволяют закрепить бокс LUX на поперечинах всех европейских производителей багажных систем.</p>";
      echo "<p class='text'>Грузоподъёмность боксов Люкс соответствует европейскому стандарту, и составляет 50 кг распределенного груза.</p>"; ?>
      <div class="img__wrap">
        <img class="img good__img" src="/content/autobox/img/lux/lux_1.jpg" alt="Lux, Россия">
        <img class="img good__img" src="/content/autobox/img/lux/lux_2.jpg" alt="Lux, Россия">
      </div>
      <div class="table table--buttons">
        <ul class="table__header">
          <li class="table__cell">Наименование, характеристики</li>
          <li class="table__cell"<?php echo $stylepriceautobox ?>>Цена</li>
          <li class="table__cell"></li>
        </ul>
        <ul class="table__row">
          <li class="table__cell"><?php echo $lux[name1]; ?></li>
          <li class="table__cell table__cell--price" <?php echo $stylepriceautobox ?>><?php echo $lux[price1]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $lux['id1']; ?>" class="button button__buy button--cell">Заказать</a>
          </li>
        </ul>
        <ul class="table__row">
          <li class="table__cell"><?php echo $lux[name2]; ?></li>
          <li class="table__cell table__cell--price"<?php echo $stylepriceautobox ?>><?php echo $lux[price2]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $lux['id2']; ?>" class="button button__buy button--cell">Заказать</a>
          </li>
        </ul>
        <ul class="table__row">
          <li class="table__cell"><?php echo $lux[name3]; ?></li>
          <li class="table__cell table__cell--price"<?php echo $stylepriceautobox ?>><?php echo $lux[price3]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $lux['id3']; ?>" class="button button__buy button--cell">Заказать</a>
          </li>
        </ul>
        <ul class="table__row">
          <li class="table__cell"><?php echo $lux[name4]; ?></li>
          <li class="table__cell table__cell--price"<?php echo $stylepriceautobox ?>><?php echo $lux[price4]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $lux['id4']; ?>" class="button button__buy button--cell">Заказать</a>
          </li>
        </ul>
        <ul class="table__row">
          <li class="table__cell"><?php echo $lux[name5]; ?></li>
          <li class="table__cell table__cell--price"<?php echo $stylepriceautobox ?>><?php echo $lux[price5]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $lux['id5']; ?>" class="button button__buy button--cell">Заказать</a>
          </li>
        </ul>
        <ul class="table__row">
          <li class="table__cell"><?php echo $lux[name6]; ?></li>
          <li class="table__cell table__cell--price"<?php echo $stylepriceautobox ?>><?php echo $lux[price6]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $lux['id6']; ?>" class="button button__buy button--cell">Заказать</a>
          </li>
        </ul>
      </div>
      <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } elseif ($autobox == 'atlant') {
      echo "<title> $titleconst";
      echo $keywords[2][title];
      echo "</title>";
      echo "<meta name='description' content='";
      echo $keywords[2][description];
      echo "'/>";
      echo "<meta name='keywords' content='";
      echo $keywords[2][keywords];
      echo "'/>";

      $_SESSION['discoveryclassic'] = $discoveryclassic;
      $_SESSION['discoverysport'] = $discoverysport;
      $_SESSION['dynamic'] = $dynamic;
      $_SESSION['airtek'] = $airtek;
      $_SESSION['url'] = $_SERVER['REQUEST_URI'];

      echo "<h1 class='title title-h1'>Автобоксы Атлант</h1>";
      echo "<p class='text'>Производитель: ООО «Атлант»,Россия, Спб<br>Производство: совместное Италия-Спб</p>";
      echo "<p class='text'>Давно зарекомендовавшая себя на рынке автобагажников в России компания Атлант представляет широкий спектр выбора боксов для вашего автомобиля по вашим потребностям!</p>";
      echo "<h2 class='title title-h2'>Серия DISCOVERY, открывание одностороннее</h2>"; ?>
      <div class="img__wrap">
        <img class="img good__img" src="/content/autobox/img/discovery/discovery_1.jpg" alt="discovery">
      </div>
      <div class="table table--buttons">
        <ul class="table__row">
          <li class="table__cell"><?php echo $discoveryclassic[name1]; ?></li>
          <li class="table__cell"<?php echo $stylepriceautobox ?>><?php echo $discoveryclassic[price1]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $discoveryclassic['id1']; ?>"
                                     class="button button__buy button--cell">Заказать</a></li>
        </ul>
        <ul class="table__row">
          <li class="table__cell"><?php echo $discoveryclassic[name2]; ?></li>
          <li class="table__cell"<?php echo $stylepriceautobox ?>><?php echo $discoveryclassic[price2]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $discoveryclassic['id2']; ?>"
                                     class="button button__buy button--cell">Заказать</a></li>
        </ul>
        <ul class="table__row">
          <li class="table__cell"><?php echo $discoveryclassic[name3]; ?></li>
          <li class="table__cell"<?php echo $stylepriceautobox ?>><?php echo $discoveryclassic[price3]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $discoveryclassic['id3']; ?>"
                                     class="button button__buy button--cell">Заказать</a></li>
        </ul>
      </div>
      <div class="img__wrap">
        <img class="img good__img" src="/content/autobox/img/discovery/discovery_2.jpg" alt="discovery">
      </div>
      <div class="table table--buttons">
      <ul class="table__row">
        <li class="table__cell"><?php echo $discoverysport[name1]; ?></li>
        <li class="table__cell"<?php echo $stylepriceautobox ?>><?php echo $discoverysport[price1]; ?></li>
        <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                   href="/buy/<?php echo $discoverysport['id1']; ?>"
                                   class="button button__buy button--cell">Заказать</a></li>
      </ul>
      <ul class="table__row">
        <li class="table__cell"><?php echo $discoverysport[name2]; ?></li>
        <li class="table__cell"<?php echo $stylepriceautobox ?>><?php echo $discoverysport[price2]; ?></li>
        <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                   href="/buy/<?php echo $discoverysport['id2']; ?>"
                                   class="button button__buy button--cell">Заказать</a></li>
      </ul>
      </div><?php
      echo "<h2 class='title title-h2'>Серия Атлант, двухстороннее открывание, цвет металлик</h2>"; ?>
      <div class="img__wrap">
        <img class="img good__img" src="/content/autobox/img/atlant/atlant_1.jpg" alt="atlant">
      </div>
      <div class="table table--buttons">
        <ul class="table__row">
          <li class="table__cell"><?php echo $dynamic[name1]; ?></li>
          <li class="table__cell"<?php echo $stylepriceautobox ?>><?php echo $dynamic[price1]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $dynamic['id1']; ?>" class="button button__buy button--cell">Заказать</a>
          </li>
        </ul>
        <ul class="table__row">
          <li class="table__cell"><?php echo $dynamic[name2]; ?></li>
          <li class="table__cell"<?php echo $stylepriceautobox ?>><?php echo $dynamic[price2]; ?></li>
          <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                     href="/buy/<?php echo $dynamic['id2']; ?>" class="button button__buy button--cell">Заказать</a>
          </li>
        </ul>
      </div>
      <div class="img__wrap">
        <img class="img good__img" src="/content/autobox/img/atlant/atlant_2.jpg" alt="atlant">
      </div>
      <div class="table table--buttons">
      <ul class="table__row">
        <li class="table__cell"><?php echo $airtek[name1]; ?></li>
        <li class="table__cell"<?php echo $stylepriceautobox ?>><?php echo $airtek[price1]; ?></li>
        <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                   href="/buy/<?php echo $airtek['id1']; ?>" class="button button__buy button--cell">Заказать</a>
        </li>
      </ul>
      <ul class="table__row">
        <li class="table__cell"><?php echo $airtek[name2]; ?></li>
        <li class="table__cell"<?php echo $stylepriceautobox ?>><?php echo $airtek[price2]; ?></li>
        <li class="table__cell"><a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                                   href="/buy/<?php echo $airtek['id2']; ?>" class="button button__buy button--cell">Заказать</a>
        </li>
      </ul>
      </div><?php
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } elseif ($autobox == 'vetlan') {
      echo "<title> $titleconst";
      echo $keywords[1][title];
      echo "</title>";
      echo "<meta name='description' content='";
      echo $keywords[1][description];
      echo "'/>";
      echo "<meta name='keywords' content='";
      echo $keywords[1][keywords];
      echo "'/>";

      $_SESSION['vetlan'] = $vetlan;
      $_SESSION['url'] = $_SERVER['REQUEST_URI'];

      echo "<h1 class='title title-h1'>Автомобильные боксы Vetlan (Пермь)</h1>";
      echo "<p class='text'>Автобоксы «VetlaN» рассчитаны на эксплуатацию в условиях, где жаркое лето сменяет холодная зима. Эти боксы, надежные настолько, насколько требует эксплуатация подобного устройства на наших неровных дорогах. Это – ваша безопасность и спокойствие во время длительных путешествий.</p>";
      echo "<p class='text'>Автобоксы изготовлены из качественного пластика – АБС (акрилонитрилбутадиенстирол). Материал отличается повышенной стойкостью к воздействию агрессивных веществ и не меняет цвета со временем. Эти автобагажники на крышу сделаны из пластика, которые выдержат практически любые дорожные нагрузки, сильный ветер и любую непогоду, включая дождь, град и снег. Автобоксы «VetlaN» обладают отличной аэродинамикой.</p>";
      echo "<p class='text'>С боксом «VetlaN» Вы забудете о нехватке места в багажнике вашего авто. Теперь собираясь в дальнюю поездку у Вас не будет болеть голова о том, куда складывать детские игрушки, матрасы и подушки, все для пикника и т.п. «VetlaN» - это лучший выбор.</p>"; ?>

      <div class="good"> <?php
        echo "<h2 class='title title-h2'>";
        echo $vetlan[0]['title'];
        echo "</h2>"; ?>
        <div class="img__wrap">
          <?php echo $vetlan[0]['img1'];
          echo $vetlan[0]['img2'];
          echo $vetlan[0]['img3'];
          echo $vetlan[0]['img4']; ?>
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
        <?php echo "<p class='text'>";
        echo $vetlan[0]['desc1'];
        echo "</p>";
        echo "<p class='text'>";
        echo $vetlan[0]['desc2'];
        echo "</p>"; ?>
        <div class="good__price">
          <div class="good__price-info">
            <p class="text"<?php echo $stylepriceautobox ?>><?php echo "Черный: <strong>";
              echo $vetlan[0]['price_black']; ?></strong></p>
          </div>
          <div class="good__buttons">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
               href="/buy/<?php echo $vetlan[0]['id1']; ?>" class="button button__buy">Заказать</a>
            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
               href="/prokat/<?php echo $vetlan[0]['id1']; ?>" class="button button__buy button__buy--prokat">Взять в
              прокат</a>
          </div>
        </div>
        <div class="good__price">
          <div class="good__price-info">
            <p class="text"<?php echo $stylepriceautobox ?>><?php echo "Серый: <strong>";
              echo $vetlan[0]['price_gray']; ?></strong></p>
          </div>
          <div class="good__buttons">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
               href="/buy/<?php echo $vetlan[0]['id2']; ?>" class="button button__buy">Заказать</a>
            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
               href="/prokat/<?php echo $vetlan[0]['id2']; ?>" class="button button__buy button__buy--prokat">Взять в
              прокат</a>
          </div>
        </div>
        <div class="good__price">
          <div class="good__price-info">
            <p class="text"<?php echo $stylepriceautobox ?>><?php echo "Белый: <strong>";
              echo $vetlan[0]['price_white']; ?></strong></p>
          </div>
          <div class="good__buttons">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
               href="/buy/<?php echo $vetlan[0]['id3']; ?>" class="button button__buy">Заказать</a>
            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
               href="/prokat/<?php echo $vetlan[0]['id3']; ?>" class="button button__buy button__buy--prokat">Взять в
              прокат</a>
          </div>
        </div>
      </div>
      <div class="good"> <?php
        echo "<h2 class='title title-h2'>";
        echo $vetlan[1]['title'];
        echo "</h2>"; ?>
        <div class="img__wrap">
          <?php echo $vetlan[1]['img1'];
          echo $vetlan[1]['img2'];
          echo $vetlan[1]['img3'];
          echo $vetlan[1]['img4']; ?>
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
        <?php echo "<p class='text'>";
        echo $vetlan[1]['desc1'];
        echo "</p>";
        echo "<p class='text'>";
        echo $vetlan[1]['desc2'];
        echo "</p>"; ?>
        <div class="good__price">
          <div class="good__price-info">
            <p class="text"<?php echo $stylepriceautobox ?>><?php echo "Черный: <strong>";
              echo $vetlan[1]['price_black']; ?></strong></p>
          </div>
          <div class="good__buttons">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
               href="/buy/<?php echo $vetlan[1]['id1']; ?>" class="button button__buy">Заказать</a>
            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
               href="/prokat/<?php echo $vetlan[1]['id1']; ?>" class="button button__buy button__buy--prokat">Взять в
              прокат</a>
          </div>
        </div>
        <div class="good__price">
          <div class="good__price-info">
            <p class="text"<?php echo $stylepriceautobox ?>><?php echo "Серый: <strong>";
              echo $vetlan[1]['price_gray']; ?></strong></p>
          </div>
          <div class="good__buttons">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
               href="/buy/<?php echo $vetlan[1]['id2']; ?>" class="button button__buy">Заказать</a>
            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
               href="/prokat/<?php echo $vetlan[1]['id2']; ?>" class="button button__buy button__buy--prokat">Взять в
              прокат</a>
          </div>
        </div>
        <div class="good__price">
          <div class="good__price-info">
            <p class="text"<?php echo $stylepriceautobox ?>><?php echo "Белый: <strong>";
              echo $vetlan[1]['price_white']; ?></strong></p>
          </div>
          <div class="good__buttons">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
               href="/buy/<?php echo $vetlan[1]['id3']; ?>" class="button button__buy">Заказать</a>
            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
               href="/prokat/<?php echo $vetlan[1]['id3']; ?>" class="button button__buy button__buy--prokat">Взять в
              прокат</a>
          </div>
        </div>
      </div>

      <div class="good"> <?php
        echo "<h2 class='title title-h2'>";
        echo $vetlan[2]['title'];
        echo "</h2>"; ?>
        <div class="img__wrap">
          <?php echo $vetlan[2]['img1'];
          echo $vetlan[2]['img2'];
          echo $vetlan[2]['img3'];
          echo $vetlan[2]['img4']; ?>
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
        <?php echo "<p class='text'>";
        echo $vetlan[2]['desc1'];
        echo "</p>";
        echo "<p class='text'>";
        echo $vetlan[2]['desc2'];
        echo "</p>"; ?>
        <div class="good__price">
          <div class="good__price-info">
            <p class="text"<?php echo $stylepriceautobox ?>><?php echo "Черный: <strong>";
              echo $vetlan[2]['price_black']; ?></strong></p>
          </div>
          <div class="good__buttons">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
               href="/buy/<?php echo $vetlan[2]['id1']; ?>" class="button button__buy">Заказать</a>
            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
               href="/prokat/<?php echo $vetlan[2]['id1']; ?>" class="button button__buy button__buy--prokat">Взять в
              прокат</a>
          </div>
        </div>
        <div class="good__price">
          <div class="good__price-info">
            <p class="text"<?php echo $stylepriceautobox ?>><?php echo "Серый: <strong>";
              echo $vetlan[2]['price_gray']; ?></strong></p>
          </div>
          <div class="good__buttons">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
               href="/buy/<?php echo $vetlan[2]['id2']; ?>" class="button button__buy">Заказать</a>
            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
               href="/prokat/<?php echo $vetlan[2]['id2']; ?>" class="button button__buy button__buy--prokat">Взять в
              прокат</a>
          </div>
        </div>
        <div class="good__price">
          <div class="good__price-info">
            <p class="text"<?php echo $stylepriceautobox ?>><?php echo "Белый: <strong>";
              echo $vetlan[2]['price_white']; ?></strong></p>
          </div>
          <div class="good__buttons">
            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
               href="/buy/<?php echo $vetlan[2]['id3']; ?>" class="button button__buy">Заказать</a>
            <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
               href="/prokat/<?php echo $vetlan[2]['id3']; ?>" class="button button__buy button__buy--prokat">Взять в
              прокат</a>
          </div>
        </div>
      </div> <?php
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } elseif ($autobox == 'inmax') {

      echo "<title> $titleconst";
      echo $keywords[6][title];
      echo "</title>";
      echo "<meta name='description' content='";
      echo $keywords[6][description];
      echo "'/>";
      echo "<meta name='keywords' content='";
      echo $keywords[6][keywords];
      echo "'/>";

      $_SESSION['inmax'] = $inmax;
      $_SESSION['url'] = $_SERVER['REQUEST_URI'];

      echo "<h1 class='title title-h1'>Автомобильные боксы INMAX</h1>";
      echo "<p class='text'>Автомобильный бокс производства российской компании Inmax «Space 460» – оптимальное соотношение качества и цены. </p>"; ?>

      <div class="good"> <?php
      echo "<h2 class='title title-h2'>";
      echo $inmax['name'];
      echo "</h2>"; ?>
      <div class="img__wrap">
        <?php echo $inmax['img1'];
        echo $inmax['img2'];
        echo $inmax['img3'];
        echo $inmax['img4']; ?>
      </div>
      <div class="table">
        <div class="table__column"></div>
        <ul class="table__header">
          <li class="table__cell">Характеристики</li>
          <li class="table__cell">Значение</li>
        </ul>
        <ul class="table__row">
          <li class="table__cell">Длина</li>
          <li class="table__cell"><?php echo $inmax['length']; ?></li>
        </ul>
        <ul class="table__row">
          <li class="table__cell">Ширина</li>
          <li class="table__cell"><?php echo $inmax['width']; ?></li>
        </ul>
        <ul class="table__row">
          <li class="table__cell">Высота</li>
          <li class="table__cell"><?php echo $inmax['height']; ?></li>
        </ul>
        <ul class="table__row">
          <li class="table__cell">Объем</li>
          <li class="table__cell"><?php echo $inmax['volume']; ?></li>
        </ul>
        <ul class="table__row">
          <li class="table__cell">Материал</li>
          <li class="table__cell"><?php echo $inmax['material']; ?></li>
        </ul>
      </div>
      <div class="good__price">
        <div class="good__price-info">
          <p class="text"<?php echo $stylepriceautobox ?>><?php echo "Цена: <strong>";
            echo $inmax['price']; ?></strong></p>
        </div>
        <div class="good__buttons">
          <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $inmax['id']; ?>"
             class="button button__buy">Заказать</a>
          <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
             href="/prokat/<?php echo $inmax['id']; ?>" class="button button__buy button__buy--prokat">Взять в
            прокат</a>
        </div>
      </div>
      </div><?php
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } elseif ($autobox == 'terradrive') {
      echo "<title> $titleconst";
      echo $keywords[7][title];
      echo "</title>";
      echo "<meta name='description' content='";
      echo $keywords[7][description];
      echo "'/>";
      echo "<meta name='keywords' content='";
      echo $keywords[7][keywords];
      echo "'/>";

      $_SESSION['terradrivefour'] = $terradrivefour;
      $_SESSION['terradrivetwo'] = $terradrivetwo;
      $_SESSION['url'] = $_SERVER['REQUEST_URI'];

      echo "<h1 class='title title-h1'>Автомобильные боксы Terra Drive</h1>";
      echo "<p class='text'>Автомобильные боксы TERRA DRIVE — это качественные и недорогие автомобильные багажники.</p>";
      echo "<p class='text'>Прочные, стильные, а также, что немаловажно, добавляют Вашему автомобилю довольно существенное увеличение грузового пространства. Возможностей, которые предоставляет автомобильному путешественнику автобокс для автомобиля, множество. Прикрепив на крышу автомобиля автобокс TERRA DRIVE, у Вас появится возможность значимо увеличить его объем возимого багажа практически в 2 раза. Автомобильные боксы защищают ваш багаж от влаги, грязи и пыли. Надежно запираются на ключ.</p>";
      echo "<p class='text'>Автомобильные автобоксы TERRA DRIVE предназначены для перевозки груза на крыше легкового автомобиля. Они позволяют максимально увеличить полезный объем автомобиля и при этом, обтекаемая форма, которой обладают все автобоксы TERRA DRIVE, отнюдь не делает хуже аэродинамику авто, не приводит к потере скоростных характеристик. Особенно автобоксы актуальны для владельцев небольших автомобилей, любителей путешествий и активного отдыха (лыжи, сноуборды, рыбацкие снасти, ружья и т. д.), молодых родителей (детская коляска), а так же для авто с ГБО.</p>";

      foreach ($terradrivefour as $terrafour): ?>
        <div class="good">
          <h2 class="title title-h2"><?php echo $terrafour['title'] ?></h2>
          <div class="img__wrap">
            <?php echo $terrafour['img1'];
            echo $terrafour['img2'];
            echo $terrafour['img3'];
            echo $terrafour['img4'];
            echo $terrafour['img5'];
            echo $terrafour['img6'];
            echo $terrafour['img7']; ?>
          </div>
          <div class="table">
            <div class="table__column"></div>
            <ul class="table__header">
              <li class="table__cell">Характеристики</li>
              <li class="table__cell">Значение</li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Грузоподьемность</li>
              <li class="table__cell"><?php echo $terrafour['carrying']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Объем</li>
              <li class="table__cell"><?php echo $terrafour['volume']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Открытие</li>
              <li class="table__cell"><?php echo $terrafour['lock']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Размеры внешние, см</li>
              <li class="table__cell"><?php echo $terrafour['size_outdoor']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Размеры внутренние, см</li>
              <li class="table__cell"><?php echo $terrafour['size_indoor']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Цвет днища</li>
              <li class="table__cell"><?php echo $terrafour['color_bottom']; ?></li>
            </ul>
          </div>
          <p class="text" <?php echo $stylepriceautobox ?>>Цена: <strong><?php echo $terrafour['price'] ?></strong></p>
          <div class="good__price">
            <div class="good__price-info">
              <p class="text"><?php echo $terrafour['namecard1'] ?></p>
            </div>
            <div class="good__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $terrafour['id1']; ?>" class="button button__buy">Заказать</a>
              <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
                 href="/prokat/<?php echo $terrafour['id1']; ?>" class="button button__buy button__buy--prokat">Взять в
                прокат</a>
            </div>
          </div>
          <div class="good__price">
            <div class="good__price-info">
              <p class="text"><?php echo $terrafour['namecard2'] ?></p>
            </div>
            <div class="good__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $terrafour['id2']; ?>" class="button button__buy">Заказать</a>
              <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
                 href="/prokat/<?php echo $terrafour['id2']; ?>" class="button button__buy button__buy--prokat">Взять в
                прокат</a>
            </div>
          </div>
          <div class="good__price">
            <div class="good__price-info">
              <p class="text"><?php echo $terrafour['namecard3'] ?></p>
            </div>
            <div class="good__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $terrafour['id3']; ?>" class="button button__buy">Заказать</a>
              <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
                 href="/prokat/<?php echo $terrafour['id3']; ?>" class="button button__buy button__buy--prokat">Взять в
                прокат</a>
            </div>
          </div>
          <div class="good__price">
            <div class="good__price-info">
              <p class="text"><?php echo $terrafour['namecard4'] ?></p>
            </div>
            <div class="good__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $terrafour['id4']; ?>" class="button button__buy">Заказать</a>
              <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
                 href="/prokat/<?php echo $terrafour['id4']; ?>" class="button button__buy button__buy--prokat">Взять в
                прокат</a>
            </div>
          </div>

        </div>
      <?php endforeach;

      foreach ($terradrivetwo as $terratwo): ?>
        <div class="good">
          <h2 class="title title-h2"><?php echo $terratwo['title'] ?></h2>
          <div class="img__wrap">
            <?php echo $terratwo['img1'];
            echo $terratwo['img2'];
            echo $terratwo['img3'];
            echo $terratwo['img4'];
            echo $terratwo['img5'];
            echo $terratwo['img6'];
            echo $terratwo['img7']; ?>
          </div>
          <div class="table">
            <div class="table__column"></div>
            <ul class="table__header">
              <li class="table__cell">Характеристики</li>
              <li class="table__cell">Значение</li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Грузоподьемность</li>
              <li class="table__cell"><?php echo $terratwo['carrying']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Объем</li>
              <li class="table__cell"><?php echo $terratwo['volume']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Открытие</li>
              <li class="table__cell"><?php echo $terratwo['lock']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Размеры внешние, см</li>
              <li class="table__cell"><?php echo $terratwo['size_outdoor']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Размеры внутренние, см</li>
              <li class="table__cell"><?php echo $terratwo['size_indoor']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Цвет днища</li>
              <li class="table__cell"><?php echo $terratwo['color_bottom']; ?></li>
            </ul>
          </div>
          <p class="text" <?php echo $stylepriceautobox ?>>Цена: <strong><?php echo $terratwo['price'] ?></strong></p>
          <div class="good__price">
            <div class="good__price-info">
              <p class="text"><?php echo $terratwo['namecard1'] ?></p>
            </div>
            <div class="good__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $terratwo['id1']; ?>" class="button button__buy">Заказать</a>
              <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
                 href="/prokat/<?php echo $terratwo['id1']; ?>" class="button button__buy button__buy--prokat">Взять в
                прокат</a>
            </div>
          </div>
          <div class="good__price">
            <div class="good__price-info">
              <p class="text"><?php echo $terratwo['namecard2'] ?></p>
            </div>
            <div class="good__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $terratwo['id2']; ?>" class="button button__buy">Заказать</a>
              <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
                 href="/prokat/<?php echo $terratwo['id2']; ?>" class="button button__buy button__buy--prokat">Взять в
                прокат</a>
            </div>
          </div>

        </div>
      <?php endforeach;
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } ?>
  </div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html"); ?>
