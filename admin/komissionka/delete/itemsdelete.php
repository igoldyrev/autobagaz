<?php echo "<title>Выбор товара для удаления</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html"); ?>

<div class="admin__container">
  <h1 class="title title-h1">Выбор товара для удаления</h1>

  <?php
  $dbname = "9082410193_zakaz";
  include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php"); ?>

  <div class="form__container">
    <form action="/admin/komissionka/delete/delete" method="post">
      <?php
      $select_sql = "SELECT komm_items_id, komm_items_name, komm_items_status FROM komm_items INNER JOIN status ON komm_items.komm_items_status = status.status_name AND status.status_name <> 'УДАЛЕН'";
      $result = mysqli_query($connect, $select_sql);
      $row = mysqli_fetch_array($result);

      do {
        printf("<div class='admin__item'><input class='admin__radio' type='radio' name='kommitem' value='%s'>%s", $row['komm_items_id'], '<span class="text">' . $row['komm_items_name'] . '</span></div>');
      } while ($row = mysqli_fetch_array($result))
      ?>
      <input class="button button__zakaz" type="submit" value="Удалить товар">
    </form>
  </div>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
  </div>
</div>
