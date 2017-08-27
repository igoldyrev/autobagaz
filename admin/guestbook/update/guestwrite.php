<?php echo "<title>Внесение изменений в элемент</title>";
echo "<h1>Внесение изменений в элемент</h1>";

include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
include ($_SERVER["DOCUMENT_ROOT"]."/admin/connect.php");
$id = $_REQUEST['rewiew'];
$select_sql = "SELECT * FROM guestbook WHERE id = $id";
$result = mysql_query($select_sql);
$row = mysql_fetch_array($result);
printf("<form action='/admin/guestbook/update/update.php' method='post'>
<input type='hidden' name='id'  value='%s'><br/>
<label for='name'>Имя человека, оставившего отзыв</label><br/>
<input type='text' name='name' size='50' value='%s'><br/>
<label for='phone'>Телефон человека, оставившего отзыв</label><br/>
<input type='text' name='phone' size='50' value='%s'><br/>
<label for='rewiew'>Сам текст отзыва</label><br/>
<input type='text' name='rewiew' size='50' value='%s'><br/>
<br/>
<input id='submit' type='submit' value='Редактировать отзыв'><br/>
</form>",$row['id'], $row['name'], $row['phone'], $row['rewiew']);
?>
<a href="/admin/guestbook/update/guestupdate.php">Вернуться к выбору отзыва для редактирования</a><br>
<a href="/admin/index.php">Вернуться на главную админки</a>