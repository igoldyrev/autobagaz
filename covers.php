<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatags.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/header.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/proposition/proposition.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation/navigation.html");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/breadcrumbs/breadcrumbs.php");

include($_SERVER["DOCUMENT_ROOT"] . "/content/covers/backend/keywords.php");
include($_SERVER["DOCUMENT_ROOT"] . "/content/covers/backend/array.php"); ?>

<div class="wrapper">
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/left-nav/left-nav.html"); ?>
	<div class="wrapper__content">
		<?php
		$cover = $_GET['cover'];
		$_SESSION['url'] = $_SERVER['REQUEST_URI'];

		if (!isset($cover)) {
			echo "<title> $titleconst";
      		echo $keywords[0][title];
      		echo "</title>";
      		echo "<meta name='description' content='";
      		echo $keywords[0][description];
      		echo "'/>";

      		echo "<h1 class='title title-h1'>" . $keywords[0][title] . "</h1>"; ?>

      		<div class="catalog">
      			<div class="catalog__item">
      				<a href="/covers/cayman" class="catalog__item-link"></a>
		          	<div class="catalog__image-wrap">
		          		<img class="catalog__image" src="/content/covers/img/Cayman_Black_Alkantara_Front.jpg" alt="cayman">
		          	</div>
          			<div class="catalog__text">
            			<p class="text">Авточехлы Cayman</p>
          			</div>
        		</div>
        		<div class="catalog__item">
      				<a href="/covers/oregon" class="catalog__item-link"></a>
		          	<div class="catalog__image-wrap">
		          		<img class="catalog__image" src="/content/covers/img/Oregon_Model_Black_Face.jpg" alt="oregon">
		          	</div>
          			<div class="catalog__text">
            			<p class="text">Авточехлы Oregon</p>
          			</div>
        		</div>
        		<div class="catalog__item">
      				<a href="/covers/trend" class="catalog__item-link"></a>
		          	<div class="catalog__image-wrap">
		          		<img class="catalog__image" src="/content/covers/img/Trend_Black_White_Front.jpg" alt="trend">
		          	</div>
          			<div class="catalog__text">
            			<p class="text">Авточехлы Trend</p>
          			</div>
        		</div>
      		</div>
      		<?php } elseif ($cover == 'cayman') {
      			echo "<title> $titleconst";
			    echo $keywords[1][title];
			    echo "</title>";
			    echo "<meta name='description' content='";
			    echo $keywords[1][description];
			    echo "'/>";
			 
			 	$_SESSION['cayman'] = $cayman;
      			$_SESSION['url'] = $_SERVER['REQUEST_URI'];

      			echo "<h1 class='title title-h1'>" . $keywords[1][title] . "</h1>";

      			foreach ($cayman as $cay): ?>
      				<div class="product">
      					<div class="img__wrap product__photos">
      						<?php echo $cay['img1'] ?>
            				<?php echo $cay['img2'] ?>
            				<?php echo $cay['img3'] ?>	
          				</div>
          				<div class="product__info">
          					<h3 class="title title-h3"><?php echo $cay['name'] ?></h3>
            				<p class="text"><?php echo $cay['desc1'] ?></p>
							<p class="text"><?php echo $cay['desc2'] ?></p>
							<p class="text"><?php echo $cay['desc3'] ?></p>
          				</div>
      				</div>
      			<?php endforeach;
      			include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");

      		} elseif ($cover == 'oregon') {
      			echo "<title> $titleconst";
			    echo $keywords[2][title];
			    echo "</title>";
			    echo "<meta name='description' content='";
			    echo $keywords[2][description];
			    echo "'/>";
			 
			 	$_SESSION['oregon'] = $oregon;
      			$_SESSION['url'] = $_SERVER['REQUEST_URI'];

      			echo "<h1 class='title title-h1'>" . $keywords[2][title] . "</h1>";

      			foreach ($oregonromb as $oromb): ?>
      				<div class="product">
      					<div class="img__wrap product__photos">
      						<?php echo $oromb['img1'] ?>
            				<?php echo $oromb['img2'] ?>
            				<?php echo $oromb['img3'] ?>	
          				</div>
          				<div class="product__info">
          					<h3 class="title title-h3"><?php echo $oromb['name'] ?></h3>
            				<p class="text"><?php echo $oromb['desc1'] ?></p>
							<p class="text"><?php echo $oromb['desc2'] ?></p>
							<p class="text"><?php echo $oromb['desc3'] ?></p>
          				</div>
      				</div>
      			<?php endforeach;

      			foreach ($oregonmodel as $omodel): ?>
      				<div class="product">
      					<div class="img__wrap product__photos">
      						<?php echo $omodel['img1'] ?>
            				<?php echo $omodel['img2'] ?>
            				<?php echo $omodel['img3'] ?>	
          				</div>
          				<div class="product__info">
          					<h3 class="title title-h3"><?php echo $omodel['name'] ?></h3>
            				<p class="text"><?php echo $omodel['desc1'] ?></p>
							<p class="text"><?php echo $omodel['desc2'] ?></p>
							<p class="text"><?php echo $omodel['desc3'] ?></p>
          				</div>
      				</div>
      			<?php endforeach;

      			foreach ($oregonuniversal as $ouniv): ?>
      				<div class="product">
      					<div class="img__wrap product__photos">
      						<?php echo $ouniv['img1'] ?>
            				<?php echo $ouniv['img2'] ?>
            				<?php echo $ouniv['img3'] ?>	
          				</div>
          				<div class="product__info">
          					<h3 class="title title-h3"><?php echo $ouniv['name'] ?></h3>
            				<p class="text"><?php echo $ouniv['desc1'] ?></p>
							<p class="text"><?php echo $ouniv['desc2'] ?></p>
							<p class="text"><?php echo $ouniv['desc3'] ?></p>
          				</div>
      				</div>
      			<?php endforeach; 
      			include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php");     			


      		} elseif ($cover == 'trend') {
      			echo "<title> $titleconst";
			    echo $keywords[3][title];
			    echo "</title>";
			    echo "<meta name='description' content='";
			    echo $keywords[3][description];
			    echo "'/>";
			 
			 	$_SESSION['trend'] = $trend;
      			$_SESSION['url'] = $_SERVER['REQUEST_URI'];

      			echo "<h1 class='title title-h1'>" . $keywords[3][title] . "</h1>";

      			foreach ($trendromb as $tromb): ?>
      				<div class="product">
      					<div class="img__wrap product__photos">
      						<?php echo $tromb['img1'] ?>
            				<?php echo $tromb['img2'] ?>
            				<?php echo $tromb['img3'] ?>	
          				</div>
          				<div class="product__info">
          					<h3 class="title title-h3"><?php echo $tromb['name'] ?></h3>
            				<p class="text"><?php echo $tromb['desc1'] ?></p>
							<p class="text"><?php echo $tromb['desc2'] ?></p>
							<p class="text"><?php echo $tromb['desc3'] ?></p>
          				</div>
      				</div>
      			<?php endforeach;

      			foreach ($trend as $tr): ?>
      				<div class="product">
      					<div class="img__wrap product__photos">
      						<?php echo $tr['img1'] ?>
            				<?php echo $tr['img2'] ?>
            				<?php echo $tr['img3'] ?>	
          				</div>
          				<div class="product__info">
          					<h3 class="title title-h3"><?php echo $tr['name'] ?></h3>
            				<p class="text"><?php echo $tr['desc1'] ?></p>
							<p class="text"><?php echo $tr['desc2'] ?></p>
							<p class="text"><?php echo $tr['desc3'] ?></p>
          				</div>
      				</div>
      			<?php endforeach;
      			include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php"); 
      		}



		?>
	</div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html"); ?>