<?php
include ($_SERVER["DOCUMENT_ROOT"]."/backend/keywords/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php");
	echo "<title> $titleconst"; echo $keywords[10][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[10][description]; echo "'/>"; ?>

<div class="wrapper">
    <div class="error">
        <div class="error__link-wrap">
            <a class="error__link" href="/"><img class="error__img" src="/src/common.blocks/error/img/logo.jpg" alt="autobagaz.ru"></a>
        </div>
        <div class="error__text">
            <h2 class="title title-h2">Ошибка 404. Файл не найден.</h2>
            <p class="text">Возможно вы ошиблись при наборе адреса, или ссылка, по которой вы прошли, устарела.</p>
            <p class="text">Но вы также можете перейти на <a class="link" href="/">главную страницу</a> сайта.</p>
        </div>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html");?>