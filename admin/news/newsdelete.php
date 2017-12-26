<?php echo "<title>Выбор новости для удаления</title>";
echo "<h1>Выбор новости для удаления</h1>";

include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
include ($_SERVER["DOCUMENT_ROOT"]."/admin/connect_news.php"); ?>
<form action="/admin/guestbook/delete/delete.php" method="post">
<?php
$select_sql = "SELECT * FROM  news";
$result = mysql_query($select_sql);
$row = mysql_fetch_array($result);
do
{
printf("<input type='radio' name='news' value='%s'>%s<br/><br/>", $row['news_id'], $row['news_title']);	
}
while($row = mysql_fetch_array($result))
?>
<input type="submit" value="Удалить новость с сайта">
</form>
<a href="/admin/index.php">Вернуться на главную админки</a>