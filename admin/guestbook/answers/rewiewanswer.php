<?php
echo "<title>Выбор отзыва для ответа</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html"); ?>

<div class="admin__container">
    <h1 class="title title-h1">Выбор отзыва для ответа</h1>

    <?php
    $dbname = "9082410193_zakaz";

    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php"); ?>

    <div class="form__container">
        <form action="/admin/guestbook/answers/answerwrite.php" method="post">
            <?php
            $select_sql = "SELECT * FROM guestbook INNER JOIN status ON guestbook.status = status.status_name AND status.status_name <> 'УДАЛЕН'";
            $result = mysqli_query($connect, $select_sql);
            $row = mysqli_fetch_array($result);

            do
            {
                printf("<div class='admin__item'><input class='admin__radio' type='radio' name='answer' value='%s'>%s", $row['id'], '<span class="text">'.$row['name'].'</span></div>');
            }
            while($row = mysqli_fetch_array($result))
            ?>
            <input class="button button__zakaz" type="submit" value="Выбрать отзыв">
        </form>
    </div>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
    </div>
</div>
