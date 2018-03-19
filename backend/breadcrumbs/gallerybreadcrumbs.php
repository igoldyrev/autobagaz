<?php
$dbname = "9082410193_gallery";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

$auto = $_GET['auto'];

$query = "SELECT * FROM `photos` ORDER BY `id` DESC";
$res = mysqli_query($connect, $query);

while ($row = mysqli_fetch_assoc($res)){
    if ($auto == $row['link']){ ?>

        <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="/gallery">Галерея работ</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $row['name'] ?></span>
        </div><?php

    }
}
