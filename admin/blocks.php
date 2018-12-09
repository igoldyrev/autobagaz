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
if ($checkedpricebagazh == 'checked'){
    $stylepricebagazh = 'style="display: block; "';
}elseif ($checkedpricebagazh == 'none'){
    $stylepricebagazh = 'style="display: none; "';
}
if ($checkedpriceautobox == 'checked'){
    $stylepriceautobox = 'style="display: block; "';
}elseif ($checkedpriceautobox == 'none'){
    $stylepriceautobox = 'style="display: none; "';
}
if ($checkedpricevelo == 'checked'){
    $stylepricevelo = 'style="display: block; "';
}elseif ($checkedpricevelo == 'none'){
    $stylepricevelo = 'style="display: none; "';
}
if ($checkedpriceskies == 'checked'){
    $stylepriceskies = 'style="display: block; "';
}elseif ($checkedpriceskies == 'none'){
    $stylepriceskies = 'style="display: none; "';
}
if ($checkedpricebraslet == 'checked'){
    $stylepricebraslet = 'style="display: block; "';
}elseif ($checkedpricebraslet == 'none'){
    $stylepricebraslet = 'style="display: none; "';
}
if ($checkedpricecovers == 'checked'){
    $stylepricecovers = 'style="display: block; "';
}elseif ($checkedpricecovers == 'none'){
    $stylepricecovers = 'style="display: none; "';
}