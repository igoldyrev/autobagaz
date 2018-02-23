<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/content/reelings/backend/keywords.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php
        $reelings = $_GET['reelings'];
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        if (!isset($reelings)) {
            echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[0][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги</h1>";
                echo "<p class='text'>Автомобиль должен быть не только функциональным, но и красивым, должен радовать глаз. С этим утверждением сегодня согласится, наверное, каждый. Тем более сейчас, когда автомобилей на дорогах стало особенно много. Придать облику вашего авто законченность и спортивную элегантность, подчеркнуть его сдержанную энергию, полную внутренней силы, способна такая незначительная на первый взгляд деталь как рейлинги на крыше автомобиля. Редкий водитель доволен объемом багажного отделения своего автомобиля. Но - благодаря рейлингам - даже малолитражка (не говоря уже о внедорожниках или машинах «средней ценовой категории») может перевозить куда большие объемы груза, чем было заложено конструкторами. Таким образом, решительно для любого автомобиля рейлинги - это необходимость, а часто и одно из условий, позволяющее установить на авто багажники: как стандартные, так и герметичные удобные боксы.</p>";
                echo "<p class='text'>В данном разделе представлены рейлинги ООО АвтоПолимерСервис. Мы являемся официальными представителями данной компании в Перми.</p>"; ?>

                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/lada" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/logo/lada.png" alt="lada">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LADA</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/chevrolet" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/logo/chevrolet.png" alt="chevrolet">
                        </div>
                        <div class="catalog__text">
                            <p class="text">CHEVROLET</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/renault" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/logo/renault.png" alt="renault">
                        </div>
                        <div class="catalog__text">
                            <p class="text">RENAULT</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/kia" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/logo/kia.png" alt="kia">
                        </div>
                        <div class="catalog__text">
                            <p class="text">KIA</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/mazda" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/logo/mazda.png" alt="mazda">
                        </div>
                        <div class="catalog__text">
                            <p class="text">MAZDA</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/hyundai" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/logo/hyundai.png" alt="hyundai">
                        </div>
                        <div class="catalog__text">
                            <p class="text">HYUNDAI</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/opel" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/logo/opel.png" alt="opel">
                        </div>
                        <div class="catalog__text">
                            <p class="text">OPEL</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/toyota" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/logo/toyota.png" alt="toyota">
                        </div>
                        <div class="catalog__text">
                            <p class="text">TOYOTA</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/landrover" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/logo/land_rover.png" alt="land rover">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LAND ROVER</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/datsun" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/logo/datsun.png" alt="datsun">
                        </div>
                        <div class="catalog__text">
                            <p class="text">DATSUN</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'lada') {
                echo "<title> $titleconst"; echo $keywords[1][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[1][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[1][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги для автомобилей Lada</h1>"; ?>

                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/xray" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/lada/xray/polymer-black.png" alt="lada xray">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LADA XRAY</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/largus" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/lada/largus/anod-gray.png" alt="lada largus">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LADA LARGUS</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/granta-liftback" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/lada/granta-liftbek/polymer-black.png" alt="lada granta">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LADA GRANTA Лифтбек</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/granta-e" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/lada/granta-e/anod-gray.png" alt="lada granta">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LADA GRANTA "E"</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/granta-kalina-sedan" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/lada/granta-sedan/white.png" alt="lada granta">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LADA GRANTA Седан, KALINA Седан</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/kalina-xetchbek" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/lada/kalina-xetchbek/polymer-black.gif" alt="lada kalina">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LADA KALINA Хэтчбек "S"</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/kalina-universal" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/lada/kalina-universal/anod-gray-2013.gif" alt="lada kalina">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LADA KALINA Универсал "M"</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/4x4" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/lada/4x4/anod-gray.gif" alt="lada 4x4">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LADA 4x4</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/l4x4" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/lada/4x4-l/polymer-black.gif" alt="lada 4x4 L">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LADA 4x4 L</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'chevrolet') {
            echo "<title> $titleconst"; echo $keywords[2][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[2][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[2][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Рейлинги для автомобилей Chevrolet</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/chevi-m" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/chevrolet/niva-m/polymer-black.gif" alt="chevrolet niva m">
                        </div>
                        <div class="catalog__text">
                            <p class="text">CHEVROLET NIVA M</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/chevi-l" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/chevrolet/niva-l/anod-gray.png" alt="chevrolet niva l">
                        </div>
                        <div class="catalog__text">
                            <p class="text">CHEVROLET NIVA L</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'renault') {
            echo "<title> $titleconst"; echo $keywords[3][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[3][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[3][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Рейлинги для автомобилей Renault</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/kaptur" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/renault/kaptur/polymer-black.png" alt="renault kaptur">
                        </div>
                        <div class="catalog__text">
                            <p class="text">RENAULT KAPTUR</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/logan" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/renault/logan-2004-2014/anod-gray.gif" alt="renault logan">
                        </div>
                        <div class="catalog__text">
                            <p class="text">RENAULT LOGAN</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/new-logan" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/renault/logan-new/white.png" alt="renault logan">
                        </div>
                        <div class="catalog__text">
                            <p class="text">Новый RENAULT LOGAN</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/sandero" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/renault/logan-2004-2014/anod-gray.gif" alt="renault sandero">
                        </div>
                        <div class="catalog__text">
                            <p class="text">RENAULT SANDERO</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/new-sandero" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/renault/logan-new/white.png" alt="renault sandero">
                        </div>
                        <div class="catalog__text">
                            <p class="text">Новый RENAULT SANDERO</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'kia') {
            echo "<title> $titleconst"; echo $keywords[4][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[4][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[4][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Рейлинги для автомобилей KIA</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/ceed" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/kia/ceed-2006-2012/polymer-black.png" alt="kia ceed">
                        </div>
                        <div class="catalog__text">
                            <p class="text">KIA CEED</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/new-ceed" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/kia/ceed-new/anod-gray-vkladka.png" alt="kia ceed">
                        </div>
                        <div class="catalog__text">
                            <p class="text">Новый KIA CEED</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'mazda') {
            echo "<title> $titleconst"; echo $keywords[5][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[5][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[5][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Рейлинги для автомобилей Mazda</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/three" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/mazda/3-2003-2009/polymer-black.png" alt="mazda 3">
                        </div>
                        <div class="catalog__text">
                            <p class="text">MAZDA 3</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/cx5-1" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/mazda/cx-5-2012-2017/anod-gray.png" alt="mazda cx-5">
                        </div>
                        <div class="catalog__text">
                            <p class="text">MAZDA CX5 I</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/cx5-2" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/mazda/cx-5-new/white.png" alt="mazda cx-5">
                        </div>
                        <div class="catalog__text">
                            <p class="text">MAZDA CX5 II</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'hyundai') {
            echo "<title> $titleconst"; echo $keywords[6][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[6][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[6][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Рейлинги для автомобилей Hyundai</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/creta" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/hyundai/creta/polymer-black.png" alt="hyundai creta">
                        </div>
                        <div class="catalog__text">
                            <p class="text">HYUNDAI CRETA</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/solaris" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/hyundai/solaris/anod-gray.png" alt="hyundai solaris">
                        </div>
                        <div class="catalog__text">
                            <p class="text">HYUNDAI SOLARIS</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/i30" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/hyundai/i-30/white.png" alt="hyundai i30">
                        </div>
                        <div class="catalog__text">
                            <p class="text">HYUNDAI i30</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'opel') {
            echo "<title> $titleconst"; echo $keywords[7][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[7][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[7][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Рейлинги для автомобилей Opel</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/astra" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/opel/astra-2004-2014/polymer-black.png" alt="opel astra">
                        </div>
                        <div class="catalog__text">
                            <p class="text">OPEL ASTRA (H)</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'toyota') {
            echo "<title> $titleconst"; echo $keywords[8][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[8][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[8][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Рейлинги для автомобилей Toyota</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/rav4-3" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/toyota/rav4-2006-2013/polymer-black.png" alt="toyota rav-4">
                        </div>
                        <div class="catalog__text">
                            <p class="text">TOYOTA RAV-4 III (2006-2013)</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/rav4-4" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/toyota/rav4-2013/anod-gray.png" alt="toyota rav-4">
                        </div>
                        <div class="catalog__text">
                            <p class="text">TOYOTA RAV-4 IV (20013-н.в.)</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/prado150" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/toyota/prado-150/white.png" alt="toyota prado">
                        </div>
                        <div class="catalog__text">
                            <p class="text">TOYOTA PRADO 150</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'landrover') {
            echo "<title> $titleconst"; echo $keywords[9][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[9][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[9][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Рейлинги для автомобилей Land Rover</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/freelander2" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/landrover/freelander-2/polymer-black.png" alt="land rover freelander 2">
                        </div>
                        <div class="catalog__text">
                            <p class="text">LAND ROVER FREELANDER 2</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'datsun') {
            echo "<title> $titleconst"; echo $keywords[10][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[10][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[10][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Рейлинги для автомобилей Datsun</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/on-do" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/datsun/on-do/polymer-black.gif" alt="datsun on-do">
                        </div>
                        <div class="catalog__text">
                            <p class="text">DATSUN ON-DO</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/mi-do" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/reelings/img/datsun/mi-do/anod-gray.gif" alt="datsun mi-do">
                        </div>
                        <div class="catalog__text">
                            <p class="text">DATSUN MI-DO</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'xray') {
            echo "<title> $titleconst"; echo $keywords[11][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[11][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[11][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Рейлинги АПС для Лада XRAY</h1>";
            include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/lada.php");
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];
            $_SESSION['lada_xray'] = $lada_xray;

            foreach ($lada_xray as $item): ?>
                <div class="good">
                    <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                    <div class="good__description">
                        <div class="img__wrap">
                            <?php echo $item['img']; ?>
                        </div>
                        <p class="text">Цвет: <?php echo $item['color']; ?></p>
                    </div>
                    <div class="good__price">
                        <div class="good__price-inner">
                            <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                            <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                        </div>
                        <div class="good__buttons">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
           <?php endforeach;
           include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'largus') {
                echo "<title> $titleconst"; echo $keywords[12][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[12][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[12][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Лада LARGUS</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['lada_largus'] = $lada_largus;

                foreach ($lada_largus as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'granta_liftbek') {
                echo "<title> $titleconst"; echo $keywords[13][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[13][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[13][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Лада GRANTA Лифтбек</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['granta_liftbek'] = $granta_liftbek;

                foreach ($granta_liftbek as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'granta-e') {
                echo "<title> $titleconst"; echo $keywords[14][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[14][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[14][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Лада GRANTA 'E'</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['granta_e'] = $granta_e;

                foreach ($granta_e as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'granta-kalina-sedan') {
                echo "<title> $titleconst"; echo $keywords[15][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[15][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[15][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Лада Гранта / Калина Седан</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['granta_sedan'] = $granta_sedan;

                foreach ($granta_sedan as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'kalina-xetchbek') {
                echo "<title> $titleconst"; echo $keywords[16][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[16][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[16][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Лада Калина Хэтчбек S</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['kalina_xetchbek'] = $kalina_xetchbek;

                foreach ($kalina_xetchbek as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'kalina-universal') {
                echo "<title> $titleconst"; echo $keywords[17][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[17][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[17][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Лада Калина Универсал M</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['kalina_universal'] = $kalina_universal;

                foreach ($kalina_universal as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == '4x4') {
                echo "<title> $titleconst"; echo $keywords[18][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[18][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[18][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Лада 4x4</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['lada_4x4'] = $lada_4x4;

                foreach ($lada_4x4 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'l4x4') {
                echo "<title> $titleconst"; echo $keywords[19][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[19][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[19][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Лада 4x4 L</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['lada_4x4_l'] = $lada_4x4_l;

                foreach ($lada_4x4_l as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings =='chevi-m') {
                echo "<title> $titleconst"; echo $keywords[20][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[20][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[20][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Chevrolet Niva M</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['niva_m'] = $niva_m;

                foreach ($niva_m as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'chevi-l') {
                echo "<title> $titleconst"; echo $keywords[21][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[21][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[21][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Chevrolet Niva L</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['niva_l'] = $niva_l;

                foreach ($niva_l as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'kaptur') {
                echo "<title> $titleconst"; echo $keywords[22][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[22][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[22][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Renault Kaptur</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/renault.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['renault_kaptur'] = $renault_kaptur;

                foreach ($renault_kaptur as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'logan') {
                echo "<title> $titleconst"; echo $keywords[23][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[23][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[23][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Renault Logan (2004 - 2014)</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/renault.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['renault_logan_2004'] = $renault_logan_2004;

                foreach ($renault_logan_2004 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'new-logan') {
                echo "<title> $titleconst"; echo $keywords[24][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[24][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[24][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для новый Renault Logan </h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/renault.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['renault_logan_2015'] = $renault_logan_2015;

                foreach ($renault_logan_2015 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'sandero') {
                echo "<title> $titleconst"; echo $keywords[25][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[25][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[25][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Renault Sandero</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/renault.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['renault_sandero_2010'] = $renault_sandero_2010;

                foreach ($renault_sandero_2010 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'new-sandero') {
                echo "<title> $titleconst"; echo $keywords[26][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[26][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[26][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для новый Renault Sandero</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/renault.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['renault_sandero_2014'] = $renault_sandero_2014;

                foreach ($renault_sandero_2014 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'ceed') {
                echo "<title> $titleconst"; echo $keywords[27][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[27][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[27][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Kia Ceed</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['kia_ceed_2006'] = $kia_ceed_2006;

                foreach ($kia_ceed_2006 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'new-ceed') {
                echo "<title> $titleconst"; echo $keywords[28][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[28][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[28][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для новый Kia Ceed</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['kia_ceed_2012'] = $kia_ceed_2012;

                foreach ($kia_ceed_2012 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'three') {
                echo "<title> $titleconst"; echo $keywords[29][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[29][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[29][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Mazda 3</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/mazda.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['mazda3'] = $mazda3;

                foreach ($mazda3 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'cx5-1') {
                echo "<title> $titleconst"; echo $keywords[30][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[30][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[30][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Mazda CX-5 I</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/mazda.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['mazda_cx5_1'] = $mazda_cx5_1;

                foreach ($mazda_cx5_1 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'cx5-2') {
                echo "<title> $titleconst"; echo $keywords[31][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[31][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[31][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Mazda CX-5 II</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/mazda.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['mazda_cx5_2'] = $mazda_cx5_2;

                foreach ($mazda_cx5_2 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'creta') {
                echo "<title> $titleconst"; echo $keywords[32][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[32][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[32][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Hyundai Creta</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/hyundai.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['hyundai_creta'] = $hyundai_creta;

                foreach ($hyundai_creta as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'solaris') {
                echo "<title> $titleconst"; echo $keywords[33][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[33][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[33][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Hyundai Solaris</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/hyundai.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['hyundai_solaris'] = $hyundai_solaris;

                foreach ($hyundai_solaris as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'i30') {
                echo "<title> $titleconst"; echo $keywords[34][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[34][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[34][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Hyundai i30</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/hyundai.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['hyundai_i30'] = $hyundai_i30;

                foreach ($hyundai_i30 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'astra') {
                echo "<title> $titleconst"; echo $keywords[35][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[35][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[35][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Opel Astra</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['opel_astra_2004'] = $opel_astra_2004;

                foreach ($opel_astra_2004 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'rav4-3') {
                echo "<title> $titleconst"; echo $keywords[36][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[36][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[36][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Toyota RAV-4 III</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/toyota.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['toyota_rav4_2006'] = $toyota_rav4_2006;

                foreach ($toyota_rav4_2006 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'rav4-4') {
                echo "<title> $titleconst"; echo $keywords[37][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[38][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[38][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Toyota RAV-4 IV</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/toyota.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['toyota_rav4_2013'] = $toyota_rav4_2013;

                foreach ($toyota_rav4_2013 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'prado150') {
                echo "<title> $titleconst"; echo $keywords[38][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[38][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[38][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Toyota PRADO 150</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/toyota.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['toyota_prado150'] = $toyota_prado150;

                foreach ($toyota_prado150 as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'freelander2') {
                echo "<title> $titleconst"; echo $keywords[39][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[39][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[39][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Land Rover Freelander 2</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['landrover'] = $landrover;

                foreach ($landrover as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'on-do') {
                echo "<title> $titleconst"; echo $keywords[40][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[40][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[40][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Datsun ON-DO</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/datsun.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['on_do'] = $on_do;

                foreach ($on_do as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($reelings == 'mi-do') {
                echo "<title> $titleconst"; echo $keywords[41][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[41][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[41][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Рейлинги АПС для Datsun MI-DO</h1>";
                include($_SERVER["DOCUMENT_ROOT"] . "/content/reelings/backend/arrays/datsun.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];
                $_SESSION['mi_do'] = $mi_do;

                foreach ($mi_do as $item): ?>
                    <div class="good">
                        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img__wrap">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-inner">
                                <p class="text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__buttons">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>