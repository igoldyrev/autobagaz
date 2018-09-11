<?php echo "<title>Сообщение обновлено</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html"); ?>

<div class="admin__container">
    <?php
    $dbname = "9082410193_news";

    include ($_SERVER["DOCUMENT_ROOT"]."/backend/connectdb.php");

    $id=$_REQUEST['id'];
    $title=trim($_REQUEST['title']);
    $msg=trim($_REQUEST['msg']);
    $holiday=trim($_REQUEST['holiday']);

    $update_sql = "UPDATE message SET title='$title', msg='$msg', holiday='$holiday' WHERE id='$id'";
    mysqli_query($connect, $update_sql) or die("Ошибка обновления" . mysqli_error());
    echo '<h3 class="title title-h3">Сообщение успешно обновлено!</h3>'; ?>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/message/update/msgupdate">Вернуться к выбору сообщения</a>
        <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
    </div>
</div>
