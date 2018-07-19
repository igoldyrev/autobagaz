<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-auth.php"); ?>

<div class="auth__wrapper">
  <div class="auth__content">

    <?php
    if (!isset($_COOKIE['userString'])) {

      echo "<title>Необходимо войти</title>";
      echo "<div class='good-message good-message--wrong'>";
      echo "<p class='text'>Необходимо войти в аккаунт</p>";
      echo "</div>";
      echo "<div class='notification-wrap'>";
      echo "<a class='link link--green-hover' href='/login'>Вернуться назад</a>";
      echo "</div>";

      header('Refresh: 1; Url=login');
    } elseif ($_COOKIE['userRank'] == '2') {
      echo "<title>Здравствуйте, " . $_COOKIE['userLogin'] . "</title>";
      echo "<div class='good-message'>";
      echo "<p class='text'>Здравствуйте, " . $_COOKIE['userLogin'] . "</p>";
      echo "</div>";
      echo "<div class='notification-wrap'>";
      echo "<p class='text'>Через 3 секунды Вы будете перенаправлены на страницу админки</p>";
      echo "<p class='text'>Если этого не произошло, то нажмите на ссылку:</p>";
      echo "<a class='link link--green-hover' href='/admin'>Перейти в админку</a>";
      echo "</div>";
      header('Refresh: 3; URL=/admin');
    } else {
      echo "<title>Здравствуйте, " . $_COOKIE['userLogin'] . "</title>";
      echo "<div class='good-message'>";
      echo "<p class='text'>Здравствуйте, " . $_COOKIE['userLogin'] . "</p>";
      echo "</div>";
      echo "<div class='notification-wrap'>";
      echo "<p class='text'>Через 3 секунды Вы будете перенаправлены на главную страницу</p>";
      echo "<p class='text'>Если этого не произошло, то нажмите на ссылку:</p>";
      echo "<a class='link link--green-hover' href='/'>Перейти</a>";
      echo "</div>";
      header('Refresh: 3; URL=/');
    } ?>

  </div>
</div>
<div class="auth__footer">
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html"); ?>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html"); ?>



