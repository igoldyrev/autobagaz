'use strict';
(function () {
    var ESC_KEYCODE = 27;
    var modalCall = document.querySelector('.modal-call');
    var modalCallOverlay = document.querySelector('.modal-call__overlay');
    var modalCallClose = document.querySelector('.modal-call__close');
    var modalCallButton = document.querySelector('.modal-call__button');
    var modalCallInput = document.querySelector('.form__input--call');

    var onModalCallEscPress = function (evt) {
        if (evt.keyCode === ESC_KEYCODE) {
            onModalCallClose();
        }
    }
    
    var onModalCallClose = function () {
        modalCall.classList.remove('modal-call--active');
        modalCallOverlay.classList.remove('modal-call__overlay--active');
    };
    
    var onModalCallInputFocus = function () {
        document.removeEventListener('keydown', onModalCallEscPress);
    };

    var onModalCallInputFocusLost = function () {
        document.addEventListener('keydown', onModalCallEscPress);
    };

    var onModalCallButtonClick = function () {
        modalCall.classList.add('modal-call--active');
        modalCallOverlay.classList.add('modal-call__overlay--active');

        modalCallOverlay.addEventListener('click', onModalCallClose);
        modalCallClose.addEventListener('click', onModalCallClose);
        document.addEventListener('keydown', onModalCallEscPress);
    };

    modalCallButton.addEventListener('click', onModalCallButtonClick);
    modalCallInput.addEventListener('focus', onModalCallInputFocus);
    modalCallInput.addEventListener('blur', onModalCallInputFocusLost);
})();
