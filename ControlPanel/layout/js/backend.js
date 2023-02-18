 // Add Asterisk On Required Field

$('input').each(function() {
    if ($(this).attr('required') === 'required') {
        $(this).after('<span class="asterisk">*</span>');
    }
});
