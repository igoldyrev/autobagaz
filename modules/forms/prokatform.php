<div class="form__container">
    <form action="/vprokat" method="post" class="form">
        <span class="form__label">Ваше имя:</span>
        <div class="form__input-block">
            <input type="text" name="name" required class="form__input" placeholder="Введите Ваше имя">
            <label for="name" class="form__label--shown">Введите Ваше имя</label>
        </div>
        <span class="form__label">Ваш телефон:</span>
        <div class="form__input-block">
            <input type="text" name="phone" required class="form__input" placeholder="Введите номер телефона">
            <label for="phone" class="form__label--shown">Введите номер телефона</label>
        </div>
        <span class="form__label">Тип оборудования. Вы можете выбрать несколько видов:</span>
        <div class="form__input-block">
            <p class="form__label--checkbox"><input type="checkbox" name="bagazhnik" value="Багажник на крышу" class="form__checkbox" <?php echo $checkedbagazh ?>>Багажник на крышу</p>
            <p class="form__label--checkbox"><input type="checkbox" name="autobox" value="Автобокс" class="form__checkbox" <?php echo $checkedbox ?>>Автобокс на крышу</p>
            <p class="form__label--checkbox"><input type="checkbox" name="velokreplenie_krysha" value="Велокрепление на крышу" class="form__checkbox" <?php echo $checkedvelokrysha ?>>Велокрепление на крышу</p>
            <p class="form__label--checkbox"><input type="checkbox" name="velokreplenie_farkop" value="Велокрепление на фаркоп" class="form__checkbox" <?php echo $checkedvelofarkop ?>>Велокрепление на фаркоп</p>
            <p class="form__label--checkbox"><input type="checkbox" name="lyzhnoe_kreplenie" value="Лыжное крепление" class="form__checkbox" <?php echo $checkedlyzhi ?>>Лыжное крепление</p>
            <p class="form__label--checkbox"><input type="checkbox" name="braslets" value="Браслеты противоскольжения" class="form__checkbox" <?php echo $checkedbraslets ?>>Браслеты противоскольжения</p>
        </div>
        <span class="form__label">Срок проката:</span>
        <div class="form__input-block">
            <select name="time" size="1" class="form__select">
                <option value="Не выбрано" selected>Не указано</option>
                <option value="0-14 дней">От 0 до 14 дней</option>
                <option value="15-21 дней">От 15 до 21 дня</option>
                <option value="21+ дней">От 21 дня</option>
            </select>
        </div>
        <span class="form__label">Дополнительная информация:</span>
        <div class="form__input-block">
            <textarea name="text" class="form__input form__textarea" placeholder="Введите какую-либо дополнительную информацию"></textarea>
            <label for="text" class="form__label--shown">Введите какую-либо дополнительную информацию</label>
        </div>
        <button class="button__zakaz">Взять в прокат</button>
    </form>
</div>