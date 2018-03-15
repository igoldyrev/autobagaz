<?php echo "<title>Запись удален!</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <?php
    $dbname = "9082410193_gallery";
    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

    $id=$_REQUEST['galleryitem'];
    $delete_sql = "DELETE FROM photos WHERE id=$id";
    mysqli_query($connect, $delete_sql) or die("<p class='text'>При удалении записи произошла ошибка</p>". mysqli_error());
    echo "<h3 class='title title-h3'>Запись успешно удалена!</h3>"; ?>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/gallery/gallerydelete/gallerydelete">Вернуться к выбору записей</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>