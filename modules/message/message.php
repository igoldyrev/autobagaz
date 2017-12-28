<?php
$sdd_db_host='localhost'; // хост
$sdd_db_name='9082410193_news'; // бд
$sdd_db_user='9082410193'; // пользователь бд
$sdd_db_pass='GfhjkmDatabase'; // пароль к бд
$conn = mysql_connect($sdd_db_host,$sdd_db_user,$sdd_db_pass); // коннект с сервером бд
mysql_query ("set_client='utf8'");//Следующие 2 строки решают проблему с кодировкой.
mysql_query ("SET NAMES utf8");
if(!$conn)
{
    throw new Exception('Не удалось подключиться к базе данных! Проверьте параметры подключения');
}
if(!mysql_select_db($sdd_db_name, $conn)) // выбор бд
{
    throw new Exception("Не удалось выбрать базу данных {$ssd_db_name}!");
}
$result = mysql_query('SELECT * FROM `message` ORDER BY id DESC', $conn); // запрос на выборку
if(!$result)
{
    throw new Exception(sprintf('Не удалось выполнить запрос к БД, код ошибки %d, текст ошибки: %s', mysql_errno($conn), mysql_error($conn)));
}

while ($row = mysql_fetch_assoc($result))
{ ?>
    <div class="index-message">
        <h2 class="index-message__title"><?php echo $row['title'] ?></h2>
        <p class="index-message__text"><?php echo $row['msg'] ?></p>
        <p class="index-message__holiday">С наступающими, Вас, праздниками!</p>
    </div><?php
}