<?php echo "<title>Выбор отзыва для удаления</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <h1 class="title title-h1">Выбор отзыва для удаления</h1>

    <?php
    $dbname = "9082410193_zakaz";

    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php"); ?>

    <div class="form__container">
        <form action="/admin/guestbook/delete/delete.php" method="post">
            <?php
            $select_sql = "SELECT id, name, phone, rewiew FROM guestbook";
            $result = mysqli_query($connect, $select_sql);
            $row = mysqli_fetch_array($result);

            do
            {
                printf("<div class='admin__item'><input class='admin__radio' type='radio' name='rewiew' value='%s'>%s", $row['id'], '<span class="text">'.$row['name'].'</span></div>');
            }
            while($row = mysqli_fetch_array($result))
            ?>
            <input class="button button__zakaz" type="submit" value="Удалить отзыв">
        </form>
    </div>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>