<?php echo "<title>Новость удалена!</title>";

include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
include ($_SERVER["DOCUMENT_ROOT"]."/admin/connect.php");

$id=$_REQUEST['news'];
$delete_sql = "DELETE FROM news WHERE id=$id";
mysql_query($delete_sql) or die("<p>При удалении произошла ошибка</p>". mysql_error());
echo "<h3>Новость успешно удалена!</h3>";
?>

<a href="/admin/news/newsdelete.php">Вернуться к выбору новостей</a><br>
<a href="/admin/index.php">Вернуться на главную админки</a>