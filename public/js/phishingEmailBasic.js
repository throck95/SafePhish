$('document').ready(function() {
    $('#submitButton').click(function(e) {
        var projectName = $('#projectNameSelect').val();
        var emailTemplate = $('#emailTemplateSelect').val();
        var fromEmail = $('#fromEmailText').val();
        var password = $('#passwordText').val();
        var subject = $('#subjectText').val();
        var company = $('#companyText').val();
        var host = $('#mailServerText').val();
        var port = $('#mailPortText').val();
        if(textEmpty(fromEmail) || textEmpty(subject) || textEmpty(company) ||
            selectEmpty(projectName) || selectEmpty(emailTemplate)) {
            e.preventDefault();
            if(textEmpty(fromEmail)) {
                $('#fromEmailText').css('border-color','red');
            } else {
                $('#fromEmailText').css('border-color','');
            }
            if(textEmpty(subject)) {
                $('#subjectText').css('border-color','red');
            } else {
                $('#subjectText').css('border-color','');
            }
            if(textEmpty(company)) {
                $('#companyText').css('border-color','red');
            } else {
                $('#companyText').css('border-color','');
            }
            if(selectEmpty(projectName)) {
                $('#projectNameSelect').css('border-color','red');
            } else {
                $('#projectNameSelect').css('border-color','');
            }
            if(selectEmpty(emailTemplate)) {
                $('#emailTemplateSelect').css('border-color','red');
            } else {
                $('#emailTemplateSelect').css('border-color','');
            }
        }
    });
});

function textEmpty(val) {
    return val == '';
}

function selectEmpty(val) {
    return val == '0' || val == '-1';
}

function getProject(sel) {
    var projectName = sel.value;
    if(projectName == "0") {
        window.location.href = 'http://localhost:8888/projects/create';
    } else if(projectName == "-1") {
        //do nothing
    } else {
        if(!window.confirm('Are you sure you want to reuse this project?')) {
            $('#projectNameSelect').val('-1');
        }
    }
}

function getTemplateData(sel) {
    var templateName = sel.value;
    if(templateName == "0") {
        window.location.href = 'http://localhost:8888/templates/create';
    } else if(templateName == "-1") {
        //do nothing
    } else {
        var path = 'http://localhost:8888/files/templates/' + templateName;
        $.get(path,function(data) {
            $('#templateContentDiv').html(data);
        });
    }
}