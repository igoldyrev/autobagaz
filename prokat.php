<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");
	echo "<meta name='description' content='"; echo $keywords[2][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[2][keywords]; echo "'/>";

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<?php 	
$id = $_GET['id'];

if (!isset($id)) { 
	echo "<title> $titleconst"; echo $keywords[2][title]; echo "</title>";
	echo "<p>Случается так, что багажник, автобокс(бокс на крышу),велокрепление, лыжное крепление и иные бывают нужны разово, или время от времени.</p>";
	echo "<p>В этом случае удобно воспользоваться арендой багажного оборудования-быстро и надежно закрепить лесенку, длинномерные грузы, выехать к месту отдыха с боксом, уехать с велосипедом покорять парки Перми и Пермский край в целом или поставить лыжное крепление и с комфортом перевезти горные/охотничьи лыжи к курорту, отдохнуть и избавить салон своего авто от неминуемых пятен от растаявшего снега с лыж/бордов. Отдыхать активно теперь не только приятно, но еще и удобно!</p>";
	echo "<p>В случае сложных дорожных условий в путешествии или плохой погоды во время охоты/рыбалки-воспользуйтесь прокатом браслетов или цепей противоскольжения и самые сложные дороги станут легко проходимыми даже для самых маленьких и легких машин.</p>"; 
} elseif ($id == '1') {
	$tovar = $_SESSION['autobagazhniki'][0][name];
	echo "<title>Взятие в прокат "; echo $_SESSION['autobagazhniki'][0][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div>
	<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/prokatform.php");
} elseif ($id == '2') {
	$tovar = $_SESSION['autobagazhniki'][1][name];
	echo "<title>Взятие в прокат "; echo $_SESSION['autobagazhniki'][1][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> 
	<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/prokatform.php");
} elseif ($id == '3') {
	$tovar = $_SESSION['autobagazhniki'][2][name];
	echo "<title>Взятие в прокат "; echo $_SESSION['autobagazhniki'][2][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> 
	<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/prokatform.php");
} elseif ($id == '4') {
	$tovar = $_SESSION['autobagazhniki'][3][name];
	echo "<title>Взятие в прокат "; echo $_SESSION['autobagazhniki'][3][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> 
	<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/prokatform.php");
}
$_SESSION['tovar'] = $tovar; ?>
<p>Чтобы <b>воспользоваться</b> услугами аренды необходимо сделать несколько простых шагов:</p> 
<ol>
	<li>Забронируйте багажник, бокс, или любой необходимый аксессуар по телефону, или оставив заявку на сайте (для нас важно, чтобы ваше путешествие ничто не омрачило-выбранное багажное оборудование 100% будет Вас ждать точно в срок)</li> 
	<li>В день аренды необходимо приехать в пункт проката, взяв с собой: 
		<ul><li>паспорт</li>
		<li>залоговую сумму (полная стоимость товара, взятого в прокат)</li></ul></li> 
	<li>В нашем магазине-прокате мы оформляем договор проката, квитанцию об оплате и выдаем Вам выбранное багажное оборудование.</li> 
	<li>Чтобы сократить время визита в магазин-вы можете заполнить <a href ="/docs/Договор проката.doc">договор</a> и отправить нам его на электронный адрес <a href="mailto:autobagaz@yandex.ru">autobagaz@yandex.ru</a>
</ol>
<p>Стоимость дня проката определяется исходя из времени пользования оборудованием:</p>
<table cellspacing="0" align="center">
<tr><td class="producttablecaption" align="center">Сроки проката</td><td class="producttablecaption" align="center">Прокат дуг багажника, крепления для велосипеда (на крышу), лыж, лодки, браслетов противоскольжения</td><td class="producttablecaption" align="center">Прокат автобокса, велокрепления на фаркоп/заднюю дверь, цепей противоскольжения</td></tr>
<tr><td class="producttable" align="center">От 0 до 14 дней</td><td class="producttable" align="center">130 рублей/день</td><td class="producttable" align="center">270 рублей/день</td></tr>
<tr><td class="producttable" align="center">От 15 до 21 дня</td><td class="producttable" align="center">110 рублей/день</td><td class="producttable" align="center">240 рублей/день</td></tr>
<tr><td class="producttable" align="center">От 21 дня</td><td class="producttable" align="center">90 рублей/день</td><td class="producttable" align="center">210 рублей/день</td></tr>
</table>
<p>Обращаем ваше внимание, что время проката считается календарными днями. Монтаж/демонтаж багажных систем осуществляется полностью силами арендатора, либо оплачивается отдельно.</p>
<p>С общими правилами пользования багажным оборудованием можно ознакомиться <a href="/docs/Правила эксплуатации автобоксов.doc">здесь</a>.</p></div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html"); 
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>