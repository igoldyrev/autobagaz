<?php
echo "<title>Выключить / включить блоки</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html");
include ($_SERVER["DOCUMENT_ROOT"]."/admin/message/activate/configmessage.php");

if ($checkedmsgon == 'checked'){
    $checkedmsgon = "checked";
}elseif ($checkedmsgon == 'none'){
    $checkedmsgon = "";
}elseif ($checkedstock == 'checked'){
    $checkedstock = "checked";
}elseif ($checkedstock == 'none'){
    $checkedstock = "";
}elseif ($checkedpricebagazh == 'checked'){
    $checkedpricebagazh = "checked";
}elseif ($checkedpricebagazh == 'none'){
    $checkedpricebagazh = "";
}elseif ($checkedpriceautobox == 'checked'){
    $checkedpriceautobox = "checked";
}elseif ($checkedpriceautobox == 'none'){
    $checkedpriceautobox = "";
}elseif ($checkedpricevelo == 'checked'){
    $checkedpricevelo = "checked";
}elseif ($checkedpricevelo == 'none'){
    $checkedpricevelo = "";
}elseif ($checkedpriceskies == 'checked'){
    $checkedpriceskies = "checked";
}elseif ($checkedpriceskies == 'none'){
    $checkedpriceskies = "";
}elseif ($checkedpricebraslet == 'checked'){
    $checkedpricebraslet = "checked";
}elseif ($checkedpricebraslet == 'none'){
    $checkedpricebraslet = "";
} elseif ($checkedpricecovers == 'checked') {
  $checkedpricecovers = "checked";
} elseif ($checkedpricecovers == 'none') {
  $checkedpricecovers = "";
} elseif ($checkedpriceexpidition == 'checked') {
  $checkedpriceexpidition = "checked";
} elseif ($checkedpriceexpidition == 'none') {
  $checkedpriceexpidition = "";
}elseif ($checkedpriceporogi == 'checked') {
  $checkedpriceporogi = "checked";
} elseif ($checkedpriceporogi == 'none') {
  $checkedpriceporogi = "";
} ?>

<div class="admin__container">
  <h1 class="title title-h1">Выключение блоков на главной странице</h1>

  <div class="form__container">
    <p class="text">Если галочка установлена - то блок отображается на странице. Если она убрана - то не
      отображается.</p>
    <form action="/admin/message/activate/activate" method="post" class="form">
      <div class="form__input-wrap clearfix">
        <input type="checkbox" name="msg_on" class="form__checkbox" id="msgon" <?php echo $checkedmsgon ?>>
        <label for="msgon" class="form__label--checkbox">Включить/выключить сообщение</label>
      </div>
      <div class="form__input-wrap clearfix">
        <input type="checkbox" name="stock_on" class="form__checkbox" id="stockon" <?php echo $checkedstock ?>>
        <label for="stockon" class="form__label--checkbox">Включить/выключить блок с акцией</label>
      </div>
      <h2 class="title title-h2">Отключение/включение цен на сайте</h2>
      <div class="form__input-wrap clearfix">
        <input type="checkbox" name="price_on_bagazh" class="form__checkbox"
               id="priceonbagazh" <?php echo $checkedpricebagazh ?>>
        <label for="priceonbagazh" class="form__label--checkbox">Включить/выключить цены в разделе Автобагажники</label>
      </div>
      <div class="form__input-wrap clearfix">
        <input type="checkbox" name="price_on_autobox" class="form__checkbox"
               id="priceonautobox" <?php echo $checkedpriceautobox ?>>
        <label for="priceonautobox" class="form__label--checkbox">Включить/выключить цены в разделе Автобоксы</label>
      </div>
      <div class="form__input-wrap clearfix">
        <input type="checkbox" name="price_on_velo" class="form__checkbox"
               id="priceonvelo" <?php echo $checkedpricevelo ?>>
        <label for="priceonvelo" class="form__label--checkbox">Включить/выключить цены в разделе Велокрепления</label>
      </div>
      <div class="form__input-wrap clearfix">
        <input type="checkbox" name="price_on_skies" class="form__checkbox"
               id="priceonskies" <?php echo $checkedpriceskies ?>>
        <label for="priceonskies" class="form__label--checkbox">Включить/выключить цены в разделе Лыжные
          крепления</label>
      </div>
      <div class="form__input-wrap clearfix">
        <input type="checkbox" name="price_on_braslet" class="form__checkbox"
               id="priceonbraslet" <?php echo $checkedpricebraslet ?>>
        <label for="priceonbraslet" class="form__label--checkbox">Включить/выключить цены в разделе Браслеты</label>
      </div>
      <div class="form__input-wrap clearfix">
        <input type="checkbox" name="price_on_covers" class="form__checkbox"
               id="priceoncovers" <?php echo $checkedpricecovers ?>>
        <label for="priceoncovers" class="form__label--checkbox">Включить/выключить цены в разделе Авточехлы</label>
      </div>
      <div class="form__input-wrap clearfix">
        <input type="checkbox" name="price_on_expidition" class="form__checkbox"
               id="priceonexpidition" <?php echo $checkedpriceexpidition ?>>
        <label for="priceonexpidition" class="form__label--checkbox">Включить/выключить цены в разделе Экспедиционные
          багажники</label>
      </div>
      <div class="form__input-wrap clearfix">
        <input type="checkbox" name="price_on_porogi" class="form__checkbox"
               id="priceonporogi" <?php echo $checkedpriceporogi ?>>
        <label for="priceonporogi" class="form__label--checkbox">Включить/выключить цены в разделе Пороги для автомобилей</label>
      </div>
      <input type="submit" class="button button__zakaz" value="Включить/выключить блоки">
    </form>
  </div>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
  </div>
  <div>
