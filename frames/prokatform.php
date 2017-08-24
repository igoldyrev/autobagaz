<form action="/scripts/prokatsend.php" method="post">
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
<span class="label_top">Тип оборудования:</span>
<div class="better-placeholder">
  <select class="better-placeholder__select" size="1" name="equipment">
    <option selected="selected" value="none">Не указано</option>
    <option value="Багажные дуги/крепление для велосипеда на крышу">Багажные дуги/крепление для велосипеда на крышу</option>
    <option value="Автобокс/велокрепление на фаркоп">Автобокс/велокрепление на фаркоп</option>
  </select>
</div><br>
<span class="label_top">Срок проката:</span>
<div class="better-placeholder">
  <select class="better-placeholder__select" size="1" name="time">
    <option selected="selected" value="none">Не указано</option>
    <option value="0-14">От 0 до 14 дней</option>
    <option value="15-21">От 15 до 21 дня</option>
    <option value="21-">От 21 дня</option>
  </select>
</div><br>
<span class="label_top">Дополнительная информация</span>
<div class="better-placeholder">
<textarea name="text" class="better-placeholder__input" pattern="^[A-Za-zА-Яа-яЁё0-9\s]+$" placeholder="Введите какую-либо дополнительную информацию"></textarea>
  <label for="text" class="better-placeholder__label">Введите какую-либо дополнительную информацию</label>
</div><br>
<div align="center">
<input class="input__button" type="submit" value="Взять в прокат">
</div>
</form>
<p>Правила пользования услугами аренды и стоимость дня проката приведены ниже.</p>