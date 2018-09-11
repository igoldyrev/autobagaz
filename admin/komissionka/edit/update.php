<?php echo "<title>Товар обновлен</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html"); ?>

<div class="admin__container">
  <?php
  $dbname = "9082410193_zakaz";
  include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

  $id = $_REQUEST['id'];
  $name = trim($_REQUEST['name']);
  $img0 = trim($_REQUEST['img0']);
  $img1 = trim($_REQUEST['img1']);
  $im2 = trim($_REQUEST['img2']);
  $img3 = trim($_REQUEST['img3']);
  $img4 = trim($_REQUEST['img4']);
  $price = trim($_REQUEST['price']);
  $category = trim($_REQUEST['category']);

  $update_sql = "UPDATE komm_items SET komm_items_name='$name',  komm_items_img0='$img0', komm_items_img1='$img1', komm_items_img2='$img2', komm_items_img3='$img3', komm_items_img4='$img4', komm_items_price='$price', komm_items_group='$category', komm_items_status='ИЗМЕНЕН' WHERE komm_items_id='$id'";
  mysqli_query($connect, $update_sql) or die("Ошибка обновления" . mysqli_error());
  echo '<h3 class="title title-h3">Товар успешно обновлен!</h3>'; ?>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin/komissionka/edit/itemchoice">Вернуться к выбору записи</a>
    <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
  </div>
</div>
