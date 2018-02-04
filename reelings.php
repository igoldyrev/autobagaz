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
            } elseif ($reelings == 'xray') {
            echo "<title> $titleconst"; echo $keywords[49][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[49][description]; echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[49][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Рейлинги АПС для Лада XRAY</h1>";
            include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/lada.php");
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];

            foreach ($lada_xray as $item): ?>
                <div class="good">
                    <h2 class="good__name"><?php echo $item['name']; ?></h2>
                    <div class="good__description">
                        <div class="img_div">
                            <?php echo $item['img']; ?>
                        </div>
                        <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                    </div>
                    <div class="good__price">
                        <div class="good__price-info">
                            <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                            <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                        </div>
                        <div class="good__price-button">
                            <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                        </div>
                    </div>
                </div>
           <?php endforeach;
           include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'largus') {
                echo "<title> $titleconst"; echo $keywords[50][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[50][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[50][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Лада LARGUS</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($lada_largus as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'granta_liftbek') {
                echo "<title> $titleconst"; echo $keywords[51][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[51][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[51][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Лада GRANTA Лифтбек</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($granta_liftbek as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'granta-e') {
                echo "<title> $titleconst"; echo $keywords[52][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[52][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[52][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Лада GRANTA 'E'</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($granta_e as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'granta-kalina-sedan') {
                echo "<title> $titleconst"; echo $keywords[53][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[53][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[53][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Лада Гранта / Калина Седан</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($granta_sedan as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'kalina-xetchbek') {
                echo "<title> $titleconst"; echo $keywords[54][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[54][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[54][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Лада Калина Хэтчбек S</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($kalina_xetchbek as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'kalina-universal') {
                echo "<title> $titleconst"; echo $keywords[55][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[55][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[55][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Лада Калина Универсал M</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($kalina_universal as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'lada-4x4') {
                echo "<title> $titleconst"; echo $keywords[56][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[56][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[56][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Лада 4x4</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($lada_4x4 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'lada-4x4-l') {
                echo "<title> $titleconst"; echo $keywords[57][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[57][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[57][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Лада 4x4 L</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/lada.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($lada_4x4_l as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings =='chevrolet-m') {
                echo "<title> $titleconst"; echo $keywords[58][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[58][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[58][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Chevrolet Niva M</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($niva_m as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'chevrolet-l') {
                echo "<title> $titleconst"; echo $keywords[59][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[59][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[59][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Chevrolet Niva L</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($niva_l as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'kaptur') {
                echo "<title> $titleconst"; echo $keywords[60][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[60][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[60][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Renault Kaptur</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/renault.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($renault_kaptur as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'logan') {
                echo "<title> $titleconst"; echo $keywords[61][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[61][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[61][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Renault Logan (2004 - 2014)</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/renault.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($renault_logan_2004 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'logan-new') {
                echo "<title> $titleconst"; echo $keywords[62][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[62][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[62][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для новый Renault Logan </h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/renault.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($renault_logan_2015 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'sandero') {
                echo "<title> $titleconst"; echo $keywords[63][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[63][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[63][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Renault Sandero</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/renault.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($renault_sandero_2010 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'sandero-new') {
                echo "<title> $titleconst"; echo $keywords[64][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[64][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[64][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для новый Renault Sandero</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/renault.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($renault_sandero_2014 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'ceed') {
                echo "<title> $titleconst"; echo $keywords[65][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[65][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[65][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Kia Ceed</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($kia_ceed_2006 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'ceed-new') {
                echo "<title> $titleconst"; echo $keywords[66][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[66][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[66][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для новый Kia Ceed</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($kia_ceed_2012 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'mazda3') {
                echo "<title> $titleconst"; echo $keywords[67][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[67][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[67][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Mazda 3</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/mazda.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($mazda3 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'mazdacx5-1') {
                echo "<title> $titleconst"; echo $keywords[68][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[68][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[68][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Mazda CX-5 I</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/mazda.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($mazda_cx5_1 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'mazdacx5-2') {
                echo "<title> $titleconst"; echo $keywords[69][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[69][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[69][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Mazda CX-5 II</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/mazda.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($mazda_cx5_2 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'creta') {
                echo "<title> $titleconst"; echo $keywords[70][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[70][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[70][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Hyundai Creta</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/hyundai.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($hyundai_creta as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'solaris') {
                echo "<title> $titleconst"; echo $keywords[71][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[71][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[71][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Hyundai Solaris</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/hyundai.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($hyundai_solaris as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'i30') {
                echo "<title> $titleconst"; echo $keywords[72][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[72][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[72][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Hyundai i30</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/hyundai.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($hyundai_i30 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'astra') {
                echo "<title> $titleconst"; echo $keywords[73][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[73][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[73][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Opel Astra</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($opel_astra_2004 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'rav4-3') {
                echo "<title> $titleconst"; echo $keywords[74][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[74][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[74][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Toyota RAV-4 III</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/toyota.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($toyota_rav4_2006 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'rav4-4') {
                echo "<title> $titleconst"; echo $keywords[75][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[75][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[75][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Toyota RAV-4 IV</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/toyota.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($toyota_rav4_2013 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'prado150') {
                echo "<title> $titleconst"; echo $keywords[76][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[76][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[76][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Toyota PRADO 150</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/toyota.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($toyota_prado150 as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'freelander2') {
                echo "<title> $titleconst"; echo $keywords[77][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[77][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[77][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Land Rover Freelander 2</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/aps.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($landrover as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'on-do') {
                echo "<title> $titleconst"; echo $keywords[78][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[78][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[78][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Datsun ON-DO</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/datsun.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($on_do as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($reelings == 'mi-do') {
                echo "<title> $titleconst"; echo $keywords[79][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[79][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[79][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Рейлинги АПС для Datsun MI-DO</h1>";
                include ($_SERVER["DOCUMENT_ROOT"]."/arrays/aps/datsun.php");
                $_SESSION['url'] = $_SERVER['REQUEST_URI'];

                foreach ($mi_do as $item): ?>
                    <div class="good">
                        <h2 class="good__name"><?php echo $item['name']; ?></h2>
                        <div class="good__description">
                            <div class="img_div">
                                <?php echo $item['img']; ?>
                            </div>
                            <p class="page__text">Цвет: <?php echo $item['color']; ?></p>
                        </div>
                        <div class="good__price">
                            <div class="good__price-info">
                                <p class="page__text">Цена без монтажа <strong><?php echo $item['price']; ?></strong></p>
                                <p class="page__text">Цена с монтажом <strong><?php echo $item['price_montazh']; ?></strong></p>
                            </div>
                            <div class="good__price-button">
                                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } ?>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>