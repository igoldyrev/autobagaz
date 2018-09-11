<?php echo "<title>Внесение изменений в товар</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html"); ?>

<div class="admin__container">
  <h1 class="title title-h1">Внесение изменений в товар</h1>

  <?php
  $dbname = "9082410193_zakaz";
  include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

  $id = $_REQUEST['kommitem'];
  $select_sql = "SELECT * FROM komm_items WHERE komm_items_id = $id";
  $result = mysqli_query($connect, $select_sql);
  $row = mysqli_fetch_array($result); ?>

  <div class="form__container">
    <?php
    printf("<form action='/admin/komissionka/edit/update' method='post'>
                <div class='form__input-wrap'>
                    <input type='hidden' name='id'  value='%s'>
                </div>
                <label class='form__label' for='name'>Название товара</label>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='name' size='50' value='%s'>   
                </div>
                <p class='text'>Для удаления фотографий из записи удалите адрес фото из поля с ним и обновите запись. Добавлять новые фото временно нельзя :(</p>
                <label class='form__label' for='img0'>Первая фотография</label>
                <img class='img admin__img' src='%s'>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='img0' size='50' value='%s'>
                </div>
                <label class='form__label' for='img1'>Вторая фотография</label>
                <img class='img admin__img' src='%s'>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='img1' size='50' value='%s'>
                </div>
                <label class='form__label' for='img2'>Третья фотография</label>
                <img class='img admin__img' src='%s'>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='img2' size='50' value='%s'>
                </div>
                <label class='form__label' for='img3'>Четвертая фотография</label>
                <img class='img admin__img' src='%s'>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='img3' size='50' value='%s'>
                </div>
                <label class='form__label' for='img4'>Пятая фотография</label>
                <img class='img admin__img' src='%s'>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='img4' size='50' value='%s'>
                </div>
                <label class='form__label' for='price'>Цена</label>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='price' size='50' value='%s'>
                </div>
                <label class='form__label' for='category'>Категория</label>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='category' size='50' value='%s'>
                </div>
                <input class='button button__zakaz' id='submit' type='submit' value='Редактировать товар'>
    </form>", $row['komm_items_id'], $row['komm_items_name'], $row['komm_items_img0'], $row['komm_items_img0'], $row['komm_items_img1'], $row['komm_items_img1'], $row['komm_items_img2'], $row['komm_items_img2'], $row['komm_items_img3'], $row['komm_items_img3'], $row['komm_items_img4'], $row['komm_items_img4'], $row['komm_items_price'], $row['komm_items_group']); ?>
  </div>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin/komissionka/edit/itemchoice">Вернуться к выбору товара для редактирования</a>
    <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
  </div>
</div>
