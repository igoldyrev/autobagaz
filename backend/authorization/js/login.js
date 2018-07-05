'use strict';
(function () {
  var authorizationForm = document.querySelector('.js-authorization-form');
  var authorizationFormMessage = document.querySelector('.js-authorization-form-message');
  var url = '/intro';

  var authorizationFormIntro = function (data, onSuccess, onError) {
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

  authorizationForm.addEventListener('submit', function (evt) {
    authorizationFormIntro(new FormData(authorizationForm), function () {
      authorizationFormMessage.classList.remove('good-message--auth');
    });
    evt.preventDefault();
  });

})();
