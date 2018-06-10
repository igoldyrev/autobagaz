'use strict';
(function () {
  var topHeader = document.querySelector('.top-header');
  var topHeaderInner = document.querySelector('.top-header__inner');
  var topHeaderAddress = document.querySelector('.top-header__address');
  var topHeaderShopAddress = document.querySelectorAll('.top-header__shop-address');
  var topHeaderShopLast = document.querySelector('.top-header__shop-last');
  window.onscroll = function () {
    var scrolled = window.pageYOffset || document.documentElement.scrollTop;
    if (scrolled > 50) {
      topHeader.classList.add('top-header__height-30');
      topHeaderAddress.classList.add('top-header__hidden');
      topHeaderInner.classList.add('top-header__center');
      topHeaderShopAddress.forEach(function (adr) {
        adr.classList.add('top-header__hidden');
      });
      topHeaderShopLast.classList.remove('top-header__shop-last-child');
    } else {
      topHeader.classList.remove('top-header__height-30');
      topHeaderAddress.classList.remove('top-header__hidden');
      topHeaderInner.classList.remove('top-header__center');
      topHeaderShopAddress.forEach(function (adr) {
        adr.classList.remove('top-header__hidden');
      });
      topHeaderShopLast.classList.add('top-header__shop-last-child');
    }
  };
})();
