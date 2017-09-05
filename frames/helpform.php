<?php 
echo "<h3>Не можете определиться с выбором? Заполните форму ниже, мы Вам поможем с этим!</h3>"; ?>
	
	<form action="/help" method="post">
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
<span class="label_top">Ваше сообщение</span>
<div class="better-placeholder">
<textarea name="message" class="better-placeholder__input" pattern="^[A-Za-zА-Яа-яЁё0-9\s]+$" placeholder="Введите Ваше сообщение"></textarea>
  <label for="message" class="better-placeholder__label">Введите Ваше сообщение</label>
</div><br>
<div align="center">
<input class="input__button" type="submit" value="Помогите с выбором!">
</div></form>