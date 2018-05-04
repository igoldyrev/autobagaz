/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
__webpack_require__(2);
__webpack_require__(3);
__webpack_require__(4);
__webpack_require__(5);
__webpack_require__(6);
module.exports = __webpack_require__(7);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


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

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function () {
  var tabs = document.querySelector('.tabs');
  var tabsItem = document.querySelectorAll('.tabs__item');

  var clearClasses = function clearClasses(tabItem, tabOpen, tabClass) {
    tabItem.forEach(function (item) {
      item.classList.remove('tabs__item--active');
    });

    tabOpen.forEach(function (tab) {
      tab.classList.remove(tabClass);
    });
  };

  var tabClicked = function tabClicked(tabItem, tabOpened, tabClass) {
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

      var specialTabSaleClick = function specialTabSaleClick() {
        var tabSale = document.querySelector('.special__sale');
        clearClasses(tabsItem, specialTab, specialClassActive);
        tabClicked(specialTabSale, tabSale, specialClassActive);
      };

      var specialTabKommClick = function specialTabKommClick() {
        var tabKomm = document.querySelector('.special__komm');
        clearClasses(tabsItem, specialTab, specialClassActive);
        tabClicked(specialTabKomm, tabKomm, specialClassActive);
      };

      specialTabSale.addEventListener('click', specialTabSaleClick);
      specialTabKomm.addEventListener('click', specialTabKommClick);
    } else if (guestbookTabRewiew && guestbookTabForm) {
      var guestbookClassActive = 'guestbook__tab--active';
      var guestbookTab = document.querySelectorAll('.guestbook__tab');

      var guestbookTabRewiewClick = function guestbookTabRewiewClick() {
        var tabRewiews = document.querySelector('.guestbook__rewiews');
        clearClasses(tabsItem, guestbookTab, guestbookClassActive);
        tabClicked(guestbookTabRewiew, tabRewiews, guestbookClassActive);
      };

      var guestbookTabFormClick = function guestbookTabFormClick() {
        var tabForm = document.querySelector('.guestbook__rewiews-add');
        clearClasses(tabsItem, guestbookTab, guestbookClassActive);
        tabClicked(guestbookTabForm, tabForm, guestbookClassActive);
      };

      guestbookTabRewiew.addEventListener('click', guestbookTabRewiewClick);
      guestbookTabForm.addEventListener('click', guestbookTabFormClick);
    }
  }
})();

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


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

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function () {
  var modalCall = document.querySelector('.modal-call');
  var modalCallOverlay = document.querySelector('.modal-call__overlay');
  var modalCallClose = document.querySelector('.modal-call__close');
  var modalCallButton = document.querySelector('.modal-call__button');
  var modalCallInput = document.querySelectorAll('.form__input--call');
  var modalCallHeader = document.querySelector('.modal-call__header');
  var modalCallForm = document.querySelector('.js-modal-call-form');
  var modalCallInputName = document.querySelector('.js-modal-form-input-name');
  var modalCallInputPhone = document.querySelector('.js-modal-form-input-phone');
  var url = '/call';

  var onModalCallClose = function onModalCallClose() {
    modalCall.classList.remove('modal-call--active');
    modalCallOverlay.classList.remove('modal-call__overlay--active');

    modalCall.style.top = 45 + '%';
    modalCall.style.left = 45 + '%';
  };

  var onModalCallEscPress = function onModalCallEscPress(evt) {
    window.onEscPress(evt, onModalCallClose);
  };

  var onModalCallInputFocus = function onModalCallInputFocus() {
    document.removeEventListener('keydown', onModalCallEscPress);
  };

  var onModalCallInputFocusLost = function onModalCallInputFocusLost() {
    document.addEventListener('keydown', onModalCallEscPress);
  };

  var onModalCallButtonClick = function onModalCallButtonClick() {
    modalCall.classList.add('modal-call--active');
    modalCallOverlay.classList.add('modal-call__overlay--active');

    modalCallClose.addEventListener('click', onModalCallClose);
    document.addEventListener('keydown', onModalCallEscPress);
  };

  var modalCallHeaderDown = function modalCallHeaderDown(evt) {
    evt.preventDefault();

    var startCoords = {
      x: evt.clientX,
      y: evt.clientY
    };

    var onMouseMove = function onMouseMove(moveEvt) {
      moveEvt.preventDefault();

      var shift = {
        x: startCoords.x - moveEvt.clientX,
        y: startCoords.y - moveEvt.clientY
      };

      startCoords = {
        x: moveEvt.clientX,
        y: moveEvt.clientY
      };

      modalCall.style.top = modalCall.offsetTop - shift.y + 'px';
      modalCall.style.left = modalCall.offsetLeft - shift.x + 'px';
    };

    var onMouseUp = function onMouseUp(upEvt) {
      upEvt.preventDefault();

      document.removeEventListener('mousemove', onMouseMove);
      document.removeEventListener('mouseup', onMouseUp);
    };

    document.addEventListener('mousemove', onMouseMove);
    document.addEventListener('mouseup', onMouseUp);
  };

  modalCallHeader.addEventListener('mousedown', modalCallHeaderDown);
  modalCallButton.addEventListener('click', onModalCallButtonClick);

  modalCallInput.forEach(function (input) {
    input.addEventListener('focus', onModalCallInputFocus);
    input.addEventListener('blur', onModalCallInputFocusLost);
  });

  modalCallInputName.addEventListener('invalid', function () {
    if (modalCallInputName.validity.valueMissing) {
      modalCallInputName.setCustomValidity('Это обязательное поле');
    } else {
      modalCallInputName.setCustomValidity('');
    }
  });

  modalCallInputPhone.addEventListener('invalid', function () {
    if (modalCallInputPhone.validity.tooLong) {
      modalCallInputPhone.setCustomValidity('Номер телефона не может быть больше 11 цифр');
    } else if (modalCallInputPhone.validity.valueMissing) {
      modalCallInputPhone.setCustomValidity('Это обязательное поле');
    } else {
      modalCallInputPhone.setCustomValidity('');
    }
  });

  modalCallInputName.addEventListener('input', function (evt) {
    var target = evt.target;
    if (target.value.length === 0) {
      target.setCustomValidity('Это обязательное поле');
    } else {
      modalCallInputName.setCustomValidity('');
    }
  });

  modalCallInputPhone.addEventListener('input', function (evt) {
    var target = evt.target;
    if (target.value.length > 11) {
      target.setCustomValidity('Номер телефона не может быть больше 11 цифр');
    } else if (target.value.length === 0) {
      target.setCustomValidity('Это обязательное поле');
    } else {
      modalCallInputPhone.setCustomValidity('');
    }
  });

  var modalCallSend = function modalCallSend(data, onSuccess, onError) {
    var xhr = new XMLHttpRequest();

    xhr.addEventListener('load', function () {
      if (xhr.status === 200) {
        onSuccess(xhr.response);
      } else {
        onError('При отправке формы произошла ошибка :(');
      }
    });

    xhr.open('POST', url);
    xhr.send(data);
  };

  modalCallForm.addEventListener('submit', function (evt) {
    modalCallSend(new FormData(modalCallForm), function () {
      modalCall.classList.remove('modal-call--active');
      modalCallOverlay.classList.remove('modal-call__overlay--active');
    });
    evt.preventDefault();
  });

  setTimeout(onModalCallButtonClick, 75000);
})();

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function () {
  var galleyTag = document.querySelectorAll('.gallery__tag');
  galleyTag.forEach(function (tag) {
    if (tag.textContent === '') {
      tag.style.display = 'none';
    }
  });
})();

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function () {
  window.onload = function () {
    var imgAll = document.querySelectorAll('.img');
    var imgBig = document.querySelector('.img__big');
    var imgPopup = document.querySelector('.img__popup');
    var imgClose = document.querySelector('.img__close');
    var imgButtomRight = imgPopup.querySelector('.img__button--right');
    var imgButtomLeft = imgPopup.querySelector('.img__button--left');

    var closePopup = function closePopup() {
      imgPopup.style.display = '';
      document.body.classList.remove('img__modal-open');
    };

    var getArrayImageSrc = [].map.call(imgAll, function (it) {
      return it.src;
    });

    var findIndex = function findIndex(array, value) {
      return array.indexOf(value);
    };

    var buttonRightClick = function buttonRightClick() {
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

    var buttonLeftClick = function buttonLeftClick() {
      var i = findIndex(getArrayImageSrc, imgBig.src);
      if (i === 0) {
        i = i + 1;
      } else {
        i = findIndex(getArrayImageSrc, imgBig.src) - 1;
      }
      if (i < 0) {
        i = getArrayImageSrc.length - 1;
      }
      imgBig.src = getArrayImageSrc[i];
    };

    var openPhoto = function openPhoto(image) {
      var imageSrc = image.src;
      imgBig.src = imageSrc;
      imgPopup.style.display = 'flex';
      document.body.classList.add('img__modal-open');
    };

    imgAll.forEach(function (img) {
      img.addEventListener('click', function () {
        openPhoto(img);
        imgButtomRight.addEventListener('click', buttonRightClick);
        imgButtomLeft.addEventListener('click', buttonLeftClick);
      });
    });
    imgClose.addEventListener('click', closePopup);
  };
})();

/***/ }),
/* 7 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);