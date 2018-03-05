<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">

    <?php

    $id = $_GET['id'];

    if (!isset($id)) {
        echo "<title>"; echo "Выберите товар для заказа"; echo "</title>"; ?>
        <div class="good_message">
        <?php echo "<p>Вы  не выбрали ничего для заказа. Вернитесь в каталог и выберите из него что-нибудь. А затем заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ab1') {
        $tovar = $_SESSION['autobagazhniki'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][0][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p class='text'>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ab2') {
        $tovar = $_SESSION['autobagazhniki'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][1][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p class='text'>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ab3') {
        $tovar = $_SESSION['autobagazhniki'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][2][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p class='text'>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ab4') {
        $tovar = $_SESSION['autobagazhniki'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][3][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p class='text'>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 's1') {
        $tovar = $_SESSION['sales'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['sales'][0][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p class='text'>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 's2') {
        $tovar = $_SESSION['sales'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['sales'][1][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p class='text'>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 's3') {
        $tovar = $_SESSION['sales'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['sales'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'yuago') {
        $tovar = $_SESSION['yuago'][name];
        echo "<title>Заказ товара "; echo $_SESSION['yuago'][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'turino') {
        $tovar = $_SESSION['turino'][name];
        echo "<title>Заказ товара "; echo $_SESSION['turino'][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'lux600blackmetal') {
        $tovar = $_SESSION['lux'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['lux'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'lux600blackfrosted') {
        $tovar = $_SESSION['lux'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['lux'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'lux600white') {
        $tovar = $_SESSION['lux'][name3];
        echo "<title>Заказ товара "; echo $_SESSION['lux'][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'lux960blackfrosted') {
        $tovar = $_SESSION['lux'][name4];
        echo "<title>Заказ товара "; echo $_SESSION['lux'][name4]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'lux960blackmetal') {
        $tovar = $_SESSION['lux'][name5];
        echo "<title>Заказ товара "; echo $_SESSION['lux'][name5]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'lux960white') {
        $tovar = $_SESSION['lux'][name6];
        echo "<title>Заказ товара "; echo $_SESSION['lux'][name6]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'dc320') {
        $tovar = $_SESSION['discoveryclassic'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['discoveryclassic'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'dc430') {
        $tovar = $_SESSION['discoveryclassic'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['discoveryclassic'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'dc500') {
        $tovar = $_SESSION['discoveryclassic'][name3];
        echo "<title>Заказ товара "; echo $_SESSION['discoveryclassic'][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ds431') {
        $tovar = $_SESSION['discoverysport'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['discoverysport'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ds501') {
        $tovar = $_SESSION['discoverysport'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['discoverysport'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'dynamic434') {
        $tovar = $_SESSION['dynamic'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['dynamic'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'dynamic504') {
        $tovar = $_SESSION['dynamic'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['dynamic'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'airtek435') {
        $tovar = $_SESSION['airtek'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['airtek'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'airtek505') {
        $tovar = $_SESSION['airtek'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['airtek'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '400Mblack') {
        $tovar = $_SESSION['vetlan'][0][name1];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][0][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '400Mgray') {
        $tovar = $_SESSION['vetlan'][0][name2];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][0][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '400Mwhite') {
        $tovar = $_SESSION['vetlan'][0][name3];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][0][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '430Mblack') {
        $tovar = $_SESSION['vetlan'][1][name1];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][1][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '430Mgray') {
        $tovar = $_SESSION['vetlan'][1][name2];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][1][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '430Mwhite') {
        $tovar = $_SESSION['vetlan'][1][name3];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][1][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '550Mblack') {
        $tovar = $_SESSION['vetlan'][2][name1];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][2][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '550Mgray') {
        $tovar = $_SESSION['vetlan'][2][name2];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][2][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '550Mwhite') {
        $tovar = $_SESSION['vetlan'][2][name3];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][2][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vk1') {
        $tovar = $_SESSION['velokrysha'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][0][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vk2') {
        $tovar = $_SESSION['velokrysha'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][1][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vk3') {
        $tovar = $_SESSION['velokrysha'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][2][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vk4') {
        $tovar = $_SESSION['velokrysha'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][3][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vf1') {
        $tovar = $_SESSION['velofarkop'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['velofarkop'][0][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vf2') {
        $tovar = $_SESSION['velofarkop'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['velofarkop'][1][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'amos34') {
        $tovar = $_SESSION['lyzhi'][0][name1];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][0][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'amos56') {
        $tovar = $_SESSION['lyzhi'][0][name2];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][0][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'atlant34') {
        $tovar = $_SESSION['lyzhi'][1][name1];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][1][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'atlant56') {
        $tovar = $_SESSION['lyzhi'][1][name2];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][1][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'montblanc34') {
        $tovar = $_SESSION['lyzhi'][2][name1];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][2][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'montblanc56') {
        $tovar = $_SESSION['lyzhi'][2][name2];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][2][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'thule34') {
        $tovar = $_SESSION['lyzhi'][3][name1];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][3][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'thule56') {
        $tovar = $_SESSION['lyzhi'][3][name2];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][3][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xtender') {
        $tovar = $_SESSION['lyzhi'][4][name];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][4][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'r12') {
        $tovar = $_SESSION['braslet'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['braslet'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'r16') {
        $tovar = $_SESSION['braslet'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['braslet'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'gazel') {
        $tovar = $_SESSION['braslet'][name3];
        echo "<title>Заказ товара "; echo $_SESSION['braslet'][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'stay_set_su') {
        $tovar = $_SESSION['inno_basic'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_basic'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'stay_set_fr') {
        $tovar = $_SESSION['inno_basic'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_basic'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'stay_set_xr') {
        $tovar = $_SESSION['inno_basic'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_basic'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'stay_set') {
        $tovar = $_SESSION['inno_basic'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_basic'][3][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xs100') {
        $tovar = $_SESSION['inno_aero'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_aero'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xs200') {
        $tovar = $_SESSION['inno_aero'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_aero'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xs300') {
        $tovar = $_SESSION['inno_aero'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_aero'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xs400') {
        $tovar = $_SESSION['inno_aero'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_aero'][3][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA1260U5') {
        $tovar = $_SESSION['inno_box'][0][name1];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][0][name1]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA1260U6') {
        $tovar = $_SESSION['inno_box'][0][name2];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][0][name2]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA1250U1') {
        $tovar = $_SESSION['inno_box'][0][name3];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][0][name3]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA1460U5') {
        $tovar = $_SESSION['inno_box'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA33RBK') {
        $tovar = $_SESSION['inno_box'][2][name1];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][2][name1]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA33RDS') {
        $tovar = $_SESSION['inno_box'][2][name2];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][2][name2]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA56U1') {
        $tovar = $_SESSION['inno_box'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][3][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xrayblack') {
        $tovar = $_SESSION['lada_xray'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['lada_xray'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xraygray') {
        $tovar = $_SESSION['lada_xray'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['lada_xray'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xraywhite') {
        $tovar = $_SESSION['lada_xray'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['lada_xray'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'largusblack') {
        $tovar = $_SESSION['lada_largus'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['lada_largus'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'largusgray') {
        $tovar = $_SESSION['lada_largus'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['lada_largus'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'larguswhite') {
        $tovar = $_SESSION['lada_largus'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['lada_largus'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'liftbekblack') {
        $tovar = $_SESSION['granta_liftbek'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['granta_liftbek'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'liftbekgray') {
        $tovar = $_SESSION['granta_liftbek'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['granta_liftbek'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'liftbekwhite') {
        $tovar = $_SESSION['granta_liftbek'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['granta_liftbek'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'grantaeblack') {
        $tovar = $_SESSION['granta_e'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['granta_e'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'grantaegray') {
        $tovar = $_SESSION['granta_e'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['granta_e'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'grantaeblackpoperechina') {
        $tovar = $_SESSION['granta_e'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['granta_e'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'grantaegraypoperechina') {
        $tovar = $_SESSION['granta_e'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['granta_e'][3][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'grantablack') {
        $tovar = $_SESSION['granta_sedan'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['granta_sedan'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'grantagray') {
        $tovar = $_SESSION['granta_sedan'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['granta_sedan'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'grantawhite') {
        $tovar = $_SESSION['granta_sedan'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['granta_sedan'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kalinaxetchbekblack') {
        $tovar = $_SESSION['kalina_xetchbek'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['kalina_xetchbek'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kalinaxetchbekgray') {
        $tovar = $_SESSION['kalina_xetchbek'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['kalina_xetchbek'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kalinaxetchbekwhite') {
        $tovar = $_SESSION['kalina_xetchbek'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['kalina_xetchbek'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kalinauniversal2008black') {
        $tovar = $_SESSION['kalina_universal'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['kalina_universal'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kalinauniversal2008gray') {
        $tovar = $_SESSION['kalina_universal'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['kalina_universal'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kalinauniversal2013black') {
        $tovar = $_SESSION['kalina_universal'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['kalina_universal'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kalinauniversal2013gray') {
        $tovar = $_SESSION['kalina_universal'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['kalina_universal'][3][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kalinauniversal2008cleanblack') {
        $tovar = $_SESSION['kalina_universal'][4][name];
        echo "<title>Заказ товара "; echo $_SESSION['kalina_universal'][4][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kalinauniversal2013cleangray') {
        $tovar = $_SESSION['kalina_universal'][5][name];
        echo "<title>Заказ товара "; echo $_SESSION['kalina_universal'][5][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '4x4black') {
        $tovar = $_SESSION['lada_4x4'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['lada_4x4'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '4x4gray') {
        $tovar = $_SESSION['lada_4x4'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['lada_4x4'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '4x4lblack') {
        $tovar = $_SESSION['lada_4x4_l'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['lada_4x4_l'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '4x4lgray') {
        $tovar = $_SESSION['lada_4x4'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['lada_4x4_l'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'nivamblack') {
        $tovar = $_SESSION['niva_m'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['niva_m'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'nivamgray') {
        $tovar = $_SESSION['niva_m'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['niva_m'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'nivalblack') {
        $tovar = $_SESSION['niva_l'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['niva_l'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'nivalgray') {
        $tovar = $_SESSION['niva_l'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['niva_l'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'nivalwhite') {
        $tovar = $_SESSION['niva_l'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['niva_l'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ceed2006black') {
        $tovar = $_SESSION['kia_ceed_2006'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['kia_ceed_2006'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ceed2006gray') {
        $tovar = $_SESSION['kia_ceed_2006'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['kia_ceed_2006'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ceed2006white') {
        $tovar = $_SESSION['kia_ceed_2006'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['kia_ceed_2006'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ceed2012black') {
        $tovar = $_SESSION['kia_ceed_2012'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['kia_ceed_2012'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ceed2012gray') {
        $tovar = $_SESSION['kia_ceed_2012'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['kia_ceed_2012'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ceed2012white') {
        $tovar = $_SESSION['kia_ceed_2012'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['kia_ceed_2012'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'astrablack') {
        $tovar = $_SESSION['opel_astra_2004'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['opel_astra_2004'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'astragray') {
        $tovar = $_SESSION['opel_astra_2004'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['opel_astra_2004'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'astrawhite') {
        $tovar = $_SESSION['$opel_astra_2004'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['opel_astra_2004'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'freelanderblack') {
        $tovar = $_SESSION['landrover'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['landrover'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'freelandergray') {
        $tovar = $_SESSION['landrover'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['landrover'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'freelanderwhite') {
        $tovar = $_SESSION['landrover'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['landrover'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'cretablack') {
        $tovar = $_SESSION['hyundai_creta'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['hyundai_creta'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'cretagray') {
        $tovar = $_SESSION['hyundai_creta'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['hyundai_creta'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'cretawhite') {
        $tovar = $_SESSION['hyundai_creta'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['hyundai_creta'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'solarisblack') {
        $tovar = $_SESSION['hyundai_solaris'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['hyundai_solaris'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'solarisgray') {
        $tovar = $_SESSION['hyundai_solaris'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['hyundai_solaris'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'solariswhite') {
        $tovar = $_SESSION['hyundai_solaris'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['hyundai_solaris'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'i30black') {
        $tovar = $_SESSION['hyundai_i30'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['hyundai_i30'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'i30gray') {
        $tovar = $_SESSION['hyundai_i30'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['hyundai_i30'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'i30white') {
        $tovar = $_SESSION['hyundai_i30'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['hyundai_i30'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'mazda3black') {
        $tovar = $_SESSION['mazda3'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['mazda3'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'mazda3gray') {
        $tovar = $_SESSION['mazda3'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['mazda3'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'mazda3white') {
        $tovar = $_SESSION['mazda3'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['mazda3'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'mazdacx5oneblack') {
        $tovar = $_SESSION['mazda_cx5_1'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['mazda_cx5_1'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'mazdacx5onegray') {
        $tovar = $_SESSION['mazda_cx5_1'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['mazda_cx5_1'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'mazdacx5onewhite') {
        $tovar = $_SESSION['mazda_cx5_1'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['mazda_cx5_1'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'mazdacx5twoblack') {
        $tovar = $_SESSION['mazda_cx5_2'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['mazda_cx5_2'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'mazdacx5twogray') {
        $tovar = $_SESSION['mazda_cx5_2'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['mazda_cx5_2'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'mazdacx5twowhite') {
        $tovar = $_SESSION['mazda_cx5_2'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['mazda_cx5_2'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'rav42006black') {
        $tovar = $_SESSION['toyota_rav4_2006'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['toyota_rav4_2006'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'rav42006gray') {
        $tovar = $_SESSION['toyota_rav4_2006'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['toyota_rav4_2006'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'rav42006white') {
        $tovar = $_SESSION['toyota_rav4_2006'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['toyota_rav4_2006'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'rav42013black') {
        $tovar = $_SESSION['toyota_rav4_2013'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['toyota_rav4_2013'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'rav42013gray') {
        $tovar = $_SESSION['toyota_rav4_2013'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['toyota_rav4_2013'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'rav42013white') {
        $tovar = $_SESSION['toyota_rav4_2013'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['toyota_rav4_2013'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'prado150black') {
        $tovar = $_SESSION['toyota_prado150'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['toyota_prado150'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'prado150gray') {
        $tovar = $_SESSION['toyota_prado150'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['toyota_prado150'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'prado150white') {
        $tovar = $_SESSION['toyota_prado150'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['toyota_prado150'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kapturblack') {
        $tovar = $_SESSION['renault_kaptur'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_kaptur'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kapturgray') {
        $tovar = $_SESSION['renault_kaptur'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_kaptur'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'kapturwhite') {
        $tovar = $_SESSION['renault_kaptur'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_kaptur'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'logan2004black') {
        $tovar = $_SESSION['renault_logan_2004'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_logan_2004'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'logan2004gray') {
        $tovar = $_SESSION['renault_logan_2004'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_logan_2004'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'logan2004white') {
        $tovar = $_SESSION['renault_logan_2004'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_logan_2004'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'logan2015black') {
        $tovar = $_SESSION['renault_logan_2015'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_logan_2015'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'logan2015gray') {
        $tovar = $_SESSION['renault_logan_2015'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_logan_2015'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'logan2015white') {
        $tovar = $_SESSION['renault_logan_2015'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_logan_2015'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'sandero2010black') {
        $tovar = $_SESSION['renault_sandero_2010'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_sandero_2010'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'sandero2010gray') {
        $tovar = $_SESSION['renault_sandero_2010'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_sandero_2010'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'sandero2010white') {
        $tovar = $_SESSION['renault_sandero_2010'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_sandero_2010'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'sandero2015black') {
        $tovar = $_SESSION['renault_sandero_2014'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_sandero_2014'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'sandero2015gray') {
        $tovar = $_SESSION['renault_sandero_2014'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_sandero_2014'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'sandero2015white') {
        $tovar = $_SESSION['renault_sandero_2014'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['renault_sandero_2014'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abcheviniva') {
        $tovar = $_SESSION['expiditions'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'absuzukijimmny') {
        $tovar = $_SESSION['expiditions'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abrenodaster') {
        $tovar = $_SESSION['expiditions'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abplatforma') {
        $tovar = $_SESSION['expiditions'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][3][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abkorzina') {
        $tovar = $_SESSION['expiditions'][4][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][4][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abexpidition') {
        $tovar = $_SESSION['expiditions'][5][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][5][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abplatforma-vodostok') {
        $tovar = $_SESSION['expiditions'][6][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][6][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abkorzina-universal') {
        $tovar = $_SESSION['expiditions'][7][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][7][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abniva2121') {
        $tovar = $_SESSION['expiditions'][8][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][8][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abkiasportage') {
        $tovar = $_SESSION['expiditions'][9][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][9][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abniva2131') {
        $tovar = $_SESSION['expiditions'][10][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][10][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abusilennyi') {
        $tovar = $_SESSION['expiditions'][11][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][11][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abtoyotaprado') {
        $tovar = $_SESSION['expiditions'][12][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][12][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abpatriot') {
        $tovar = $_SESSION['expiditions'][13][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][13][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abxterra') {
        $tovar = $_SESSION['expiditions'][14][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][14][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abmodern') {
        $tovar = $_SESSION['expiditions'][15][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][15][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ablux-3door') {
        $tovar = $_SESSION['expiditions'][16][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][16][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abwallhover') {
        $tovar = $_SESSION['expiditions'][17][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][17][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abuazhunter') {
        $tovar = $_SESSION['expiditions'][18][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][18][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abmodern-duster') {
        $tovar = $_SESSION['expiditions'][19][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][19][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abnina-5door') {
        $tovar = $_SESSION['expiditions'][20][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][20][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abuaz') {
        $tovar = $_SESSION['expiditions'][21][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][21][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abmodern-lux') {
        $tovar = $_SESSION['expiditions'][22][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][22][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abrendjer') {
        $tovar = $_SESSION['expiditions'][23][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][23][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'abfurgon') {
        $tovar = $_SESSION['expiditions'][24][name];
        echo "<title>Заказ товара "; echo $_SESSION['expiditions'][24][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    }
    $_SESSION['tovar'] = $tovar;
    include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/buyform.php");
    ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
