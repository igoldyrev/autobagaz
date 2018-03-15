<?php echo "<title>Внесение изменений в запись</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <h1 class="title title-h1">Внесение изменений в запись</h1>

    <?php
    $dbname = "9082410193_gallery";
    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

    $id = $_REQUEST['galleryitem'];
    $select_sql = "SELECT * FROM photos WHERE id = $id";
    $result = mysqli_query($connect, $select_sql);
    $row = mysqli_fetch_array($result); ?>

    <div class="form__container">
        <?php
            printf("<form action='/admin/gallery/galleryedit/update' method='post'>
                <div class='form__input-wrap'>
                    <input type='hidden' name='id'  value='%s'>
                </div>
                <label class='form__label' for='name'>Название записи</label>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='name' size='50' value='%s'>   
                </div>
                <label class='form__label' for='tag1'>Первый тег</label>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='tag1' size='50' value='%s'>
                </div>
                <label class='form__label' for='tag2'>Второй тег</label>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='tag2' size='50' value='%s'>
                </div>
                <label class='form__label' for='tag3'>Третий тег</label>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='tag3' size='50' value='%s'>
                </div>
                <input class='button button__zakaz' id='submit' type='submit' value='Редактировать запись'>
    </form>",$row['id'], $row['name'], $row['tag1'], $row['tag2'], $row['tag3']); ?>
    </div>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/gallery/galleryedit/galleryedit">Вернуться к выбору записи для редактирования</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>