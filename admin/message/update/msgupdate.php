<?php
echo "<title>Выбор элемента для редактирования</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html"); ?>

<div class="admin__container">
    <h1 class="page__title-h1">Выбор сообщения для редактирования</h1>

    <?php
    $dbname = "9082410193_news";

    include ($_SERVER["DOCUMENT_ROOT"]."/modules/connectdb.php"); ?>

    <div class="form__container">
        <form action="/admin/message/update/msgwrite.php" method="post">
            <?php
            $select_sql = "SELECT id, title, msg, holiday FROM message";
            $result = mysqli_query($connect, $select_sql);
            $row = mysqli_fetch_array($result);

            do
            {
                printf("<div class='admin__item'><input class='admin__radio' type='radio' name='rewiew' value='%s'>%s", $row['id'], '<span class="page__text">'.$row['title'].'</span></div>');
            }
            while($row = mysqli_fetch_array($result))
            ?>
            <input class="button button__zakaz" type="submit" value="Выбрать сообщение">
        </form>
    </div>
    <div class="admin__link-down clearfix">
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>