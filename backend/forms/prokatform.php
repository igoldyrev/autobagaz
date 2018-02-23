<div class="form__container">
    <form action="/vprokat" method="post" class="form" onsubmit="yaCounter40650914.reachGoal('post_prokat'); return true">
        <span class="form__label">Ваше имя:</span>
        <div class="form__input-wrap">
            <input type="text" name="name" required autofocus class="form__input" placeholder="Введите Ваше имя">
            <label for="name" class="form__label--shown">Введите Ваше имя</label>
        </div>
        <span class="form__label">Ваш телефон:</span>
        <div class="form__input-wrap">
            <input type="text" name="phone" required class="form__input" placeholder="Введите номер телефона">
            <label for="phone" class="form__label--shown">Введите номер телефона</label>
        </div>
        <span class="form__label">Тип оборудования. Вы можете выбрать несколько видов:</span>
        <div class="form__input-wrap clearfix">
            <input type="checkbox" name="bagazhnik" class="form__checkbox" id="bagazhnik" <?php echo $checkedbagazh ?>>
            <label for="bagazhnik" class="form__label--checkbox">Багажник на крышу</label>
            <input type="checkbox" name="autobox" class="form__checkbox" id="autobox" <?php echo $checkedbox ?>>
            <label for="autobox" class="form__label--checkbox">Автобокс на крышу</label>
            <input type="checkbox" name="velokreplenie_krysha" class="form__checkbox" id="velokreplenie_krysha" <?php echo $checkedvelokrysha ?>>
            <label for="velokreplenie_krysha" class="form__label--checkbox">Велокрепление на крышу</label>
            <input type="checkbox" name="velokreplenie_farkop" class="form__checkbox" id="velokreplenie_farkop" <?php echo $checkedvelofarkop ?>>
            <label for="velokreplenie_farkop" class="form__label--checkbox">Велокрепление на фаркоп</label>
            <input type="checkbox" name="lyzhnoe_kreplenie" class="form__checkbox" id="lyzhnoe_kreplenie" <?php echo $checkedlyzhi ?>>
            <label for="lyzhnoe_kreplenie" class="form__label--checkbox">Лыжное крепление</label>
            <input type="checkbox" name="braslets" class="form__checkbox" id="braslets" <?php echo $checkedbraslets ?>>
            <label for="braslets" class="form__label--checkbox">Браслеты противоскольжения</label>
        </div>
        <span class="form__label">Срок проката:</span>
        <div class="form__input-wrap">
            <select name="time" size="1" class="form__select">
                <option value="Не выбрано" selected>Не указано</option>
                <option value="0-14 дней">От 0 до 14 дней</option>
                <option value="15-21 дней">От 15 до 21 дня</option>
                <option value="21+ дней">От 21 дня</option>
            </select>
        </div>
        <span class="form__label">Дополнительная информация:</span>
        <div class="form__input-wrap">
            <textarea name="text" class="form__input form__textarea" placeholder="Введите какую-либо дополнительную информацию"></textarea>
            <label for="text" class="form__label--shown">Введите какую-либо дополнительную информацию</label>
        </div>
        <div class="g-recaptcha" data-sitekey="6LenJjcUAAAAALv0jIybM3O45CnsEYa4X58EZ1uH"></div>
        <button class="button button__zakaz button__zakaz--prokat">Взять в прокат</button>
    </form>
</div>
<p class="page__text">Правила пользования услугами аренды и стоимость дня проката приведены ниже.</p>