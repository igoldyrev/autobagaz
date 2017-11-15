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
                <h2 class="page__title-h2">Магазин AVTOPRICEP59</h2>
                <p class="partner__text">Сайт: <a href="http://avtopricep59.ru/" class="partner__link">AVTOPRICEP59</a></p>
                <p class="partner__text">Почта: <a href="mailto:PRI6EST@yandex.ru" class="partner__link">PRI6EST@yandex.ru</a></p>
                <p class="partner__text">Телефон: <a href="tel:89124998777" class="partner__link">8-912-499-8777</a></p>
                <p class="partner__text">Адрес: г. Пермь ул. Спешилова, 81</p>
            </div>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html");?>
</div>