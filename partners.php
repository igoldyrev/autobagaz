<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");
echo "<title> $titleconst"; echo $keywords[29][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[29][description]; echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[29][keywords]; echo "'/>";

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); ?>
    <div id="leftmenu">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
    </div>
    <div id="content">
        <h1>Наши партнеры</h1>
        <div class="partner">
            <h3>Магазин AVTOPRICEP59</h3>
            <p>Сайт: <a href="http://avtopricep59.ru/">AVTOPRICEP59</a></p>
            <p>Почта: <a href="mailto:PRI6EST@yandex.ru">PRI6EST@yandex.ru</a></p>
            <p>Телефон: <a href="tel:8-912-499-8777">8-912-499-8777</a></p>
            <p>Адрес: Спешилова 81</p>
        </div>
       </div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");?>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html");?>