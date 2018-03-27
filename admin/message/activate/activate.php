<?php
echo "<title>Состояние блока изменено</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <?php
    $file = fopen("configmessage.php", 'a');
    ftruncate($file, 0);
    $config = 'configmessage.php';
    $head = "<?php \n";
    file_put_contents($config, $head);
    if(isset($_POST['msg_on']) == true ){
        echo '<h2 class="title title-h2">Блок с обьявлением включен</h2>';
        $checkedmsgon = '$checkedmsgon';
        $content = file_get_contents($config);
        $content .= "$checkedmsgon = 'checked';\n ";
        file_put_contents($config, $content);
    } elseif(isset($_POST['msg_on']) == false ) {
        echo '<h2 class="title title-h2">Блок с обьявлением выключен</h2>';
        $checkedmsgon = '$checkedmsgon';
        $content = file_get_contents($config);
        $content .= "$checkedmsgon = 'none';\n ";
        file_put_contents($config, $content);
    }
    if(isset($_POST['stock_on']) == true ){
        echo '<h2 class="title title-h2">Блок с акцией включен</h2>';
        $checkedstock = '$checkedstock';
        $contents = file_get_contents($config);
        $contents .= "$checkedstock = 'checked';\n ";
        file_put_contents($config, $contents);
    } elseif (isset($_POST['stock_on']) == false){
        echo '<h2 class="title title-h2">Блок с акцией выключен</h2>';
        $checkedstock = '$checkedstock';
        $contents = file_get_contents($config);
        $contents .= "$checkedstock = 'none';\n ";
        file_put_contents($config, $contents);
    }
    if(isset($_POST['price_on_bagazh']) == true ){
        echo '<h2 class="title title-h2">Цены в разделе Автобагажники показываются</h2>';
        $checkedpricebagazh = '$checkedpricebagazh';
        $contents = file_get_contents($config);
        $contents .= "$checkedpricebagazh = 'checked';\n ";
        file_put_contents($config, $contents);
    } elseif (isset($_POST['price_on_bagazh']) == false){
        echo '<h2 class="title title-h2">Цены в разделе Автобагажники НЕ показываются</h2>';
        $checkedpricebagazh = '$checkedpricebagazh';
        $contents = file_get_contents($config);
        $contents .= "$checkedpricebagazh = 'none';\n ";
        file_put_contents($config, $contents);
    }
    if(isset($_POST['price_on_autobox']) == true ){
        echo '<h2 class="title title-h2">Цены в разделе Автобоксы показываются</h2>';
        $checkedpriceautobox = '$checkedpriceautobox';
        $contents = file_get_contents($config);
        $contents .= "$checkedpriceautobox = 'checked';\n ";
        file_put_contents($config, $contents);
    } elseif (isset($_POST['price_on_autobox']) == false){
        echo '<h2 class="title title-h2">Цены в разделе Автобоксы НЕ показываются</h2>';
        $checkedpriceautobox = '$checkedpriceautobox';
        $contents = file_get_contents($config);
        $contents .= "$checkedpriceautobox = 'none';\n ";
        file_put_contents($config, $contents);
    }
    if(isset($_POST['price_on_velo']) == true ){
        echo '<h2 class="title title-h2">Цены в разделе Велокрепления показываются</h2>';
        $checkedpricevelo = '$checkedpricevelo';
        $contents = file_get_contents($config);
        $contents .= "$checkedpricevelo = 'checked';\n ";
        file_put_contents($config, $contents);
    } elseif (isset($_POST['price_on_velo']) == false){
        echo '<h2 class="title title-h2">Цены в разделе Велокрепления НЕ показываются</h2>';
        $checkedpricevelo = '$checkedpricevelo';
        $contents = file_get_contents($config);
        $contents .= "$checkedpricevelo = 'none';\n ";
        file_put_contents($config, $contents);
    }
    if(isset($_POST['price_on_skies']) == true ){
        echo '<h2 class="title title-h2">Цены в разделе Лыжные крепления показываются</h2>';
        $checkedpriceskies = '$checkedpriceskies';
        $contents = file_get_contents($config);
        $contents .= "$checkedpriceskies = 'checked';\n ";
        file_put_contents($config, $contents);
    } elseif (isset($_POST['price_on_skies']) == false){
        echo '<h2 class="title title-h2">Цены в разделе Лыжные крепления НЕ показываются</h2>';
        $checkedpriceskies = '$checkedpriceskies';
        $contents = file_get_contents($config);
        $contents .= "$checkedpriceskies = 'none';\n ";
        file_put_contents($config, $contents);
    }
    if(isset($_POST['price_on_braslet']) == true ){
        echo '<h2 class="title title-h2">Цены в разделе Браслеты показываются</h2>';
        $checkedpricebraslet = '$checkedpricebraslet';
        $contents = file_get_contents($config);
        $contents .= "$checkedpricebraslet = 'checked';\n ";
        file_put_contents($config, $contents);
    } elseif (isset($_POST['price_on_braslet']) == false){
        echo '<h2 class="title title-h2">Цены в разделе Браслеты НЕ показываются</h2>';
        $checkedpricebraslet = '$checkedpricebraslet';
        $contents = file_get_contents($config);
        $contents .= "$checkedpricebraslet = 'none';\n ";
        file_put_contents($config, $contents);
    } ?>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/message/activate/msgactivate">Вернуться на предыдущую страницу</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>
