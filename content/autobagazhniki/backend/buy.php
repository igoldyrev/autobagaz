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
            <div class="good-message">
                <?php echo "<p class='text'>Вы  не выбрали ничего для заказа. Вернитесь в каталог и выберите из него что-нибудь. А затем заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
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
        } ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."backend/blocks/counters.html"); ?>