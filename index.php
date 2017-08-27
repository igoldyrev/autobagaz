<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<?php
$page = $_GET['page'];

if (!isset($page)) {
	echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[0][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";
	include ($_SERVER["DOCUMENT_ROOT"]."/frames/newslist.php"); ?>
	
	<div class="catalog">
		<div class="menu_item">
			<div class="item_image">
			<a href="/autobagazhniki"><img src="/images/index/1_autobagazniki.jpg" alt="autobagazhniki" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/autobagazhniki">Автобагажники</a>
			</div>
		</div>
		<div class="menu_item">
			<div class="item_image">
			<a href="/autobagazhniki"><img src="/images/index/2_autobox.jpg" alt="autobox" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/autobox">Автомобильные боксы</a>
			</div>
		</div>
		<div class="menu_item">
			<div class="item_image">
			<a href="/autobagazhniki"><img src="/images/index/3_velokreplenya.jpg" alt="velokreplenya" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/velokreplenya">Велокрепления</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/autobagazhniki"><img src="/images/index/4_lyzh_kreplenya.jpg" alt="lyzhnye kreplenya" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/kreplenya-dlya-lyzh-shoubord">Крепления для лыж и сноубордов</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/autobagazhniki"><img src="/images/index/6_reelings.jpg" alt="reelings" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/reelings">Рейлинги</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/autobagazhniki"><img src="/images/index/7_braslet.jpg" alt="braslet" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/braslets">Браслеты противоскольжения</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/autobagazhniki"><img src="/images/index/8_farkops.jpg" alt="farkops" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/farkops">Фаркопы</a>
			</div>
		</div>
		
	</div>



<?php
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
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html"); ?>