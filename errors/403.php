<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");
	echo "<title> $titleconst"; echo $keywords[27][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[27][description]; echo "'/>"; ?>

<div class="error">
    <div class="error__link">
        <a href="/"><img class="error__img" src="/images/logo.jpg" alt="autobagaz.ru"></a>
    </div>
    <div class="error__text">
        <h2 class="page__title-h2">Ошибка 403. Доступ запрещен.</h2>
        <p class="page__text page__text--error">Доступ в эту папку запрещен администратором сайта или в папке нет индексного файла.</p>
        <p class="page__text page__text--error">Но вы также можете перейти на <a class="page__link" href="/">главную страницу</a> сайта.</p>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html");?>
