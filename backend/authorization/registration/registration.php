<?php
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
echo "<title>Зарегистрироваться</title>"; ?>

<div class="auth__wrapper">
  <div class="auth__content">
    <h2 class="title title-h2 auth__title">Регистрация</h2>
    <div class="auth__form-wrap">
      <form action="" class="form auth__form">
        <span class="form__label">Придумайте имя пользователя:</span>
        <div class="form__input-wrap">
          <input type="text" name="login" required autofocus class="form__input auth__input"
                 placeholder="На латинице, не более 30 символов">
          <label for="login" class="form__label--shown">На латинице, не более 30 символов</label>
        </div>
        <span class="form__label">Электронная почта:</span>
        <div class="form__input-wrap">
          <input type="email" name="email" required class="form__input auth__input" placeholder="name@domain.ru">
          <label for="login" class="form__label--shown">name@domain.ru</label>
        </div>
        <span class="form__label">Придумайте пароль:</span>
        <div class="form__input-wrap">
          <input type="password" name="password" required class="form__input auth__input"
                 placeholder="Латинские буквы и цифры, не более 30 символов">
          <label for="login" class="form__label--shown">Латинские буквы и цифры, не более 30 символов</label>
        </div>
        <span class="form__label">Повторите пароль:</span>
        <div class="form__input-wrap">
          <input type="password" name="password-retype" required class="form__input auth__input"
                 placeholder="Повторите пароль еще раз">
          <label for="login" class="form__label--shown">Повторите пароль еще раз</label>
        </div>
        <button class="button button__zakaz auth__input">Зарегистрироваться</button>
        <p class="text auth__license">Нажимая кнопку «Зарегистрироваться» вы соглашаетесь с <a
            class="link auth__license" href="#">Пользовательским соглашением</a> и даете
          <a class="link auth__license" href="#">Согласие на обработку персональных данных</a>.</p>
      </form>
    </div>
  </div>
</div>
