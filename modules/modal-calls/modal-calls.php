<div class="modal-call__overlay"></div>
<div class="modal-call">
    <div class="modal-call__close">X</div>
    <div class="modal-call__header">
        <h2 class="page__title-h2">Введите имя и телефон и мы Вам перезвоним в течении 10 минут!</h2>
    </div>
    <div class="modal-call__body">
        <form action="/call" method="post" class="form" onsubmit="yaCounter40650914.reachGoal('post_call'); return true">
            <span class="form__label">Ваше имя:</span>
            <div class="form__input-block">
                <input type="text" name="name" required autofocus class="form__input form__input--call" placeholder="Введите Ваше имя">
                <label for="name" class="form__label--shown">Введите Ваше имя</label>
            </div>
            <span class="form__label">Ваш телефон:</span>
            <div class="form__input-block">
                <input type="text" name="phone" required class="form__input form__input--call" placeholder="Введите номер телефона">
                <label for="phone" class="form__label--shown">Введите номер телефона</label>
            </div>
            <button class="button button__call">Перезвоните мне!</button>
        </form>
    </div>
</div>