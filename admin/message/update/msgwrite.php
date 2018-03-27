<?php echo "<title>Внесение изменений в сообщение</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <h1 class="title title-h1">Внесение изменений в сообщение</h1>

    <?php
    $dbname = "9082410193_news";

    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

    $id = $_REQUEST['message'];
    $select_sql = "SELECT * FROM message WHERE id = $id";
    $result = mysqli_query($connect, $select_sql);
    $row = mysqli_fetch_array($result); ?>



    <div class="form__container">
        <?php
        printf("<form action='/admin/message/update/update.php' method='post'>
                <div class='form__input-wrap'>
                    <input type='hidden' name='id'  value='%s'>
                </div>
                <div class='form__input-wrap'>
                    <label class='form__label' for='title'>Верхний заголовок (красный)</label>
                    <input class='form__input' type='text' name='title' size='50' value='%s'>   
                </div>
                <div class='form__input-wrap'>
                    <label class='form__label' for='msg'>Текст сообщения</label>
                    <textarea class='form__input form__textarea form__textarea--admin' name='msg' >%s</textarea>
                </div>
                <div class='form__input-wrap'>
                    <label class='form__label' for='holiday'>Нижний заголовок (красный)</label>
                    <input class='form__input' type='text' name='holiday' size='50' value='%s'>
                </div>
                <input class='button button__zakaz' id='submit' type='submit' value='Редактировать сообщение'>
    </form>",$row['id'], $row['title'], $row['msg'], $row['holiday']);
        ?>
    </div>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/message/update/msgupdate">Вернуться к выбору сообщения для редактирования</a>
        <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
    </div>
</div>