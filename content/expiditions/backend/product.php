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
        } elseif ($id == 'abrenodaster') { ?>

            <title><?php echo $keywords[3][title]; ?></title>
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
                        <li><?php echo $lists[2]['item1'] ?></li>
                        <li><?php echo $lists[2]['item2'] ?></li>
                        <li><?php echo $lists[2]['item3'] ?></li>
                        <li><?php echo $lists[2]['item4'] ?></li>
                        <li><?php echo $lists[2]['item5'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abplatforma') { ?>

            <title><?php echo $keywords[4][title]; ?></title>
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
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[3]['item1'] ?></li>
                        <li><?php echo $lists[3]['item2'] ?></li>
                        <li><?php echo $lists[3]['item3'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abkorzina') { ?>

            <title><?php echo $keywords[5][title]; ?></title>
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
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[4]['item1'] ?></li>
                        <li><?php echo $lists[4]['item2'] ?></li>
                        <li><?php echo $lists[4]['item3'] ?></li>
                        <li><?php echo $lists[4]['item4'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abexpidition') { ?>

            <title><?php echo $keywords[6][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <p class="text"><?php echo $product['desc2'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[5]['item1'] ?></li>
                        <li><?php echo $lists[5]['item2'] ?></li>
                        <li><?php echo $lists[5]['item3'] ?></li>
                        <li><?php echo $lists[5]['item4'] ?></li>
                        <li><?php echo $lists[5]['item5'] ?></li>
                        <li><?php echo $lists[5]['item6'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abplatforma-vodostok') { ?>

            <title><?php echo $keywords[7][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[6]['item1'] ?></li>
                        <li><?php echo $lists[6]['item2'] ?></li>
                        <li><?php echo $lists[6]['item3'] ?></li>
                        <li><?php echo $lists[6]['item4'] ?></li>
                        <li><?php echo $lists[6]['item5'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abkorzina-universal') { ?>

            <title><?php echo $keywords[8][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[7]['item1'] ?></li>
                        <li><?php echo $lists[7]['item2'] ?></li>
                        <li><?php echo $lists[7]['item3'] ?></li>
                        <li><?php echo $lists[7]['item4'] ?></li>
                        <li><?php echo $lists[7]['item5'] ?></li>
                        <li><?php echo $lists[7]['item6'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abniva2121') { ?>

            <title><?php echo $keywords[9][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <p class="text"><?php echo $product['desc2'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[8]['item1'] ?></li>
                        <li><?php echo $lists[8]['item2'] ?></li>
                        <li><?php echo $lists[8]['item3'] ?></li>
                        <li><?php echo $lists[8]['item4'] ?></li>
                        <li><?php echo $lists[8]['item5'] ?></li>
                        <li><?php echo $lists[8]['item6'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abkiasportage') { ?>

            <title><?php echo $keywords[10][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[9]['item1'] ?></li>
                        <li><?php echo $lists[9]['item2'] ?></li>
                        <li><?php echo $lists[9]['item3'] ?></li>
                        <li><?php echo $lists[9]['item4'] ?></li>
                        <li><?php echo $lists[9]['item5'] ?></li>
                        <li><?php echo $lists[9]['item6'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abniva2131') { ?>

            <title><?php echo $keywords[11][title]; ?></title>
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
                        <li><?php echo $lists[10]['item1'] ?></li>
                        <li><?php echo $lists[10]['item2'] ?></li>
                        <li><?php echo $lists[10]['item3'] ?></li>
                        <li><?php echo $lists[10]['item4'] ?></li>
                        <li><?php echo $lists[10]['item5'] ?></li>
                        <li><?php echo $lists[10]['item6'] ?></li>
                        <li><?php echo $lists[10]['item7'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abusilennyi') { ?>

            <title><?php echo $keywords[12][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img4'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[11]['item1'] ?></li>
                        <li><?php echo $lists[11]['item2'] ?></li>
                        <li><?php echo $lists[11]['item3'] ?></li>
                        <li><?php echo $lists[11]['item4'] ?></li>
                        <li><?php echo $lists[11]['item5'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abtoyotaprado') { ?>

            <title><?php echo $keywords[13][title]; ?></title>
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
                        <li><?php echo $lists[12]['item1'] ?></li>
                        <li><?php echo $lists[12]['item2'] ?></li>
                        <li><?php echo $lists[12]['item3'] ?></li>
                        <li><?php echo $lists[12]['item4'] ?></li>
                        <li><?php echo $lists[12]['item5'] ?></li>
                        <li><?php echo $lists[12]['item6'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abpatriot') { ?>

            <title><?php echo $keywords[14][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <p class="text"><?php echo $product['desc2'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[13]['item1'] ?></li>
                        <li><?php echo $lists[13]['item2'] ?></li>
                        <li><?php echo $lists[13]['item3'] ?></li>
                        <li><?php echo $lists[13]['item4'] ?></li>
                        <li><?php echo $lists[13]['item5'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abxterra') { ?>

            <title><?php echo $keywords[15][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <p class="text"><?php echo $product['desc2'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[14]['item1'] ?></li>
                        <li><?php echo $lists[14]['item2'] ?></li>
                        <li><?php echo $lists[14]['item3'] ?></li>
                        <li><?php echo $lists[14]['item4'] ?></li>
                        <li><?php echo $lists[14]['item5'] ?></li>
                        <li><?php echo $lists[14]['item6'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abmodern') { ?>

            <title><?php echo $keywords[16][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[15]['item1'] ?></li>
                        <li><?php echo $lists[15]['item2'] ?></li>
                        <li><?php echo $lists[15]['item3'] ?></li>
                        <li><?php echo $lists[15]['item4'] ?></li>
                        <li><?php echo $lists[15]['item5'] ?></li>
                        <li><?php echo $lists[15]['item6'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'ablux-3door') { ?>

            <title><?php echo $keywords[17][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img4'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[16]['item1'] ?></li>
                        <li><?php echo $lists[16]['item2'] ?></li>
                        <li><?php echo $lists[16]['item3'] ?></li>
                        <li><?php echo $lists[16]['item4'] ?></li>
                        <li><?php echo $lists[16]['item5'] ?></li>
                        <li><?php echo $lists[16]['item6'] ?></li>
                        <li><?php echo $lists[16]['item7'] ?></li>
                        <li><?php echo $lists[16]['item8'] ?></li>
                        <li><?php echo $lists[16]['item9'] ?></li>
                        <li><?php echo $lists[16]['item10'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abwallhover') { ?>

            <title><?php echo $keywords[18][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <p class="text"><?php echo $product['desc2'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[17]['item1'] ?></li>
                        <li><?php echo $lists[17]['item2'] ?></li>
                        <li><?php echo $lists[17]['item3'] ?></li>
                        <li><?php echo $lists[17]['item4'] ?></li>
                        <li><?php echo $lists[17]['item5'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abuazhunter') { ?>

            <title><?php echo $keywords[19][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <p class="text"><?php echo $product['desc2'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[18]['item1'] ?></li>
                        <li><?php echo $lists[18]['item2'] ?></li>
                        <li><?php echo $lists[18]['item3'] ?></li>
                        <li><?php echo $lists[18]['item4'] ?></li>
                        <li><?php echo $lists[18]['item5'] ?></li>
                        <li><?php echo $lists[18]['item6'] ?></li>
                        <li><?php echo $lists[18]['item7'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abmodern-duster') { ?>

            <title><?php echo $keywords[20][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[19]['item1'] ?></li>
                        <li><?php echo $lists[19]['item2'] ?></li>
                        <li><?php echo $lists[19]['item3'] ?></li>
                        <li><?php echo $lists[19]['item4'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abnina-5door') { ?>

            <title><?php echo $keywords[21][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[20]['item1'] ?></li>
                        <li><?php echo $lists[20]['item2'] ?></li>
                        <li><?php echo $lists[20]['item3'] ?></li>
                        <li><?php echo $lists[20]['item4'] ?></li>
                        <li><?php echo $lists[20]['item5'] ?></li>
                        <li><?php echo $lists[20]['item6'] ?></li>
                        <li><?php echo $lists[20]['item7'] ?></li>
                        <li><?php echo $lists[20]['item8'] ?></li>
                        <li><?php echo $lists[20]['item9'] ?></li>
                        <li><?php echo $lists[20]['item10'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abuaz') { ?>

            <title><?php echo $keywords[22][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img4'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[21]['item1'] ?></li>
                        <li><?php echo $lists[21]['item2'] ?></li>
                        <li><?php echo $lists[21]['item3'] ?></li>
                        <li><?php echo $lists[21]['item4'] ?></li>
                        <li><?php echo $lists[21]['item5'] ?></li>
                        <li><?php echo $lists[21]['item6'] ?></li>
                        <li><?php echo $lists[21]['item7'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abmodern-lux') { ?>

            <title><?php echo $keywords[23][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img4'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[22]['item1'] ?></li>
                        <li><?php echo $lists[22]['item2'] ?></li>
                        <li><?php echo $lists[22]['item3'] ?></li>
                        <li><?php echo $lists[22]['item4'] ?></li>
                        <li><?php echo $lists[22]['item5'] ?></li>
                        <li><?php echo $lists[22]['item6'] ?></li>
                        <li><?php echo $lists[22]['item7'] ?></li>
                        <li><?php echo $lists[22]['item8'] ?></li>
                        <li><?php echo $lists[22]['item9'] ?></li>
                        <li><?php echo $lists[22]['item10'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abrendjer') { ?>

            <title><?php echo $keywords[24][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <p class="text"><?php echo $product['desc1'] ?></p>
                    <p class="text"><?php echo $product['desc2'] ?></p>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[23]['item1'] ?></li>
                        <li><?php echo $lists[23]['item2'] ?></li>
                        <li><?php echo $lists[23]['item3'] ?></li>
                        <li><?php echo $lists[23]['item4'] ?></li>
                        <li><?php echo $lists[23]['item5'] ?></li>
                        <li><?php echo $lists[23]['item6'] ?></li>
                    </ul>
                    <div class="good__price">
                        <p class="span">Цена: <strong><?php echo $product['price'] ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'abfurgon') { ?>

            <title><?php echo $keywords[25][title]; ?></title>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $product['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img3'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $product['img4'] ?>">
                </div>
                <div class="product__info">
                    <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
                    <ul class="list list__unsorted">
                        <li><?php echo $lists[24]['item1'] ?></li>
                        <li><?php echo $lists[24]['item2'] ?></li>
                        <li><?php echo $lists[24]['item3'] ?></li>
                        <li><?php echo $lists[24]['item4'] ?></li>
                        <li><?php echo $lists[24]['item5'] ?></li>
                        <li><?php echo $lists[24]['item6'] ?></li>
                        <li><?php echo $lists[24]['item7'] ?></li>
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
