<div class="form__container">
    <form action="/rewiew" method="post" class="form">
        <span class="form__label">Ваше имя:</span>
        <div class="form__input-block">
            <input type="text" name="name" required class="form__input" placeholder="Введите Ваше имя">
            <label for="name" class="form__label--shown">Введите Ваше имя</label>
        </div>
        <span class="form__label">Ваш телефон:</span>
        <div class="form__input-block">
            <input type="text" name="phone" class="form__input" placeholder="Введите номер телефона. Номер телефона НЕ публикуется">
            <label for="phone" class="form__label--shown">Введите номер телефона. Номер телефона НЕ публикуется</label>
        </div>
        <span class="form__label">Ваш отзыв:</span>
        <div class="form__input-block">
            <textarea name="rewiew" class="form__input form__textarea" placeholder="Введите Ваш отзыв о нас"></textarea>
            <label for="rewiew" class="form__label--shown">Введите Ваш отзыв о нас</label>
        </div>
        <div class="g-recaptcha" data-sitekey="6LenJjcUAAAAALv0jIybM3O45CnsEYa4X58EZ1uH"></div>
        <button class="button button__rewiew">Оставить отзыв</button>
    </form>
</div>