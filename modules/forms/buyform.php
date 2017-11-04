<div class="form__container">
    <form action="/zakaz" method="post" class="form">
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
        <span class="form__label">Марка машины:</span>
        <div class="form__input-block">
            <input type="text" name="auto" class="form__input" placeholder="Введите марку автомобиля">
            <label for="auto" class="form__label--shown">Введите марку автомобиля</label>
        </div>
        <span class="form__label">Тип кузова:</span>
        <div class="form__input-block">
            <select name="kuzov" size="1" class="form__select">
                <option value="Не выбрано" selected>Не указано</option>
                <option value="Седан">Седан</option>
                <option value="Хэтчбэк">Хэтчбэк</option>
                <option value="Универсал">Универсал</option>
            </select>
        </div>
        <span class="form__label">Год выпуска:</span>
        <div class="form__input-block">
            <input type="text" name="year" class="form__input" placeholder="Введите год выпуска автомобиля">
            <label for="year" class="form__label--shown">Введите год выпуска автомобиля</label>
        </div>
        <span class="form__label">Дополнительная информация:</span>
        <div class="form__input-block">
            <textarea name="text" class="form__input form__textarea" placeholder="Введите какую-либо дополнительную информацию"></textarea>
            <label for="text" class="form__label--shown">Введите какую-либо дополнительную информацию</label>
        </div>
        <button class="button__zakaz">Отправить заказ</button>
    </form>
</div>