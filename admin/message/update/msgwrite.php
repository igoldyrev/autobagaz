<?php echo "<title>Внесение изменений в сообщение</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html"); ?>

<div class="admin__container">
    <h1 class="page__title-h1">Внесение изменений в сообщение</h1>

    <?php
    $dbname = "9082410193_news";

    include ($_SERVER["DOCUMENT_ROOT"]."/modules/connectdb.php");

    $id = $_REQUEST['rewiew'];
    $select_sql = "SELECT * FROM message WHERE id = $id";
    $result = mysqli_query($connect, $select_sql);
    $row = mysqli_fetch_array($result); ?>



    <div class="form__container">
        <?php
        printf("<form action='/admin/message/update/update.php' method='post'>
                <div class='form__input-block'>
                    <input type='hidden' name='id'  value='%s'>
                </div>
                <div class='form__input-block'>
                    <label class='form__label' for='title'>Верхний заголовок (красный)</label>
                    <input class='form__input' type='text' name='title' size='50' value='%s'>   
                </div>
                <div class='form__input-block'>
                    <label class='form__label' for='msg'>Текст сообщения</label>
                    <textarea class='form__input form__textarea form__textarea--admin' name='msg' >%s</textarea>
                </div>
                <div class='form__input-block'>
                    <label class='form__label' for='holiday'>Нижний заголовок (красный)</label>
                    <input class='form__input' type='text' name='holiday' size='50' value='%s'>
                </div>
                <input class='button button__zakaz' id='submit' type='submit' value='Редактировать сообщение'>
    </form>",$row['id'], $row['title'], $row['msg'], $row['holiday']);
        ?>
    </div>
    <div class="admin__link-down clearfix">
        <a class="admin__link" href="/admin/message/update/msgupdate.php">Вернуться к выбору сообщения для редактирования</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>