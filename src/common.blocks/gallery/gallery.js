$('.gallery__tag').each(function () {
    if ($(this).text() === '') {
        $(this).remove();
    }
});