'use strict';
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

    var onModalCallEscPress = function (evt) {
        if (evt.keyCode === ESC_KEYCODE) {
            onModalCallClose();
        }
    };
    
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

    var modalCallSend = function (data, onSuccess, onError) {
        var xhr = new XMLHttpRequest();

        xhr.addEventListener('load', function () {
            if (xhr.status === 200) {
                onSuccess(xhr.response);
            } else {
                onError ('При отправке формы произошла ошибка :(');
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

    setTimeout(onModalCallButtonClick, 20000);
})();
