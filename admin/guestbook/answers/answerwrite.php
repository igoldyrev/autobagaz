<?php echo "<title>Ответ на отзыв</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html"); ?>

    <div class="admin__container">
        <h1 class="title title-h1">Ответ на отзыв</h1>

        <?php
        $dbname = "9082410193_zakaz";

        include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

        $id = $_REQUEST['answer'];
        $select_sql = "SELECT * FROM guestbook WHERE id = $id";
        $result = mysqli_query($connect, $select_sql);
        $row = mysqli_fetch_array($result); ?>

        <div class="form__container">
            <?php
            printf("<form action='/admin/guestbook/answers/answer.php' method='post'>
                <div class='form__input-wrap'>
                    <input type='hidden' name='id'  value='%s'>
                </div>
                <div class='form__input-wrap'>
                    <label class='form__label' for='answer'>Введите ответ на отзыв</label>
                    <textarea class='form__input form__textarea form__textarea--admin' name='answer' autofocus ></textarea>                 
                </div>
                <input class='button button__zakaz' id='submit' type='submit' value='Ответить на отзыв'>
    </form>",$row['id'], $row['answer']);
            ?>
        </div>
        <div class="admin__link-wrap clearfix">
            <a class="admin__link" href="/admin/guestbook/answers/rewiewanswer">Вернуться к выбору отзыва для ответа</a>
            <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
        </div>
    </div>
