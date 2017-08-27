<?php echo "<title>Выбор отзыва для удаления</title>";
echo "<h1>Выбор отзыва для удаления</h1>";

include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
include ($_SERVER["DOCUMENT_ROOT"]."/admin/connect.php"); ?>
<form action="/admin/guestbook/delete/delete.php" method="post">
<?php
$select_sql = "SELECT id, name, phone, rewiew FROM guestbook";
$result = mysql_query($select_sql);
$row = mysql_fetch_array($result);
do
{
printf("<input type='radio' name='rewiew' value='%s'>%s<br/><br/>", $row['id'], $row['name']);	
}
while($row = mysql_fetch_array($result))
?>
<input type="submit" value="Удалить отзыв">
</form>
<a href="/admin/index.php">Вернуться на главную админки</a>