<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/header.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/proposition/proposition.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include($_SERVER["DOCUMENT_ROOT"] . "/content/autobagazhniki/backend/array.php");
include($_SERVER["DOCUMENT_ROOT"] . "/content/autobagazhniki/backend/keywords.php");

$_SESSION['autobagazhniki'] = $autobagazhniki;
$_SESSION['reelings'] = $reelings;
$_SESSION['shtatnye'] = $shtatnye;
$_SESSION['smooth'] = $smooth;
$_SESSION['vodostok'] = $vodostok;
$_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>

<div class="wrapper">
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/left-nav/left-nav.html"); ?>
  <div class="wrapper__content">
    <?php
    $id = $_GET['id'];
    $good = [];
    foreach ($autobagazhniki as $product) {
      if ($product['id'] == $id) {
        $good = $product;
        break;
      }
    };

    if ($id == 'reelings') { ?>
      <title><?php echo $keywords[1][title]; ?></title>
      <h1 class="title title-h1"><?php echo $product['name'] ?></h1>
      <p class="text">В нашем магазине есть несколько видов багажников на рейлинг, все они представлены ниже.</p>

      <?php foreach ($reelings as $reeling): ?>
        <div class="product">
          <div class="img__wrap product__photos">
            <?php echo $reeling['img1'] ?>
            <?php echo $reeling['img2'] ?>
            <?php echo $reeling['img3'] ?>
            <?php echo $reeling['img4'] ?>
          </div>
          <div class="product__info">
            <h2 class="title title-h2"><?php echo $reeling['name'] ?></h2>
            <p class="text"><?php echo $reeling['desc'] ?></p>
            <div class="product__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
                 href="/prokat/<?php echo $reeling['id']; ?>" class="button button__buy button__buy--prokat">Взять в
                прокат</a>
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $reeling['id']; ?>" class="button button__buy">Заказать</a>
            </div>
          </div>
        </div>
      <?php endforeach;
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } elseif ($id == 'shtatnye') { ?>
      <title><?php echo $keywords[2][title]; ?></title>
      <h1 class="title title-h1"><?php echo $product['name'] ?></h1>
      <p class="text">В нашем магазине есть несколько видов багажников на штатные места, все они представлены ниже.</p>

      <?php foreach ($shtatnye as $shtat): ?>
        <div class="product">
          <div class="img__wrap product__photos">
            <?php echo $shtat['img1'] ?>
            <?php echo $shtat['img2'] ?>
            <?php echo $shtat['img3'] ?>
            <?php echo $shtat['img4'] ?>
          </div>
          <div class="product__info">
            <h2 class="title title-h2"><?php echo $shtat['name'] ?></h2>
            <p class="text"><?php echo $shtat['desc'] ?></p>
            <div class="product__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
                 href="/prokat/<?php echo $shtat['id']; ?>" class="button button__buy button__buy--prokat">Взять в
                прокат</a>
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $shtat['id']; ?>" class="button button__buy">Заказать</a>
            </div>
          </div>
        </div>
      <?php endforeach;
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } elseif ($id == 'smooth') { ?>
      <title><?php echo $keywords[3][title]; ?></title>
      <h1 class="title title-h1"><?php echo $product['name'] ?></h1>
      <p class="text">В нашем магазине есть несколько видов багажников на плоскую крышу, все они представлены ниже.</p>

      <?php foreach ($smooth as $smoo): ?>
        <div class="product">
          <div class="img__wrap product__photos">
            <?php echo $smoo['img1'] ?>
            <?php echo $smoo['img2'] ?>
            <?php echo $smoo['img3'] ?>
            <?php echo $smoo['img4'] ?>
          </div>
          <div class="product__info">
            <h2 class="title title-h2"><?php echo $smoo['name'] ?></h2>
            <p class="text"><?php echo $smoo['desc'] ?></p>
            <div class="product__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
                 href="/prokat/<?php echo $smoo['id']; ?>" class="button button__buy button__buy--prokat">Взять в
                прокат</a>
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $smoo['id']; ?>" class="button button__buy">Заказать</a>
            </div>
          </div>
        </div>
      <?php endforeach;
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } elseif ($id == 'vodostok') { ?>
      <title><?php echo $keywords[4][title]; ?></title>
      <h1 class="title title-h1"><?php echo $product['name'] ?></h1>
      <p class="text">В нашем магазине есть несколько видов багажников на водосток, все они представлены ниже.</p>

      <?php foreach ($vodostok as $stok): ?>
        <div class="product">
          <div class="img__wrap product__photos">
            <?php echo $stok['img1'] ?>
            <?php echo $stok['img2'] ?>
            <?php echo $stok['img3'] ?>
            <?php echo $stok['img4'] ?>
          </div>
          <div class="product__info">
            <h2 class="title title-h2"><?php echo $stok['name'] ?></h2>
            <p class="text"><?php echo $stok['desc'] ?></p>
            <div class="product__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true"
                 href="/prokat/<?php echo $stok['id']; ?>" class="button button__buy button__buy--prokat">Взять в
                прокат</a>
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $stok['id']; ?>" class="button button__buy">Заказать</a>
            </div>
          </div>
        </div>
      <?php endforeach;
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");
    } ?>
  </div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
