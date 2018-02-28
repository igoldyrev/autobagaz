console.log('Это сайт компании Автобагаж');
console.log('Сейчас сайт работает нормально');

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

