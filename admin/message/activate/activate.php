<?php
echo "<title>Состояние блока изменено</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/admin/headtags.html"); ?>

<div class="admin__container">
    <?php
    $file = fopen("configmessage.php", 'a');
    ftruncate($file, 0);
    $config = 'configmessage.php';
    $head = "<?php \n";
    file_put_contents($config, $head);
    if(isset($_POST['msg_on']) == true ){
        echo '<h1 class="page__title-h1">Блок включен</h1>';
        $checkedmsgon = '$checkedmsgon';
        $content = file_get_contents($config);
        $content .= "$checkedmsgon = 'checked';\n ";
        file_put_contents($config, $content);
        echo "$content";
    } else {
        echo '<h1 class="page__title-h1">Блок выключен</h1>';
        $checkedmsgon = '$checkedmsgon';
        $content = file_get_contents($config);
        $content .= "$checkedmsgon = 'none';\n ";
        file_put_contents($config, $content);
        echo "$content";
    }
    ?>
    <div class="admin__link-down clearfix">
        <a class="admin__link" href="/admin/message/activate/msgactivate.php">Вернуться на предыдущую страницу</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>
