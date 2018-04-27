'use strict';
(function () {
  window.onload = function () {
    var imgAll = document.querySelectorAll('.img');
    var imgBig = document.querySelector('.img__big');
    var imgPopup = document.querySelector('.img__popup');
    var imgClose = document.querySelector('.img__close');
    imgAll.forEach(function (img) {
      img.addEventListener('click', function () {
        var imgSrc = img.src;
        imgBig.src = imgSrc;
        imgPopup.style.display = 'flex';
        document.body.classList.add('img__modal-open');
      });
    });
    var closePopup = function () {
      imgPopup.style.display = '';
      document.body.classList.remove('img__modal-open');
    };
    imgClose.addEventListener('click', closePopup);
    imgPopup.addEventListener('click', closePopup);
  };
})();
