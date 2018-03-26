<?php
echo "<title>Выключить / включить блоки</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php");
include ($_SERVER["DOCUMENT_ROOT"]."/admin/message/activate/configmessage.php");

if ($checkedmsgon == 'checked'){
    $checkedmsgon = "checked";
}elseif ($checkedmsgon == 'none'){
    $checkedmsgon = "";
}elseif ($checkedstock == 'checked'){
    $checkedstock = "checked";
}elseif ($checkedstock == 'none'){
    $checkedstock = "";
}elseif ($checkedprice == 'checked'){
    $checkedprice = "checked";
}elseif ($checkedprice == 'none'){
    $checkedprice = "";
} ?>

<div class="admin__container">
    <h1 class="title title-h1">Выключение блоков на главной странице</h1>

    <div class="form__container">
        <p class="text">Если галочка установлена - то блок отображается на странице. Если она убрана - то не отображается.</p>
        <form action="/admin/message/activate/activate.php" method="post" class="form">
            <div class="form__input-wrap clearfix">
                <input type="checkbox" name="msg_on" class="form__checkbox" id="msgon" <?php echo $checkedmsgon ?>>
                <label for="msgon" class="form__label--checkbox">Включить/выключить сообщение</label>
            </div>
            <div class="form__input-wrap clearfix">
                <input type="checkbox" name="stock_on" class="form__checkbox" id="stockon" <?php echo $checkedstock ?>>
                <label for="stockon" class="form__label--checkbox">Включить/выключить блок с акцией</label>
            </div>
            <div class="form__input-wrap clearfix">
                <input type="checkbox" name="price_on" class="form__checkbox" id="priceon" <?php echo $checkedprice ?>>
                <label for="priceon" class="form__label--checkbox">Включить/выключить цены на сайте</label>
            </div>
            <input type="submit" class="button button__zakaz" value="Включить/выключить блоки">
        </form>
    </div>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>