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
        } ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."backend/blocks/counters.html"); ?>
