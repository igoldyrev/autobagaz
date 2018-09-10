<?php echo "<title>Отзыв обновлен</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html"); ?>

<div class="admin__container">
    <?php
    $dbname = "9082410193_zakaz";

    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

    $id=$_REQUEST['id'];
    $name=trim($_REQUEST['name']);
    $phone=trim($_REQUEST['phone']);
    $rewiew=trim($_REQUEST['rewiew']);

    $update_sql = "UPDATE guestbook SET name='$name', phone='$phone', rewiew='$rewiew', status='ИЗМЕНЕН', date=curdate() WHERE id='$id'";
    mysqli_query($connect, $update_sql) or die("Ошибка обновления" . mysqli_error());
    echo '<h3 class="title title-h3">Отзыв успешно обновлен!</h3>'; ?>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/guestbook/update/guestupdate">Вернуться к выбору отзыва</a>
        <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
    </div>
</div>
