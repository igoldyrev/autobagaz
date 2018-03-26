<?php
include ($_SERVER["DOCUMENT_ROOT"]."/admin/message/activate/configmessage.php");
//Условия для сообщения на главной странице
if ($checkedmsgon == 'checked'){
    $stylemsg = 'style="display: flex; "';
}elseif ($checkedmsgon == 'none'){
    $stylemsg = 'style="display: none; "';
}
//Условия для акции на главной странице
if ($checkedstock == 'checked'){
    $stylestock = 'style="display: block; "';
}elseif ($checkedstock == 'none'){
    $stylestock = 'style="display: none; "';
}
//Условия для цен на сайте
if ($checkedprice == 'checked'){
    $styleprice = 'style="display: block; "';
}elseif ($checkedprice == 'none'){
    $styleprice = 'style="display: none; "';
}