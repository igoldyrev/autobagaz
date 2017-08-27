<?php
include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
echo "<title>Админка сайта Автобагаж.ру!</title>";
echo "<h1>Админка сайта Автобагаж.ру!</h1>"; ?>

<div class="good">
<?php echo "<h3>Панель управления отзывами</h3>"; ?>	
<a href="/admin/guestbook/update/guestupdate.php">Редактировать отзывы</a><br>
<a href="/admin/guestbook/delete/guestdelete.php">Удалить отзывы</a>
</div>

<div class="good">
<?php echo "<h3>Панель управления новостями</h3>"; ?>	
<a href="/admin/news/newsdelete.php">Удалить новости</a>
</div>

<a href="/">Вернуться на главную страницу сайта</a>