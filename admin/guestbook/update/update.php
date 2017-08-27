<?php echo "<title>Отзыв обновлен</title>";

include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
include ($_SERVER["DOCUMENT_ROOT"]."/admin/connect.php");

$id=$_REQUEST['id'];
$name=trim($_REQUEST['name']);
$phone=trim($_REQUEST['phone']);
$rewiew=trim($_REQUEST['rewiew']);

$update_sql = "UPDATE guestbook SET name='$name', phone='$phone', rewiew='$rewiew' WHERE id='$id'";
mysql_query($update_sql) or die("Ошибка вставки" . mysql_error());
echo '<h3>Отзыв успешно обновлен!</h3>';
?>
<a href="/admin/guestbook/update/guestupdate.php">Вернуться к выбору отзыва</a><br>
<a href="/admin/index.php">Вернуться на главную админки</a>