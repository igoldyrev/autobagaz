<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");
	echo "<title> $titleconst"; echo $keywords[28][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[28][description]; echo "'/>"; ?>

<div class="error">
    <div class="error__link">
        <a href="/"><img class="error__img" src="/images/logo.jpg" alt="autobagaz.ru"></a>
    </div>
    <div class="error__text">
        <h2 class="page__title-h2">Ошибка 500. Внутренняя ошибка сервера.</h2>
        <p class="page__text page__text--error">Возможные причины ошибки: неподдерживаемые директивы или синтаксическая ошибка в файле .htaccess, ошибка в CGI-скрипте или неверные права.</p>
        <p class="page__text page__text--error">Вы также можете перейти на <a class="page__link" href="/">главную страницу</a> сайта.</p>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html");?>

