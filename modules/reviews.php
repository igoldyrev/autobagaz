<?php
$dbname = "9082410193_zakaz";

require_once ("/modules/connectdb.php");

$query = "SELECT * FROM guestbook ORDER BY id DESC LIMIT 5"; // запрос на выборку

echo "<h2 class='page__title-h2'>Последние отзывы о нас</h2>";
if ($result = mysqli_query($connect, $query)) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="rewiew">';
        echo '<div class="rewiew__name">';
        echo '<span>'.$row['name'].'</span>';
        echo '</div>';
        echo '<div class="rewiew__text">';
        echo '<p class="page__text page__text--rewiew">'.$row['rewiew'].'</p>';
        echo '</div>';
        echo '</div>';
    }
} ?>
<a href="/guestbook" class="left-nav left-nav__link left-nav__link--rewiew">Смотреть все отзывы</a>