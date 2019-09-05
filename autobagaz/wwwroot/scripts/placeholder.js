$('.form__input').on('input', function () {
    var $this = $(this);
    if ($this.val() == '') {
        $this.removeClass('form__input_filled');
    } else {
        $this.addClass('form__input_filled');
    }
});