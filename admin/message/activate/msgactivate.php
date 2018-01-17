<?php
echo "<title>Выключить обьявление</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html"); ?>

<div class="admin__container">
    <h1 class="page__title-h1">Выключение объявления на главной странице</h1>

    <div class="form__container">
        <form action="/admin/message/activate/activate.php" method="post" class="form">
            <div class="form__input-block clearfix">
                <input type="checkbox" name="msg_on" class="form__checkbox" id="msgon" <?php echo $checkedmsgon ?>>
                <label for="msgon" class="form__label--checkbox">Выключить блок</label>
            </div>
            <input type="submit" class="button button__zakaz" value="Выключить блок">
        </form>
    </div>
    <div class="admin__link-down clearfix">
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>
