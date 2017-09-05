<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");
	echo "<title> $titleconst"; echo $keywords[27][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[27][description]; echo "'/>"; ?>

<div style="padding-top:15px">
 <table align="center">
    <tr>
        <td cellpadding="10px" rowspan="2"><a href="/" target="_parent"><img src="/images/logo.jpg" alt="autobagaz.ru" width="400px"></a></td>
    </tr>
	</table>
</div>

<h2 align="center">Ошибка 403. Доступ запрещен.</h2>
<p align="center">Доступ в эту папку запрещен администратором сайта или в папке нет индексного файла.</p>
<p align="center">Вы можете попробовать перейти на <a href="/">главную страницу</a> сайта.</p>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html");?>