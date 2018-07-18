<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
echo "<title>Войти</title>";

$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

if ((isset($_POST['login']) && $_POST['login'] != '') && (isset($_POST['password']) && $_POST['password'] != '')) {
  $login = $_POST['login'];
  $password = $_POST['password'];

  $login = htmlspecialchars($login);
  $login = urldecode($login);
  $login = trim($login);
  $login = $_REQUEST['login'];

  $querylogin = "SELECT user_login, user_hash, user_rank FROM users WHERE user_login='" . $login . "'";
  $res = mysqli_query($connect, $querylogin);
  $numrows = mysqli_num_rows($res);

  if ($numrows != 0) {
    while ($row = mysqli_fetch_assoc($res)) {
      $dblogin = $row['user_login'];
      $dbHash = $row['user_hash'];
      $dbRank = $row['user_rank'];
      $dbId = $row['user_id'];
    }
    $dbHash = substr($dbHash, 0, 60);

    if ($login = $dblogin) {
      if (password_verify($password, $dbHash)) {
        function generateRandomString($length = 32)
        {
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
          return $randomString;
        }

        $randomUserString = generateRandomString();
        $queryString = "UPDATE users SET user_string='$randomUserString' WHERE user_login='$login'";
        $resString = mysqli_query($connect, $queryString);

        $cookieNameLogin = "userLogin";
        $cookieValueLogin = $login;

        $cookieNameString = "userString";
        $cookieValueString = $randomUserString;

        $cookieNameId = "userId";
        $cookieValueId = $dbId;

        $cookieNameRank = "userRank";
        $cookieValueRank = $dbRank;

        setcookie($cookieNameLogin, $cookieValueLogin, time() + (21600), "/"); //6h
        setcookie($cookieNameString, $cookieValueString, time() + (21600), "/"); //6h
        setcookie($cookieNameId, $cookieValueId, time() + (21600), "/"); //6h
        setcookie($cookieNameRank, $cookieValueRank, time() + (21600), "/"); //6h

        header('Refresh: 1; Url=intro');
      } else {
        $message = "Введенный пароль неверный!";
      }
    }
  } else {
    $message = "Такого пользователя не существует";
  }
} ?>

<div class="auth__wrapper">
  <div class="auth__content">
    <h2 class="title title-h2 auth__title">Войти</h2>
    <div class="auth__form-wrap">
      <form method="post" class="form auth__form">
        <div class="form__input-wrap">
          <input type="text" name="login" required autofocus maxlength="30" class="form__input auth__input"
                 placeholder="Введите логин">
          <label for="login" class="form__label--shown">Введите логин</label>
        </div>
        <div class="form__input-wrap">
          <input type="password" name="password" required maxlength="30" class="form__input auth__input"
                 placeholder="Введите пароль">
          <label for="password" class="form__label--shown">Введите пароль</label>
        </div>
        <button class="button button__zakaz auth__input">Войти</button>
        <a href="/reset-password" class="link auth__license auth__center">Забыли пароль?</a>
        <p class="text auth__license">Нет аккаунта? <a class="link auth__license" href="/registration">Зарегистрироваться</a>
        </p>
      </form>
    </div>
  </div>
  <?php
  if (!empty($message)) {
    echo "<p class='good-message good-message--wrong auth__error'>" . $message . "</p>";
  } ?>
</div>
<div class="auth__footer">
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html"); ?>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html"); ?>
