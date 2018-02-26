<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");
echo "<title> $titleconst"; echo $keywords[29][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[29][description]; echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[29][keywords]; echo "'/>"; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php");?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html");?>
        <div class="content">
            <h1 class="page__title-h1">Наши партнеры</h1>
            <div class="partner">
                <h2 class="page__title-h2">Магазин ARMYLIFE</h2>
                <div class="partner__inner">
                    <div class="partner__logo">
                        <img src="/images/partners/armylife.jpg" alt="armylife">
                    </div>
                    <div class="partner__description">
                        <p class="partner__text">Сайт: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="http://армилайф.рф/" class="partner__link" target="_blank">армилайф.рф</a></p>
                        <p class="partner__text">Почта: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="mailto:armylife.info@yandex.ru" class="partner__link">armylife.info@yandex.ru</a></p>
                        <p class="partner__text">Телефон: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="tel:+73422105758" class="partner__link">+7(342)210-57-58</a></p>
                        <p class="partner__text">Телефон: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="tel:+73422045201" class="partner__link">+7(342)204-52-01</a></p>
                        <p class="partner__text">Телефон: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="tel:+79223545399" class="partner__link">+7(922)354-53-99</a></p>
                        <p class="partner__text">Телефон: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="tel:+73422405399" class="partner__link">+7(342)240-53-99</a></p>
                        <p class="partner__text">Адрес: г. Пермь, ул. Героев Хасана, 48, корпус 2</p>
                        <p class="partner__text">Адрес: г. Пермь, ул. Дзержинского, 15</p>
                    </div>
                </div>
            </div>
<!--            <div class="partner">-->
<!--                <h2 class="page__title-h2">Парк активного отдыха "Юго-Камские горки"</h2>-->
<!--                <div class="partner__inner partner__inner--column">-->
<!--                    <div class="partner__logo partner__logo--column">-->
<!--                        <img src="/images/partners/ugokamsk.jpg" alt="Юго-Камские горки">-->
<!--                    </div>-->
<!--                    <div class="partner__description">-->
<!--                        <p class="partner__text">Сайт: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="http://ugo-kamsk.ru/" class="partner__link" target="_blank">ugo-kamsk.ru</a></p>-->
<!--                        <p class="partner__text">Почта: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="mailto:servis-park@mail.ru" class="partner__link">servis-park@mail.ru</a></p>-->
<!--                        <p class="partner__text">Телефон: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="tel:89048430916" class="partner__link">8-904-843-09-16</a></p>-->
<!--                        <p class="partner__text">Адрес:  Пермский край. поселок Юго-Камск</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="partner">
                <h2 class="page__title-h2">Магазин AVTOPRICEP59</h2>
                <p class="partner__text">Сайт: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="http://avtopricep59.ru/" class="partner__link" target="_blank">AVTOPRICEP59</a></p>
                <p class="partner__text">Почта: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="mailto:PRI6EST@yandex.ru" class="partner__link">PRI6EST@yandex.ru</a></p>
                <p class="partner__text">Телефон: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="tel:89124998777" class="partner__link">8-912-499-8777</a></p>
                <p class="partner__text">Адрес: г. Пермь ул. Спешилова, 81</p>
            </div>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html");?>
</div>