<?php
$dbname = "9082410193_news";

include ($_SERVER["DOCUMENT_ROOT"]."/modules/connectdb.php");

$query = "SELECT * FROM `news` ORDER BY news_id DESC LIMIT 4";

echo "<h2 class='page__title-h2'>Новости</h2>";
if ($result = mysqli_query($connect, $query)) {
    echo "<div class='news'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='news__item news__item--index''>";
        echo "<div class='news__info'>";
        echo "<span class='news__date page__text'>".$row['news_date']."</span>";
        echo "<span class='page__text'>Автор: ".$row['news_author']."</span>";
        echo "</div>";
        echo "<a href='".$row['news_link']."' class='news__title page__link'>".$row['news_title']."</a>";
        echo "<p class='news__annotation page__text'>".$row['news_annotation']."</p>";
        echo "<a href='".$row['news_link']."' class='news__link page__link'>Читать далее</a>";
        echo "</div>";
    }
    echo "</div>";
    echo '<a class="left-nav__link left-nav__link--rewiew" href="/news">Все новости</a>';
}