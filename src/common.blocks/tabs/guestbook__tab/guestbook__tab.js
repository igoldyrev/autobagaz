$(function () {
    $('.guestbook__tab-add').click(function()
    {
        $('.tabs__item').removeClass('tabs__item--active');
        $('.guestbook__tab').removeClass('guestbook__tab--active');

        $('.guestbook__tab-add').addClass('tabs__item--active');
        $('.guestbook__rewiews-add').addClass('guestbook__tab--active');
    });

    $('.guestbook__tab-rewiew').click(function()
    {
        $('.guestbook__tab-add').removeClass('tabs__item--active');
        $('.guestbook__rewiews-add').removeClass('guestbook__tab--active');

        $('.guestbook__tab-rewiew').addClass('tabs__item--active');
        $('.guestbook__rewiews').addClass('guestbook__tab--active');
    });
});