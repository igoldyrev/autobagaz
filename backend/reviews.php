<?php
$dbname = "9082410193_zakaz";

include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

$query = "SELECT * FROM guestbook ORDER BY id DESC LIMIT 5"; // запрос на выборку

echo "<h2 class= 'title                        title-h2'>Последние отзывы о нас</h2>";
if ($result = mysqli_query($connect, $query)) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="rewiew">';
        echo '<div class="rewiew__name">';
        echo '<span>'.$row['name'].'</span>';
        echo '</div>';
        echo '<div class="rewiew__text-wrap">';
        echo '<p class="text rewiew__text">'.$row['rewiew'].'</p>';
        echo '</div>';
        echo '</div>';
    }
} ?>
<a href="/guestbook" class="left-nav left-nav__link left-nav__link--rewiew">Смотреть все отзывы</a>