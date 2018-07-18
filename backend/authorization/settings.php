<?php
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-auth.php");
echo "<title>Настройки пользователя</title>";

$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

$user_id = $_SESSION['user']['id'];

if (!isset($_SESSION["user"])) {
  echo "<title>Необходимо войти</title>";
  echo "<div class='good-message good-message--wrong'>";
  echo "<p class='text'>Необходимо войти в аккаунт</p>";
  echo "</div>";
  echo "<div class='notification-wrap'>";
  echo "<a class='link link--green-hover' href='/login'>Вернуться назад</a>";
  echo "</div>";
  header('Refresh: 1; Url=login');
} else {
  if ((isset($_POST['name']) && $_POST['name'] != '') && (isset($_POST['surname']) && $_POST['surname'] != '') && (isset($_POST['phone']) && $_POST['phone'] != '')) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthday = $_POST['birthday'];
    $auto = $_POST['auto'];
    $phone = $_POST['phone'];

    $name = htmlspecialchars($name);
    $surname = htmlspecialchars($surname);
    $birthday = htmlspecialchars($birthday);
    $auto = htmlspecialchars($auto);
    $phone = htmlspecialchars($phone);

    $name = urldecode($name);
    $surname = urldecode($surname);
    $birthday = urldecode($birthday);
    $auto = urldecode($auto);
    $phone = urldecode($phone);

    $name = trim($name);
    $surname = trim($surname);
    $birthday = trim($birthday);
    $auto = trim($auto);
    $phone = trim($phone);

    $querysettings = "INSERT INTO users_settings (user_s_id, user_s_name, user_s_surname, user_s_birthday, user_s_auto, user_s_phone) VALUES ('$user_id', '$name', '$surname', '$birthday', '$auto', '$phone')";
    $ressettings = mysqli_query($connect, $querysettings);

    $messageSuccess = 'Настройка аккаунта завершена!';
    //header('Refresh: 1; Url=profile');

  }
} ?>

<div class="auth__wrapper">
  <div class="auth__content">
    <h2 class="title title-h2 auth__title">Настройки пользователя</h2>
    <div class="auth__form-wrap">
      <form method="post" class="form auth__form">
        <div class="form__input-wrap">
          <input type="text" name="name" required autofocus maxlength="100" class="form__input auth__input"
                 placeholder="Ваше имя">
          <label for="login" class="form__label--shown">Ваше имя</label>
        </div>
        <div class="form__input-wrap">
          <input type="text" name="surname" required maxlength="100" class="form__input auth__input"
                 placeholder="Ваша фамилия">
          <label for="login" class="form__label--shown">Ваша фамилия</label>
        </div>
        <div class="form__input-wrap">
          <input type="text" name="birthday" class="form__input auth__input" placeholder="Дата рождения">
          <label for="login" class="form__label--shown">Дата рождения</label>
        </div>
        <div class="form__input-wrap">
          <input type="text" name="auto" class="form__input auth__input" placeholder="Ваш автомобиль">
          <label for="login" class="form__label--shown">Ваш автомобиль</label>
        </div>
        <div class="form__input-wrap">
          <input type="text" name="phone" required maxlength="12" class="form__input auth__input"
                 placeholder="Ваш телефон">
          <label for="login" class="form__label--shown">Ваш телефон</label>
        </div>

        <button class="button button__zakaz auth__input">Перейти в профиль</button>
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
