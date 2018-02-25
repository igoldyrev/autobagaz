$(function () {
    $('.special__tab-komm').click(function()
    {
        $('.tabs__item').removeClass('tabs__item--active');
        $('.special__tab').removeClass('special__tab--active');

        $('.special__tab-komm').addClass('tabs__item--active');
        $('.special__komm').addClass('special__tab--active');
    });

    $('.special__tab-sale').click(function()
    {
        $('.special__tab-komm').removeClass('tabs__item--active');
        $('.special__komm').removeClass('special__tab--active');

        $('.special__tab-sale').addClass('tabs__item--active');
        $('.special__sale').addClass('special__tab--active');
    });
});