'use strict';
(function () {
  var galleyTag = document.querySelectorAll('.gallery__tag');
  galleyTag.forEach(function (tag) {
    if (tag.textContent === '') {
      tag.style.display = 'none';
    }
  });
})();
