<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");


$page = $_GET['page'];

if (!isset($page)) {
	echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[0][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";

	echo "Это главная страница";

	} elseif ($page == 'contacts') {
	echo "<title> $titleconst"; echo $keywords[6][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[6][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[6][keywords]; echo "'/>";

	echo "Это страница с контактами";
	} elseif ($page == 'feedback') {
	echo "<title> $titleconst"; echo $keywords[4][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[4][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[4][keywords]; echo "'/>";

	echo "Это страница обратной связи";
	} elseif ($page == 'prokat') {
	echo "<title> $titleconst"; echo $keywords[3][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[3][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[3][keywords]; echo "'/>";

	echo "Это страница проката оборудования";
	}
?>