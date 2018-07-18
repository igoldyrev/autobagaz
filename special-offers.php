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
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php $_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>
        <div class="tabs">
            <div class="tabs__item special__tab-sale tabs__item--active">Товары со скидкой</div>
            <div class="tabs__item special__tab-komm">Комиссионные товары</div>
        </div>
        <div class="special__tab special__sale special__tab--active">
            <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/sales/sales.php"); ?>
        </div>

        <div class="special__tab special__komm">
            <?php echo "<h1 class='title title-h1'>Комиссионка</h1>";
            echo "<p class='text'>В этом разделе мы продаем б/у багажники, автобоксы и аксессуары в рабочем состоянии. Часть багажников - использовались в прокате, часть - были оставлены на реализацию нашими клиентами. В течении 2-х недель вы можете вернуть багажник, если он вам не подойдет или окажется неисправен.</p>";
            echo "<p class='text'>Если у вас есть ненужный багажник - мы его купим.</p>";
            echo "<h2 class='title title-h2'>Автомобильные багажники</h2>";

            // Соединение с БД MySQL
            $dbname = "9082410193_komm";

            include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

            // Количество записей на странице
            $on_page = 30;

            // Получаем количество записей таблицы
            $query = "SELECT COUNT(*) FROM `bagazhniki`";
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
            if ($current_page < 1)
            {
                $current_page = 1;
            }
            // Если текущая страница больше общего количества страница, то
            // текущая страница равна количеству страниц
            elseif ($current_page > $num_pages)
            {
                $current_page = $num_pages;
            }

            // Начать получение данных от числа (текущая страница - 1) * количество записей на странице
            $start_from = ($current_page - 1) * $on_page;

            // Формат оператора LIMIT <ЗАПИСЬ ОТ>, <КОЛИЧЕСТВО ЗАПИСЕЙ>
            $query = "SELECT * FROM `bagazhniki` ORDER BY `bg_id` ASC LIMIT $start_from, $on_page";
            $res = mysqli_query($connect, $query);

            // Вывод результатов
            while ($row = mysqli_fetch_assoc($res))
            {
                echo '<div class="good">';
                echo '<h3 class="title title-h3">'.$row['bg_name'].'</h3>';
                echo '<div class="good__description">';
                echo '<div class="img__wrap">';
                echo $row['bg_img1']; echo $row['bg_img2']; echo $row['bg_img3']; echo $row['bg_img4']; echo $row['bg_img5'];
                echo '</div>';
                echo '</div>';
                echo '<p class="text">Цена '.$row['bg_price'].' рублей.</p>';
                echo '</div>';
            }

            echo "<h2 class='title title-h2'>Фаркопы</h2>";
            // Получаем количество записей таблицы
            $query = "SELECT COUNT(*) FROM `farkops`";
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
            if ($current_page < 1)
            {
                $current_page = 1;
            }
            // Если текущая страница больше общего количества страница, то
            // текущая страница равна количеству страниц
            elseif ($current_page > $num_pages)
            {
                $current_page = $num_pages;
            }

            // Начать получение данных от числа (текущая страница - 1) * количество записей на странице
            $start_from = ($current_page - 1) * $on_page;

            // Формат оператора LIMIT <ЗАПИСЬ ОТ>, <КОЛИЧЕСТВО ЗАПИСЕЙ>
            $query = "SELECT * FROM `farkops` ORDER BY `fs_id` ASC LIMIT $start_from, $on_page";
            $res = mysqli_query($connect, $query);

            // Вывод результатов
            while ($row = mysqli_fetch_assoc($res))
            {
                echo '<div class="good">';
                echo '<h3 class="title title-h3">'.$row['fs_name'].'</h3>';
                echo '<div class="good__description">';
                echo '<div class="img__wrap">';
                echo $row['fs_img1']; echo $row['fs_img2']; echo $row['fs_img3']; echo $row['fs_img4']; echo $row['fs_img5'];
                echo '</div>';
                echo '</div>';
                echo '<p class="text">Цена '.$row['fs_price'].' рублей.</p>';
                echo '</div>';
            }

            echo "<h2 class='title title-h2'>Корзины</h2>";
            // Получаем количество записей таблицы
            $query = "SELECT COUNT(*) FROM `korzins`";
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
            if ($current_page < 1)
            {
                $current_page = 1;
            }
            // Если текущая страница больше общего количества страница, то
            // текущая страница равна количеству страниц
            elseif ($current_page > $num_pages)
            {
                $current_page = $num_pages;
            }

            // Начать получение данных от числа (текущая страница - 1) * количество записей на странице
            $start_from = ($current_page - 1) * $on_page;

            // Формат оператора LIMIT <ЗАПИСЬ ОТ>, <КОЛИЧЕСТВО ЗАПИСЕЙ>
            $query = "SELECT * FROM `korzins` ORDER BY `ks_id` ASC LIMIT $start_from, $on_page";
            $res = mysqli_query($connect, $query);

            // Вывод результатов
            while ($row = mysqli_fetch_assoc($res))
            {
                echo '<div class="good">';
                echo '<h3 class="title title-h3">'.$row['ks_name'].'</h3>';
                echo '<div class="good__description">';
                echo '<div class="img__wrap">';
                echo $row['ks_img1']; echo $row['ks_img2']; echo $row['ks_img3']; echo $row['ks_img4']; echo $row['ks_img5'];
                echo '</div>';
                echo '</div>';
                echo '<p class="text">Цена '.$row['ks_price'].' рублей.</p>';
                echo '</div>';
            } ?>
        </div>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
