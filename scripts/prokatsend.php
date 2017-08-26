<?php
session_start();
if (isset($_POST['captcha']) && $_POST['captcha'] == $_SESSION['keystring']){
// Соединение с БД MySQL
//$sql = mysql_connect('localhost', '9082410193', 'GfhjkmDatabase');
//mysql_select_db('9082410193_zakaz', $sql);
//mysql_query ("set_client='utf8'");//Следующие 2 строки решают проблему с кодировкой.
//mysql_query ("SET NAMES utf8");

//В файле на первом этапе нужно принять данные из пост массива. Для этого создаем переменные
$name = $_POST['name'];
$phone = $_POST['phone'];
$equipment = $_POST['equipment'];
$time = $_POST['time'];
$text = $_POST['text'];
//Первая функция преобразует все символы, которые пользователь попытается добавить в форму
$name = htmlspecialchars($name);
$phone = htmlspecialchars($phone);
$equipment = htmlspecialchars($equipment);
$time = htmlspecialchars($time);
$text = htmlspecialchars($text);
//Вторая функция декодирует url, если пользователь попытается его добавить в форму
$name = urldecode($name);
$phone = urldecode($phone);
$equipment = urldecode($equipment);
$time = urldecode($time);
$text = urldecode($text);
//Третьей функцией мы удалим пробелы с начала и конца строки, если таковые имеются
$name = trim($name);
$phone = trim($phone);
$equipment = trim($equipment);
$time = trim($time);
$text = trim($text);
//Заносим данные из формы в переменные
$name = $_REQUEST['name'];
$phone = $_REQUEST['phone'];
$equipment = $_REQUEST['equipment'];
$time = $_REQUEST['time'];
$text = $_REQUEST['text'];
//Создаем запрос в базу данных
//$sql_insert = "INSERT INTO zakaz (name, phone, auto, kuzov, year, text)" . 
//"VALUES('{$name}', '{$phone}', '{$auto}', '{$kuzov}', '{$year}', '{$text}');";
//mysql_query($sql_insert);

//$sql_users = "INSERT INTO users (name, phone)" . 
//"VALUES('{$name}', '{$phone}');";
//mysql_query($sql_users);



if((isset($_POST['name'])&&$_POST['name']!="")&&(isset($_POST['phone'])&&$_POST['phone']!="")&&(isset($_POST['equipment'])&&$_POST['equipment']!="")&&(isset($_POST['time'])&&$_POST['time']!="")&&(isset($_POST['text'])&&$_POST['text']!="")){

if (mail("goldirev12@yandex.ru", "Заказ оборудования в прокат", 
"Заказан товар ".$_SESSION['tovar'].";
Имя:".$name.";
Телефон: ".$phone.";
Оборудование: ".$equipment.";
Срок: ".$time.";
Дополнительная информация: ".$text.";

Техническая информация:
Примерный user-agent: ".$_SERVER['HTTP_USER_AGENT'].";
ip-адрес:" .$_SERVER['REMOTE_ADDR'].";
Ссылка на скрипт, с которого пришло письмо:" .$_SERVER['REQUEST_URI'] ,
"From: goldirev12@yandex.ru \r\n"))
 {     	echo "<center><b>Вы успешно забронировали оборудование! Мы с Вами свяжемся в ближайшее время!</b><br><br><center>Через 5 секунд Вы будете перенаправлены на страницу проката<br><br>Если этого не произошло, то нажмите на ссылку:<br><a href='/prokat.php'>Вернуться назад</a>"; 
header('Refresh: 5; URL=/prokat.php');
} 
else { 
    echo "<center>При бронировании возникли проблемы :(<br><a href='/prokat'>Вернуться назад</a>";
}}
else {
	echo "<center>Вы не заполнили одно или несколько из обязательных полей формы, вернитесь, пожалуйста, и заполните его<br><a href='/prokat'>Вернуться назад</a>";
}
}
else{
    echo "<center>Вы неправильно ввели числа с картинки, вернитесь, пожалуйста, и введите их правильно<br><br><a href='/prokat.php'>Вернуться назад</a>";
}
unset($_SESSION['tovar']);
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html");?>