<?php echo "<title>Выбор новости для удаления</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <h1 class='title title-h1'>Выбор новости для удаления</h1>

    <?php
    $dbname = "9082410193_news";

    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php"); ?>

    <div class="form__container">
        <form action="/admin/news/delete.php" method="post">

            <?php
            $select_sql = "SELECT * FROM  news";
            $result = mysqli_query($connect, $select_sql);
            $row = mysqli_fetch_array($result);

            do
            {
                printf("<div class='admin__item'><input class='admin__radio' type='radio' name='news' value='%s'>%s", $row['news_id'], '<span class="text">'.$row['news_title'].'</span></div>');
            }
            while($row = mysqli_fetch_array($result))
            ?>

            <input class="button button__zakaz" type="submit" value="Удалить новость с сайта">
        </form>
    </div>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>