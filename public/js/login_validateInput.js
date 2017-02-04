$('document').ready(function() {
    $('#submitButton').click(function(e) {
        var username = $('#usernameText');
        var password = $('#passwordText');
        if(textEmpty(username) || textEmpty(password)) {
            e.preventDefault();
            if(textEmpty(username)) {
                username.css('border-color','red');
            } else {
                username.css('border-color','');
            }
            if(textEmpty(password)) {
                password.css('border-color','red');
            } else {
                password.css('border-color','');
            }
        }
    });
});

function textEmpty(obj) {
    return obj.val() == '';
}