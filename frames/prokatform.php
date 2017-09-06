<form action="/vprokat" method="post">
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
  <p><input type="checkbox" name="bagazhnik" value="Багажник на крышу" <?php echo $checkedbagazh ?>>Багажник на крышу</p>
  <p><input type="checkbox" name="autobox" value="Автобокс" <?php echo $checkedbox ?>>Автобокс на крышу</p>
  <p><input type="checkbox" name="velokreplenie_krysha" value="Велокрепление на крышу" <?php echo $checkedvelokrysha ?>>Велокрепление на крышу</p>
  <p><input type="checkbox" name="velokreplenie_farkop" value="Велокрепление на фаркоп" <?php echo $checkedvelofarkop ?>>Велокрепление на фаркоп</p>
  <p><input type="checkbox" name="lyzhnoe_kreplenie" value="Лыжное крепление" <?php echo $checkedlyzhi ?>>Лыжное крепление</p>
  <p><input type="checkbox" name="braslets" value="Браслеты противоскольжения" <?php echo $checkedbraslets ?>>Браслеты противоскольжения</p>
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
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/captcha_frame.php"); ?>
<div align="center">
<input class="input__button" type="submit" value="Взять в прокат">
</div>
</form>
<p>Правила пользования услугами аренды и стоимость дня проката приведены ниже.</p>