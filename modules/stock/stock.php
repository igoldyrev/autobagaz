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
$result = mysql_query('SELECT * FROM `news` ORDER BY news_id DESC LIMIT 1', $conn); // запрос на выборку
if(!$result)
{
    throw new Exception(sprintf('Не удалось выполнить запрос к БД, код ошибки %d, текст ошибки: %s', mysql_errno($conn), mysql_error($conn)));
}

while ($row = mysql_fetch_assoc($result))
{ ?>
    <div class="stock__container">
    <div class="stock__bg"></div>
    <div class="stock">
        <div class="stock__block">
            <h2 class="stock__title"><?php echo $row['news_title'] ?></h2>
            <p class="stock__description"><?php echo $row['news_annotation'] ?></p>
            <a onclick="yaCounter40650914.reachGoal('banner_click'); return true" class="stock__link" href="<?php echo $row['news_link'] ?>">Участвовать в розыгрыше</a>
        </div>
        <div class="stock__block">
            <img class="stock__image" src="/images/stock/new-year.jpg">
        </div>
    </div>
    </div><?php
}