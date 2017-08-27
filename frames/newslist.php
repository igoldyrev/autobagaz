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
$result = mysql_query('SELECT * FROM `news` ORDER BY news_id DESC LIMIT 5', $conn); // запрос на выборку
if(!$result)
{
    throw new Exception(sprintf('Не удалось выполнить запрос к БД, код ошибки %d, текст ошибки: %s', mysql_errno($conn), mysql_error($conn)));
}

while($row = mysql_fetch_array($result))
{
    echo '<table class="newslist">
			<tr>		
				<td width="100px" class="newslist">'.$row['news_date'].'</td>
				<td class="newslist"><a href="'.$row['news_link'].'">'.$row['news_title'].'</a></td>	
			</tr>
		</table>';// выводим данные
}
echo '<center><a href="news.php">Архив новостей</a></center>';
?>