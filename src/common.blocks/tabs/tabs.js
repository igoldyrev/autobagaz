'use strict';
(function () {
  var tabs = document.querySelector('.tabs');
  var tabsItem = document.querySelectorAll('.tabs__item');

  var clearClasses = function (tabItem, tabOpen, tabClass) {
    tabItem.forEach(function (item) {
      item.classList.remove('tabs__item--active');
    });

    tabOpen.forEach(function (tab) {
      tab.classList.remove(tabClass);
    });
  };

  var tabClicked = function (tabItem, tabOpened, tabClass) {
    tabItem.classList.add('tabs__item--active');
    tabOpened.classList.add(tabClass);
  };

  if (tabs) {
    var specialTabSale = document.querySelector('.special__tab-sale');
    var specialTabKomm = document.querySelector('.special__tab-komm');

    var guestbookTabRewiew = document.querySelector('.guestbook__tab-rewiew');
    var guestbookTabForm = document.querySelector('.guestbook__tab-add');

    if (specialTabSale && specialTabKomm) {
      var specialClassActive = 'special__tab--active';
      var specialTab = document.querySelectorAll('.special__tab');

      var specialTabSaleClick = function () {
        var tabSale = document.querySelector('.special__sale');
        clearClasses(tabsItem, specialTab, specialClassActive);
        tabClicked(specialTabSale, tabSale, specialClassActive);
      };

      var specialTabKommClick = function () {
        var tabKomm = document.querySelector('.special__komm');
        clearClasses(tabsItem, specialTab, specialClassActive);
        tabClicked(specialTabKomm, tabKomm, specialClassActive);
      };

      specialTabSale.addEventListener('click', specialTabSaleClick);
      specialTabKomm.addEventListener('click', specialTabKommClick);

    } else if (guestbookTabRewiew && guestbookTabForm) {
      var guestbookClassActive = 'guestbook__tab--active';
      var guestbookTab = document.querySelectorAll('.guestbook__tab');

      var guestbookTabRewiewClick = function () {
        var tabRewiews = document.querySelector('.guestbook__rewiews');
        clearClasses(tabsItem, guestbookTab, guestbookClassActive);
        tabClicked(guestbookTabRewiew, tabRewiews, guestbookClassActive);
      };

      var guestbookTabFormClick = function () {
        var tabForm = document.querySelector('.guestbook__rewiews-add');
        clearClasses(tabsItem, guestbookTab, guestbookClassActive);
        tabClicked(guestbookTabForm, tabForm, guestbookClassActive);
      };

      guestbookTabRewiew.addEventListener('click', guestbookTabRewiewClick);
      guestbookTabForm.addEventListener('click', guestbookTabFormClick);
    }
  }
})();
