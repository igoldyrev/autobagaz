<?php session_start();
$titleconst = "Автобагаж - купить автобагажники и автобоксы на крышу автомобиля в Перми - ";
include ($_SERVER["DOCUMENT_ROOT"]."/admin/blocks.php");
?>
<html lang="ru">

<!-- meta tags -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="robots" content="index,follow">

<!-- meta property -->
<meta property="place:location:latitude" content="58.03593904782619">
<meta property="place:location:longitude" content="56.2000031453342">
<meta property="business:contact_data:street_address" content="Ул. Спешилова 102/29">
<meta property="business:contact_data:locality" content="Пермь">
<meta property="business:contact_data:email" content="autobagaz@yandex.ru">
<meta property="business:contact_data:website" content="https://autobagaz.ru">
<meta property="og:url" content="https://autobagaz.ru">
<meta property="og:site_name" content="Автобагаж">

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

<link rel="stylesheet" href="../build/autobagaz.css">
<link rel="stylesheet" href="../src/fa/css/font-awesome.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?139"></script>
<script type="text/javascript">
    VK.init({apiId: 5866168, onlyWidgets: true});
</script>

<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/modal-call/modal-call.html"); ?>
<div class="modal-call__button"><i class="fa fa-phone fa-4x" aria-hidden="true"></i></div>

<?php
$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

if (isset($_GET['logout'])) {
  $login = $_COOKIE['userLogin'];
  setcookie('userString', 'exit', time() - (21600), "/"); //6h
  $queryexit = "UPDATE users SET user_string = '' WHERE user_login = '" . $login . "'";
  $res = mysqli_query($connect, $queryexit);
  header('Refresh: 1; URL=/login');
}
