<?php echo "<title>Товар восстановлен!</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html"); ?>

<div class="admin__container">
  <?php
  $dbname = "9082410193_zakaz";
  include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

  $id = $_REQUEST['kommitem'];
  $delete_sql = "UPDATE komm_items SET komm_items_status='ВОССТАНОВЛЕН' WHERE komm_items_id=$id";
  mysqli_query($connect, $delete_sql) or die("<p class='text'>При восстановлении записи произошла ошибка</p>" . mysqli_error());
  echo "<h3 class='title title-h3'>Товар успешно восстановлен!</h3>"; ?>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin/komissionka/restore/itemsrestore">Вернуться к выбору товара для
      восстановления</a>
    <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
  </div>
</div>
