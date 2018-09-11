<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/keywords/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
echo "<title> $titleconst"; echo $keywords[3][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[3][description];      echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[3][keywords]; echo "'/>"; ?>

<div class="wrapper">
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/left-nav/left-nav.html"); ?>
  <div class="wrapper__content">
    <?php $_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>
    <div class="tabs">
      <div class="tabs__item special__tab-sale tabs__item--active">Товары со скидкой</div>
      <div class="tabs__item special__tab-komm">Комиссионные товары</div>
    </div>
    <div class="special__tab special__sale special__tab--active">
      <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/sales/sales.php"); ?>
    </div>

    <div class="special__tab special__komm">
      <?php echo "<h1 class='title title-h1'>Комиссионка</h1>";
      echo "<p class='text'>В этом разделе мы продаем б/у багажники, автобоксы и аксессуары в рабочем состоянии. Часть багажников - использовались в прокате, часть - были оставлены на реализацию нашими клиентами. В течении 2-х недель вы можете вернуть багажник, если он вам не подойдет или окажется неисправен.</p>";
      echo "<p class='text'>Если у вас есть ненужный багажник - мы его купим.</p>";

      $dbname = "9082410193_zakaz";
      include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

      // Количество записей на странице
      $on_page = 30;

      // Получаем количество записей таблицы
      $query = "SELECT COUNT(*) FROM `komm_items` INNER JOIN status ON komm_items.komm_items_status = status.status_name AND status.status_name <> 'УДАЛЕН'";
      $res = mysqli_query($connect, $query);
      $count_records = mysqli_fetch_row($res);
      $count_records = $count_records[0];

      // Получаем количество страниц
      // Делим количество всех записей на количество записей на странице
      // и округляем в большую сторону
      $num_pages = ceil($count_records / $on_page);

      // Текущая страница из GET-параметра page
      // Если параметр не определен, то текущая страница равна 1
      $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

      // Если текущая страница меньше единицы, то страница равна 1
      if ($current_page < 1) {
        $current_page = 1;
      }
      // Если текущая страница больше общего количества страница, то
      // текущая страница равна количеству страниц
      elseif ($current_page > $num_pages) {
        $current_page = $num_pages;
      }

      // Начать получение данных от числа (текущая страница - 1) * количество записей на странице
      $start_from = ($current_page - 1) * $on_page;

      // Формат оператора LIMIT <ЗАПИСЬ ОТ>, <КОЛИЧЕСТВО ЗАПИСЕЙ>
      $query = "SELECT * FROM `komm_items` INNER JOIN status ON komm_items.komm_items_status = status.status_name AND status.status_name <> 'УДАЛЕН' ORDER BY `komm_items_id` ASC LIMIT $start_from, $on_page";
      $res = mysqli_query($connect, $query);

      if ($count_records == 0) {
        echo '<div class="good-message">';
        echo '<p class="text">На сайте пока нет товаров в Комиссионке</p>';
        echo '</div>';
      } elseif ($count_records <> 0) {
        // Вывод результатов
        while ($row = mysqli_fetch_assoc($res)) {
          echo '<div class="good">';
          echo '<h3 class="title title-h3">' . $row['komm_items_name'] . '</h3>';
          echo '<div class="good__description">';
          echo '<div class="img__wrap">';
          echo '<img class="img good__img good__img--mini" src="' . $row['komm_items_img0'] . '" alt="' . $row['komm_items_name'] . '">';
          echo '<img class="img good__img good__img--mini" src="' . $row['komm_items_img1'] . '" alt="' . $row['komm_items_name'] . '">';
          echo '<img class="img good__img good__img--mini" src="' . $row['komm_items_img2'] . '" alt="' . $row['komm_items_name'] . '">';
          echo '<img class="img good__img good__img--mini" src="' . $row['komm_items_img3'] . '" alt="' . $row['komm_items_name'] . '">';
          echo '<img class="img good__img good__img--mini" src="' . $row['komm_items_img4'] . '" alt="' . $row['komm_items_name'] . '">';
          echo '</div>';
          echo '</div>';
          echo '<div class="good__price">';
          echo '<p class="text">' . $row['komm_items_group'] . '</p>';
          echo '<p class="text">Цена ' . $row['komm_items_price'] . ' рублей.</p>';
          echo '</div>';
          echo '</div>';
        }
      } ?>
    </div>
  </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
