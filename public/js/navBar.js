$('document').ready(function() {
    var currentYear = (new Date).getFullYear();
    $('footer>#copyright').html("&copy; " + currentYear + " SafePhish. All Rights Reserved");
    assignAuthLinkPositions();
});

function assignAuthLinkPositions() {
    var counter = 0;
    $('.authenticationLink').each(function() {
        var pixel = counter*10;
        $(this).css('right',pixel+'px');
        counter++;
    });
}
