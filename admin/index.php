<?php
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html");
echo "<title>Админка сайта Автобагаж.ру!</title>"; ?>

<div class="admin__container">
  <h1 class='title title-h1'>Админка сайта Автобагаж.ру!</h1>
  <div class="admin__inner">
    <div class="admin clearfix">
      <?php echo "<h3 class='title title-h3'>Отзывы</h3>"; ?>
      <a class="admin__link" href="/admin/guestbook/update/guestupdate">Редактировать</a>
      <a class="admin__link" href="/admin/guestbook/answers/rewiewanswer">Ответить на отзывы</a>
      <a class="admin__link" href="/admin/guestbook/answers/answerchoice">Редактировать ответы</a>
      <a class="admin__link" href="/admin/guestbook/delete/guestdelete">Удаление</a>
      <a class="admin__link" href="/admin/guestbook/restore/guestrestore">Восстановление</a>
    </div>

    <div class="admin clearfix">
      <?php echo "<h3 class='title title-h3'>Блоки и цены</h3>"; ?>
      <p class="text">Баннер с акцией и обьявление на главной странице</p>
      <a class="admin__link" href="/admin/message/update/msgupdate">Редактировать обьявление</a>
      <a class="admin__link" href="/admin/message/activate/msgactivate">Выключить/включить баннер и цены на сайте</a>
    </div>

    <div class="admin clearfix">
      <?php echo "<h3 class='title title-h3'>Галерея</h3>"; ?>
      <a class="admin__link" href="/admin/gallery/galleryadd/addform">Добавить запись</a>
      <a class="admin__link" href="/admin/gallery/galleryedit/galleryedit">Редактировать записи</a>
      <a class="admin__link" href="/admin/gallery/gallerydelete/gallerydelete">Удаление записей</a>
      <a class="admin__link" href="/admin/gallery/galleryrestore/galleryrestore">Восстановление записей</a>
    </div>

    <div class="admin clearfix">
      <?php echo "<h3 class='title title-h3'>Комиссионка</h3>"; ?>
      <h3 class="title title-h3">Товары</h3>
      <a class="admin__link" href="/admin/komissionka/items/add/additem">Добавить товар</a>
      <a class="admin__link" href="/admin/komissionka/items/add/additem">Добавить товар</a>
      <h3 class="title title-h3">Категории</h3>
      <a class="admin__link" href="/admin/komissionka/items/add/addcategory">Добавить категорию</a>
    </div>

    <div class="admin clearfix">
      <?php echo "<h3 class='title title-h3'>Новости</h3>"; ?>
      <!--      <a class="admin__link" href="/admin/news/newsdelete">Удалить новости</a>-->
      <h3 class="title title-h3">СКОРО...</h3>
    </div>
  </div>

  <a class="admin__link admin__link--back" href="/">Перейти на главную страницу сайта</a>
</div>
