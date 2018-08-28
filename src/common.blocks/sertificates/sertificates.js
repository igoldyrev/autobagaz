'use strict';
(function () {
  var sertificateLink = document.querySelectorAll('.sertificates__link--js');
  var imgBig = document.querySelector('.img__big');
  var imgPopup = document.querySelector('.img__popup');
  var imgClose = document.querySelector('.img__close');
  var imgButtomRight = imgPopup.querySelector('.img__button--right');
  var imgButtomLeft = imgPopup.querySelector('.img__button--left');

  var closePopup = function () {
    imgPopup.style.display = '';
    document.body.classList.remove('img__modal-open');
  };

  var getArrayImageSrc = [].map.call(sertificateLink, function (it) {
    return it.href;
  });

  for (var j = 0; j < getArrayImageSrc.length; j++) {
    while (getArrayImageSrc[j] === window.location.href) {
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

  var openLink = function (link) {
    var linkHref = link.href;
    imgBig.src = linkHref;
    imgPopup.style.display = 'flex';
    document.body.classList.add('img__modal-open');
  };

  sertificateLink.forEach(function (sertificate) {
    if (sertificate.href === window.location.href) {
      sertificate.remove();
    }
    sertificate.addEventListener('click', function (evt) {
      evt.preventDefault();
      openLink(sertificate);
      imgButtomRight.addEventListener('click', buttonRightClick);
      imgButtomLeft.addEventListener('click', buttonLeftClick);
      imgBig.addEventListener('click', buttonRightClick);
    });
  });
  imgClose.addEventListener('click', closePopup);
})();
