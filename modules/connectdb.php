<?php
$connect = mysqli_connect("localhost", "9082410193", "GfhjkmDatabase", "$dbname");
if ($connect->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $connect->connect_errno . ") " . $connect->connect_error;
}

/* изменение набора символов на utf8 */
if (!$connect->set_charset("utf8")) {
    exit();
} else {
    $connect->character_set_name();
}