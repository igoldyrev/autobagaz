<?php echo "<title>Запись обновлена</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <?php
    $dbname = "9082410193_gallery";
    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

    $id=$_REQUEST['id'];
    $name=trim($_REQUEST['name']);
    $tag1=trim($_REQUEST['tag1']);
    $tag2=trim($_REQUEST['tag2']);
    $tag3=trim($_REQUEST['tag3']);

    $update_sql = "UPDATE photos SET name='$name', tag1='$tag1', tag2='$tag2', tag3='$tag3' WHERE id='$id'";
    mysqli_query($connect, $update_sql) or die("Ошибка обновления" . mysqli_error());
    echo '<h3 class="title title-h3">Запись успешно обновлена!</h3>'; ?>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/gallery/galleryedit/galleryedit">Вернуться к выбору записи</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>