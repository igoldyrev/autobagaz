'use strict';
(function () {
  var imgAll = document.querySelectorAll('.img');
  var imgBig = document.querySelector('.img__big');
  var imgPopup = document.querySelector('.img__popup');
  var imgClose = document.querySelector('.img__close');
  var imgButtomRight = imgPopup.querySelector('.img__button--right');
  var imgButtomLeft = imgPopup.querySelector('.img__button--left');

  var closePopup = function () {
    imgPopup.style.display = '';
    document.body.classList.remove('img__modal-open');
  };

  var getArrayImageSrc = [].map.call(imgAll, function (it) {
    return it.src;
  });

  for (var i = 0; i < getArrayImageSrc.length; i++) {
    while (getArrayImageSrc[i] === window.location.href) {
      getArrayImageSrc.pop();
    }
  }

  var findIndex = function (array, value) {
    return array.indexOf(value);
  };


  var buttonRightClick = function () {
    var i = findIndex(getArrayImageSrc, imgBig.src);
    if (i === 0) {
      i = i + 1;
    } else {
      i = findIndex(getArrayImageSrc, imgBig.src) + 1;
    }
    if (i >= getArrayImageSrc.length) {
      i = 0;
    }
    imgBig.src = getArrayImageSrc[i];
  };

  var buttonLeftClick = function () {
    var i = findIndex(getArrayImageSrc, imgBig.src);
    if (i === 0) {
      i = i - 1;
    } else {
      i = findIndex(getArrayImageSrc, imgBig.src) - 1;
    }
    if (i < 0) {
      i = getArrayImageSrc.length - 1;
    }
    imgBig.src = getArrayImageSrc[i];
  };

  var openPhoto = function (image) {
    var imageSrc = image.src;
    imgBig.src = imageSrc;
    imgPopup.style.display = 'flex';
    document.body.classList.add('img__modal-open');
  };

  imgAll.forEach(function (img) {
    if (img.src === window.location.href) {
      img.remove();
    }
    img.addEventListener('click', function () {
      openPhoto(img);
      imgButtomRight.addEventListener('click', buttonRightClick);
      imgButtomLeft.addEventListener('click', buttonLeftClick);
    });
  });
  imgClose.addEventListener('click', closePopup);
})();
