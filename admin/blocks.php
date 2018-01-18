<?php
include ($_SERVER["DOCUMENT_ROOT"]."/admin/config.php");
if ($checkedmsgon == 'checked'){
    $stylemsg = 'style="display: flex; "';
}elseif ($checkedmsgon == 'none'){
    $stylemsg = 'style="display: none; "';
}
if ($checkedstock == 'checked'){
    $stylestock = 'style="display: block; "';
}elseif ($checkedstock == 'none'){
    $stylestock = 'style="display: none; "';
}
