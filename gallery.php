<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/keywords/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/gallerybreadcrumbs.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">

        <?php
        $dbname = "9082410193_gallery";
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

        $auto = $_GET['auto'];

        if (!isset($auto)){
            echo "<title> $titleconst"; echo $keywords[2][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[2][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[2][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Галерея работ</h1>";
            echo "<p class='text'>В этом разделе приведены фотографии наших клиентов, которые когда-либо приобретали у нас багажник или автобокс. Как Вы видите, у нас действительно есть выбор практически на любой автомобиль!</p>";

            // Количество записей на странице
            $on_page = 9;

            // Получаем количество записей таблицы
            $query = "SELECT COUNT(*) FROM photos";
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
            $query = "SELECT * FROM `photos` ORDER BY `id` DESC LIMIT $start_from, $on_page";
            $res = mysqli_query($connect, $query);

            if ($count_records == 0) {
                echo '<div class="good-message">';
                echo '<p class="text">В галерее пока нет фотографий</p>';
                echo '</div>';
            }elseif ($count_records <> 0){

                // Вывод результатов ?>
                <div class="gallery"><?php
                    while ($row = mysqli_fetch_assoc($res))
                    {?>
                        <div class="gallery__item">
                            <img src="<?php echo $row['img0']?>" class="gallery__img" alt="<?php echo $row['name']?>">
                            <a href="/gallery/<?php echo $row['link']?>" class="gallery__name"><?php echo $row['name']?></a>
                            <div class="gallery__info">
                                <div class="gallery__tag-inner">
                                    <a href="#" class="gallery__tag"><?php echo $row['tag1']?></a>
                                    <a href="#" class="gallery__tag"><?php echo $row['tag2']?></a>
                                    <a href="#" class="gallery__tag"><?php echo $row['tag3']?></a>
                                </div>
                                <p class="text"><?php echo $row['date']?></p>
                            </div>
                        </div><?php
                    } ?>
                </div><?php

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
                        echo '<a class="link" href="gallery.php?page='.$page.'">'.$page.'</a> &nbsp;';
                    }
                }
            }
        }

        $query = "SELECT * FROM `photos` ORDER BY `id` DESC";
        $res = mysqli_query($connect, $query);

        while ($row = mysqli_fetch_assoc($res)){

            if ($auto == $row['link']){
                echo "<title> $titleconst"; echo $row['name']; echo "</title>"; ?>

                <div class="news__inner">
                    <h2 class="title title-h2"><?php echo $row['name'] ?></h2>
                    <div class="img__wrap">
                        <img class="img good__img news__img" src="<?php echo $row['img0'] ?>" alt="<?php echo $row['name'] ?>">
                        <img class="img good__img news__img" src="<?php echo $row['img1'] ?>" alt="<?php echo $row['name'] ?>">
                        <img class="img good__img news__img" src="<?php echo $row['img2'] ?>" alt="<?php echo $row['name'] ?>">
                        <img class="img good__img news__img" src="<?php echo $row['img3'] ?>" alt="<?php echo $row['name'] ?>">
                        <img class="img good__img news__img" src="<?php echo $row['img4'] ?>" alt="<?php echo $row['name'] ?>">
                        <img class="img good__img news__img" src="<?php echo $row['img5'] ?>" alt="<?php echo $row['name'] ?>">
                        <img class="img good__img news__img" src="<?php echo $row['img6'] ?>" alt="<?php echo $row['name'] ?>">
                        <img class="img good__img news__img" src="<?php echo $row['img7'] ?>" alt="<?php echo $row['name'] ?>">
                        <img class="img good__img news__img" src="<?php echo $row['img8'] ?>" alt="<?php echo $row['name'] ?>">
                        <img class="img good__img news__img" src="<?php echo $row['img9'] ?>" alt="<?php echo $row['name'] ?>">
                    </div>
                </div><?php
            }
        } ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>