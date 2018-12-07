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
				<div class="good">
				  <?php echo "<h2 class='title title-h2'>" . $cay['name'] . "</h2>"; ?>
				  <div class="img__wrap">
				    <?php echo $cay['img1'];
				    echo $cay['img2'];
				    echo $cay['img3']; ?>
				  </div>
				  <?php echo "<p class='text'>" . $cay['desc1'] . "</p>";
				  echo "<p class='text'>" . $cay['desc2'] . "</p>";
				  echo "<p class='text'>" . $cay['desc3'] . "</p>"; ?>
				  <div class="good__price">
				    <div class="good__price-info">
				      <p class="text"<?php echo $stylepricecovers ?>><?php echo "Цена: <strong>";
				              echo $cay['price']; ?></strong></p>
				    </div>
				    <div class="good__buttons">
				      <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
				               href="/buy/<?php echo $cay['id']; ?>" class="button button__buy">Заказать</a>
				    </div>
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
      			echo "<h2 class='title title-h2'>" . 'Авточехлы Орегон Ромб' . "</h2>";

      			foreach ($oregonromb as $oromb): ?>
				<div class="good">
				  <?php echo "<h2 class='title title-h2'>" . $oromb['name'] . "</h2>"; ?>
				  <div class="img__wrap">
				    <?php echo $oromb['img1'];
				    echo $oromb['img2'];
				    echo $oromb['img3']; ?>
				  </div>
				  <?php echo "<p class='text'>" . $oromb['desc1'] . "</p>";
				  echo "<p class='text'>" . $oromb['desc2'] . "</p>";
				  echo "<p class='text'>" . $oromb['desc3'] . "</p>"; ?>
				  <div class="good__price">
				    <div class="good__price-info">
				      <p class="text"<?php echo $stylepricecovers ?>><?php echo "Цена: <strong>";
				              echo $oromb['price']; ?></strong></p>
				    </div>
				    <div class="good__buttons">
				      <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
				               href="/buy/<?php echo $oromb['id']; ?>" class="button button__buy">Заказать</a>
				    </div>
				  </div>
				</div>
				<?php endforeach;

				echo "<h2 class='title title-h2'>" . 'Авточехлы Орегон Модельные' . "</h2>";

      			foreach ($oregonmodel as $omodel): ?>
				<div class="good">
				  <?php echo "<h2 class='title title-h2'>" . $omodel['name'] . "</h2>"; ?>
				  <div class="img__wrap">
				    <?php echo $omodel['img1'];
				    echo $omodel['img2'];
				    echo $omodel['img3']; ?>
				  </div>
				  <?php echo "<p class='text'>" . $omodel['desc1'] . "</p>";
				  echo "<p class='text'>" . $omodel['desc2'] . "</p>";
				  echo "<p class='text'>" . $omodel['desc3'] . "</p>"; ?>
				  <div class="good__price">
				    <div class="good__price-info">
				      <p class="text"<?php echo $stylepricecovers ?>><?php echo "Цена: <strong>";
				              echo $omodel['price']; ?></strong></p>
				    </div>
				    <div class="good__buttons">
				      <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
				               href="/buy/<?php echo $omodel['id']; ?>" class="button button__buy">Заказать</a>
				    </div>
				  </div>
				</div>
				<?php endforeach;

				echo "<h2 class='title title-h2'>" . 'Авточехлы Орегон Универсальные' . "</h2>";

      			foreach ($oregonuniversal as $ouniv): ?>
				<div class="good">
				  <?php echo "<h2 class='title title-h2'>" . $ouniv['name'] . "</h2>"; ?>
				  <div class="img__wrap">
				    <?php echo $ouniv['img1'];
				    echo $ouniv['img2'];
				    echo $ouniv['img3']; ?>
				  </div>
				  <?php echo "<p class='text'>" . $ouniv['desc1'] . "</p>";
				  echo "<p class='text'>" . $ouniv['desc2'] . "</p>";
				  echo "<p class='text'>" . $ouniv['desc3'] . "</p>"; ?>
				  <div class="good__price">
				    <div class="good__price-info">
				      <p class="text"<?php echo $stylepricecovers ?>><?php echo "Цена: <strong>";
				              echo $ouniv['price']; ?></strong></p>
				    </div>
				    <div class="good__buttons">
				      <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
				               href="/buy/<?php echo $ouniv['id']; ?>" class="button button__buy">Заказать</a>
				    </div>
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
      			echo "<h2 class='title title-h2'>" . 'Авточехлы Тренд Двойной Ромб' . "</h2>";

      			foreach ($trendromb as $tromb): ?>
      			<div class="good">
				  	<?php echo "<h2 class='title title-h2'>" . $tromb['name'] . "</h2>"; ?>
				  <div class="img__wrap">
				    <?php echo $tromb['img1'];
				    echo $tromb['img2'];
				    echo $tromb['img3']; ?>
				  </div>
				  <?php echo "<p class='text'>" . $tromb['desc1'] . "</p>";
				  echo "<p class='text'>" . $tromb['desc2'] . "</p>";
				  echo "<p class='text'>" . $tromb['desc3'] . "</p>"; ?>
				  <div class="good__price">
				    <div class="good__price-info">
				      <p class="text"<?php echo $stylepricecovers ?>><?php echo "Цена: <strong>";
				              echo $tromb['price']; ?></strong></p>
				    </div>
				    <div class="good__buttons">
				      <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
				               href="/buy/<?php echo $tromb['id']; ?>" class="button button__buy">Заказать</a>
				    </div>
				  </div>
				</div>
				<?php endforeach;

      			echo "<h2 class='title title-h2'>" . 'Авточехлы Тренд' . "</h2>";

      			foreach ($trend as $tr): ?>
      			<div class="good">
				  <?php echo "<h2 class='title title-h2'>" . $tr['name'] . "</h2>"; ?>
				  <div class="img__wrap">
				    <?php echo $tr['img1'];
				    echo $tr['img2'];
				    echo $tr['img3']; ?>
				  </div>
				  <?php echo "<p class='text'>" . $tr['desc1'] . "</p>";
				  echo "<p class='text'>" . $tr['desc2'] . "</p>";
				  echo "<p class='text'>" . $tr['desc3'] . "</p>"; ?>
				  <div class="good__price">
				    <div class="good__price-info">
				      <p class="text"<?php echo $stylepricecovers ?>><?php echo "Цена: <strong>";
				              echo $tr['price']; ?></strong></p>
				    </div>
				    <div class="good__buttons">
				      <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true"
				               href="/buy/<?php echo $tr['id']; ?>" class="button button__buy">Заказать</a>
				    </div>
				  </div>
				</div>
				<?php endforeach;
      			include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php"); 
      		} ?>
	</div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html"); ?>	