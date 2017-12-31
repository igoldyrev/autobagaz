import {log} from './notification';

//notify('Here is my mesage');
log('Это сайт компании Автобагаж');
log('Сейчас сайт работает нормально');

//import {topmenu} from './js/nav-menu.js';

$(function()
{
    $('.guestbook__tab-add').click(function()
    {
        $('.page__header-tab').removeClass('page__header-tab--active');
        $('.guestbook__tab').removeClass('guestbook__tab--active');

        $('.guestbook__tab-add').addClass('page__header-tab--active');
        $('.guestbook__rewiews-add').addClass('guestbook__tab--active');
    });

    $('.guestbook__tab-rewiew').click(function()
    {
        $('.guestbook__tab-add').removeClass('page__header-tab--active');
        $('.guestbook__rewiews-add').removeClass('guestbook__tab--active');

        $('.guestbook__tab-rewiew').addClass('page__header-tab--active');
        $('.guestbook__rewiews').addClass('guestbook__tab--active');
    });
});

if (window.localStorage) {
    var elements = document.querySelectorAll('[name]');

    for (var i = 0, length = elements.length; i < length; i++) {
        (function(element) {
            var name = element.getAttribute('name');

            element.value = localStorage.getItem(name) || '';

            element.onkeyup = function() {
                localStorage.setItem(name, element.value);
            };
        })(elements[i]);
    }
}