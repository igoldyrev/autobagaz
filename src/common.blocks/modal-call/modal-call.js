'use strict';
(function () {
    var ESC_KEYCODE = 27;
    var modalCall = document.querySelector('.modal-call');
    var modalCallOverlay = document.querySelector('.modal-call__overlay');
    var modalCallClose = document.querySelector('.modal-call__close');
    var modalCallButton = document.querySelector('.modal-call__button');
    var modalCallInput = document.querySelector('.form__input--call');
    var modalCallHeader = document.querySelector('.modal-call__header');

    var onModalCallEscPress = function (evt) {
        if (evt.keyCode === ESC_KEYCODE) {
            onModalCallClose();
        }
    }
    
    var onModalCallClose = function () {
        modalCall.classList.remove('modal-call--active');
        modalCallOverlay.classList.remove('modal-call__overlay--active');

        modalCall.style.top = 45 + '%';
        modalCall.style.left = 45 + '%';
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

        modalCallClose.addEventListener('click', onModalCallClose);
        document.addEventListener('keydown', onModalCallEscPress);
    };

    var modalCallHeaderDown = function (evt) {
        evt.preventDefault();

        var startCoords = {
            x: evt.clientX,
            y: evt.clientY
        };

        var onMouseMove = function (moveEvt) {
            moveEvt.preventDefault();

            var shift = {
                x: startCoords.x - moveEvt.clientX,
                y: startCoords.y - moveEvt.clientY
            };

            startCoords = {
                x: moveEvt.clientX,
                y: moveEvt.clientY
            };

            modalCall.style.top = (modalCall.offsetTop - shift.y) + 'px';
            modalCall.style.left = (modalCall.offsetLeft - shift.x) + 'px';
        };

        var onMouseUp = function (upEvt) {
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
})();
