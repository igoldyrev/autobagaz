<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");
	echo "<title> $titleconst"; echo $keywords[26][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[26][description]; echo "'/>"; ?>

<div class="error">
    <div class="error__link">
        <a href="/"><img class="error__img" src="/images/logo.jpg" alt="autobagaz.ru"></a>
    </div>
    <div class="error__text">
        <h2 class="page__title-h2">Ошибка 404. Файл не найден.</h2>
        <p class="page__text page__text--error">Возможно вы ошиблись при наборе адреса, или ссылка, по которой вы прошли, устарела.</p>
        <p class="page__text page__text--error">Но вы также можете перейти на <a class="page__link" href="/">главную страницу</a> сайта.</p>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html");?>