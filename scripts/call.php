<?php
session_start();
$url = $_SESSION['url']; 
// Соединение с БД MySQL
$sql = mysql_connect('localhost', '9082410193', 'GfhjkmDatabase');
mysql_select_db('9082410193_zakaz', $sql);
mysql_query ("set_client='utf8'");//Следующие 2 строки решают проблему с кодировкой.
mysql_query ("SET NAMES utf8");

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

//Создаем запрос в базу данных
$sql_insert = "INSERT INTO calls (name, phone)" . 
"VALUES('{$name}', '{$phone}');";
mysql_query($sql_insert);

$sql_users = "INSERT INTO users (name, phone)" . 
"VALUES('{$name}', '{$phone}');";
mysql_query($sql_users);

if((isset($_POST['name'])&&$_POST['name']!="")&&(isset($_POST['phone'])&&$_POST['phone']!="")){

if (mail("autobagaz@yandex.ru", "Звонок с сайта!!!", 
"Страница с которой пришло письмо ".$_SESSION['url'].";
Имя:".$name.";
Телефон: ".$phone.";

Техническая информация:
Примерный user-agent: ".$_SERVER['HTTP_USER_AGENT'].";
ip-адрес:" .$_SERVER['REMOTE_ADDR'].";
Ссылка на скрипт, с которого пришло письмо:" .$_SERVER['REQUEST_URI'] ,
"From: autobagaz@yandex.ru \r\n"))
 {     	echo "<center><b>Мы Вам обязательно перезвоним!</b><br><br><center>Через 3 секунды Вы будете перенаправлены на предыдущую страницу<br><br>Если этого не произошло, то нажмите на ссылку:<br><a href='"; echo $_SESSION['url']; echo"'>Вернуться назад</a>"; 
header('Refresh: 3; URL='.$url);
} 
else { 
    echo "<center>При отправке данных возникли проблемы :(<br><a href='"; echo $_SESSION['url']; echo "'>Вернуться назад</a>";
}}
else {
	echo "<center>Вы не заполнили одно из обязательных полей формы, вернитесь, пожалуйста, и заполните его<br><a href='"; echo $_SESSION['url']; echo "'>Вернуться назад</a>";
}
unset($_SESSION['url']);
include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html");?>