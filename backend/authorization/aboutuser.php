<?php
$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

if (!isset($_COOKIE['userString'])) {
  header("HTTP/1.1 401 Unauthorized");
  include($_SERVER["DOCUMENT_ROOT"] . "/backend/errors/401.php");
  exit;
}

if (isset($_COOKIE['userString'])) {
  $cookieString = $_COOKIE['userString'];
  $cookieLogin = $_COOKIE['userLogin'];

  $querystring = "SELECT user_login, user_string FROM users WHERE user_login='" . $cookieLogin . "'";
  $res = mysqli_query($connect, $querystring);

  while ($row = mysqli_fetch_assoc($res)) {
    $dbString = $row['user_string'];
  }

  if ($cookieString != $dbString) {
    header("HTTP/1.1 401 Unauthorized");
    include($_SERVER["DOCUMENT_ROOT"] . "/backend/errors/401.php");
    exit;
  }
}

if (isset($_GET['logout'])) {
  $login = $_COOKIE['userLogin'];
  setcookie('userString', 'exit', time() - (21600), "/"); //6h
  $queryexit = "UPDATE users SET user_string = '' WHERE user_login = '" . $login . "'";
  $res = mysqli_query($connect, $queryexit);
  header('Refresh: 1; URL=/login');
}
