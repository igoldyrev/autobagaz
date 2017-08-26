<?php echo "<title>Запись удалена</title>";
echo "<h1>Запись удалена</h1>";

include ($_SERVER["DOCUMENT_ROOT"]."/admin/connect.php");

$id=$_REQUEST['rewiew'];
$delete_sql = "DELETE FROM guestbook WHERE id=$id";
mysql_query($delete_sql) or die("<p>При удалении произошла ошибка</p>". mysql_error());
echo "<p>Запись была успешно удалена!</p>";
?>

<a href="/admin/guestbook/delete/guestdelete.php">Вернуться к выбору отзывов</a><br>
<a href="/admin/index.php">Вернуться на главную админки</a>