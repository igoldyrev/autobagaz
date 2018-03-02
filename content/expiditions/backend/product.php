<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/header.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/proposition/proposition.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/expiditions/backend/array.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/expiditions/backend/lists.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/expiditions/backend/keywords.php"); ?>

<div class="wrapper">
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php
        $id = $_GET['id'];
        $good = [];
        foreach ($expiditions as $product) {
            if ($product['id'] == $id) {
                $good = $product;
                break;
            }
        };

        if($id == 'abcheviniva') { ?>

            <title><?php echo $keywords[1][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img4'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <p class="text"><?php echo $product['desc2'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[0]['item1'] ?></li>
                        <li><?php echo $lists[0]['item2'] ?></li>
                        <li><?php echo $lists[0]['item3'] ?></li>
                        <li><?php echo $lists[0]['item4'] ?></li>
                        <li><?php echo $lists[0]['item5'] ?></li>
                        <li><?php echo $lists[0]['item6'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
            } elseif ($id == 'absuzukijimmny') { ?>

            <title><?php echo $keywords[2][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img4'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img5'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <p class="text"><?php echo $product['desc2'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[1]['item1'] ?></li>
                        <li><?php echo $lists[1]['item2'] ?></li>
                        <li><?php echo $lists[1]['item3'] ?></li>
                        <li><?php echo $lists[1]['item4'] ?></li>
                        <li><?php echo $lists[1]['item5'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php

        }



        ?>


    </div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
