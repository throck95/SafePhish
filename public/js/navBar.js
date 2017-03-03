$('document').ready(function() {
    var counter = 0;
    $('.authenticationLink').each(function() {
        var pixel = counter*10;
        $(this).css('right',pixel+'px');
        counter++;
    });
});
