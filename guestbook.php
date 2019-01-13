<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/keywords/keywords.php");
echo "<title> $titleconst"; echo $keywords[5][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[5][description];      echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[5][keywords]; echo "'/>"; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
            <div class="tabs">
                <div class="tabs__item guestbook__tab-rewiew tabs__item--active">Все отзывы</div>
                <div class="tabs__item guestbook__tab-add">Оставить отзыв</div>
            </div>
            <div class="guestbook__tab guestbook__rewiews guestbook__tab--active">
                <h1 class="title title-h1">Нам важно Ваше мнение!</h1>
                <p class="text">На данной странице Вы можете оставить отзыв о нашей проделанной работе, либо написать нам какие-либо пожелания. А также посмотреть другие отзывы о нас.</p>
                <?php
                // Соединение с БД MySQL
                $dbname = "9082410193_zakaz";

                include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

                // Количество записей на странице
                $on_page = 10;

                // Получаем количество записей таблицы
                $query = "SELECT COUNT(*) FROM guestbook INNER JOIN `status` ON guestbook.status = status.status_name AND status.status_name <> 'УДАЛЕН'";
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
                $query = "SELECT * FROM `guestbook` INNER JOIN `status` ON guestbook.status = status.status_name AND status.status_name <> 'УДАЛЕН' ORDER BY `id` DESC LIMIT $start_from, $on_page";
                $res = mysqli_query($connect, $query);

                if ($count_records == 0) {
                    echo '<div class="good-message">';
                    echo '<p class="text">На сайте пока не оставлено ни одного отзыва :( Вы можете сделать это первым!</p>';
                    echo '</div>';
                } elseif ($count_records <> 0){

                    // Вывод результатов
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        echo '<div class="rewiew">';
                        echo '<div class="rewiew__name">';
                        echo '<span>'.$row['name'].'</span>';
                        echo '</div>';
                        echo '<div class="rewiew__text-wrap">';
                        echo '<p class="text rewiew__text">'.$row['rewiew'].'</p>';
                        echo '</div>';
                        echo '<div class="rewiew__text-wrap">';
                        echo '<p class="text rewiew__answer">'.$row['answer'].'</p>';
                        echo '</div>';
                        echo '</div>';
                    }

                    // Вывод списка страниц
                    echo '<p class="page-numbers">';
                    for ($page = 1; $page <= $num_pages; $page++)
                    {
                        if ($page == $current_page)
                        {
                            echo '<strong>'.$page.'</strong> &nbsp;';
                        }
                        else
                        {
                            echo '<a class="link" href="guestbook.php?page='.$page.'">'.$page.'</a> &nbsp;';
                        }
                    } ?>
                    <div class="tabs__item guestbook__tab-add link-green">Добавить отзыв на сайт</div>
                    <?php
                }
                echo '</p>'; ?>
            </div>

            <div class="guestbook__tab guestbook__rewiews-add">
                <h2 class="title title-h2">Оставить свой отзыв о нас!</h2>
                <?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/rewiewform.php"); ?>
            </div>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
