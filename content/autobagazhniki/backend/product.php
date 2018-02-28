<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/header.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/proposition/proposition.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation/navigation.html");
include($_SERVER["DOCUMENT_ROOT"] . "/content/autobagazhniki/backend/array.php");
include($_SERVER["DOCUMENT_ROOT"] . "/content/autobagazhniki/backend/keywords.php"); ?>

<div class="wrapper">
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php
        $id = $_GET['id'];
        $good = [];
        foreach ($autobagazhniki as $product) {
            if ($product['id'] == $id) {
                $good = $product;
                break;
            }
        };

        if($id == 'ab1') { ?>

            <title><?php echo $keywords[1][title]; ?></title>
            <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
            <p class="text">В нашем магазине есть несколько видов багажников на рейлинг, все они представлены ниже.</p>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $reelings[0]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[0]['img2'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $reelings[0]['name'] ?></h3>
                    <p class="text"><?php echo $reelings[0]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $reelings[1]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[1]['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[1]['img3'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $reelings[1]['name'] ?></h3>
                    <p class="text"><?php echo $reelings[1]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $reelings[2]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[2]['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[2]['img3'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $reelings[2]['name'] ?></h3>
                    <p class="text"><?php echo $reelings[2]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $reelings[3]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[3]['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[3]['img3'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[3]['img4'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $reelings[3]['name'] ?></h3>
                    <p class="text"><?php echo $reelings[3]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $reelings[4]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[4]['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[4]['img3'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $reelings[4]['name'] ?></h3>
                    <p class="text"><?php echo $reelings[4]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $reelings[5]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[5]['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $reelings[5]['img3'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $reelings[5]['name'] ?></h3>
                    <p class="text"><?php echo $reelings[5]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'ab2') { ?>

            <title><?php echo $keywords[2][title]; ?></title>
            <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
            <p class="text">В нашем магазине есть несколько видов багажников на штатные места, все они представлены ниже.</p>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $shtatnye[0]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $shtatnye[0]['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $shtatnye[0]['img3'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $shtatnye[0]['name'] ?></h3>
                    <p class="text"><?php echo $shtatnye[0]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $shtatnye[1]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $shtatnye[1]['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $shtatnye[1]['img3'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $shtatnye[1]['name'] ?></h3>
                    <p class="text"><?php echo $shtatnye[1]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $shtatnye[2]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $shtatnye[2]['img2'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $shtatnye[2]['name'] ?></h3>
                    <p class="text"><?php echo $shtatnye[2]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'ab3') { ?>

            <title><?php echo $keywords[3][title]; ?></title>
            <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
            <p class="text">В нашем магазине есть несколько видов багажников на плоскую крышу, все они представлены ниже.</p>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $smooth[0]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $smooth[0]['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $smooth[0]['img3'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $smooth[0]['name'] ?></h3>
                    <p class="text"><?php echo $smooth[0]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $smooth[1]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $smooth[1]['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $smooth[1]['img3'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $smooth[1]['name'] ?></h3>
                    <p class="text"><?php echo $smooth[1]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $smooth[2]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $smooth[2]['img2'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $smooth[2]['name'] ?></h3>
                    <p class="text"><?php echo $smooth[2]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div><?php
        } elseif ($id == 'ab4') { ?>

            <title><?php echo $keywords[4][title]; ?></title>
            <h2 class="title title-h2"><?php echo $product['name'] ?></h2>
            <p class="text">В нашем магазине есть несколько видов багажников на водосток, все они представлены ниже.</p>
            <div class="product">
                <div class="img__wrap product__photos">
                    <img class="img product__img" src="<?php echo $vodostok[0]['img1'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $vodostok[0]['img2'] ?>">
                    <img class="img product__img product__img--small" src="<?php echo $vodostok[0]['img3'] ?>">
                </div>
                <div class="product__info">
                    <h3 class="title title-h3"><?php echo $vodostok[0]['name'] ?></h3>
                    <p class="text"><?php echo $vodostok[0]['desc'] ?></p>
                    <p class="text">Для заказа данного багажника нажмите кнопку Заказать и укажите в сообщении что Вы выбрали именно эту модель багажника. Мы с Вами свяжемся и уточним есть ли она в наличии в данный момент.</p>
                    <div class="product__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $product['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $product['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div><?php
        } ?>
    </div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>