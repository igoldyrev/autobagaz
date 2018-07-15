<?php
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.html");
echo "<title>Имя Фамилия - Автобагаж</title>";

$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

$id = $_GET['id'];

if (!isset($id)) {
  if (isset($_SESSION['reguser']['id'])) {
    header('Refresh: 1; Url=profile.php?id=' . $_SESSION['reguser']['id'] . '');
  } else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER["DOCUMENT_ROOT"] . "/backend/errors/403.php");
    exit;
  }
} elseif ($id == $_SESSION['reguser']['id']) {
  echo 'good';
} elseif ($id != $_SESSION['reguser']['id']) {
  echo 'profile';
}


