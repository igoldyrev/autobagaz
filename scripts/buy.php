<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<?php

$id = $_GET['id'];

if (!isset($id)) { 
	echo "<title>"; echo "Выберите товар для заказа"; echo "</title>"; ?>
	<div class="good_message">
	<?php echo "<p>Вы  не выбрали ничего для заказа. Вернитесь в каталог и выберите из него что-нибудь. А затем заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'ab1') {
	$tovar = $_SESSION['autobagazhniki'][0][name];
	echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][0][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'ab2') {
	$tovar = $_SESSION['autobagazhniki'][1][name];
	echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][1][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'ab3') {
	$tovar = $_SESSION['autobagazhniki'][2][name];
	echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][2][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'ab4') {
	$tovar = $_SESSION['autobagazhniki'][3][name];
	echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][3][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 's1') { 
	$tovar = $_SESSION['sales'][0][name];
	echo "<title>Заказ товара "; echo $_SESSION['sales'][0][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 's2') { 
	$tovar = $_SESSION['sales'][1][name];
	echo "<title>Заказ товара "; echo $_SESSION['sales'][1][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'yuago') {
	$tovar = $_SESSION['yuago'][name];
	echo "<title>Заказ товара "; echo $_SESSION['yuago'][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'turino') {
	$tovar = $_SESSION['turino'][name];
	echo "<title>Заказ товара "; echo $_SESSION['turino'][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'lux600blackmetal') {
	$tovar = $_SESSION['lux'][name1];
	echo "<title>Заказ товара "; echo $_SESSION['lux'][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'lux600blackfrosted') {
	$tovar = $_SESSION['lux'][name2];
	echo "<title>Заказ товара "; echo $_SESSION['lux'][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'lux600white') {
	$tovar = $_SESSION['lux'][name3];
	echo "<title>Заказ товара "; echo $_SESSION['lux'][name3]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'lux960blackfrosted') {
	$tovar = $_SESSION['lux'][name4];
	echo "<title>Заказ товара "; echo $_SESSION['lux'][name4]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'lux960blackmetal') {
	$tovar = $_SESSION['lux'][name5];
	echo "<title>Заказ товара "; echo $_SESSION['lux'][name5]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'lux960white') {
	$tovar = $_SESSION['lux'][name6];
	echo "<title>Заказ товара "; echo $_SESSION['lux'][name6]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'dc320') {
	$tovar = $_SESSION['discoveryclassic'][name1];
	echo "<title>Заказ товара "; echo $_SESSION['discoveryclassic'][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'dc430') {
	$tovar = $_SESSION['discoveryclassic'][name2];
	echo "<title>Заказ товара "; echo $_SESSION['discoveryclassic'][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'dc500') {
	$tovar = $_SESSION['discoveryclassic'][name3];
	echo "<title>Заказ товара "; echo $_SESSION['discoveryclassic'][name3]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'ds431') {
	$tovar = $_SESSION['discoverysport'][name1];
	echo "<title>Заказ товара "; echo $_SESSION['discoverysport'][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'ds501') {
	$tovar = $_SESSION['discoverysport'][name2];
	echo "<title>Заказ товара "; echo $_SESSION['discoverysport'][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'dynamic434') {
	$tovar = $_SESSION['dynamic'][name1];
	echo "<title>Заказ товара "; echo $_SESSION['dynamic'][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'dynamic504') {
	$tovar = $_SESSION['dynamic'][name2];
	echo "<title>Заказ товара "; echo $_SESSION['dynamic'][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'airtek435') {
	$tovar = $_SESSION['airtek'][name1];
	echo "<title>Заказ товара "; echo $_SESSION['airtek'][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'airtek505') {
	$tovar = $_SESSION['airtek'][name2];
	echo "<title>Заказ товара "; echo $_SESSION['airtek'][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '400Mblack') {
	$tovar = $_SESSION['vetlan'][0][name1];
	echo "<title>Заказ товара "; echo $_SESSION['vetlan'][0][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '400Mgray') {
	$tovar = $_SESSION['vetlan'][0][name2];
	echo "<title>Заказ товара "; echo $_SESSION['vetlan'][0][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '400Mwhite') {
	$tovar = $_SESSION['vetlan'][0][name3];
	echo "<title>Заказ товара "; echo $_SESSION['vetlan'][0][name3]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '430Mblack') {
	$tovar = $_SESSION['vetlan'][1][name1];
	echo "<title>Заказ товара "; echo $_SESSION['vetlan'][1][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '430Mgray') {
	$tovar = $_SESSION['vetlan'][1][name2];
	echo "<title>Заказ товара "; echo $_SESSION['vetlan'][1][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '430Mwhite') {
	$tovar = $_SESSION['vetlan'][1][name3];
	echo "<title>Заказ товара "; echo $_SESSION['vetlan'][1][name3]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '550Mblack') {
	$tovar = $_SESSION['vetlan'][2][name1];
	echo "<title>Заказ товара "; echo $_SESSION['vetlan'][2][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '550Mgray') {
	$tovar = $_SESSION['vetlan'][2][name2];
	echo "<title>Заказ товара "; echo $_SESSION['vetlan'][2][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '550Mwhite') {
	$tovar = $_SESSION['vetlan'][2][name3];
	echo "<title>Заказ товара "; echo $_SESSION['vetlan'][2][name3]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'vk1') {
	$tovar = $_SESSION['velokrysha'][0][name];
	echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][0][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'vk2') {
	$tovar = $_SESSION['velokrysha'][1][name];
	echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][1][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'vk3') {
	$tovar = $_SESSION['velokrysha'][2][name];
	echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][2][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'vk4') {
	$tovar = $_SESSION['velokrysha'][3][name];
	echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][3][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'vf1') {
	$tovar = $_SESSION['velofarkop'][0][name];
	echo "<title>Заказ товара "; echo $_SESSION['velofarkop'][0][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'vf2') {
	$tovar = $_SESSION['velofarkop'][1][name];
	echo "<title>Заказ товара "; echo $_SESSION['velofarkop'][1][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'amos34') {
	$tovar = $_SESSION['lyzhi'][0][name1];
	echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][0][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'amos56') {
	$tovar = $_SESSION['lyzhi'][0][name2];
	echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][0][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'atlant34') {
	$tovar = $_SESSION['lyzhi'][1][name1];
	echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][1][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'atlant56') {
	$tovar = $_SESSION['lyzhi'][1][name2];
	echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][1][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'montblanc34') {
	$tovar = $_SESSION['lyzhi'][2][name1];
	echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][2][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'montblanc56') {
	$tovar = $_SESSION['lyzhi'][2][name2];
	echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][2][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'thule34') {
	$tovar = $_SESSION['lyzhi'][3][name1];
	echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][3][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'thule56') {
	$tovar = $_SESSION['lyzhi'][3][name2];
	echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][3][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'xtender') {
	$tovar = $_SESSION['lyzhi'][4][name];
	echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][4][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'r12') {
	$tovar = $_SESSION['braslet'][name1];
	echo "<title>Заказ товара "; echo $_SESSION['braslet'][name1]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'r16') {
	$tovar = $_SESSION['braslet'][name2];
	echo "<title>Заказ товара "; echo $_SESSION['braslet'][name2]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == 'gazel') {
	$tovar = $_SESSION['braslet'][name3];
	echo "<title>Заказ товара "; echo $_SESSION['braslet'][name3]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
}
$_SESSION['tovar'] = $tovar; ?>

<form action="/zakaz" method="post">
<span class="label_top">Ваше имя:</span>
<div class="better-placeholder">
  <input type="text" name="name" required="required" pattern="[А-Яа-яЁё]{2,}" class="better-placeholder__input" placeholder="Введите Ваше имя">
  <label for="name" class="better-placeholder__label">Введите Ваше имя</label>
</div><br>
<span class="label_top">Ваш телефон:</span>
<div class="better-placeholder">
  <input type="text" name="phone" class="better-placeholder__input" required="required" pattern="[0-9]{10,11}" placeholder="Введите номер телефона">
  <label for="phone" class="better-placeholder__label">Введите номер телефона</label>
</div><br>
<span class="label_top">Марка машины:</span>
<div class="better-placeholder">
  <input type="text" name="auto" class="better-placeholder__input" pattern="^[A-Za-zА-Яа-яЁё0-9\s]+$" placeholder="Введите марку автомобиля">
  <label for="auto" class="better-placeholder__label">Введите марку автомобиля</label>
</div><br>
<span class="label_top">Тип кузова:</span>
<div class="better-placeholder">
  <select class="better-placeholder__select" size="1" name="kuzov">
    <option selected="selected" value="none">Не указано</option>
    <option value="sedan">Седан</option>
    <option value="xetchbek">Хэтчбек</option>
    <option value="universal">Универсал</option>
  </select>
</div><br>
<span class="label_top">Год выпуска:</span>
<div class="better-placeholder">
  <input type="text" name="year" class="better-placeholder__input" placeholder="Введите год выпуска автомобиля">
  <label for="year" class="better-placeholder__label">Введите год выпуска автомобиля</label>
</div><br>
<span class="label_top">Дополнительная информация</span>
<div class="better-placeholder">
<textarea name="text" class="better-placeholder__input" pattern="^[A-Za-zА-Яа-яЁё0-9\s]+$" placeholder="Введите какую-либо дополнительную информацию"></textarea>
  <label for="text" class="better-placeholder__label">Введите какую-либо дополнительную информацию</label>
</div><br>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/captcha_frame.php"); ?>
<div align="center">
<input class="input__button" type="submit" value="Отправить заказ">
</div>
</form></div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html"); 
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>