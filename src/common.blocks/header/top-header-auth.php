<div class="top-header-auth">
  <div class="top-header-auth__inner">
    <a href="/" title="Перейти на главную страницу" class="top-header-auth__link"><img
      src="/src/common.blocks/header/img/logo_circle.jpg" class="top-header-auth__logo"></a>
    <div class="top-header-auth__shop">
      <a class="top-header-auth__shop-address" href="/contacts#dzerzhinskogo" title="Посмотреть на карте">г.Пермь, ул.
        Дзержинского 15</a>
      <a onclick="yaCounter40650914.reachGoal('call_phone'); return true" class="top-header-auth__shop-phone"
         href="tel:+73422889929">+7 342 288 99 29</a>
    </div>
    <div class="top-header-auth__shop">
      <a class="top-header-auth__shop-address" href="/contacts#speshilova" title="Посмотреть на карте">г.Пермь, ул.
        Спешилова
        102/29</a>
      <a onclick="yaCounter40650914.reachGoal('call_phone'); return true" class="top-header-auth__shop-phone"
         href="tel:+73422889969">+7 342 288 99 69</a>
    </div>
    <div class="top-header-auth__shop top-header-auth__shop-last top-header-auth__shop-last-child">
      <a class="top-header-auth__shop-address" href="/contacts#speshilova" title="Посмотреть на карте">г.Пермь, ул.
        Тургенева 23</a>
      <a onclick="yaCounter40650914.reachGoal('call_phone'); return true" class="top-header-auth__shop-phone"
         href="tel:+73422889939">+7 342 288 99 39 </a>
    </div>
    <?php
    if (!empty($_COOKIE['userString'])) {
      echo '<a href="/profile?id=' . $_COOKIE['userId'] . '" class="auth__link">Профиль</a>';
      echo '<a href="/?logout=1" class="auth__link">Выйти</a>';
    } else {
      echo '<a href="/registration" title="Зарегистрироваться или войти" class="top-header-auth__icon" target="_blank"><i
      class="fa fa-user-o fa-2x top-header-auth__icon" aria-hidden="true"></i></a>';
    } ?>
  </div>
</div>
