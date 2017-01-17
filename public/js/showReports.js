$('document').ready( function() {
    $('#websiteDatepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        changeDay: true,
        showButtonPanel: true,
        dateFormat: 'mm/dd/yy',
        onClose: function(dateText, inst) {
            function isDonePressed() {
                return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
            }
            if (isDonePressed()) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var day = $("#ui-datepicker-div .ui-datepicker-day :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, day)).trigger('change');

                $('.date-picker').focusout();
            }
        },
        beforeShow: function(input, inst) {
            inst.dpDiv.addClass('month_year_datepicker');
            if((datestr = $(this).val()).length > 0) {
                var month = new Date().getMonth();
                var day = new Date().getDate();
                var year = new Date().getFullYear();
                $(this).datepicker('option', 'defaultDate', new Date(year, month, day));
                $(".ui-datepicker-calendar").hide();
            }
        }
    });
});


var app = angular.module('resultsApp', []);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller('resultsController', function($scope) {
    $scope.websiteSortType = 'WBS_Ip';
    $scope.websiteSortReverse = false;
    $scope.websiteQuantity = 10;


    $scope.emailSortType = 'EML_Ip';
    $scope.emailSortReverse = false;
    $scope.emailQuantity = 10;


    $scope.reportsSortType = 'RPT_EmailSubject';
    $scope.reportsSortReverse = false;
    $scope.reportsQuantity = 10;

    $scope.searchTerm = '';

    $scope.websiteLoadMore = function() {
        $scope.websiteQuantity += 10;
    };
    $scope.websiteLoadLess = function() {
        $scope.websiteQuantity -= 10;
    };

    $scope.emailLoadMore = function() {
        $scope.emailQuantity += 10;
    };
    $scope.emailLoadLess = function() {
        $scope.emailQuantity -= 10;
    };

    $scope.reportsLoadMore = function() {
        $scope.reportsQuantity += 10;
    };
    $scope.reportsLoadLess = function() {
        $scope.reportsQuantity -= 10;
    };

    $scope.websiteData = [];
    $.get("websitedata/json",function(data) {
        $scope.websiteData = data;
        $scope.$apply();
    });

    $scope.emailData = [];
    $.get("emaildata/json",function(data) {
        $scope.emailData = data;
        $scope.$apply();
    });

    $scope.reportsData = [];
    $.get("reportsdata/json",function(data) {
        $scope.reportsData = data;
        $scope.$apply();
    });
});
