<?php echo "<title>Добавление категории в комиссионку</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html");

$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");


$name = $_POST['name'];
$name = htmlspecialchars($name);
$name = urldecode($name);
$name = trim($name);
$name = $_REQUEST['name'];

if ((isset($_POST['name']) && $_POST['name'] != "")) {
  $sql_category = "INSERT INTO komm_groups (komm_groups_name, komm_groups_status) VALUES ('$name', 'СОЗДАН')";
  mysqli_query($connect, $sql_category);
  $messageSuccess = 'Категория успешно добавлена!';
} ?>

<div class="admin__container">
  <h1 class="title title-h1">Добавление записи в Комиссионку</h1>

  <div class="form__container">
    <form action="" method="post">
      <span class="form__label">Введите название категории (например, автобагажники):</span>
      <div class="form__input-wrap">
        <input type="text" name="name" required autofocus class="form__input" placeholder="Введите имя категории">
        <label for="name" class="form__label--shown">Введите имя категории</label>
      </div>
      <input class='button button__zakaz' id='submit' type='submit' value='Добавить категорию'>
    </form>
    <?php
    if (!empty($message)) {
      echo "<p class='good-message good-message--wrong'>" . $message . "</p>";
    } elseif (!empty($messageSuccess)) {
      echo "<p class='good-message'>" . $messageSuccess . "</p>";
    } ?>
  </div>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin">Вернуться на главную админки</a>
  </div>
</div>
