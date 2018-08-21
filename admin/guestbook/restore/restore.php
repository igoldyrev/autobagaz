<?php echo "<title>Отзыв восстановлен!</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
  <?php
  $dbname = "9082410193_zakaz";

  include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

  $id = $_REQUEST['rewiew'];
  $delete_sql = "UPDATE guestbook SET status='ВОССТАНОВЛЕН', date=curdate() WHERE id=$id";
  mysqli_query($connect, $delete_sql) or die("<p class='text'>При восстановлении отзыва произошла ошибка</p>" . mysqli_error());
  echo "<h3 class='title title-h3'>Отзыв успешно восстановлен!</h3>";
  ?>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin/guestbook/restore/guestrestore">Вернуться к выбору отзывов</a>
    <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
  </div>
</div>
