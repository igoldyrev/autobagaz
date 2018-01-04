<?php
include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
echo "<title>Админка сайта Автобагаж.ру!</title>"; ?>

<div class="admin__container">
    <h1 class='page__title-h1'>Админка сайта Автобагаж.ру!</h1>

    <div class="admin clearfix">
        <?php echo "<h3 class='page__title-h3'>Панель управления отзывами</h3>"; ?>
        <a class="admin__link" href="/admin/guestbook/update/guestupdate.php">Редактировать отзывы</a>
        <a class="admin__link" href="/admin/guestbook/delete/guestdelete.php">Удалить отзывы</a>
    </div>

    <div class="admin clearfix">
        <?php echo "<h3 class='page__title-h3'>Панель управления новостями</h3>"; ?>
        <a class="admin__link" href="/admin/news/newsdelete.php">Удалить новости</a>
    </div>

    <div class="admin clearfix">
        <?php echo "<h3 class='page__title-h3'>Скачать данные сайта</h3>"; ?>
        <a class="admin__link" href="/admin/files/keywords.zip">Скачать</a>
    </div>

    <a class="admin__link admin__link--back" href="/">Вернуться на главную страницу сайта</a>
</div>