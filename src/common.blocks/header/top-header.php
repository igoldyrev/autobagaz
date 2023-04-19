<div class="top-header">
  <div class="top-header__inner">
    <span class="top-header__address">Наши адреса:</span>
    <div class="top-header__shop top-header__shop-last top-header__shop-last-child">
      <a class="top-header__shop-address" href="/contacts#dzerzhinskogo" title="Посмотреть на карте">г.Пермь, ул.
        Дзержинского
        15</a>
      <a onclick="yaCounter40650914.reachGoal('call_phone'); return true" class="top-header__shop-phone"
         href="tel:+7 342 288 99 29">+7 342 288 99 29</a>
    </div>
<!--    <div class="top-header__shop top-header__shop-last top-header__shop-last-child">-->
<!--      <a class="top-header__shop-address" href="/contacts#vasileva" title="Посмотреть на карте">г.Пермь, ул. Васильева 1/3</a>-->
<!--      <a onclick="yaCounter40650914.reachGoal('call_phone'); return true" class="top-header__shop-phone"-->
<!--         href="tel:+7 342 288 99 69">+7 342 288 99 69</a>-->
<!--    </div>-->
    <!-- <div class="top-header__shop top-header__shop-last top-header__shop-last-child">
      <a class="top-header__shop-address" href="/contacts#lebedeva" title="Посмотреть на карте">г.Пермь, ул.
        Лебедева, 34</a>
      <a onclick="yaCounter40650914.reachGoal('call_phone'); return true" class="top-header__shop-phone"
         href="tel:+73422889939">+7 342 288 99 39 </a>
    </div> -->
    <?php
    if (!empty($_COOKIE['userString'])) {
      //echo '<a href="/profile?id=' . $_COOKIE['userId'] . '" class="auth__link">Профиль</a>';
      echo '<a href="/admin/" class="auth__link">Админка</a>';
      echo '<a href="/?logout=1" class="auth__link">Выйти</a>';
    } ?>
  </div>
</div>
