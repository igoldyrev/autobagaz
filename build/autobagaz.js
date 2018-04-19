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


console.log('Это сайт компании Автобагаж');
console.log('Сейчас сайт работает нормально');

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
};

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$(function () {
    $('.guestbook__tab-add').click(function () {
        $('.tabs__item').removeClass('tabs__item--active');
        $('.guestbook__tab').removeClass('guestbook__tab--active');

        $('.guestbook__tab-add').addClass('tabs__item--active');
        $('.guestbook__rewiews-add').addClass('guestbook__tab--active');
    });

    $('.guestbook__tab-rewiew').click(function () {
        $('.guestbook__tab-add').removeClass('tabs__item--active');
        $('.guestbook__rewiews-add').removeClass('guestbook__tab--active');

        $('.guestbook__tab-rewiew').addClass('tabs__item--active');
        $('.guestbook__rewiews').addClass('guestbook__tab--active');
    });
});

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$(function () {
    $('.special__tab-komm').click(function () {
        $('.tabs__item').removeClass('tabs__item--active');
        $('.special__tab').removeClass('special__tab--active');

        $('.special__tab-komm').addClass('tabs__item--active');
        $('.special__komm').addClass('special__tab--active');
    });

    $('.special__tab-sale').click(function () {
        $('.special__tab-komm').removeClass('tabs__item--active');
        $('.special__komm').removeClass('special__tab--active');

        $('.special__tab-sale').addClass('tabs__item--active');
        $('.special__sale').addClass('special__tab--active');
    });
});

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$('.rewiew__text-wrap').each(function () {
    if ($(this).text() === '') {
        $(this).remove();
    }
});

$('.rewiew__answer').each(function () {
    if ($(this).text() === '') {
        $(this).remove();
    }
});

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function () {
    var ESC_KEYCODE = 27;
    var modalCall = document.querySelector('.modal-call');
    var modalCallOverlay = document.querySelector('.modal-call__overlay');
    var modalCallClose = document.querySelector('.modal-call__close');
    var modalCallButton = document.querySelector('.modal-call__button');
    var modalCallInput = document.querySelector('.form__input--call');
    var modalCallHeader = document.querySelector('.modal-call__header');
    var modalCallForm = document.querySelector('.js-modal-call-form');
    var modalCallInputName = document.querySelector('.js-modal-form-input-name');
    var modalCallInputPhone = document.querySelector('.js-modal-form-input-phone');
    var url = '/call';

    var onModalCallEscPress = function onModalCallEscPress(evt) {
        if (evt.keyCode === ESC_KEYCODE) {
            onModalCallClose();
        }
    };

    var onModalCallClose = function onModalCallClose() {
        modalCall.classList.remove('modal-call--active');
        modalCallOverlay.classList.remove('modal-call__overlay--active');

        modalCall.style.top = 45 + '%';
        modalCall.style.left = 45 + '%';
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
    modalCallInput.addEventListener('focus', onModalCallInputFocus);
    modalCallInput.addEventListener('blur', onModalCallInputFocusLost);

    modalCallInputName.addEventListener('invalid', function (evt) {
        if (modalCallInputName.validity.valueMissing) {
            modalCallInputName.setCustomValidity('Это обязательное поле');
        } else {
            modalCallInputName.setCustomValidity('');
        }
    });

    modalCallInputPhone.addEventListener('invalid', function (evt) {
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
        modalCallSend(new FormData(modalCallForm), function (response) {
            modalCall.classList.remove('modal-call--active');
            modalCallOverlay.classList.remove('modal-call__overlay--active');
        });
        evt.preventDefault();
    });
})();

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$('.gallery__tag').each(function () {
    if ($(this).text() === '') {
        $(this).remove();
    }
});

/***/ }),
/* 7 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);