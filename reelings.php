<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php");?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html");?>
        <div class="content">
            <?php
            $reelings = $_GET['reelings'];
            if (!isset($reelings)) {
                echo "<title> $titleconst"; echo $keywords[20][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[20][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[20][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги</h1>";
                echo "<p class='page__text'>Автомобиль должен быть не только функциональным, но и красивым, должен радовать глаз. С этим утверждением сегодня согласится, наверное, каждый. Тем более сейчас, когда автомобилей на дорогах стало особенно много. Придать облику вашего авто законченность и спортивную элегантность, подчеркнуть его сдержанную энергию, полную внутренней силы, способна такая незначительная на первый взгляд деталь как рейлинги на крыше автомобиля. Редкий водитель доволен объемом багажного отделения своего автомобиля. Но - благодаря рейлингам - даже малолитражка (не говоря уже о внедорожниках или машинах «средней ценовой категории») может перевозить куда большие объемы груза, чем было заложено конструкторами. Таким образом, решительно для любого автомобиля рейлинги - это необходимость, а часто и одно из условий, позволяющее установить на авто багажники: как стандартные, так и герметичные удобные боксы.</p>";
                echo "<p class='page__text'>В данном разделе представлены рейлинги ООО АвтоПолимерСервис. Мы являемся официальными представителями данной компании в Перми.</p>"; ?>

                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/lada" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/lada"><img class="item__image-img" src="/images/aps/logo/lada.png" alt="lada"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/lada">LADA</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/chevrolet" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/chevrolet"><img class="item__image-img" src="/images/aps/logo/chevrolet.png" alt="chevrolet"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/chevrolet">CHEVROLET</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/renault" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/renault"><img class="item__image-img" src="/images/aps/logo/renault.png" alt="renault"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/renault">RENAULT</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/kia" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/kia"><img class="item__image-img" src="/images/aps/logo/kia.png" alt="kia"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/kia">KIA</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/mazda" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/mazda"><img class="item__image-img" src="/images/aps/logo/mazda.png" alt="mazda"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/mazda">MAZDA</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/hyundai" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/hyundai"><img class="item__image-img" src="/images/aps/logo/kia.png" alt="hyundai"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/hyundai">HYUNDAI</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/opel" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/opel"><img class="item__image-img" src="/images/aps/logo/opel.png" alt="opel"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/opel">OPEL</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/toyota" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/toyota"><img class="item__image-img" src="/images/aps/logo/toyota.png" alt="toyota"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/toyota">TOYOTA</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/landrover" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/landrover"><img class="item__image-img" src="/images/aps/logo/land_rover.png" alt="land rover"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/landrover">LAND ROVER</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/datsun" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/datsun"><img class="item__image-img" src="/images/aps/logo/datsun.png" alt="datsun"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/datsun">DATSUN</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'lada') {
                echo "<title> $titleconst"; echo $keywords[39][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[39][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[39][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги для автомобилей Lada</h1>"; ?>

                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/xray" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/xray"><img class="item__image-img" src="/images/aps/lada/xray/polymer-black.png" alt="lada xray"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/xray">LADA XRAY</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/largus" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/largus"><img class="item__image-img" src="/images/aps/lada/largus/anod-gray.png" alt="lada largus"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/largus">LADA LARGUS</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/granta-liftback" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/granta-liftback"><img class="item__image-img" src="/images/aps/lada/granta-liftbek/polymer-black.png" alt="lada granta"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/granta-liftback">LADA GRANTA Лифтбек</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/granta-e" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/granta-e"><img class="item__image-img" src="/images/aps/lada/granta-e/anod-gray.png" alt="lada granta"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/granta-e">LADA GRANTA "E"</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/granta-kalina-sedan" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/granta-kalina-sedan"><img class="item__image-img" src="/images/aps/lada/granta-sedan/white.png" alt="lada granta"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/granta-kalina-sedan">LADA GRANTA Седан, KALINA Седан</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/kalina-xetchbek" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/kalina-xetchbek"><img class="item__image-img" src="/images/aps/lada/kalina-xetchbek/polymer-black.gif" alt="lada kalina"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/kalina-xetchbek">LADA KALINA Хэтчбек "S"</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/kalina-universal" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/kalina-universal"><img class="item__image-img" src="/images/aps/lada/kalina-universal/anod-gray-2013.gif" alt="lada kalina"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/kalina-universal">LADA KALINA Универсал "M"</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/lada-4x4" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/lada-4x4"><img class="item__image-img" src="/images/aps/lada/4x4/anod-gray.gif" alt="lada 4x4"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/lada-4x4">LADA 4x4</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/lada-4x4-l" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/lada-4x4-l"><img class="item__image-img" src="/images/aps/lada/4x4-l/polymer-black.gif" alt="lada 4x4 L"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/lada-4x4-l">LADA 4x4 L</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'chevrolet') {
            echo "<title> $titleconst"; echo $keywords[40][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[40][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[40][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Рейлинги для автомобилей Chevrolet</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/chevrolet-m" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/chevrolet-m"><img class="item__image-img" src="/images/aps/chevrolet/niva-m/polymer-black.gif" alt="chevrolet niva m"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/chevrolet-m">CHEVROLET NIVA M</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/chevrolet-l" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/chevrolet-l"><img class="item__image-img" src="/images/aps/chevrolet/niva-l/anod-gray.png" alt="chevrolet niva l"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/chevrolet-l">CHEVROLET NIVA L</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'renault') {
            echo "<title> $titleconst"; echo $keywords[41][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[41][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[41][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Рейлинги для автомобилей Renault</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/kaptur" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/kaptur"><img class="item__image-img" src="/images/aps/renault/kaptur/polymer-black.png" alt="renault kaptur"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/kaptur">RENAULT KAPTUR</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/logan" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/logan"><img class="item__image-img" src="/images/aps/renault/logan-2004-2014/anod-gray.gif" alt="renault logan"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/logan">RENAULT LOGAN</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/logan-new" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/logan-new"><img class="item__image-img" src="/images/aps/renault/logan-new/white.png" alt="renault logan"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/logan-new">Новый RENAULT LOGAN</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/sandero" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/sandero"><img class="item__image-img" src="/images/aps/renault/logan-2004-2014/anod-gray.gif" alt="renault sandero"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/sandero">RENAULT SANDERO</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/sandero-new" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/sandero-new"><img class="item__image-img" src="/images/aps/renault/logan-new/white.png" alt="renault sandero"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/sandero-new">Новый RENAULT SANDERO</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'kia') {
            echo "<title> $titleconst"; echo $keywords[42][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[42][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[42][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Рейлинги для автомобилей KIA</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/ceed" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/ceed"><img class="item__image-img" src="/images/aps/kia/ceed-2006-2012/polymer-black.png" alt="kia ceed"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/ceed">KIA CEED</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/ceed-new" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/ceed-new"><img class="item__image-img" src="/images/aps/kia/ceed-new/anod-gray-vkladka.png" alt="kia ceed"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/ceed-new">Новый KIA CEED</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'mazda') {
            echo "<title> $titleconst"; echo $keywords[43][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[43][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[43][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Рейлинги для автомобилей Mazda</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/mazda3" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/mazda3"><img class="item__image-img" src="/images/aps/mazda/3-2003-2009/polymer-black.png" alt="mazda 3"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/mazda3">MAZDA 3</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/mazdacx5-1" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/mazdacx5-1"><img class="item__image-img" src="/images/aps/mazda/cx-5-2012-2017/anod-gray.png" alt="mazda cx-5"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/mazdacx5-1">MAZDA CX5 I</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/mazdacx5-2" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/mazdacx5-2"><img class="item__image-img" src="/images/aps/mazda/cx-5-new/white.png" alt="mazda cx-5"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/mazdacx5-2">MAZDA CX5 II</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'hyundai') {
            echo "<title> $titleconst"; echo $keywords[44][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[44][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[44][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Рейлинги для автомобилей Hyundai</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/creta" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/creta"><img class="item__image-img" src="/images/aps/hyundai/creta/polymer-black.png" alt="hyundai creta"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/creta">HYUNDAI CRETA</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/solaris" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/solaris"><img class="item__image-img" src="/images/aps/hyundai/solaris/anod-gray.png" alt="hyundai solaris"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/solaris">HYUNDAI SOLARIS</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/i30" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/i30"><img class="item__image-img" src="/images/aps/hyundai/i-30/white.png" alt="hyundai i30"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/i30">HYUNDAI i30</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'opel') {
            echo "<title> $titleconst"; echo $keywords[45][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[45][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[45][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Рейлинги для автомобилей Opel</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/astra" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/astra"><img class="item__image-img" src="/images/aps/opel/astra-2004-2014/polymer-black.png" alt="opel astra"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/astra">OPEL ASTRA (H)</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'toyota') {
            echo "<title> $titleconst"; echo $keywords[46][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[46][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[46][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Рейлинги для автомобилей Toyota</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/rav4-3" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/rav4-3"><img class="item__image-img" src="/images/aps/toyota/rav4-2006-2013/polymer-black.png" alt="toyota rav-4"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/rav4-3">TOYOTA RAV-4 III (2006-2013)</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/rav4-4" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/rav4-4"><img class="item__image-img" src="/images/aps/toyota/rav4-2013/anod-gray.png" alt="toyota rav-4"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/rav4-4">TOYOTA RAV-4 IV (20013-н.в.)</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/prado150" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/prado150"><img class="item__image-img" src="/images/aps/toyota/prado-150/white.png" alt="toyota prado"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/prado150">TOYOTA PRADO 150</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'landrover') {
            echo "<title> $titleconst"; echo $keywords[47][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[47][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[47][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Рейлинги для автомобилей Land Rover</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/freelander2" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/freelander2"><img class="item__image-img" src="/images/aps/landrover/freelander-2/polymer-black.png" alt="land rover freelander 2"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/freelander2">LAND ROVER FREELANDER 2</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($reelings == 'datsun') {
            echo "<title> $titleconst"; echo $keywords[48][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[48][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[48][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Рейлинги для автомобилей Datsun</h1>"; ?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/reelings/on-do" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/on-do"><img class="item__image-img" src="/images/aps/datsun/on-do/polymer-black.gif" alt="datsun on-do"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/on-do">DATSUN ON-DO</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/reelings/mi-do" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/reelings/mi-do"><img class="item__image-img" src="/images/aps/datsun/mi-do/anod-gray.gif" alt="datsun mi-do"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/mi-do">DATSUN MI-DO</a>
                        </div>
                    </div>
                </div> <?php
            }


            $_SESSION['url'] = $_SERVER['REQUEST_URI'];

            ?>




        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>