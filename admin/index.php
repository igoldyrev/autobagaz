<?php
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php");
echo "<title>Админка сайта Автобагаж.ру!</title>"; ?>

<div class="admin__container">
    <h1 class='title title-h1'>Админка сайта Автобагаж.ру!</h1>

    <div class="admin clearfix">
        <?php echo "<h3 class='title title-h3'>Панель управления отзывами</h3>"; ?>
        <a class="admin__link" href="/admin/guestbook/update/guestupdate.php">Редактировать отзывы</a>
        <a class="admin__link" href="/admin/guestbook/answers/rewiewanswer.php">Ответить на отзывы</a>
        <a class="admin__link" href="/admin/guestbook/answers/answerchoice.php">Редактировать ответы на отзывы</a>
        <a class="admin__link" href="/admin/guestbook/delete/guestdelete.php">Удалить отзывы</a>
    </div>

    <div class="admin clearfix">
        <?php echo "<h3 class='title title-h3'>Панель управления блоками</h3>"; ?>
        <p class="text">Блок Акция и блок с обьявлением на главной странице.</p>
        <a class="admin__link" href="/admin/message/update/msgupdate.php">Редактировать обьявление</a>
        <a class="admin__link" href="/admin/message/activate/msgactivate.php">Выключить/включить блоки</a>
    </div>

    <div class="admin clearfix">
        <?php echo "<h3 class='title title-h3'>Панель управления новостями</h3>"; ?>
        <a class="admin__link" href="/admin/news/newsdelete.php">Удалить новости</a>
    </div>

    <a class="admin__link admin__link--back" href="/">Вернуться на главную страницу сайта</a>
</div>