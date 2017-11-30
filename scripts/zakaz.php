<?php
session_start();
$recaptcha = $_POST['g-recaptcha-response'];
$url = $_SESSION['url'];
if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']){
    $secret = '6LenJjcUAAAAABdHEQwyLXTrML44hGMRy82nYjYJ';
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = $_POST['g-recaptcha-response'];
    $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
    //var_dump($rsp);
    $arr = json_decode($rsp, TRUE);
    if($arr['success']) {
        // Соединение с БД MySQL
        $sql = mysql_connect('localhost', '9082410193', 'GfhjkmDatabase');
        mysql_select_db('9082410193_zakaz', $sql);
        mysql_query ("set_client='utf8'");//Следующие 2 строки решают проблему с кодировкой.
        mysql_query ("SET NAMES utf8");

        //В файле на первом этапе нужно принять данные из пост массива. Для этого создаем переменные
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $auto = $_POST['auto'];
        $kuzov = $_POST['kuzov'];
        $year = $_POST['year'];
        $text = $_POST['text'];
        //Первая функция преобразует все символы, которые пользователь попытается добавить в форму
        $name = htmlspecialchars($name);
        $phone = htmlspecialchars($phone);
        $auto = htmlspecialchars($auto);
        $kuzov = htmlspecialchars($kuzov);
        $year = htmlspecialchars($year);
        $text = htmlspecialchars($text);
        //Вторая функция декодирует url, если пользователь попытается его добавить в форму
        $name = urldecode($name);
        $phone = urldecode($phone);
        $auto = urldecode($auto);
        $kuzov = urldecode($kuzov);
        $year = urldecode($year);
        $text = urldecode($text);
        //Третьей функцией мы удалим пробелы с начала и конца строки, если таковые имеются
        $name = trim($name);
        $phone = trim($phone);
        $auto = trim($auto);
        $kuzov = trim($kuzov);
        $year = trim($year);
        $text = trim($text);
        //Заносим данные из формы в переменные
        $name = $_REQUEST['name'];
        $phone = $_REQUEST['phone'];
        $auto = $_REQUEST['auto'];
        $kuzov = $_REQUEST['kuzov'];
        $year = $_REQUEST['year'];
        $text = $_REQUEST['text'];

        //Создаем запрос в базу данных
        $sql_users = "INSERT INTO users (name, phone)" .
            "VALUES('{$name}', '{$phone}');";
        mysql_query($sql_users);

        if((isset($_POST['name'])&&$_POST['name']!="")&&(isset($_POST['phone'])&&$_POST['phone']!="")){

            if (mail("autobagaz@yandex.ru", "Заказ товара с сайта",
                "Заказан товар ".$_SESSION['tovar'].";
    Имя:".$name.";
	Телефон: ".$phone.";
	Марка машины: ".$auto.";
	Тип кузова: ".$kuzov.";
	Год выпуска: ".$year.";
	Текст заказа: ".$text.";

	Техническая информация:
	Примерный user-agent: ".$_SERVER['HTTP_USER_AGENT'].";
	ip-адрес:" .$_SERVER['REMOTE_ADDR'].";
	Ссылка на скрипт, с которого пришло письмо:" .$_SERVER['REQUEST_URI'] ,           "From: autobagaz@yandex.ru \r\n"))
            {     	echo "<center><b>Ваш заказ успешно отправлен!</b><br><br><center>Через 3 секунды Вы будете перенаправлены на предыдущую страницу<br><br>Если этого не произошло, то нажмите на ссылку:<br><a href='".$url; echo "'>Вернуться назад</a>";
                header('Refresh: 3; URL='.$url);
            }
            else {
                echo "<center>При отправке заказа возникли проблемы :(<br><a href='".$url; echo "'>Вернуться назад</a>";
            }}
        else {
            echo "<center>Вы не заполнили одно из обязательных полей формы, вернитесь, пожалуйста, и заполните его<br><a href='".$url; echo "'>Вернуться назад</a>";
        }
    } else {
        echo "<center>Вы неправильно ввели  капчу, вернитесь, пожалуйста, и введите правильно<br><br><a href='".$url; echo "'>Вернуться назад</a>";
    }
}
else {
    echo "<center>Вы не ввели  капчу, вернитесь, пожалуйста, и введите её<br><br><a href='".$url; echo "'>Вернуться назад</a>";
}

unset($_SESSION['tovar']);
unset($_SESSION['url']);
include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html");?>