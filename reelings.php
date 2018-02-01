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
                            <a href="/reelings/lada-4x4-l"><img class="item__image-img" src="/images/aps/lada/4x4-l" alt="lada 4x4 L"></a>
                        </div>
                        <div class="item__link">
                            <a href="/reelings/lada-4x4-l">LADA 4x4 L</a>
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