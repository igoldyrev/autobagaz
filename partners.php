<?php
include ($_SERVER["DOCUMENT_ROOT"]."/backend/keywords/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
echo "<title> $titleconst"; echo $keywords[8][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[8][description]; echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[8][keywords]; echo "'/>"; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <h1 class="title title-h1">Наши партнеры</h1>
        <div class="partner">
            <h2 class="title title-h2">Магазин ARMYLIFE</h2>
            <div class="partner__inner">
                <img class="partner__logo" src="/content/partner/armylife.jpg" alt="armylife">
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
        <div class="partner">
              <h2 class="title title-h2">Парапланерный клуб "ПермАЭРО"</h2>
              <div class="partner__inner">
                  <img class="partner__logo" src="/content/partner/permaero.png" alt="permaero">
                  <div class="partner__description">
                      <p class="partner__text">Сайт: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="https://permaero.ru/" class="partner__link" target="_blank">permaero.ru</a></p>
                      <p class="partner__text">Почта: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="mailto:info@permaero.ru" class="partner__link">info@permaero.ru</a></p>
                      <p class="partner__text">Телефон: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="tel:+79824574388" class="partner__link">+7 (982) 457 43 88</a></p>
                      <p class="partner__text">Контактное лицо: Силин Роман (Руководитель клуба)</p>
                  </div>
              </div>
          </div>
<!--        <div class="partner">-->
<!--            <h2 class="title title-h2">Парк активного отдыха "Юго-Камские горки"</h2>-->
<!--            <div class="partner__inner partner__inner--column">-->
<!--                <img class="partner__logo partner__logo--column" src="/content/partner/ugokamsk.jpg" alt="Юго-Камские горки">-->
<!--                <div class="partner__description">-->
<!--                    <p class="partner__text">Сайт: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="http://ugo-kamsk.ru/" class="partner__link" target="_blank">ugo-kamsk.ru</a></p>-->
<!--                    <p class="partner__text">Почта: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="mailto:servis-park@mail.ru" class="partner__link">servis-park@mail.ru</a></p>-->
<!--                    <p class="partner__text">Телефон: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="tel:89048430916" class="partner__link">8-904-843-09-16</a></p>-->
<!--                    <p class="partner__text">Адрес:  Пермский край. поселок Юго-Камск</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <div class="partner">
            <h2 class="title title-h2">Электровелосипеды Пермь</h2>
            <p class="partner__text">Телефон: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="tel:89323370758" class="partner__link">+ 7 (932) 3370758</a></p>
            <p class="partner__text">Skype: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="skype:ebikekitsupport" class="partner__link">ebikekitsupport</a></p>
            <p class="partner__text"><span>Часы работы: </span><span>Вторник - Суббота с 11:30 до 17:30</span></p>
            <p class="partner__text">Сайт: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="http://electricbikes59.ru" class="partner__link" target="_blank">electricbikes59</a></p>
        </div>
        <div class="partner">
            <h2 class="title title-h2">Магазин AVTOPRICEP59</h2>
            <p class="partner__text">Сайт: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="http://avtopricep59.ru/" class="partner__link" target="_blank">AVTOPRICEP59</a></p>
            <p class="partner__text">Почта: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="mailto:PRI6EST@yandex.ru" class="partner__link">PRI6EST@yandex.ru</a></p>
            <p class="partner__text">Телефон: <a onclick="yaCounter40650914.reachGoal('partner_link'); return true" href="tel:89124998777" class="partner__link">8-912-499-8777</a></p>
            <p class="partner__text">Адрес: г. Пермь ул. Спешилова, 81</p>
        </div>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
