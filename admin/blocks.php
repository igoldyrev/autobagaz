<?php
include ($_SERVER["DOCUMENT_ROOT"]."/admin/config.php");
if ($checkedmsgon == 'checked'){
    $style = 'style="display: flex; "';
}elseif ($checkedmsgon == 'none'){
    $style = 'style="display: none; "';
}
if ($checkedstock == 'checked'){
    $style = 'style="display: block; "';
}elseif ($checkedstock == 'none'){
    $style = 'style="display: none; "';
}
