 // Add Asterisk On Required Field

$('input').each(function() {
    if ($(this).attr('required') === 'required') {
        $(this).after('<span class="asterisk">*</span>');
    }
});

// Convert Password Field To Text Field On Hover

$('.show-pass').hover(function() {
    // Access To Password Input
    let passField = $(this).parent().children('input');
    passField.attr('type', 'text');

    
}, function() {
    let passField = $(this).parent().children('input');
    passField.attr('type', 'password');
});


// Confirmation Message On Button

$('.confirm').click(function() {
    return confirm('Are You Sure !');
});
