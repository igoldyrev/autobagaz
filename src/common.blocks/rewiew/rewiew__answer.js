'use strict';
(function () {
  var rewiewTextWrap = document.querySelectorAll('.rewiew__text-wrap');
  var textRewiewAnswer = document.querySelectorAll('.rewiew__answer');

  textRewiewAnswer.forEach(function (rewiew) {
    if (rewiew.textContent === '') {
      rewiew.style.display = 'none';
    }
  });
  rewiewTextWrap.forEach(function (wrap) {
    if (wrap.textContent === '') {
      wrap.style.display = 'none';
    }
  });
})();
