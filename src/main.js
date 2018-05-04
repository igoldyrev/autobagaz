'use strict';
(function () {
  var ESC_KEYCODE = 27;

  if (window.localStorage) {
    var elements = document.querySelectorAll('[name]');

    for (var i = 0, length = elements.length; i < length; i++) {
      (function (element) {
        var name = element.getAttribute('name');
        element.value = localStorage.getItem(name) || '';
        element.onkeyup = function () {
          localStorage.setItem(name, element.value);
        };
      })(elements[i]);
    }
  }

  window.onEscPress = function (evt, action) {
    if (evt.keyCode === ESC_KEYCODE) {
      action();
    }
  };
})();

