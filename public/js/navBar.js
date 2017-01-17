$('document').ready(function() {
    var currentYear = (new Date).getFullYear();
    $('footer>p').html("&copy; " + currentYear + " SafePhish. All Rights Reserved");
    assignInfoBarPositions();
    templateToggle();
    assignAuthLinkPositions();

    //button vars
    var templates = $('#templatesNavButton');
    var projects = $('#projectsNavButton');
    var emails = $('#emailNavButton');
    var results = $('#resultsNavButton');

    templates.hover(function() {
        $('.projectsInfo').hide();
        $('.templatesInfo').show();
        $('.emailInfo').hide();
        $('.authInfo').hide();
    }, function() {
        templateToggle();
    });
    projects.hover(function() {
        $('.projectsInfo').show();
        $('.templatesInfo').hide();
        $('.emailInfo').hide();
        $('.authInfo').hide();
    }, function() {
        templateToggle();
    });
    emails.hover(function() {
        $('.projectsInfo').hide();
        $('.templatesInfo').hide();
        $('.emailInfo').show();
        $('.authInfo').hide();
    }, function() {
        templateToggle();
    });
    results.hover(function() {
        $('.projectsInfo').hide();
        $('.templatesInfo').hide();
        $('.emailInfo').hide();
        $('.authInfo').hide();
    }, function() {
        templateToggle();
    });
    results.click(function() {
        window.location.href = "/";
    });

    changeInfoView(projects);
    changeInfoView(templates);
    changeInfoView(emails);
    changeInfoView(results);
});

function templateToggle() {
    var activeButton = $('.tempActiveNavButton').text();
    if(activeButton == 'Templates') {
        $('.projectsInfo').hide();
        $('.emailInfo').hide();
        $('.templatesInfo').show();
        $('.authInfo').hide();
    } else if(activeButton == 'Projects') {
        $('.projectsInfo').show();
        $('.emailInfo').hide();
        $('.templatesInfo').hide();
        $('.authInfo').hide();
    } else if(activeButton == 'Send Email') {
        $('.projectsInfo').hide();
        $('.emailInfo').show();
        $('.templatesInfo').hide();
        $('.authInfo').hide();
    } else if(activeButton == 'Results') {
        $('.projectsInfo').hide();
        $('.emailInfo').hide();
        $('.templatesInfo').hide();
        $('.authInfo').hide();
    } else {
        $('.projectsInfo').hide();
        $('.emailInfo').hide();
        $('.templatesInfo').hide();
        $('.authInfo').show();
    }
}

function changeInfoView(button) {
    button.click(function() {
        var activeButton = $('.tempActiveNavButton');
        activeButton.removeClass('tempActiveNavButton');
        button.addClass('tempActiveNavButton');
    });
}

function assignInfoBarPositions() {
    var counter = 0;
    $('.templatesInfo').each(function() {
        var pixel = counter*225;
        $(this).css('left',pixel+'px');
        counter++;
    });
    counter = 0;
    $('.projectsInfo').each(function() {
        var pixel = counter*225;
        $(this).css('left',pixel+'px');
        counter++;
    });
    counter = 0;
    $('.emailInfo').each(function() {
        var pixel = counter*225;
        $(this).css('left',pixel+'px');
        counter++;
    });
}

function assignAuthLinkPositions() {
    var counter = 0;
    $('.authenticationLink').each(function() {
        var pixel = counter*100;
        $(this).css('right',pixel+'px');
        counter++;
    });
}
