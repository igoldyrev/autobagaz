<?php echo "<title>Отзыв обновлен</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <?php
    $dbname = "9082410193_zakaz";

    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

    $id=$_REQUEST['id'];
    $name=trim($_REQUEST['name']);
    $phone=trim($_REQUEST['phone']);
    $rewiew=trim($_REQUEST['rewiew']);

    $update_sql = "UPDATE guestbook SET name='$name', phone='$phone', rewiew='$rewiew' WHERE id='$id'";
    mysqli_query($connect, $update_sql) or die("Ошибка обновления" . mysqli_error());
    echo '<h3 class="title title-h3">Отзыв успешно обновлен!</h3>'; ?>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/guestbook/update/guestupdate.php">Вернуться к выбору отзыва</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>