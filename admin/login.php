<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
echo "<title>Войти в админ-панель</title>";

$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

if (isset($_SESSION['session_username'])) {
  header('Refresh: 3; Url=intro.php');
}

if ((isset($_POST['login']) && $_POST['login'] != '') && (isset($_POST['password']) && $_POST['password'] != '')) {
  $login = $_POST['login'];
  $password = $_POST['password'];

  $login = htmlspecialchars($login);
  $password = htmlspecialchars($password);

  $login = urldecode($login);
  $password = urldecode($password);

  $login = trim($login);
  $password = trim($password);

  $login = $_REQUEST['login'];
  $password = $_REQUEST['password'];

  $query = "SELECT user_login, user_password FROM users WHERE user_login =" . $login;
  mysqli_query($connect, $query);
  $numrows = mysqli_num_rows($query);

  if ($numrows == 0) {
    while ($row = mysqli_fetch_assoc($query)) {
      $dblogin = $row['login'];
      $dbpassword = $row['password'];
    }

    if ($login = $dblogin) {
      $_SESSION['session_username'] = $login;
      header('Refresh: 3; Url=intro.php');
    }
  } else {
    $message = "Invalid username or password!";
  }
} else {
  $message = "All fields are required!";
}

?>

<div class="admin__container admin__container--center">
  <h1 class="title title-h1">Войти в админ-панель</h1>
  <form action="#" method="post" class="form">
    <span class="form__label">Введите логин:</span>
    <div class="form__input-wrap">
      <input type="text" name="login" required autofocus class="form__input" placeholder="Введите логин">
      <label for="login" class="form__label--shown">Введите логин</label>
    </div>
    <span class="form__label">Введите пароль:</span>
    <div class="form__input-wrap">
      <input type="text" name="password" required class="form__input" placeholder="Введите пароль">
      <label for="password" class="form__label--shown">Введите пароль</label>
    </div>
    <button class="button button__zakaz">Войти</button>
  </form>
</div>

<?php if (!empty($message)) {
  echo "<p class=\"error\">" . "MESSAGE: " . $message . "</p>";
} ?>
