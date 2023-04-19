<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
//include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/expiditions/backend/keywords.php");
include($_SERVER["DOCUMENT_ROOT"] . "/content/expiditions/backend/arrays.php");

$_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
      <?php
      $expidition = $_GET['expidition'];
      $_SESSION['url'] = $_SERVER['REQUEST_URI'];

      if (!isset($expidition)) {
        echo "<title> $titleconst";
        echo $keywords[0][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[0][description];
        echo "'/>"; ?>
        <h1 class="title title-h1">Экспедиционные багажники</h1>
        <div class="catalog">
          <div class="catalog__item">
            <a href="/expidition/chevrolet" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Chevrole_Niva/B01.01/B01.01-01.jpg"
                   alt="Chevrolet Niva">
            </div>
            <div class="catalog__text">
              <p class="text">Chevrolet Niva</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/greatwall" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Great_Wall/B87.03/B87.03-01.jpg"
                   alt="Great Wall">
            </div>
            <div class="catalog__text">
              <p class="text">Great Wall</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/isuzu" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/ISUZU/B102.05/B102.05-01.jpg" alt="Isuzu">
            </div>
            <div class="catalog__text">
              <p class="text">ISUZU</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/jeep" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/JEEP/B03.03/B03.03-01.jpg" alt="JEEP">
            </div>
            <div class="catalog__text">
              <p class="text">JEEP</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/kia" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/KIA/B108.05/B108.05-01.jpg" alt="KIA">
            </div>
            <div class="catalog__text">
              <p class="text">KIA</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/landrover" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Land_Rover/B11.01/B11.01-01.jpg"
                   alt="Land Rover">
            </div>
            <div class="catalog__text">
              <p class="text">Land Rover</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/mitsubishi" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Mitsubishi/B20.03/B20.03-01.jpg"
                   alt="Mitsubishi">
            </div>
            <div class="catalog__text">
              <p class="text">Mitsubishi</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/nissan" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Nissan/B21.05/B21.05-01.jpg" alt="Nissan">
            </div>
            <div class="catalog__text">
              <p class="text">Nissan</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/duster" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Renault_Duster/B92.05/B92.05-01.jpg"
                   alt="Renault Duster">
            </div>
            <div class="catalog__text">
              <p class="text">Renault Duster 4x4</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/ssangyong" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Ssang_Yong/B100.02/B100.02-01.jpg"
                   alt="Ssang Yong">
            </div>
            <div class="catalog__text">
              <p class="text">Ssang Yong</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/toyota" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Toyota/B06.03/B06.03-01.jpg" alt="Toyota">
            </div>
            <div class="catalog__text">
              <p class="text">Toyota</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/gazel" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Gazel/B36.03/B36.03-01.jpg" alt="Газель">
            </div>
            <div class="catalog__text">
              <p class="text">Газель, Соболь</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/niva" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Niva/B02.03/B02.03-01.jpg" alt="Нива 2131">
            </div>
            <div class="catalog__text">
              <p class="text">Нива 2121, 2131</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/buxanka" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/UAZ_Buxanka/B74/B74-01.jpg" alt="УАЗ Буханка">
            </div>
            <div class="catalog__text">
              <p class="text">УАЗ Буханка 452</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/patriot" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/UAZ_Patriot/B15/B15-01.jpg" alt="УАЗ Патриот">
            </div>
            <div class="catalog__text">
              <p class="text">УАЗ Патриот, УАЗ Пикап</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/hunter" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/UAZ_Hunter/B16.01/B16.01-01.jpg"
                   alt="УАЗ Хантер">
            </div>
            <div class="catalog__text">
              <p class="text">УАЗ Хантер</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/universal" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Universal/B14.01/B14.01-01.jpg"
                   alt="Универсальные багажники">
            </div>
            <div class="catalog__text">
              <p class="text">Универсальные багажники</p>
            </div>
          </div>
          <div class="catalog__item">
            <a href="/expidition/stairs" class="catalog__item-link"></a>
            <div class="catalog__image-wrap">
              <img class="catalog__image" src="/content/expiditions/img/Stairs/B32/B32-01.jpg" alt="Лестницы">
            </div>
            <div class="catalog__text">
              <p class="text">Лестницы</p>
            </div>
          </div>
        </div>
        <?php
      } elseif ($expidition == 'chevrolet') {
        echo "<title> $titleconst";
        echo $keywords[1][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[1][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[1][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['cheviniva'] = $cheviniva;

        foreach ($cheviniva as $chevi): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $chevi['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $chevi['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $chevi['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $chevi['img4'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $chevi['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $chevi['item1'] ?></li>
                <li><?php echo $chevi['item2'] ?></li>
                <li><?php echo $chevi['item3'] ?></li>
                <li><?php echo $chevi['item4'] ?></li>
                <li><?php echo $chevi['item5'] ?></li>
                <li><?php echo $chevi['item6'] ?></li>
                <li><?php echo $chevi['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $chevi['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $chevi['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'greatwall') {
        echo "<title> $titleconst";
        echo $keywords[2][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[2][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[2][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['greatwall'] = $greatwall;

        foreach ($greatwall as $great): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $great['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $great['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $great['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $great['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $great['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $great['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $great['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $great['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $great['item1'] ?></li>
                <li><?php echo $great['item2'] ?></li>
                <li><?php echo $great['item3'] ?></li>
                <li><?php echo $great['item4'] ?></li>
                <li><?php echo $great['item5'] ?></li>
                <li><?php echo $great['item6'] ?></li>
                <li><?php echo $great['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $great['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $great['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'isuzu') {
        echo "<title> $titleconst";
        echo $keywords[3][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[3][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[3][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['isuzu'] = $isuzu;

        foreach ($isuzu as $isuz): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $isuz['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $isuz['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $isuz['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $isuz['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $isuz['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $isuz['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $isuz['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $isuz['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $isuz['item1'] ?></li>
                <li><?php echo $isuz['item2'] ?></li>
                <li><?php echo $isuz['item3'] ?></li>
                <li><?php echo $isuz['item4'] ?></li>
                <li><?php echo $isuz['item5'] ?></li>
                <li><?php echo $isuz['item6'] ?></li>
                <li><?php echo $isuz['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $isuz['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $isuz['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'jeep') {
        echo "<title> $titleconst";
        echo $keywords[4][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[4][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[4][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['jeep'] = $jeep;

        foreach ($jeep as $jeepitem): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $jeepitem['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $jeepitem['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $jeepitem['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $jeepitem['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $jeepitem['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $jeepitem['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $jeepitem['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $jeepitem['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $jeepitem['item1'] ?></li>
                <li><?php echo $jeepitem['item2'] ?></li>
                <li><?php echo $jeepitem['item3'] ?></li>
                <li><?php echo $jeepitem['item4'] ?></li>
                <li><?php echo $jeepitem['item5'] ?></li>
                <li><?php echo $jeepitem['item6'] ?></li>
                <li><?php echo $jeepitem['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $jeepitem['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $jeepitem['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'kia') {
        echo "<title> $titleconst";
        echo $keywords[5][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[5][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[5][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['kia'] = $kia;

        foreach ($kia as $kiaitem): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $kiaitem['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $kiaitem['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $kiaitem['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $kiaitem['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $kiaitem['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $kiaitem['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $kiaitem['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $kiaitem['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $kiaitem['item1'] ?></li>
                <li><?php echo $kiaitem['item2'] ?></li>
                <li><?php echo $kiaitem['item3'] ?></li>
                <li><?php echo $kiaitem['item4'] ?></li>
                <li><?php echo $kiaitem['item5'] ?></li>
                <li><?php echo $kiaitem['item6'] ?></li>
                <li><?php echo $kiaitem['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $kiaitem['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $kiaitem['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'landrover') {
        echo "<title> $titleconst";
        echo $keywords[6][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[6][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[6][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['landrover'] = $landrover;

        foreach ($landrover as $land): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $land['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $land['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $land['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $land['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $land['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $land['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $land['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $land['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $land['item1'] ?></li>
                <li><?php echo $land['item2'] ?></li>
                <li><?php echo $land['item3'] ?></li>
                <li><?php echo $land['item4'] ?></li>
                <li><?php echo $land['item5'] ?></li>
                <li><?php echo $land['item6'] ?></li>
                <li><?php echo $land['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $land['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $land['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'mitsubishi') {
        echo "<title> $titleconst";
        echo $keywords[7][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[7][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[7][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['mitsubishi'] = $mitsubishi;

        foreach ($mitsubishi as $mitsu): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $mitsu['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $mitsu['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $mitsu['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $mitsu['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $mitsu['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $mitsu['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $mitsu['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $mitsu['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $mitsu['item1'] ?></li>
                <li><?php echo $mitsu['item2'] ?></li>
                <li><?php echo $mitsu['item3'] ?></li>
                <li><?php echo $mitsu['item4'] ?></li>
                <li><?php echo $mitsu['item5'] ?></li>
                <li><?php echo $mitsu['item6'] ?></li>
                <li><?php echo $mitsu['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $mitsu['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $mitsu['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'nissan') {
        echo "<title> $titleconst";
        echo $keywords[8][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[8][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[8][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['nissan'] = $nissan;

        foreach ($nissan as $niss): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $niss['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $niss['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $niss['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $niss['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $niss['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $niss['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $niss['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $niss['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $niss['item1'] ?></li>
                <li><?php echo $niss['item2'] ?></li>
                <li><?php echo $niss['item3'] ?></li>
                <li><?php echo $niss['item4'] ?></li>
                <li><?php echo $niss['item5'] ?></li>
                <li><?php echo $niss['item6'] ?></li>
                <li><?php echo $niss['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $niss['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $niss['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'duster') {
        echo "<title> $titleconst";
        echo $keywords[9][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[9][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[9][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['renault'] = $renault;

        foreach ($renault as $reno): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $reno['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $reno['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $reno['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $reno['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $reno['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $reno['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $reno['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $reno['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $reno['item1'] ?></li>
                <li><?php echo $reno['item2'] ?></li>
                <li><?php echo $reno['item3'] ?></li>
                <li><?php echo $reno['item4'] ?></li>
                <li><?php echo $reno['item5'] ?></li>
                <li><?php echo $reno['item6'] ?></li>
                <li><?php echo $reno['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $reno['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $reno['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'ssangyong') {
        echo "<title> $titleconst";
        echo $keywords[10][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[10][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[10][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['ssang_yong'] = $ssang_yong;

        foreach ($ssang_yong as $ssang): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $ssang['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $ssang['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $ssang['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $ssang['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $ssang['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $ssang['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $ssang['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $ssang['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $ssang['item1'] ?></li>
                <li><?php echo $ssang['item2'] ?></li>
                <li><?php echo $ssang['item3'] ?></li>
                <li><?php echo $ssang['item4'] ?></li>
                <li><?php echo $ssang['item5'] ?></li>
                <li><?php echo $ssang['item6'] ?></li>
                <li><?php echo $ssang['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $ssang['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $ssang['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'toyota') {
        echo "<title> $titleconst";
        echo $keywords[11][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[11][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[11][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['toyota'] = $toyota;

        foreach ($toyota as $toyotaitem): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $toyotaitem['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $toyotaitem['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $toyotaitem['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $toyotaitem['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $toyotaitem['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $toyotaitem['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $toyotaitem['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $toyotaitem['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $toyotaitem['item1'] ?></li>
                <li><?php echo $toyotaitem['item2'] ?></li>
                <li><?php echo $toyotaitem['item3'] ?></li>
                <li><?php echo $toyotaitem['item4'] ?></li>
                <li><?php echo $toyotaitem['item5'] ?></li>
                <li><?php echo $toyotaitem['item6'] ?></li>
                <li><?php echo $toyotaitem['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $toyotaitem['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $toyotaitem['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'gazel') {
        echo "<title> $titleconst";
        echo $keywords[12][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[12][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[12][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['gazel'] = $gazel;

        foreach ($gazel as $gazelitem): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $gazelitem['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $gazelitem['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $gazelitem['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $gazelitem['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $gazelitem['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $gazelitem['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $gazelitem['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $gazelitem['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $gazelitem['item1'] ?></li>
                <li><?php echo $gazelitem['item2'] ?></li>
                <li><?php echo $gazelitem['item3'] ?></li>
                <li><?php echo $gazelitem['item4'] ?></li>
                <li><?php echo $gazelitem['item5'] ?></li>
                <li><?php echo $gazelitem['item6'] ?></li>
                <li><?php echo $gazelitem['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $gazelitem['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $gazelitem['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'niva') {
        echo "<title> $titleconst";
        echo $keywords[13][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[13][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[13][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['niva'] = $niva;

        foreach ($niva as $nivaitem): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $nivaitem['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $nivaitem['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $nivaitem['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $nivaitem['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $nivaitem['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $nivaitem['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $nivaitem['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $nivaitem['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $nivaitem['item1'] ?></li>
                <li><?php echo $nivaitem['item2'] ?></li>
                <li><?php echo $nivaitem['item3'] ?></li>
                <li><?php echo $nivaitem['item4'] ?></li>
                <li><?php echo $nivaitem['item5'] ?></li>
                <li><?php echo $nivaitem['item6'] ?></li>
                <li><?php echo $nivaitem['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $nivaitem['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $nivaitem['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'buxanka') {
        echo "<title> $titleconst";
        echo $keywords[14][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[14][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[14][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['uaz_buxanka'] = $uaz_buxanka;

        foreach ($uaz_buxanka as $buxanka): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $buxanka['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $buxanka['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $buxanka['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $buxanka['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $buxanka['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $buxanka['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $buxanka['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $buxanka['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $buxanka['item1'] ?></li>
                <li><?php echo $buxanka['item2'] ?></li>
                <li><?php echo $buxanka['item3'] ?></li>
                <li><?php echo $buxanka['item4'] ?></li>
                <li><?php echo $buxanka['item5'] ?></li>
                <li><?php echo $buxanka['item6'] ?></li>
                <li><?php echo $buxanka['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $buxanka['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $buxanka['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'patriot') {
        echo "<title> $titleconst";
        echo $keywords[15][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[15][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[15][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['uaz_patriot'] = $uaz_patriot;

        foreach ($uaz_patriot as $patriot): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $patriot['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $patriot['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $patriot['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $patriot['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $patriot['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $patriot['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $patriot['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $patriot['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $patriot['item1'] ?></li>
                <li><?php echo $patriot['item2'] ?></li>
                <li><?php echo $patriot['item3'] ?></li>
                <li><?php echo $patriot['item4'] ?></li>
                <li><?php echo $patriot['item5'] ?></li>
                <li><?php echo $patriot['item6'] ?></li>
                <li><?php echo $patriot['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $patriot['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $patriot['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'hunter') {
        echo "<title> $titleconst";
        echo $keywords[16][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[16][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[16][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['uaz_hunter'] = $uaz_hunter;

        foreach ($uaz_hunter as $hunter): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $hunter['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $hunter['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $hunter['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $hunter['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $hunter['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $hunter['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $hunter['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $hunter['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $hunter['item1'] ?></li>
                <li><?php echo $hunter['item2'] ?></li>
                <li><?php echo $hunter['item3'] ?></li>
                <li><?php echo $hunter['item4'] ?></li>
                <li><?php echo $hunter['item5'] ?></li>
                <li><?php echo $hunter['item6'] ?></li>
                <li><?php echo $hunter['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $hunter['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $hunter['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'universal') {
        echo "<title> $titleconst";
        echo $keywords[17][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[17][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[17][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['universal'] = $universal;

        foreach ($universal as $universalitem): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $universalitem['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $universalitem['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $universalitem['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $universalitem['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $universalitem['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $universalitem['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $universalitem['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $universalitem['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $universalitem['item1'] ?></li>
                <li><?php echo $universalitem['item2'] ?></li>
                <li><?php echo $universalitem['item3'] ?></li>
                <li><?php echo $universalitem['item4'] ?></li>
                <li><?php echo $universalitem['item5'] ?></li>
                <li><?php echo $universalitem['item6'] ?></li>
                <li><?php echo $universalitem['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $universalitem['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $universalitem['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } elseif ($expidition == 'stairs') {
        echo "<title> $titleconst";
        echo $keywords[18][title];
        echo "</title>";
        echo "<meta name='description' content='";
        echo $keywords[18][description];
        echo "'/>";
        echo "<h1 class='title title-h1'>";
        echo $keywords[18][title];
        echo "</h1>";
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['stairs'] = $stairs;

        foreach ($stairs as $stairsitem): ?>
          <div class="product">
            <div class="img__wrap product__photos">
              <img class="img product__img" src="<?php echo $stairsitem['img1'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $stairsitem['img2'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $stairsitem['img3'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $stairsitem['img4'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $stairsitem['img5'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $stairsitem['img6'] ?>">
              <img class="img product__img product__img--small" src="<?php echo $stairsitem['img7'] ?>">
            </div>
            <div class="product__info">
              <h2 class="title title-h2"><?php echo $stairsitem['name'] ?></h2>
              <ul class="list list__unsorted">
                <li><?php echo $stairsitem['item1'] ?></li>
                <li><?php echo $stairsitem['item2'] ?></li>
                <li><?php echo $stairsitem['item3'] ?></li>
                <li><?php echo $stairsitem['item4'] ?></li>
                <li><?php echo $stairsitem['item5'] ?></li>
                <li><?php echo $stairsitem['item6'] ?></li>
                <li><?php echo $stairsitem['item7'] ?></li>
              </ul>
              <div class="good__price">
                <div class="good__price-info">
                  <p class="span" <?php echo $stylepriceexpidition ?>>Цена:
                    <strong><?php echo $stairsitem['price'] ?></strong></p>
                </div>
                <div class="good__buttons">
                  <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                     href="/buy/<?php echo $stairsitem['id']; ?>" class="button button__buy">Заказать</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
      } ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
