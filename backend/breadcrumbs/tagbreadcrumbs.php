<?php
$dbname = "9082410193_gallery";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

$tag = $_GET['tag'];

$on_page = 1;

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

if ($count_records <> 0){

    while ($row = mysqli_fetch_assoc($res)){ ?>

            <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="/gallery">Галерея работ</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $tag ?></span>
            </div><?php

    }
}

