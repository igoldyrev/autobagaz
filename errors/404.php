<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");
	echo "<title> $titleconst"; echo $keywords[26][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[26][description]; echo "'/>"; ?>

<div style="padding-top:15px">
 <table align="center">
    <tr>
        <td cellpadding="10px" rowspan="2"><a href="/" target="_parent"><img src="/images/logo.jpg" alt="autobagaz.ru" width="400px"></a></td>
    </tr>
	</table>
</div>

<h2 align="center">Ошибка 404. Файл не найден.</h2>
<p align="center">Возможно вы ошиблись при наборе адреса, или ссылка, по которой вы прошли, устарела.</p>
<p align="center">Но вы также можете перейти на <a href="/">главную страницу</a> сайта.</p>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html");?>