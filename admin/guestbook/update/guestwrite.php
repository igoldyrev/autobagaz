<?php echo "<title>Внесение изменений в отзыв</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html"); ?>

<div class="admin__container">
    <h1 class="page__title-h1">Внесение изменений в отзыв</h1>

    <?php
    $dbname = "9082410193_zakaz";

    include ($_SERVER["DOCUMENT_ROOT"]."/modules/connectdb.php");

    $id = $_REQUEST['rewiew'];
    $select_sql = "SELECT * FROM guestbook WHERE id = $id";
    $result = mysqli_query($connect, $select_sql);
    $row = mysqli_fetch_array($result); ?>



    <div class="form__container">
        <?php
            printf("<form action='/admin/guestbook/update/update.php' method='post'>
                <div class='form__input-block'>
                    <input type='hidden' name='id'  value='%s'>
                </div>
                <div class='form__input-block'>
                    <label class='form__label' for='name'>Имя человека, оставившего отзыв</label>
                    <input class='form__input' type='text' name='name' size='50' value='%s'>   
                </div>
                <div class='form__input-block'>
                    <label class='form__label' for='phone'>Телефон человека, оставившего отзыв</label>
                    <input class='form__input' type='text' name='phone' size='50' value='%s'>
                </div>
                <div class='form__input-block'>
                    <label class='form__label' for='rewiew'>Сам текст отзыва</label>
                    <textarea class='form__input form__textarea form__textarea--admin' name='rewiew' >%s</textarea>                 
                </div>
                <input class='button button__zakaz' id='submit' type='submit' value='Редактировать отзыв'>
    </form>",$row['id'], $row['name'], $row['phone'], $row['rewiew']);
        ?>
    </div>
    <div class="admin__link-down clearfix">
        <a class="admin__link" href="/admin/guestbook/update/guestupdate.php">Вернуться к выбору отзыва для редактирования</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>