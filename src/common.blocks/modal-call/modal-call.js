$(function() {
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