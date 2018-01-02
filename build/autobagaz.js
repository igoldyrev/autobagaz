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
module.exports = __webpack_require__(3);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _notification = __webpack_require__(2);

//notify('Here is my mesage');
(0, _notification.log)('Это сайт компании Автобагаж');
(0, _notification.log)('Сейчас сайт работает нормально');

//import {topmenu} from './js/nav-menu.js';

$(function () {
    $('.guestbook__tab-add').click(function () {
        $('.page__header-tab').removeClass('page__header-tab--active');
        $('.guestbook__tab').removeClass('guestbook__tab--active');

        $('.guestbook__tab-add').addClass('page__header-tab--active');
        $('.guestbook__rewiews-add').addClass('guestbook__tab--active');
    });

    $('.guestbook__tab-rewiew').click(function () {
        $('.guestbook__tab-add').removeClass('page__header-tab--active');
        $('.guestbook__rewiews-add').removeClass('guestbook__tab--active');

        $('.guestbook__tab-rewiew').addClass('page__header-tab--active');
        $('.guestbook__rewiews').addClass('guestbook__tab--active');
    });

    $('.special__tab-komm').click(function () {
        $('.page__header-tab').removeClass('page__header-tab--active');
        $('.special__tab').removeClass('special__tab--active');

        $('.special__tab-komm').addClass('page__header-tab--active');
        $('.special__komm').addClass('special__tab--active');
    });

    $('.special__tab-sale').click(function () {
        $('.special__tab-komm').removeClass('page__header-tab--active');
        $('.special__komm').removeClass('special__tab--active');

        $('.special__tab-sale').addClass('page__header-tab--active');
        $('.special__sale').addClass('special__tab--active');
    });
});

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

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.log = log;
//export function notify (message) {
//    alert(message);
//};

function log(message) {

    console.log(message);
};

/***/ }),
/* 3 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);