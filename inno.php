<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/arrays/inno_array.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php");?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html");?>
        <div class="content">
            <?php
            $inno = $_GET['inno'];
            if (!isset($inno)) {
                echo "<title> $titleconst"; echo $keywords[30][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[30][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[30][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Багажные системы Inno</h1>";
                echo "<p class='page__text'>Всемирно известный бренд INNO является подразделением японской корпорации Car Mate. Корпорация Car Mate была основана в 1965 году изобретателем автомобильного подголовника Такааки Мурата. Сегодня Car Mate является крупнейшим производителем автомобильных аксессуаров и принадлежностей в мире.</p>";
                echo "<p class='page__text'>Багажные системы INNO являются одним из мировых лидеров по производству универсальных автомобильных багажников. Вот уже более 30 лет работники подразделения INNO занимаются проектированием и производством инновационных и технологически продвинутых багажных систем. Отличное качество автобагажников INNO - результат многолетнего опыта работы в автоиндустрии.</p>"; ?>
            <div class="catalog">
                <div class="catalog__item">
                    <a href="inno/inno-basic" class="catalog__item-link"></a>
                    <div class="item__image">
                        <a href="inno/inno-basic"><img class="item__image-img" src="/images/inno/autobagazhniki/basic/BASIC_STAY_SET_2.jpg" alt="Inno Basic Stay Set"></a>
                    </div>
                    <div class="item__link">
                        <a href="inno/inno-basic">Базовые багажники</a>
                    </div>
                </div>
                <div class="catalog__item">
                    <a href="inno/inno-boxes" class="catalog__item-link"></a>
                    <div class="item__image">
                        <a href="inno/inno-boxes"><img class="item__image-img" src="/images/inno/boxes/newshadow16/1.jpg" alt="Inno New Shadow 16"></a>
                    </div>
                    <div class="item__link">
                        <a href="inno/inno-boxes">Автомобильные боксы</a>
                    </div>
                </div>
            </div> <?php
            } elseif ($inno == 'inno-basic') {
                echo "<title> $titleconst"; echo $keywords[31][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[31][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[31][keywords]; echo "'/>";

                $_SESSION['inno'] = $inno_basic;
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                echo "<h1 class='page__title-h1'>Базовые багажники</h1>";
                foreach ($inno_basic as $basic): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $basic['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $basic['img1']; echo $basic['img2']; echo $basic['img3']; echo $basic['img4']; echo $basic['img5']; ?>
                            </div>
                            <div class="good__text">
                                <p class="page__text"><?php echo $basic['desc1']; ?></p>
                                <p class="page__text"><?php echo $basic['desc2']; ?></p>
                            </div>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text"><?php echo $basic['price']; ?></p>
                            </div>
                            <div class="good__price-button">
                                <button class="button__buy"><a href="/buy/<?php echo $basic['id']; ?>" class="button__buy-link">Заказать</a></button>
                                <button class="button__buy button__buy--prokat"><a href="/prokat/<?php echo $basic['id']; ?>" class="button__buy-link">Взять в прокат</a></button>
                            </div>
                        </div>
                    </div>
                <?php endforeach;

                echo "<h2 class='page__title-h2'>Аэродинамические багажники</h2>";
                foreach ($inno_aero as $aero): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $aero['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $aero['img1']; echo $aero['img2']; echo $aero['img3']; echo $aero['img4']; echo $aero['img5']; ?>
                            </div>
                            <div class="good__text">
                                <p class="page__text"><?php echo $aero['desc1']; ?></p>
                                <p class="page__text"><?php echo $aero['desc2']; ?></p>
                            </div>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text"><?php echo $aero['price']; ?></p>
                            </div>
                            <div class="good__price-button">
                                <button class="button__buy"><a href="/buy/<?php echo $aero['id']; ?>" class="button__buy-link">Заказать</a></button>
                                <button class="button__buy button__buy--prokat"><a href="/prokat/<?php echo $aero['id']; ?>" class="button__buy-link">Взять в прокат</a></button>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            }


            ?>


        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>

