<?php
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.html");
echo "<title>Зарегистрироваться</title>";

$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

if ((isset($_POST['login']) && $_POST['login'] != '') && (isset($_POST['email']) && $_POST['email'] != '') && (isset($_POST['password']) && $_POST['password'] != '') && (isset($_POST['password-retype']) && $_POST['password-retype'] != '')) {
  if ($_POST['password'] === $_POST['password-retype']) {
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordretype = $_POST['password-retype'];

    $login = htmlspecialchars($login);
    $useremail = htmlspecialchars($email);

    $login = urldecode($login);
    $useremail = urldecode($email);

    $login = trim($login);
    $useremail = trim($email);

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $querylogin = "SELECT user_login FROM users WHERE user_login='" . $login . "'";
    $reslogin = mysqli_query($connect, $querylogin);
    $numrows = mysqli_num_rows($reslogin);

    include($_SERVER["DOCUMENT_ROOT"] . "/backend/scripts/mails.php");

    if ($numrows == 0) {
      $queryemail = "SELECT user_email FROM users WHERE user_email='" . $useremail . "'";
      $resemail = mysqli_query($connect, $queryemail);
      $numrowsemail = mysqli_num_rows($resemail);

      if ($numrowsemail == 0) {
        $sqladd = "INSERT INTO users (user_login, user_email, user_hash) VALUES ('$login', '$useremail', '$passwordHash')";
        $resadd = mysqli_query($connect, $sqladd);

        mail($useremail, "Регистрация на сайте autobagaz.ru", $registrationmail, "From: autobagaz@yandex.ru \r\n");
        mail("goldirev12@mail.ru", "Новая регистрация на сайте autobagaz.ru", $registrationmailme, "From: autobagaz@yandex.ru \r\n");
        $messageSuccess = 'Вы успешно зарегистрированы!';
      } else {
        $message = 'Такой email уже зарегистрирован';
      }
    } else {
      $message = 'Такой логин уже зарегистрирован';
    }
  } else {
    $message = 'Введенные пароли не совпадают!';
  }
}
?>

<div class="auth__wrapper">
  <div class="auth__content">
    <h2 class="title title-h2 auth__title">Регистрация</h2>
    <div class="auth__form-wrap">
      <form action="" method="post" class="form auth__form">
        <span class="form__label">Придумайте имя пользователя:</span>
        <div class="form__input-wrap">
          <input type="text" name="login" required autofocus maxlength="30" class="form__input auth__input"
                 placeholder="На латинице, не более 30 символов">
          <label for="login" class="form__label--shown">На латинице, не более 30 символов</label>
        </div>
        <span class="form__label">Электронная почта:</span>
        <div class="form__input-wrap">
          <input type="email" name="email" required class="form__input auth__input" placeholder="name@domain.ru">
          <label for="login" class="form__label--shown">name@domain.ru</label>
        </div>
        <span class="form__label">Придумайте пароль:</span>
        <div class="form__input-wrap">
          <input type="password" name="password" required maxlength="30" class="form__input auth__input"
                 placeholder="Латинские буквы и цифры, не более 30 символов">
          <label for="login" class="form__label--shown">Латинские буквы и цифры, не более 30 символов</label>
        </div>
        <span class="form__label">Повторите пароль:</span>
        <div class="form__input-wrap">
          <input type="password" name="password-retype" required maxlength="30" class="form__input auth__input"
                 placeholder="Повторите пароль еще раз">
          <label for="login" class="form__label--shown">Повторите пароль еще раз</label>
        </div>
        <button class="button button__zakaz auth__input">Зарегистрироваться</button>
        <p class="text auth__license">Нажимая кнопку «Зарегистрироваться» вы соглашаетесь с <a
            class="link auth__license" href="/user-agreement">Пользовательским соглашением</a> и даете согласие на
          обработку персональных данных.</p>
        <p class="text auth__license">Уже есть аккаунт? <a class="link auth__license" href="/login">Войти</a></p>
      </form>
    </div>
  </div>
  <?php
  if (!empty($message)) {
    echo "<p class='good-message good-message--wrong auth__error'>" . $message . "</p>";
  } elseif (!empty($messageSuccess)) {
    echo "<p class='good-message auth__error'>" . $messageSuccess . "</p>";
  } ?>
</div>
<div class="auth__footer">
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html"); ?>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html"); ?>
