<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");
	echo "<title> $titleconst"; echo $keywords[7][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[7][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[7][keywords]; echo "'/>";

include ($_SERVER["DOCUMENT_ROOT"]."/arrays/autobagazhniki_1.php");
$_SESSION['autobagazhniki'] = $autobagazhniki;

echo "<h1>Автомобильные багажники</h1>";
echo "<p>Проблема перевозки крупногабаритных вещей периодически возникает у каждого автомобилиста. Длинномерные грузы, громоздкие коробки и поклажу неравномерной формы редко удается разместить в стандартном багажнике автомобиля, и они начинают скапливаться в салоне, занимая собой личное пространство пассажиров и водителя. Было создано множество средств для решения этой проблемы, но, пожалуй, самыми известными и привычными из них для нас являются <b>багажники на крышу автомобиля</b></p>";
echo "<p>Каждый день в нашем магазине есть 3-10 вариантов различных багажников на любой автомобиль. И для Вашего удобства мы разбили их на категории с обозначением минимальной цены.</p>";
foreach ($autobagazhniki as $item): ?>
	<div class="good"  itemscope itemtype="http://schema.org/Product">
		<h2  itemprop="name"><?php echo $item['name']; ?></h2>
		<div class="description">
		<div class="img_div"  itemprop="image">
			<?php echo $item['img1']; echo $item['img2']; ?>
		</div>
		<div class="good_desc"  itemprop="description">
			<p><?php echo $item['desc']; ?></p>
		</div></div>
		<div class="price_info" itemscope itemtype="http://schema.org/Offer">
			<div class="price"  itemprop="price">
			<p><?php echo $item['price']; ?></p>
			</div>
			<div class="button">
			<button class="buy_button"><a href="/scripts/buy.php?id=<?php echo $item['id']; ?>">Заказать</a></button>
			<button class="prokat_button"><a href="/prokat.php?id=<?php echo $item['id']; ?>">Взять в прокат</a></button>
			</div>
		</div>
	</div>
	<?php endforeach; 
	echo "<p>Если вы являетесь гордым обладателем японского, корейского или китайского автомобиля, остальные продавцы разводят руками в подборе оборудования-не отчаивайтесь, наш богатый опыт поможет вам решить данный вопрос быстро и из наличия!</p>"; 
	include ($_SERVER["DOCUMENT_ROOT"]."/frames/helpform.php"); ?>