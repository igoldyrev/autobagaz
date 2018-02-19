<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/content/autobagazhniki/backend/array.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php
        $id = $_GET['id'];
        $good = [];
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                $good = $product;
                break;
            }
        };


        echo $product['name'];
        echo $item['img1'];
        echo $item['img2'];
        echo $product['desc'];
        echo $item['price'];
        ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html"); ?>