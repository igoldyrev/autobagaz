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
$result = mysql_query('SELECT * FROM `news` ORDER BY news_id DESC LIMIT 4', $conn); // запрос на выборку
if(!$result)
{
    throw new Exception(sprintf('Не удалось выполнить запрос к БД, код ошибки %d, текст ошибки: %s', mysql_errno($conn), mysql_error($conn)));
}

echo "<h2 class='page__title-h2'>Новости</h2>";
echo "<div class='news'>";
while ($row = mysql_fetch_assoc($result))
{
    echo "<div class='news__item news__item--index''>";
    echo "<div class='news__info'>";
    echo "<span class='news__date page__text'>".$row['news_date']."</span>";
    echo "<span class='page__text'>Автор: ".$row['news_author']."</span>";
    echo "</div>";
    echo "<a href='".$row['news_link']."' class='news__title page__link'>".$row['news_title']."</a>";
    echo "<p class='news__annotation page__text'>".$row['news_annotation']."</p>";
    echo "<a href='".$row['news_link']."' class='news__link page__link'>Читать далее</a>";
    echo "</div>";
}
echo "</div>";
echo '<a class="left-nav__link left-nav__link--rewiew" href="/news">Все новости</a>';
?>