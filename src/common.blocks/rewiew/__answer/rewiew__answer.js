$('.rewiew__text-wrap').each(function () {
    if ($(this).text() === '') {
        $(this).remove();
    }
});

$('.rewiew__answer').each(function () {
    if ($(this).text() === '') {
        $(this).remove();
    }
});