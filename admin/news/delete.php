<?php echo "<title>Новость удалена!</title>";

$dbname = "9082410193_news";

include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/connectdb.php");

$id=$_REQUEST['news'];
$delete_sql = "DELETE FROM news WHERE news_id=$id";
mysqli_query($connect, $delete_sql) or die("<p>При удалении новости произошла ошибка</p>". mysqli_error());
echo "<h3>Новость успешно удалена!</h3>";
?>

<a href="/admin/news/newsdelete.php">Вернуться к выбору новостей</a><br>
<a href="/admin/index.php">Вернуться на главную админки</a>