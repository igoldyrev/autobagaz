<?php echo "<title>Выбор новости для удаления</title>";
echo "<h1>Выбор новости для удаления</h1>";

$dbname = "9082410193_news";

include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/connectdb.php");


?>
<form action="/admin/news/delete.php" method="post">
<?php
$select_sql = "SELECT * FROM  news";
$result = mysqli_query($connect, $select_sql);
$row = mysqli_fetch_array($result);
do
{
printf("<input type='radio' name='news' value='%s'>%s<br/><br/>", $row['news_id'], $row['news_title']);	
}
while($row = mysqli_fetch_array($result))
?>
<input type="submit" value="Удалить новость с сайта">
</form>
<a href="/admin/index.php">Вернуться на главную админки</a>