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
	echo "<title> $titleconst"; echo $keywords[21][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[21][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[21][keywords]; echo "'/>"; 
	
	$_SESSION['braslet'] = $braslet; 
	$_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>
	
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h1  itemprop="name"><?php echo $braslet['title']; ?></h1>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $braslet['img']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $braslet['desc']; ?></p>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<table align="center">
				<tr><td class="producttable" align="left"><?php echo $braslet['desc1']; ?></td><td class="producttable" align="center"><?php echo $braslet['price1']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $braslet['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $braslet['id1']; ?>">Взять в прокат</a></button></td></tr>	
				<tr><td class="producttable" align="left"><?php echo $braslet['desc2']; ?></td><td class="producttable" align="center"><?php echo $braslet['price2']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $braslet['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $braslet['id2']; ?>">Взять в прокат</a></button></td></tr>	
				<tr><td class="producttable" align="left"><?php echo $braslet['desc3']; ?></td><td class="producttable" align="center"><?php echo $braslet['price3']; ?></td><td class="producttable" align="center"><button class="buy_button"><a href="/buy/<?php echo $braslet['id3']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button class="prokat_button"><a href="/prokat/<?php echo $braslet['id3']; ?>">Взять в прокат</a></button></td></tr>	
			</table>
		</div>
	</div> <?php 
	include ($_SERVER["DOCUMENT_ROOT"]."/frames/helpform.php"); ?>
</div>
<?php 
include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>