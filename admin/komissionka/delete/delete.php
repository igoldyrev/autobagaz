<?php echo "<title>Запись удалена!</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
  <?php
  $dbname = "9082410193_zakaz";
  include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

  $id = $_REQUEST['kommitem'];
  $delete_sql = "UPDATE komm_items SET komm_items_status='УДАЛЕН' WHERE komm_items_id=$id";
  mysqli_query($connect, $delete_sql) or die("<p class='text'>При удалении записи произошла ошибка</p>" . mysqli_error());
  echo "<h3 class='title title-h3'>Товар успешно удален!</h3>"; ?>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin/komissionka/delete/itemsdelete">Вернуться к выбору записей</a>
    <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
  </div>
</div>
