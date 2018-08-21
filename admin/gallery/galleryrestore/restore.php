<?php echo "<title>Запись восстановлена!</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
  <?php
  $dbname = "9082410193_zakaz";
  include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

  $id = $_REQUEST['galleryitem'];
  $delete_sql = "UPDATE gallery SET status='ВОССТАНОВЛЕН' WHERE id=$id";
  mysqli_query($connect, $delete_sql) or die("<p class='text'>При восстановлении записи произошла ошибка</p>" . mysqli_error());
  echo "<h3 class='title title-h3'>Запись успешно восстановлена!</h3>"; ?>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin/gallery/galleryrestore/galleryrestore">Вернуться к выбору записей</a>
    <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
  </div>
</div>
