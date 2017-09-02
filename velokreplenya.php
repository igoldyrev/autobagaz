<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); 
include ($_SERVER["DOCUMENT_ROOT"]."/arrays/velokreplenya_array.php"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<?php
$velokreplenya = $_GET['velokreplenya'];
if (!isset($velokreplenya)) {
	echo "<title> $titleconst"; echo $keywords[16][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[16][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[16][keywords]; echo "'/>";
	
	echo "<h1>Велокрепления</h1>";
	echo "<h3>Сколько велосипедов влезает в ваш автомобиль?</h3>";
	echo "<p>Велосипед, как средство передвижения, дает своему владельцу ни с чем не сравнимое чувство свободы – свободы от пробок, заправок, даже от дорог. Ведь любая тропинка в лесу, в парке, а иногда и бездорожье – для велосипедиста подчас лучше пыльной, забитой машинами, трассы. Тем не менее, любой велосипедист рано или поздно сталкивается с необходимостью перевозки двухколесного друга, в том числе, и на автомобиле. Ведь самый чистый воздух, самые интересные маршруты находятся вдали от города.</p>";
	echo "<p>Сразу оговоримся, что перевозка велосипеда в багажном отсеке, пусть даже большом – далеко не лучшее решение этой проблемы. Неудобно это, высока вероятность повредить, испачкать салон. Гораздо лучше воспользоваться специальными приспособлениями для транспортировки велосипеда – автомобильными велобагажниками, или, правильнее, автомобильными велокреплениями.</p>";
	echo "<p>Условно, все велокрепления можно разделить на несколько типов по способу их установки на автомобиль:</p>"; ?>
	<table class="links_catalog">
		<tr><td width="170px" class="links_catalog" align="center"><a href="/velokreplenya_na_kryshy"><img src="/images/velo/krysha/amos_1.jpg" alt="Велокрепления на крышу" width="150px"></a></td><td align="center" class="links_catalog"><a class="links_catalog" href="/velokreplenya_na_kryshy">Велокрепления на крышу</a></td></tr>
		<tr><td width="170px" class="links_catalog" align="center"><a href="/velokreplenya_na_farkop"><img src="/images/velo/farkop/amos_2.jpg" alt="Велокрепления на фаркоп" width="150px"></a></td><td class="links_catalog" align="center"><a class="links_catalog" href="/velokreplenya_na_farkop">Велокрепления на фаркоп</a></td></tr>
	</table> <?php
}


?>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>