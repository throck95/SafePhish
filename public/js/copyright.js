$('document').ready(function() {
    var currentYear = (new Date).getFullYear();
    $('footer>#copyright').html("&copy; " + currentYear + " SafePhish. All Rights Reserved");
});