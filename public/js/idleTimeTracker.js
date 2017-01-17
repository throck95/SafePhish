var idleTime = 5;
var authCheck;
$('document').ready(function() {
    $.get('/auth/check', function(data) {
        authCheck = data['authCheck'];
        if(authCheck) {
            $('#idleTime').html("Idle Timeout: " + idleTime + " minutes");
            var idleInterval = setInterval(timerIncrement, 60000);
            $(document).mousemove(function(e) {
                idleTime = 5;
                $('#idleTime').html("Idle Timeout: " + idleTime + " minutes");
            });
            $(document).keypress(function(e) {
                idleTime = 5;
                $('#idleTime').html("Idle Timeout: " + idleTime + " minutes");
            });
        }
    });
});

function timerIncrement() {
    idleTime--;
    $('#idleTime').html("Idle Timeout: " + idleTime + " minutes");
    if(idleTime == 0) {
        window.location.replace('http://localhost:8888/auth/logout');
    }
}
