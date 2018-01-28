<?php
echo "<title>Выключить обьявление</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html");
include ($_SERVER["DOCUMENT_ROOT"]."/admin/config.php");

if ($checkedmsgon == 'checked'){
    $checkedmsgon = "checked";
}elseif ($checkedmsgon == 'none'){
    $checkedmsgon = "";
}elseif ($checkedstock == 'checked'){
    $checkedstock = "checked";
}elseif ($checkedstock == 'none'){
    $checkedstock = "";
}


?>

<div class="admin__container">
    <h1 class="page__title-h1">Выключение объявления на главной странице</h1>

    <div class="form__container">
        <p class="page__text" style="margin-bottom: 15px">Если галочка установлена - то блок отображается на странице. Если она убрана - то не отображается.</p>
        <form action="/admin/message/activate/activate.php" method="post" class="form">
            <div class="form__input-block clearfix">
                <input type="checkbox" name="msg_on" class="form__checkbox" id="msgon" <?php echo $checkedmsgon ?>>
                <label for="msgon" class="form__label--checkbox">Включить/выключить сообщение</label>
            </div>
            <div class="form__input-block clearfix">
                <input type="checkbox" name="stock_on" class="form__checkbox" id="stockon" <?php echo $checkedstock ?>>
                <label for="stockon" class="form__label--checkbox">Включить/выключить блок с акцией</label>
            </div>
            <input type="submit" class="button button__zakaz" value="Включить/выключить блоки">
        </form>
    </div>
    <div class="admin__link-down clearfix">
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>