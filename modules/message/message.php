<?php
$dbname = "9082410193_news";

include ($_SERVER["DOCUMENT_ROOT"]."/modules/connectdb.php");

$query = "SELECT * FROM `message` ORDER BY id DESC";

if ($result = mysqli_query($connect, $query)) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="index-message">';
        echo '<h2 class="index-message__title">'.$row['title'].'</h2>';
            echo '<p class="index-message__text">'.$row['msg'].'</p>';
            echo '<p class="index-message__holiday">'.$row['holiday'].'</p>';
        echo '</div>';
    }
}