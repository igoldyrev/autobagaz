/******/
(function (modules) { // webpackBootstrap
  /******/ 	// The module cache
  /******/
  var installedModules = {};
  /******/
  /******/ 	// The require function
  /******/
  function __webpack_require__(moduleId) {
    /******/
    /******/ 		// Check if module is in cache
    /******/
    if (installedModules[moduleId]) {
      /******/
      return installedModules[moduleId].exports;
      /******/
    }
    /******/ 		// Create a new module (and put it into the cache)
    /******/
    var module = installedModules[moduleId] = {
      /******/      i: moduleId,
      /******/      l: false,
      /******/      exports: {}
      /******/
    };
    /******/
    /******/ 		// Execute the module function
    /******/
    modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
    /******/
    /******/ 		// Flag the module as loaded
    /******/
    module.l = true;
    /******/
    /******/ 		// Return the exports of the module
    /******/
    return module.exports;
    /******/
  }

  /******/
  /******/
  /******/ 	// expose the modules object (__webpack_modules__)
  /******/
  __webpack_require__.m = modules;
  /******/
  /******/ 	// expose the module cache
  /******/
  __webpack_require__.c = installedModules;
  /******/
  /******/ 	// define getter function for harmony exports
  /******/
  __webpack_require__.d = function (exports, name, getter) {
    /******/
    if (!__webpack_require__.o(exports, name)) {
      /******/
      Object.defineProperty(exports, name, {enumerable: true, get: getter});
      /******/
    }
    /******/
  };
  /******/
  /******/ 	// define __esModule on exports
  /******/
  __webpack_require__.r = function (exports) {
    /******/
    if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
      /******/
      Object.defineProperty(exports, Symbol.toStringTag, {value: 'Module'});
      /******/
    }
    /******/
    Object.defineProperty(exports, '__esModule', {value: true});
    /******/
  };
  /******/
  /******/ 	// create a fake namespace object
  /******/ 	// mode & 1: value is a module id, require it
  /******/ 	// mode & 2: merge all properties of value into the ns
  /******/ 	// mode & 4: return value when already ns object
  /******/ 	// mode & 8|1: behave like require
  /******/
  __webpack_require__.t = function (value, mode) {
    /******/
    if (mode & 1) value = __webpack_require__(value);
    /******/
    if (mode & 8) return value;
    /******/
    if ((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
    /******/
    var ns = Object.create(null);
    /******/
    __webpack_require__.r(ns);
    /******/
    Object.defineProperty(ns, 'default', {enumerable: true, value: value});
    /******/
    if (mode & 2 && typeof value != 'string') for (var key in value) __webpack_require__.d(ns, key, function (key) {
      return value[key];
    }.bind(null, key));
    /******/
    return ns;
    /******/
  };
  /******/
  /******/ 	// getDefaultExport function for compatibility with non-harmony modules
  /******/
  __webpack_require__.n = function (module) {
    /******/
    var getter = module && module.__esModule ?
      /******/      function getDefault() {
        return module['default'];
      } :
      /******/      function getModuleExports() {
        return module;
      };
    /******/
    __webpack_require__.d(getter, 'a', getter);
    /******/
    return getter;
    /******/
  };
  /******/
  /******/ 	// Object.prototype.hasOwnProperty.call
  /******/
  __webpack_require__.o = function (object, property) {
    return Object.prototype.hasOwnProperty.call(object, property);
  };
  /******/
  /******/ 	// __webpack_public_path__
  /******/
  __webpack_require__.p = "";
  /******/
  /******/
  /******/ 	// Load entry module and return exports
  /******/
  return __webpack_require__(__webpack_require__.s = 0);
  /******/
})
/************************************************************************/
/******/({

  /***/ "./src/common.blocks/gallery/gallery.js":
  /*!**********************************************!*\
    !*** ./src/common.blocks/gallery/gallery.js ***!
    \**********************************************/
  /*! no static exports found */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";
    eval("\n\n(function () {\n  var galleyTag = document.querySelectorAll('.gallery__tag');\n  galleyTag.forEach(function (tag) {\n    if (tag.textContent === '') {\n      tag.style.display = 'none';\n    }\n  });\n})();\n\n//# sourceURL=webpack:///./src/common.blocks/gallery/gallery.js?");

    /***/
  }),

  /***/ "./src/common.blocks/header/top-header.js":
  /*!************************************************!*\
    !*** ./src/common.blocks/header/top-header.js ***!
    \************************************************/
  /*! no static exports found */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";
    eval("\n\n(function () {\n  var topHeader = document.querySelector('.top-header');\n  var topHeaderInner = document.querySelector('.top-header__inner');\n  var topHeaderAddress = document.querySelector('.top-header__address');\n  var topHeaderShopAddress = document.querySelectorAll('.top-header__shop-address');\n  var topHeaderShopLast = document.querySelector('.top-header__shop-last');\n  var authLink = document.querySelectorAll('.auth__link');\n  window.onscroll = function () {\n    var scrolled = window.pageYOffset || document.documentElement.scrollTop;\n    if (scrolled > 50) {\n      topHeader.classList.add('top-header__height-30');\n      topHeaderAddress.classList.add('top-header__hidden');\n      topHeaderInner.classList.add('top-header__center');\n      topHeaderShopAddress.forEach(function (adr) {\n        adr.classList.add('top-header__hidden');\n      });\n      topHeaderShopLast.classList.remove('top-header__shop-last-child');\n      authLink.forEach(function (link) {\n        link.classList.add('top-header__hidden');\n      });\n    } else {\n      topHeader.classList.remove('top-header__height-30');\n      topHeaderAddress.classList.remove('top-header__hidden');\n      topHeaderInner.classList.remove('top-header__center');\n      topHeaderShopAddress.forEach(function (adr) {\n        adr.classList.remove('top-header__hidden');\n      });\n      topHeaderShopLast.classList.add('top-header__shop-last-child');\n      authLink.forEach(function (link) {\n        link.classList.remove('top-header__hidden');\n      });\n    }\n  };\n})();\n\n//# sourceURL=webpack:///./src/common.blocks/header/top-header.js?");

    /***/
  }),

  /***/ "./src/common.blocks/modal-call/modal-call.js":
  /*!****************************************************!*\
    !*** ./src/common.blocks/modal-call/modal-call.js ***!
    \****************************************************/
  /*! no static exports found */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";
    eval("\n\n(function () {\n  var modalCall = document.querySelector('.modal-call');\n  var modalCallOverlay = document.querySelector('.modal-call__overlay');\n  var modalCallClose = document.querySelector('.modal-call__close');\n  var modalCallButton = document.querySelector('.modal-call__button');\n  var modalCallInput = document.querySelectorAll('.form__input--call');\n  var modalCallHeader = document.querySelector('.modal-call__header');\n  var modalCallForm = document.querySelector('.js-modal-call-form');\n  var modalCallInputName = document.querySelector('.js-modal-form-input-name');\n  var modalCallInputPhone = document.querySelector('.js-modal-form-input-phone');\n  var url = '/call';\n\n  var onModalCallClose = function onModalCallClose() {\n    modalCall.classList.remove('modal-call--active');\n    modalCallOverlay.classList.remove('modal-call__overlay--active');\n\n    modalCall.style.top = 45 + '%';\n    modalCall.style.left = 45 + '%';\n  };\n\n  var onModalCallEscPress = function onModalCallEscPress(evt) {\n    window.onEscPress(evt, onModalCallClose);\n  };\n\n  var onModalCallInputFocus = function onModalCallInputFocus() {\n    document.removeEventListener('keydown', onModalCallEscPress);\n  };\n\n  var onModalCallInputFocusLost = function onModalCallInputFocusLost() {\n    document.addEventListener('keydown', onModalCallEscPress);\n  };\n\n  var onModalCallButtonClick = function onModalCallButtonClick() {\n    modalCall.classList.add('modal-call--active');\n    modalCallOverlay.classList.add('modal-call__overlay--active');\n\n    modalCallClose.addEventListener('click', onModalCallClose);\n    document.addEventListener('keydown', onModalCallEscPress);\n  };\n\n  var modalCallHeaderDown = function modalCallHeaderDown(evt) {\n    evt.preventDefault();\n\n    var startCoords = {\n      x: evt.clientX,\n      y: evt.clientY\n    };\n\n    var onMouseMove = function onMouseMove(moveEvt) {\n      moveEvt.preventDefault();\n\n      var shift = {\n        x: startCoords.x - moveEvt.clientX,\n        y: startCoords.y - moveEvt.clientY\n      };\n\n      startCoords = {\n        x: moveEvt.clientX,\n        y: moveEvt.clientY\n      };\n\n      modalCall.style.top = modalCall.offsetTop - shift.y + 'px';\n      modalCall.style.left = modalCall.offsetLeft - shift.x + 'px';\n    };\n\n    var onMouseUp = function onMouseUp(upEvt) {\n      upEvt.preventDefault();\n\n      document.removeEventListener('mousemove', onMouseMove);\n      document.removeEventListener('mouseup', onMouseUp);\n    };\n\n    document.addEventListener('mousemove', onMouseMove);\n    document.addEventListener('mouseup', onMouseUp);\n  };\n\n  modalCallHeader.addEventListener('mousedown', modalCallHeaderDown);\n  modalCallButton.addEventListener('click', onModalCallButtonClick);\n\n  modalCallInput.forEach(function (input) {\n    input.addEventListener('focus', onModalCallInputFocus);\n    input.addEventListener('blur', onModalCallInputFocusLost);\n  });\n\n  modalCallInputName.addEventListener('invalid', function () {\n    if (modalCallInputName.validity.valueMissing) {\n      modalCallInputName.setCustomValidity('Это обязательное поле');\n    } else {\n      modalCallInputName.setCustomValidity('');\n    }\n  });\n\n  modalCallInputPhone.addEventListener('invalid', function () {\n    if (modalCallInputPhone.validity.tooLong) {\n      modalCallInputPhone.setCustomValidity('Номер телефона не может быть больше 11 цифр');\n    } else if (modalCallInputPhone.validity.valueMissing) {\n      modalCallInputPhone.setCustomValidity('Это обязательное поле');\n    } else {\n      modalCallInputPhone.setCustomValidity('');\n    }\n  });\n\n  modalCallInputName.addEventListener('input', function (evt) {\n    var target = evt.target;\n    if (target.value.length === 0) {\n      target.setCustomValidity('Это обязательное поле');\n    } else {\n      modalCallInputName.setCustomValidity('');\n    }\n  });\n\n  modalCallInputPhone.addEventListener('input', function (evt) {\n    var target = evt.target;\n    if (target.value.length > 11) {\n      target.setCustomValidity('Номер телефона не может быть больше 11 цифр');\n    } else if (target.value.length === 0) {\n      target.setCustomValidity('Это обязательное поле');\n    } else {\n      modalCallInputPhone.setCustomValidity('');\n    }\n  });\n\n  var modalCallSend = function modalCallSend(data, onSuccess, onError) {\n    var xhr = new XMLHttpRequest();\n\n    xhr.addEventListener('load', function () {\n      if (xhr.status === 200) {\n        onSuccess(xhr.response);\n      } else {\n        onError('При отправке формы произошла ошибка :(');\n      }\n    });\n\n    xhr.open('POST', url);\n    xhr.send(data);\n  };\n\n  modalCallForm.addEventListener('submit', function (evt) {\n    modalCallSend(new FormData(modalCallForm), function () {\n      modalCall.classList.remove('modal-call--active');\n      modalCallOverlay.classList.remove('modal-call__overlay--active');\n    });\n    evt.preventDefault();\n  });\n\n  setTimeout(onModalCallButtonClick, 75000);\n})();\n\n//# sourceURL=webpack:///./src/common.blocks/modal-call/modal-call.js?");

    /***/
  }),

  /***/ "./src/common.blocks/rewiew/rewiew__answer.js":
  /*!****************************************************!*\
    !*** ./src/common.blocks/rewiew/rewiew__answer.js ***!
    \****************************************************/
  /*! no static exports found */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";
    eval("\n\n(function () {\n  var rewiewTextWrap = document.querySelectorAll('.rewiew__text-wrap');\n  var textRewiewAnswer = document.querySelectorAll('.rewiew__answer');\n\n  textRewiewAnswer.forEach(function (rewiew) {\n    if (rewiew.textContent === '') {\n      rewiew.style.display = 'none';\n    }\n  });\n  rewiewTextWrap.forEach(function (wrap) {\n    if (wrap.textContent === '') {\n      wrap.style.display = 'none';\n    }\n  });\n})();\n\n//# sourceURL=webpack:///./src/common.blocks/rewiew/rewiew__answer.js?");

    /***/
  }),

  /***/ "./src/common.blocks/tabs/tabs.js":
  /*!****************************************!*\
    !*** ./src/common.blocks/tabs/tabs.js ***!
    \****************************************/
  /*! no static exports found */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";
    eval("\n\n(function () {\n  var tabs = document.querySelector('.tabs');\n  var tabsItem = document.querySelectorAll('.tabs__item');\n\n  var clearClasses = function clearClasses(tabItem, tabOpen, tabClass) {\n    tabItem.forEach(function (item) {\n      item.classList.remove('tabs__item--active');\n    });\n\n    tabOpen.forEach(function (tab) {\n      tab.classList.remove(tabClass);\n    });\n  };\n\n  var tabClicked = function tabClicked(tabItem, tabOpened, tabClass) {\n    tabItem.classList.add('tabs__item--active');\n    tabOpened.classList.add(tabClass);\n  };\n\n  if (tabs) {\n    var specialTabSale = document.querySelector('.special__tab-sale');\n    var specialTabKomm = document.querySelector('.special__tab-komm');\n\n    var guestbookTabRewiew = document.querySelector('.guestbook__tab-rewiew');\n    var guestbookTabForm = document.querySelector('.guestbook__tab-add');\n\n    if (specialTabSale && specialTabKomm) {\n      var specialClassActive = 'special__tab--active';\n      var specialTab = document.querySelectorAll('.special__tab');\n\n      var specialTabSaleClick = function specialTabSaleClick() {\n        var tabSale = document.querySelector('.special__sale');\n        clearClasses(tabsItem, specialTab, specialClassActive);\n        tabClicked(specialTabSale, tabSale, specialClassActive);\n      };\n\n      var specialTabKommClick = function specialTabKommClick() {\n        var tabKomm = document.querySelector('.special__komm');\n        clearClasses(tabsItem, specialTab, specialClassActive);\n        tabClicked(specialTabKomm, tabKomm, specialClassActive);\n      };\n\n      specialTabSale.addEventListener('click', specialTabSaleClick);\n      specialTabKomm.addEventListener('click', specialTabKommClick);\n    } else if (guestbookTabRewiew && guestbookTabForm) {\n      var guestbookClassActive = 'guestbook__tab--active';\n      var guestbookTab = document.querySelectorAll('.guestbook__tab');\n\n      var guestbookTabRewiewClick = function guestbookTabRewiewClick() {\n        var tabRewiews = document.querySelector('.guestbook__rewiews');\n        clearClasses(tabsItem, guestbookTab, guestbookClassActive);\n        tabClicked(guestbookTabRewiew, tabRewiews, guestbookClassActive);\n      };\n\n      var guestbookTabFormClick = function guestbookTabFormClick() {\n        var tabForm = document.querySelector('.guestbook__rewiews-add');\n        clearClasses(tabsItem, guestbookTab, guestbookClassActive);\n        tabClicked(guestbookTabForm, tabForm, guestbookClassActive);\n      };\n\n      guestbookTabRewiew.addEventListener('click', guestbookTabRewiewClick);\n      guestbookTabForm.addEventListener('click', guestbookTabFormClick);\n    }\n  }\n})();\n\n//# sourceURL=webpack:///./src/common.blocks/tabs/tabs.js?");

    /***/
  }),

  /***/ "./src/library.blocks/img/img.js":
  /*!***************************************!*\
    !*** ./src/library.blocks/img/img.js ***!
    \***************************************/
  /*! no static exports found */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";
    eval("\n\n(function () {\n  var imgAll = document.querySelectorAll('.img');\n  var imgBig = document.querySelector('.img__big');\n  var imgPopup = document.querySelector('.img__popup');\n  var imgClose = document.querySelector('.img__close');\n  var imgButtomRight = imgPopup.querySelector('.img__button--right');\n  var imgButtomLeft = imgPopup.querySelector('.img__button--left');\n\n  var closePopup = function closePopup() {\n    imgPopup.style.display = '';\n    document.body.classList.remove('img__modal-open');\n  };\n\n  var getArrayImageSrc = [].map.call(imgAll, function (it) {\n    return it.src;\n  });\n\n  for (var j = 0; j < getArrayImageSrc.length; j++) {\n    while (getArrayImageSrc[j] === window.location.href) {\n      getArrayImageSrc.pop();\n    }\n  }\n\n  var findIndex = function findIndex(array, value) {\n    return array.indexOf(value);\n  };\n\n  var buttonRightClick = function buttonRightClick() {\n    var i = findIndex(getArrayImageSrc, imgBig.src);\n    if (i === 0) {\n      i = i + 1;\n    } else {\n      i = findIndex(getArrayImageSrc, imgBig.src) + 1;\n    }\n    if (i >= getArrayImageSrc.length) {\n      i = 0;\n    }\n    imgBig.src = getArrayImageSrc[i];\n  };\n\n  var buttonLeftClick = function buttonLeftClick() {\n    var i = findIndex(getArrayImageSrc, imgBig.src);\n    if (i === 0) {\n      i = i - 1;\n    } else {\n      i = findIndex(getArrayImageSrc, imgBig.src) - 1;\n    }\n    if (i < 0) {\n      i = getArrayImageSrc.length - 1;\n    }\n    imgBig.src = getArrayImageSrc[i];\n  };\n\n  var openPhoto = function openPhoto(image) {\n    var imageSrc = image.src;\n    imgBig.src = imageSrc;\n    imgPopup.style.display = 'flex';\n    document.body.classList.add('img__modal-open');\n  };\n\n  imgAll.forEach(function (img) {\n    if (img.src === window.location.href) {\n      img.remove();\n    }\n    img.addEventListener('click', function () {\n      openPhoto(img);\n      imgButtomRight.addEventListener('click', buttonRightClick);\n      imgButtomLeft.addEventListener('click', buttonLeftClick);\n      imgBig.addEventListener('click', buttonRightClick);\n    });\n  });\n  imgClose.addEventListener('click', closePopup);\n})();\n\n//# sourceURL=webpack:///./src/library.blocks/img/img.js?");

    /***/
  }),

  /***/ "./src/main.js":
  /*!*********************!*\
    !*** ./src/main.js ***!
    \*********************/
  /*! no static exports found */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";
    eval("\n\n(function () {\n  var ESC_KEYCODE = 27;\n\n  if (window.localStorage) {\n    var elements = document.querySelectorAll('[name]');\n\n    for (var i = 0, length = elements.length; i < length; i++) {\n      (function (element) {\n        var name = element.getAttribute('name');\n        element.value = localStorage.getItem(name) || '';\n        element.onkeyup = function () {\n          localStorage.setItem(name, element.value);\n        };\n      })(elements[i]);\n    }\n  }\n\n  window.onEscPress = function (evt, action) {\n    if (evt.keyCode === ESC_KEYCODE) {\n      action();\n    }\n  };\n})();\n\n//# sourceURL=webpack:///./src/main.js?");

    /***/
  }),

  /***/ "./src/style.scss":
  /*!************************!*\
    !*** ./src/style.scss ***!
    \************************/
  /*! no static exports found */
  /***/ (function (module, exports) {

    eval("// removed by extract-text-webpack-plugin\n\n//# sourceURL=webpack:///./src/style.scss?");

    /***/
  }),

  /***/ 0:
  /*!***************************************************************************************************************************************************************************************************************************************************************************************!*\
    !*** multi ./src/main.js ./src/common.blocks/tabs/tabs.js ./src/common.blocks/rewiew/rewiew__answer.js ./src/common.blocks/modal-call/modal-call.js ./src/common.blocks/gallery/gallery.js ./src/common.blocks/header/top-header.js ./src/library.blocks/img/img.js ./src/style.scss ***!
    \***************************************************************************************************************************************************************************************************************************************************************************************/
  /*! no static exports found */
  /***/ (function (module, exports, __webpack_require__) {

    eval("__webpack_require__(/*! ./src/main.js */\"./src/main.js\");\n__webpack_require__(/*! ./src/common.blocks/tabs/tabs.js */\"./src/common.blocks/tabs/tabs.js\");\n__webpack_require__(/*! ./src/common.blocks/rewiew/rewiew__answer.js */\"./src/common.blocks/rewiew/rewiew__answer.js\");\n__webpack_require__(/*! ./src/common.blocks/modal-call/modal-call.js */\"./src/common.blocks/modal-call/modal-call.js\");\n__webpack_require__(/*! ./src/common.blocks/gallery/gallery.js */\"./src/common.blocks/gallery/gallery.js\");\n__webpack_require__(/*! ./src/common.blocks/header/top-header.js */\"./src/common.blocks/header/top-header.js\");\n__webpack_require__(/*! ./src/library.blocks/img/img.js */\"./src/library.blocks/img/img.js\");\nmodule.exports = __webpack_require__(/*! ./src/style.scss */\"./src/style.scss\");\n\n\n//# sourceURL=webpack:///multi_./src/main.js_./src/common.blocks/tabs/tabs.js_./src/common.blocks/rewiew/rewiew__answer.js_./src/common.blocks/modal-call/modal-call.js_./src/common.blocks/gallery/gallery.js_./src/common.blocks/header/top-header.js_./src/library.blocks/img/img.js_./src/style.scss?");

    /***/
  })

  /******/
});
