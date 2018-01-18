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
        echo '<h2 class="page__title-h2">Блок с обьявлением включен</h2>';
        $checkedmsgon = '$checkedmsgon';
        $content = file_get_contents($config);
        $content .= "$checkedmsgon = 'checked';\n ";
        file_put_contents($config, $content);
    } elseif(isset($_POST['msg_on']) == false ) {
        echo '<h2 class="page__title-h2">Блок с обьявлением выключен</h2>';
        $checkedmsgon = '$checkedmsgon';
        $content = file_get_contents($config);
        $content .= "$checkedmsgon = 'none';\n ";
        file_put_contents($config, $content);
    }
    if(isset($_POST['stock_on']) == true ){
        echo '<h2 class="page__title-h2">Блок с акцией включен</h2>';
        $checkedstock = '$checkedstock';
        $contents = file_get_contents($config);
        $contents .= "$checkedstock = 'checked';\n ";
        file_put_contents($config, $contents);
    } elseif (isset($_POST['stock_on']) == false){
        echo '<h2 class="page__title-h2">Блок с акцией выключен</h2>';
        $checkedstock = '$checkedstock';
        $contents = file_get_contents($config);
        $contents .= "$checkedstock = 'none';\n ";
        file_put_contents($config, $contents);
    }
    ?>
    <div class="admin__link-down clearfix">
        <a class="admin__link" href="/admin/message/activate/msgactivate.php">Вернуться на предыдущую страницу</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>
