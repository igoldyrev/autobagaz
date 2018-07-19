<?php
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-auth.php");
echo "<title>Восстановление пароля</title>";

$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

if ((isset($_POST['email']) && $_POST['email'] != '')) {
  $restoreEmail = $_POST['email'];
  $queryRestoreEmail = "SELECT user_login, user_email, user_hash FROM users WHERE user_email='" . $restoreEmail . "'";
  $resRestoreEmail = mysqli_query($connect, $queryRestoreEmail);
  $numrows = mysqli_num_rows($resRestoreEmail);

  if ($numrows != 0) {
    function generateNewPassword($length = 10)
    {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }

    $newPassword = generateNewPassword();
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

    include($_SERVER["DOCUMENT_ROOT"] . "/backend/scripts/mails.php");

    $queryNewPassword = "UPDATE users SET user_hash='$newPasswordHash' WHERE user_email='$restoreEmail'";
    $resNewPassword = mysqli_query($connect, $queryNewPassword);

    mail($restoreEmail, "Восстановление пароля на autobagaz.ru", $resetpasswordmail, "From: autobagaz@yandex.ru \r\n");
    $messageSuccess = 'Сообщение с новым наролем успешно отправлено!';
    header('Refresh: 1; Url=login');
  } else {
    $messageWrong = 'Такой email не зарегистрирован!';
  }
} ?>

<div class="auth__wrapper">
  <div class="auth__content">
    <h2 class="title title-h2 auth__title">Восстановление пароля</h2>
    <div class="auth__form-wrap">
      <form method="post" class="form auth__form">
        <span class="form__label">Ваш email:</span>
        <div class="form__input-wrap">
          <input type="email" name="email" required autofocus class="form__input auth__input"
                 placeholder="Введите ваш email">
          <label for="login" class="form__label--shown">Введите ваш email</label>
        </div>
        <button class="button button__zakaz auth__input">Восстановить пароль</button>
      </form>
    </div>
  </div>
  <?php
  if (!empty($messageSuccess)) {
    echo "<p class='good-message auth__error'>" . $messageSuccess . "</p>";
  } elseif (!empty($messageWrong)) {
    echo "<p class='good-message good-message--wrong auth__error'>" . $messageWrong . "</p>";
  } ?>
</div>
<div class="auth__footer">
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html"); ?>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html"); ?>
