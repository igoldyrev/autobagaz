<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php"); ?>

<div class="wrapper">
  <div class="wrapper__content">
    <?php
    $url = $_SESSION['url'];
    $recaptcha = $_POST['g-recaptcha-response'];

    if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
      $secret = '6LenJjcUAAAAABdHEQwyLXTrML44hGMRy82nYjYJ';
      $ip = $_SERVER['REMOTE_ADDR'];
      $response = $_POST['g-recaptcha-response'];
      $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
      $arr = json_decode($rsp, TRUE);

      if ($arr['success']) {
        // Соединение с БД MySQL
        $dbname = "9082410193_zakaz";
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

        //В файле на первом этапе нужно принять данные из пост массива. Для этого создаем переменные
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        //Первая функция преобразует все символы, которые пользователь попытается добавить в форму
        $name = htmlspecialchars($name);
        $phone = htmlspecialchars($phone);
        //Вторая функция декодирует url, если пользователь попытается его добавить в форму
        $name = urldecode($name);
        $phone = urldecode($phone);
        //Третьей функцией мы удалим пробелы с начала и конца строки, если таковые имеются
        $name = trim($name);
        $phone = trim($phone);
        //Заносим данные из формы в переменные
        $name = $_REQUEST['name'];
        $phone = $_REQUEST['phone'];

        include($_SERVER["DOCUMENT_ROOT"] . "/backend/scripts/mails.php");

        if((isset($_POST['name'])&&$_POST['name']!="")&&(isset($_POST['phone'])&&$_POST['phone']!="")){
          if (mail($email, "Звонок с сайта!!!", $call, "From: autobagaz@yandex.ru \r\n")) {
            echo "<title>Вам обязательно перезвоним!</title>";
            echo "<div class='good-message'>";
            echo "<p class='text'>Мы Вам обязательно перезвоним!</p>";
            echo "</div>";
            echo "<div class='notification-wrap'>";
            echo "<p class='text'>Через 5 секунд Вы будете перенаправлены на предыдущую страницу</p>";
            echo "<p class='text'>Если этого не произошло, то нажмите на ссылку:</p>";
            echo "<a class='link link--green-hover' href='" . $url . "'>Вернуться назад</a>";
            echo "</div>";
            header('Refresh: 5; URL=' . $url);
          } else {
            echo "<title>При отправке данных возникли проблемы</title>";
            echo "<div class='good-message good-message--wrong'>";
            echo "<p class='text'>При отправке данных возникли проблемы :(</p>";
            echo "</div>";
            echo "<div class='notification-wrap'>";
            echo "<a class='link link--green-hover' href='" . $url . "'>Вернуться назад</a>";
            echo "</div>";
          }
        } else {
          echo "<title>Вы не заполнили одно из полей формы</title>";
          echo "<div class='good-message good-message--wrong'>";
          echo "<p class='text'>Вы не заполнили одно из обязательных полей формы, вернитесь, пожалуйста, и заполните его</p>";
          echo "</div>";
          echo "<div class='notification-wrap'>";
          echo "<a class='link link--green-hover' href='" . $url . "'>Вернуться назад</a>";
          echo "</div>";
        }
      } else {
        echo "<title>Вы неправильно ввели  капчу</title>";
        echo "<div class='good-message good-message--wrong'>";
        echo "<p class='text'>Вы неправильно ввели  капчу, вернитесь, пожалуйста, и введите правильно</p>";
        echo "</div>";
        echo "<div class='notification-wrap'>";
        echo "<a class='link link--link-hover' href='" . $url . "'>Вернуться назад</a>";
        echo "</div>";
      }
    } else {
      echo "<title>Вы не ввели  капчу</title>";
      echo "<div class='good-message good-message--wrong'>";
      echo "<p class='text'>Вы не ввели  капчу, вернитесь, пожалуйста, и введите её</p>";
      echo "</div>";
      echo "<div class='notification-wrap'>";
      echo "<a class='link link--green-hover' href='" . $url . "'>Вернуться назад</a>";
      echo "</div>";
    }
    unset($_SESSION['url']); ?>
  </div>
</div>
<?php  include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
