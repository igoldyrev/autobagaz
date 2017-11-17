<?php
$sdd_db_host='localhost'; // хост
$sdd_db_name='9082410193_zakaz'; // бд
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
$result = mysql_query('SELECT * FROM `guestbook` ORDER BY id DESC LIMIT 5', $conn); // запрос на выборку
if(!$result)
{
    throw new Exception(sprintf('Не удалось выполнить запрос к БД, код ошибки %d, текст ошибки: %s', mysql_errno($conn), mysql_error($conn)));
}

echo "<h2 class='page__title-h2'>Последние отзывы о нас</h2>";
while($row = mysql_fetch_array($result))
{
    echo '<div class="rewiew">';
    echo '<div class="rewiew__name">';
    echo '<span>'.$row['name'].'</span>';
    echo '</div>';
    echo '<div class="rewiew__text">';
    echo '<p class="page__text page__text--rewiew">'.$row['rewiew'].'</p>';
    echo '</div>';
    echo '</div>';
}?>
<a href="/guestbook" class="left-nav left-nav__link left-nav__link--rewiew">Смотреть все отзывы</a>
