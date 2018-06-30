<?php
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
echo "<title>Войти в админ-панель</title>"; ?>

<div class="admin__container admin__container--center">
  <h1 class="title title-h1">Войти в админ-панель</h1>
  <form action="#" method="post" class="form">
    <span class="form__label">Введите логин:</span>
    <div class="form__input-wrap">
      <input type="text" name="login" required autofocus class="form__input" placeholder="Введите логин">
      <label for="login" class="form__label--shown">Введите логин</label>
    </div>
    <span class="form__label">Введите пароль:</span>
    <div class="form__input-wrap">
      <input type="text" name="password" required class="form__input" placeholder="Введите пароль">
      <label for="password" class="form__label--shown">Введите пароль</label>
    </div>
    <button class="button button__zakaz">Войти</button>
  </form>
</div>
