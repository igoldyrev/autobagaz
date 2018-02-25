console.log('Это сайт компании Автобагаж');
console.log('Сейчас сайт работает нормально');

$(function()
{




    $('.modal-call__button').click(function()
    {
        $('.modal-call').addClass('modal-call--active');
        $('.modal-call__overlay').addClass('modal-call__overlay--active');
    });

    $('.modal-call__close').click(function()
    {
        $('.modal-call').removeClass('modal-call--active');
        $('.modal-call__overlay').removeClass('modal-call__overlay--active');
    });

    $('.modal-call__overlay').click(function()
    {
        $('.modal-call').removeClass('modal-call--active');
        $('.modal-call__overlay').removeClass('modal-call__overlay--active');
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
};

