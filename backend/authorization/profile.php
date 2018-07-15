<?php
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.html");

$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

$id = $_GET['id'];

if (!isset($id)) {
  echo "<title>Ошибка доступа</title>";
  if (isset($_SESSION['user']['id'])) {
    header('Refresh: 1; Url=profile.php?id=' . $_COOKIE['userId'] . '');
  } else {
    echo "<title>Ошибка доступа</title>";
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER["DOCUMENT_ROOT"] . "/backend/errors/403.php");
    exit;
  }
} elseif ($id == $_COOKIE['userId']) {
  $queryProfile = "SELECT * FROM users_settings WHERE user_s_id='" . $_COOKIE['userId'] . "'";
  $resProfile = mysqli_query($connect, $queryProfile);

  while ($row = mysqli_fetch_assoc($resProfile)) {
    $dbName = $row['user_s_name'];
    $dbSurname = $row['user_s_surname'];
    $dbBirthday = $row['user_s_birthday'];
    $dbAuto = $row['user_s_auto'];
  }
  echo "<title>" . $dbName . " " . $dbSurname . " - Автобагаж</title>"; ?>

  <div class="auth__wrapper">
    <div class="auth__content">
      <h2 class="title title-h2 auth__title">Профиль пользователя <?php echo $dbName;
        echo ' ';
        echo $dbSurname; ?></h2>
      <div class="auth__form-wrap auth__form">
        <p class="text">День рождения: <?php echo $dbBirthday; ?></p>
        <p class="text">На чем ездит: <?php echo $dbAuto; ?></p>
      </div>
    </div>
  </div>
  <div class="auth__footer">
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html"); ?>
  </div>
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html"); ?>

  <?php
} elseif ($id != $_COOKIE['userId']) {
  $queryProfileAnother = "SELECT * FROM users_settings WHERE user_s_id='" . $id . "'";
  $resProfile = mysqli_query($connect, $queryProfileAnother);

  while ($row = mysqli_fetch_assoc($resProfile)) {
    $dbName = $row['user_s_name'];
    $dbSurname = $row['user_s_surname'];
    $dbBirthday = $row['user_s_birthday'];
    $dbAuto = $row['user_s_auto'];
  }
  echo "<title>" . $dbName . " " . $dbSurname . " - Автобагаж</title>"; ?>

  <div class="auth__wrapper">
    <div class="auth__content">
      <h2 class="title title-h2 auth__title">Профиль пользователя <?php echo $dbName;
        echo ' ';
        echo $dbSurname; ?></h2>
      <div class="auth__form-wrap auth__form">
        <p class="text">День рождения: <?php echo $dbBirthday; ?></p>
        <p class="text">На чем ездит: <?php echo $dbAuto; ?></p>
      </div>
    </div>
  </div>
  <div class="auth__footer">
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html"); ?>
  </div>
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html");
}


