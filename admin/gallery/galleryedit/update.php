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
    $img0=trim($_REQUEST['img0']);
    $img1=trim($_REQUEST['img1']);
    $im2=trim($_REQUEST['img2']);
    $img3=trim($_REQUEST['img3']);
    $img4=trim($_REQUEST['img4']);
    $img5=trim($_REQUEST['img5']);
    $img6=trim($_REQUEST['img6']);
    $img7=trim($_REQUEST['img7']);
    $img8=trim($_REQUEST['img8']);
    $img9=trim($_REQUEST['img9']);

    $update_sql = "UPDATE photos SET name='$name', tag1='$tag1', tag2='$tag2', tag3='$tag3', img0='$img0', img1='$img1', img2='$img2', img3='$img3', img4='$img4', img5='$img5', img5='$img5', img6='$img6', img7='$img7', img8='$img8', img9='$img9' WHERE id='$id'";
    mysqli_query($connect, $update_sql) or die("Ошибка обновления" . mysqli_error());
    echo '<h3 class="title title-h3">Запись успешно обновлена!</h3>'; ?>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/gallery/galleryedit/galleryedit">Вернуться к выбору записи</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>