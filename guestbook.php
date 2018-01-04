<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");
echo "<title> $titleconst"; echo $keywords[24][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[24][description]; echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[24][keywords]; echo "'/>"; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php"); ?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html"); ?>
        <div class="content">
            <div class="page__header">
                <div class="page__header-tab guestbook__tab-rewiew page__header-tab--active">Все отзывы</div>
                <div class="page__header-tab guestbook__tab-add">Оставить отзыв</div>
            </div>
            <div class="guestbook__tab guestbook__rewiews guestbook__tab--active">
                <h1 class="page__title-h1">Нам важно Ваше мнение!</h1>
                <p class="page__text">На данной странице Вы можете оставить отзыв о нашей проделанной работе, либо написать нам какие-либо пожелания. А также посмотреть другие отзывы о нас.</p>
                <?php
                // Соединение с БД MySQL
                $dbname = "9082410193_zakaz";

                include ($_SERVER["DOCUMENT_ROOT"]."/modules/connectdb.php");

                // Количество записей на странице
                $on_page = 10;

                // Получаем количество записей таблицы
                $query = "SELECT COUNT(*) FROM guestbook";
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
                $query = "SELECT `name`, `phone`, `rewiew` FROM `guestbook` ORDER BY `id` DESC LIMIT $start_from, $on_page";
                $res = mysqli_query($connect, $query);

                if ($count_records == 0) {
                    echo '<div class="good_message">';
                    echo 'На сайте пока не оставлено ни одного отзыва :( Вы можете сделать это первым!';
                    echo '</div>';
                } elseif ($count_records <> 0){

                    // Вывод результатов
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        echo '<div class="rewiew">';
                        echo '<div class="rewiew__name">';
                        echo '<span>'.$row['name'].'</span>';
                        echo '</div>';
                        echo '<div class="rewiew__text">';
                        echo '<p class="page__text page__text--rewiew">'.$row['rewiew'].'</p>';
                        echo '</div>';
                        echo '</div>';
                    }

                    // Вывод списка страниц
                    echo '<p class="page__text page__text--guestbook">';
                    for ($page = 1; $page <= $num_pages; $page++)
                    {
                        if ($page == $current_page)
                        {
                            echo '<strong>'.$page.'</strong> &nbsp;';
                        }
                        else
                        {
                            echo '<a class="page__link" href="guestbook.php?page='.$page.'">'.$page.'</a> &nbsp;';
                        }
                    } ?>
                    <div class="page__header-tab guestbook__tab-add left-nav__link left-nav__link--rewiew">Добавить отзыв на сайт</div>
                    <?php
                }
                echo '</p>'; ?></div>

            <div class="guestbook__tab guestbook__rewiews-add">
                <h2 class="page__title-h2">Оставить свой отзыв о нас!</h2>
                <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/rewiewform.php"); ?>
            </div>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>