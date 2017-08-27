<?php echo "<title>Отзыв удален!</title>";

include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
include ($_SERVER["DOCUMENT_ROOT"]."/admin/connect.php");

$id=$_REQUEST['rewiew'];
$delete_sql = "DELETE FROM guestbook WHERE id=$id";
mysql_query($delete_sql) or die("<p>При удалении произошла ошибка</p>". mysql_error());
echo "<h3>Отзыв успешно удален!</h3>";
?>

<a href="/admin/guestbook/delete/guestdelete.php">Вернуться к выбору отзывов</a><br>
<a href="/admin/index.php">Вернуться на главную админки</a>