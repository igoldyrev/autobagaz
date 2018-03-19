<?php
echo "<title>Выбор записи для редактирования</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <h1 class="title title-h1">Выбор записи для редактирования</h1>

    <?php
    $dbname = "9082410193_gallery";
    include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php"); ?>

    <div class="form__container">
        <form action="/admin/gallery/galleryedit/gallerywrite" method="post">
            <?php
            $select_sql = "SELECT * FROM photos";
            $result = mysqli_query($connect, $select_sql);
            $row = mysqli_fetch_array($result);

            do
            {
                printf("<div class='admin__item'><input class='admin__radio' type='radio' name='galleryitem' value='%s'>%s", $row['id'], '<span class="text">'.$row['date'].'</span><span class="text">: </span><span class="text">'.$row['name'].'</span></div>');
            }
            while($row = mysqli_fetch_array($result))
            ?>
            <input class="button button__zakaz" type="submit" value="Выбрать запись">
        </form>
    </div>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>