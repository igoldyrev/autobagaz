<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");
	echo "<title> $titleconst"; echo $keywords[24][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[24][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[24][keywords]; echo "'/>";

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">

<?php
echo "<h1>Страница отзывов</h1>";
echo "<p>На данной странице Вы можете оставить отзыв о нашей проделанной работе, либо написать нам какие-либо пожелания. А также посмотреть другие отзывы о нас.</p>";

// Соединение с БД MySQL
$sql = mysql_connect('localhost', '9082410193', 'GfhjkmDatabase');
mysql_select_db('9082410193_zakaz', $sql);

mysql_query ("set_client='utf8'");//Следующие 2 строки решают проблему с кодировкой.
mysql_query ("SET NAMES utf8");

// Количество новостей на странице
$on_page = 10;

// Получаем количество записей таблицы
$query = "SELECT COUNT(*) FROM `guestbook`";
$res = mysql_query($query);
$count_records = mysql_fetch_row($res);
$count_records = $count_records[0];

// Получаем количество страниц
// Делим количество всех записей на количество записей на странице
// и округляем в большую сторону
$num_pages = ceil($count_records / $on_page);

// Текущая страница из GET-параметра page
// Если параметр не определен, то текущая страница равна 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Если текущая страница меньше единицы, то страница равна 1
if ($current_page < 1)
{
    $current_page = 1;
}
// Если текущая страница больше общего количества страница, то
// текущая страница равна количеству страниц
elseif ($current_page > $num_pages)
{
    $current_page = $num_pages;
}

// Начать получение данных от числа (текущая страница - 1) * количество записей на странице
$start_from = ($current_page - 1) * $on_page;

// Формат оператора LIMIT <ЗАПИСЬ ОТ>, <КОЛИЧЕСТВО ЗАПИСЕЙ>
$query = "SELECT `name`, `phone`, `rewiew` FROM `guestbook` ORDER BY `id` DESC LIMIT $start_from, $on_page";
$res = mysql_query($query); ?>

<form action="/scripts/rewiew.php" method="post">
<span class="label_top">Ваше имя:</span>
<div class="better-placeholder">
  <input type="text" name="name" required="required" pattern="[А-Яа-яЁё]{2,}" class="better-placeholder__input" placeholder="Введите Ваше имя">
  <label for="name" class="better-placeholder__label">Введите Ваше имя</label>
</div><br>
<span class="label_top">Ваш телефон:</span>
<div class="better-placeholder">
  <input type="text" name="phone" class="better-placeholder__input" required="required" pattern="[0-9]{10,11}" placeholder="Введите номер телефона. Номер телефона НЕ публикуется">
  <label for="phone" class="better-placeholder__label">Введите номер телефона. Номер телефона НЕ публикуется</label>
</div><br>
<span class="label_top">Ваш отзыв</span>
<div class="better-placeholder">
<textarea name="rewiew" class="better-placeholder__input" pattern="^[A-Za-zА-Яа-яЁё0-9\s]+$" placeholder="Введите Ваш отзыв о нас"></textarea>
  <label for="rewiew" class="better-placeholder__label">Введите Ваш отзыв о нас</label>
</div><br>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/captcha_frame.php"); ?>
<div align="center">
<input class="input__button" type="submit" value="Оставить отзыв">
</div>
</form>

<?php 
if ($count_records == 0) {
	echo '<div class="good_message">';
	echo 'На сайте пока не оставлено ни одного отзыва :( Вы можете сделать это первым!';
	echo '</div>';
} elseif ($count_records <> 0){

// Вывод результатов
while ($row = mysql_fetch_assoc($res))
{
	echo '<div class="rewiew">';
		echo '<div class="name">';
		echo '<span class="rewiew">'.$row['name'].'</span>';
		echo '</div>';
	echo '<p class="rewiew">'.$row['rewiew'].'</p>';	
	echo "</div>";
}

// Вывод списка страниц
echo '<p>';
for ($page = 1; $page <= $num_pages; $page++)
{
    if ($page == $current_page)
    {
        echo '<strong>'.$page.'</strong> &nbsp;';
    }
    else
    {
        echo '<a href="guestbook.php?page='.$page.'">'.$page.'</a> &nbsp;';
    }
} }
echo '</p>'; ?>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>