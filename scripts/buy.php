<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");

$id = $_GET['id'];

if (!isset($id)) { 
	echo "<title>"; echo "Выберите товар для заказа"; echo "</title>"; ?>
	<div class="good_message">
	<?php echo "<p>Вы  не выбрали ничего для заказа. Вернитесь в каталог и выберите из него что-нибудь. А затем заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '1') {
	$tovar = $_SESSION['autobagazhniki'][0][name];
	echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][0][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '2') {
	$tovar = $_SESSION['autobagazhniki'][1][name];
	echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][1][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '3') {
	$tovar = $_SESSION['autobagazhniki'][2][name];
	echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][2][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
} elseif ($id == '4') {
	$tovar = $_SESSION['autobagazhniki'][3][name];
	echo "<title>Заказ товара "; echo $_SESSION['autobagazhniki'][3][name]; echo "</title>";?>
	<div class="good_message">
	<?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
	</div> <?php
}

$_SESSION['tovar'] = $tovar; ?>

<form action="/scripts/zakaz.php" method="post">
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
<div align="center">
<input class="input__button" type="submit" value="Отправить заказ">
</div>
</form>