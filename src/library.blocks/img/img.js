'use strict';
(function () {
  window.onload = function () {
    var imgAll = document.querySelectorAll('.img');
    var imgWrap = document.querySelectorAll('.img__wrap');
    var imgBig = document.querySelector('.img__big');
    var imgPopup = document.querySelector('.img__popup');
    var imgClose = document.querySelector('.img__close');
    var imgButtomRight = imgPopup.querySelector('.img__button--right');

    var closePopup = function () {
      imgPopup.style.display = '';
      document.body.classList.remove('img__modal-open');
    };

    var countChilds = function (image) {
      return parent = image.parentElement.children.length;
    };

    // var buttonRightClick = function () {
    //   imgButtomRight.addEventListener('click', function () {
    //
    //       for (var i = 0; i < wrap.children.length; i++) {
    //         console.log('hello ' + i);
    //       }
    //
    //   });
    // };

    // console.log(imgWrap.children);
    // console.log(imgWrap.nextElementSibling);


    imgAll.forEach(function (img) {
      img.addEventListener('click', function () {
        var imgSrc = img.src;
        imgBig.src = imgSrc;
        imgPopup.style.display = 'flex';
        document.body.classList.add('img__modal-open');
        countChilds(img);
        console.log(countChilds(img));
      });
    });
    imgClose.addEventListener('click', closePopup);
  };
})();
