<?php echo "<title>Выбор записи для восстановления</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
  <h1 class="title title-h1">Выбор записи для восстановления</h1>

  <?php
  $dbname = "9082410193_zakaz";
  include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php"); ?>

  <div class="form__container">
    <form action="/admin/gallery/galleryrestore/restore" method="post">
      <?php
      $select_sql = "SELECT id, name, date, status FROM gallery INNER JOIN status ON gallery.status = status.status_name AND status.status_name = 'УДАЛЕН'";
      $result = mysqli_query($connect, $select_sql);
      $row = mysqli_fetch_array($result);

      do {
        printf("<div class='admin__item'><input class='admin__radio' type='radio' name='galleryitem' value='%s'>%s", $row['id'], '<span class="text">' . $row['date'] . '</span><span class="text">: </span><span class="text">' . $row['name'] . '</span></div>');
      } while ($row = mysqli_fetch_array($result))
      ?>
      <input class="button button__zakaz" type="submit" value="Восстановить запись">
    </form>
  </div>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
  </div>
</div>
