<?php echo "<title>Ответ изменен!</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html"); ?>

<div class="admin__container">
    <?php
    $dbname = "9082410193_zakaz";

    include ($_SERVER["DOCUMENT_ROOT"]."/modules/connectdb.php");

    $id=$_REQUEST['id'];
    $answer=trim($_REQUEST['answer']);

    $update_sql = "UPDATE guestbook SET  answer='$answer' WHERE id='$id'";
    mysqli_query($connect, $update_sql) or die("Ошибка!" . mysqli_error());
    echo '<h3 class="page__title-h3">Ответ изменен!</h3>'; ?>
    <div class="admin__link-down clearfix">
        <a class="admin__link" href="/admin/guestbook/answers/answerchoice.php">Вернуться к выбору отзыва</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>