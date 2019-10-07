<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatags.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/header.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/proposition/proposition.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation/navigation.html");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/breadcrumbs/breadcrumbs.php");
include($_SERVER["DOCUMENT_ROOT"] . "/content/porogi/backend/keywords.php");

include($_SERVER["DOCUMENT_ROOT"] . "/content/porogi/backend/array.php"); ?>

<div class="wrapper">
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/left-nav/left-nav.html"); ?>
  <div class="wrapper__content">
    <?php
    $porogi = $_GET['porogi'];
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    $_SESSION['porogi'] = $porogiarray;

    if (!isset($porogi)) {
      echo "<title> $titleconst";
      echo $keywords[0][title];
      echo "</title>";
      echo "<meta name='description' content='";
      echo $keywords[0][description];
      echo "'/>";
      echo "<meta name='keywords' content='";
      echo $keywords[0][keywords];
      echo "'/>";

      echo "<h1 class='title title-h1'>Пороги для автомобилей</h1>";
      echo "<p class='text'>Автомобильные пороги зачастую довольно узко воспринимаются владельцами авто как просто «деталь тюнинга» или ненужная опция, либо как атрибут только лишь внедорожников и минивэнов. На деле же они выполняют ряд функций, которые будут одинаково полезны для любых авто и в сочетании с другими дополнительными навесными элементами делают ваш автомобиль более защищенным от внешних условий и удобным в использовании, интереснее в визуальном плане.</p>";
      echo "<p class='text'>Основные функции порогов для автомобилей:</p>";
      echo "<p class='text'>Защищают боковые поверхности автомобиля от грязи и сколов: нижняя часть кузова не подвергается повреждениям от обуви, камней, грязи, осколков и других подобных факторов.</p>";
      echo "<p class='text'>Обеспечивают удобство посадки в автомобиль: будь то автомобиль с высоким или низким клиренсом – пороги сделают посадку в автомобиль проще и комфортнее, не изменяя при этом сам клиренс.</p>";
      echo "<p class='text'>Улучшают внешний вид автомобиля: автомобиль выглядит внушительнее и солиднее, особенно с алюминиевыми порогами.</p>";
    }

    foreach ($porogiarray as $porog): ?>
      <div class="good">
          <h2 class="title title-h2"><?php echo $porog['name'] ?></h2>
          <div class="img__wrap">
            <?php echo $porog['img']; ?>
          </div>
          <div class="table">
            <div class="table__column"></div>
            <ul class="table__row">
              <li class="table__cell">Материал</li>
              <li class="table__cell"><?php echo $porog['material']; ?></li>
            </ul>
            <ul class="table__row">
              <li class="table__cell">Вид порога</li>
              <li class="table__cell"><?php echo $porog['type']; ?></li>
            </ul>
          </div>
          <p class="text" <?php echo $stylepriceporogi ?>>Цена: <strong><?php echo $porog['price'] ?></strong></p>
          <div class="good__price">
            <div class="good__price-info">
              <p class="text"><?php echo $porog['name'] ?></p>
            </div>
            <div class="good__buttons">
              <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
                 href="/buy/<?php echo $porog['id']; ?>" class="button button__buy">Заказать</a>
            </div>
          </div>
        </div>
      <?php endforeach;
    ?>


  </div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html"); ?>
