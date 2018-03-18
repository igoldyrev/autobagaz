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
                <label class='form__label' for='img5'>Шестая фотография</label>
                <img class='img admin__img' src='%s'>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='img5' size='50' value='%s'>
                </div>
                <label class='form__label' for='img6'>Седьмая фотография</label>
                <img class='img admin__img' src='%s'>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='img6' size='50' value='%s'>
                </div>
                <label class='form__label' for='img7'>Восьмая фотография</label>
                <img class='img admin__img' src='%s'>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='img7' size='50' value='%s'>
                </div>
                <label class='form__label' for='img8'>Девятая фотография</label>
                <img class='img admin__img' src='%s'>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='img8' size='50' value='%s'>
                </div>
                <label class='form__label' for='img9'>Десятая фотография</label>
                <img class='img admin__img' src='%s'>
                <div class='form__input-wrap'>
                    <input class='form__input' type='text' name='img9' size='50' value='%s'>
                </div>
                <input class='button button__zakaz' id='submit' type='submit' value='Редактировать запись'>
    </form>",$row['id'], $row['name'], $row['tag1'], $row['tag2'], $row['tag3'], $row['img0'], $row['img0'], $row['img1'], $row['img1'], $row['img2'], $row['img2'], $row['img3'], $row['img3'], $row['img4'], $row['img4'], $row['img5'], $row['img5'], $row['img6'], $row['img6'], $row['img7'], $row['img7'], $row['img8'], $row['img8'], $row['img9'], $row['img9']); ?>
    </div>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/gallery/galleryedit/galleryedit">Вернуться к выбору записи для редактирования</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>