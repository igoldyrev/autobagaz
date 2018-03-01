<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/inno/backend/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/inno/backend/array.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php
        $inno = $_GET['inno'];
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        if (!isset($inno)) {
            echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[0][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Багажные системы Inno</h1>";
                echo "<p class='text'>Всемирно известный бренд INNO является подразделением японской корпорации Car Mate. Корпорация Car Mate была основана в 1965 году изобретателем автомобильного подголовника Такааки Мурата. Сегодня Car Mate является крупнейшим производителем автомобильных аксессуаров и принадлежностей в мире.</p>";
                echo "<p class='text'>Багажные системы INNO являются одним из мировых лидеров по производству универсальных автомобильных багажников. Вот уже более 30 лет работники подразделения INNO занимаются проектированием и производством инновационных и технологически продвинутых багажных систем. Отличное качество автобагажников INNO - результат многолетнего опыта работы в автоиндустрии.</p>"; ?>
            <div class="catalog">
                <div class="catalog__item">
                    <a href="inno/inno-basic" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/inno/img/autobagazhniki/basic/BASIC_STAY_SET_2.jpg" alt="Inno Basic Stay Set">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Базовые багажники</p>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="inno/inno-boxes" class="catalog__item-link"></a>
                    <div class="catalog__image-wrap">
                        <img class="catalog__image" src="/content/inno/img/boxes/newshadow16/1.jpg" alt="Inno New Shadow 16">
                    </div>
                    <div class="catalog__text">
                        <p class="text">Автомобильные боксы</p>
                    </div>
                </div>
            </div> <?php
            } elseif ($inno == 'inno-basic') {
                echo "<title> $titleconst"; echo $keywords[1][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[1][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[1][keywords]; echo "'/>";

                $_SESSION['inno_basic'] = $inno_basic;
                $_SESSION['inno_aero'] = $inno_aero;
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                echo "<h1 class='title title-h1'>Базовые багажники</h1>";
                foreach ($inno_basic as $basic): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $basic['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $basic['img1']; echo $basic['img2']; echo $basic['img3']; echo $basic['img4']; echo $basic['img5']; ?>
                            </div>
                            <p class="text"><?php echo $basic['desc1']; ?></p>
                            <p class="text"><?php echo $basic['desc2']; ?></p>
                        </div>
                        <div class="good__price">
                            <p class="text"><?php echo $basic['price']; ?></p>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $basic['id']; ?>" class="button button__buy" >Заказать</a>
                                <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $basic['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;

                echo "<h2 class='title title-h2'>Аэродинамические багажники</h2>";
                foreach ($inno_aero as $aero): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $aero['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $aero['img1']; echo $aero['img2']; echo $aero['img3']; echo $aero['img4']; echo $aero['img5']; ?>
                            </div>
                            <p class="text"><?php echo $aero['desc1']; ?></p>
                            <p class="text"><?php echo $aero['desc2']; ?></p>
                        </div>
                        <div class="good__price">
                            <p class="text"><?php echo $aero['price']; ?></p>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $aero['id']; ?>" class="button button__buy" >Заказать</a>
                                <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $aero['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($inno == 'inno-boxes') {
                echo "<title> $titleconst"; echo $keywords[2][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[2][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[2][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Автомобильные боксы Inno</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/inno/new-shadow" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/inno/img/boxes/newshadow16/1.jpg" alt="New Shadow">
                        </div>
                        <div class="catalog__text">
                            <p class="text">Серия New shadow</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/inno/roofbox" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/inno/img/boxes/roofbox56/1.jpg" alt="Roofbox">
                        </div>
                        <div class="catalog__text">
                            <p class="text">Серия Roofbox</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($inno == 'new-shadow') {
                echo "<title> $titleconst"; echo $keywords[3][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[3][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[3][keywords]; echo "'/>";

                $_SESSION['inno_box'] = $inno_box;
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                echo "<h1 class='title title-h1'>Автобоксы New Shadow</h1>";?>
                <div class="good"><?php
                    echo "<h2 class='title title-h2'>"; echo $inno_box[0]['title']; echo "</h2>"; ?>
                    <div class="img__wrap">
                        <?php echo $inno_box[0]['img1']; echo $inno_box[0]['img2']; echo $inno_box[0]['img3']; echo $inno_box[0]['img4']; echo $inno_box[0]['img5']; ?>
                    </div>
                    <div class="table">
                        <div class="table__column"></div>
                        <ul class="table__header">
                            <li class="table__cell">Характеристики</li>
                            <li class="table__cell">Значение</li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Размер</li>
                            <li class="table__cell"><?php echo $inno_box[0]['size']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Литраж</li>
                            <li class="table__cell"><?php echo $inno_box[0]['volume']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Способ крепления</li>
                            <li class="table__cell"><?php echo $inno_box[0]['clamp']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Способ открывания</li>
                            <li class="table__cell"><?php echo $inno_box[0]['open']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Способ запирания</li>
                            <li class="table__cell"><?php echo $inno_box[0]['closed']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Защита</li>
                            <li class="table__cell"><?php echo $inno_box[0]['material']; ?></li>
                        </ul>
                    </div>
                    <div class="good__description"> <?php
                        echo "<p class='text'>"; echo $inno_box[0]['desc1']; echo "</p>";
                        echo "<p class='text'>"; echo $inno_box[0]['desc2']; echo "</p>";
                        echo "<p class='text'>"; echo $inno_box[0]['desc3']; echo "</p>"; ?>
                    </div>
                    <div class="good__price">
                        <p class="text"><?php echo "Черный матовый: <strong>"; echo $inno_box[0]['price_black']; ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $inno_box[0]['id1']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                    <div class="good__price">
                        <p class="text"><?php echo "Серебристый матовый: <strong>"; echo $inno_box[0]['price_silver']; ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $inno_box[0]['id2']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                    <div class="good__price">
                        <p class="text"><?php echo "Белый глянец: <strong>"; echo $inno_box[0]['price_white']; ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $inno_box[0]['id3']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
                <div class="good"><?php
                    echo "<h2 class='title title-h2'>"; echo $inno_box[1]['title']; echo "</h2>"; ?>
                    <div class="img__wrap">
                        <?php echo $inno_box[1]['img1']; echo $inno_box[1]['img2']; echo $inno_box[1]['img3']; echo $inno_box[1]['img4']; echo $inno_box[1]['img5']; ?>
                    </div>
                    <div class="table">
                        <div class="table__column"></div>
                        <ul class="table__header">
                            <li class="table__cell">Характеристики</li>
                            <li class="table__cell">Значение</li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Размер</li>
                            <li class="table__cell"><?php echo $inno_box[1]['size']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Литраж</li>
                            <li class="table__cell"><?php echo $inno_box[1]['volume']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Способ крепления</li>
                            <li class="table__cell"><?php echo $inno_box[1]['clamp']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Способ открывания</li>
                            <li class="table__cell"><?php echo $inno_box[1]['open']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Способ запирания</li>
                            <li class="table__cell"><?php echo $inno_box[1]['closed']; ?></li>
                        </ul>
                        <ul class="table__row">
                            <li class="table__cell">Защита</li>
                            <li class="table__cell"><?php echo $inno_box[1]['material']; ?></li>
                        </ul>
                    </div>
                    <div class="good__description"> <?php
                        echo "<p class='text'>"; echo $inno_box[1]['desc1']; echo "</p>";
                        echo "<p class='text'>"; echo $inno_box[1]['desc2']; echo "</p>";
                        echo "<p class='text'>"; echo $inno_box[1]['desc3']; echo "</p>"; ?>
                    </div>
                    <div class="good__price">
                        <p class="text"><?php echo "Черный матовый: <strong>"; echo $inno_box[1]['price']; ?></strong></p>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $inno_box[1]['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
                <?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($inno == 'roofbox') {
            echo "<title> $titleconst"; echo $keywords[4][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[4][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[4][keywords]; echo "'/>";

            $_SESSION['inno_box'] = $inno_box;
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];

            echo "<h1 class='title title-h1'>Автобоксы Roofbox</h1>";?>
            <div class="good"><?php
                echo "<h2 class='title title-h2'>"; echo $inno_box[2]['title']; echo "</h2>"; ?>
                <div class="img__wrap">
                    <?php echo $inno_box[2]['img1']; echo $inno_box[2]['img2']; echo $inno_box[2]['img3']; echo $inno_box[2]['img4']; echo $inno_box[2]['img5']; ?>
                </div>
                <div class="table">
                    <div class="table__column"></div>
                    <ul class="table__header">
                        <li class="table__cell">Характеристики</li>
                        <li class="table__cell">Значение</li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Размер</li>
                        <li class="table__cell"><?php echo $inno_box[2]['size']; ?></li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Литраж</li>
                        <li class="table__cell"><?php echo $inno_box[2]['volume']; ?></li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Способ крепления</li>
                        <li class="table__cell"><?php echo $inno_box[2]['clamp']; ?></li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Способ открывания</li>
                        <li class="table__cell"><?php echo $inno_box[2]['open']; ?></li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Способ запирания</li>
                        <li class="table__cell"><?php echo $inno_box[2]['closed']; ?></li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Защита</li>
                        <li class="table__cell"><?php echo $inno_box[2]['material']; ?></li>
                    </ul>
                </div>
                <div class="good__description"> <?php
                    echo "<p class='text'>"; echo $inno_box[2]['desc1']; echo "</p>";
                    echo "<p class='text'>"; echo $inno_box[2]['desc2']; echo "</p>";
                    echo "<p class='text'>"; echo $inno_box[2]['desc3']; echo "</p>"; ?></div>
                <div class="good__price">
                    <p class="text"><?php echo "Черный глянец: <strong>"; echo $inno_box[2]['price']; ?></strong></p>
                    <div class="good__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $inno_box[2]['id1']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
                <div class="good__price">
                    <p class="text"><?php echo "Серый глянец: <strong>"; echo $inno_box[2]['price']; ?></strong></p>
                    <div class="good__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $inno_box[2]['id2']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
            <div class="good"><?php
                echo "<h2 class='title title-h2'>"; echo $inno_box[3]['title']; echo "</h2>"; ?>
                <div class="img__wrap">
                    <?php echo $inno_box[3]['img1']; echo $inno_box[3]['img2']; echo $inno_box[3]['img3']; echo $inno_box[3]['img4']; echo $inno_box[3]['img5']; ?>
                </div>
                <div class="table">
                    <div class="table__column"></div>
                    <ul class="table__header">
                        <li class="table__cell">Характеристики</li>
                        <li class="table__cell">Значение</li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Размер</li>
                        <li class="table__cell"><?php echo $inno_box[3]['size']; ?></li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Литраж</li>
                        <li class="table__cell"><?php echo $inno_box[3]['volume']; ?></li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Способ крепления</li>
                        <li class="table__cell"><?php echo $inno_box[3]['clamp']; ?></li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Способ открывания</li>
                        <li class="table__cell"><?php echo $inno_box[3]['open']; ?></li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Способ запирания</li>
                        <li class="table__cell"><?php echo $inno_box[3]['closed']; ?></li>
                    </ul>
                    <ul class="table__row">
                        <li class="table__cell">Защита</li>
                        <li class="table__cell"><?php echo $inno_box[3]['material']; ?></li>
                    </ul>
                </div>
                <div class="good__description"> <?php
                    echo "<p class='text'>"; echo $inno_box[3]['desc1']; echo "</p>";
                    echo "<p class='text'>"; echo $inno_box[3]['desc2']; echo "</p>";
                    echo "<p class='text'>"; echo $inno_box[3]['desc3']; echo "</p>"; ?></div>
                <div class="good__price">
                    <p class="text"><?php echo "Белый глянец: <strong>"; echo $inno_box[3]['price']; ?></strong></p>
                    <div class="good__buttons">
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $inno_box[3]['id']; ?>" class="button button__buy" >Заказать</a>
                    </div>
                </div>
            </div>
                <?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>