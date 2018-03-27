<?php echo "<title>Редактирование ответа на отзыв</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <h1 class="title title-h1">Редактирование ответа на отзыв</h1>

    <?php
    $dbname = "9082410193_zakaz";

    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

    $id = $_REQUEST['answer'];
    $select_sql = "SELECT * FROM guestbook WHERE id = $id";
    $result = mysqli_query($connect, $select_sql);
    $row = mysqli_fetch_array($result); ?>

    <div class="form__container">
        <?php
        printf("<form action='/admin/guestbook/answers/answerupdate.php' method='post'>
                <div class='form__input-wrap'>
                    <input type='hidden' name='id'  value='%s'>
                </div>
                <div class='form__input-wrap'>
                    <label class='form__label' for='answer'>Отредактируйте ответ на отзыв</label>
                    <textarea class='form__input form__textarea form__textarea--admin' name='answer' autofocus >%s</textarea>                 
                </div>
                <input class='button button__zakaz' id='submit' type='submit' value='Редактировать ответ на отзыв'>
    </form>",$row['id'], $row['answer']);
        ?>
    </div>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/guestbook/answers/answerchoice">Вернуться к выбору отзыва</a>
        <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
    </div>
</div>