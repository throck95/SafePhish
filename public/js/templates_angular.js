var app = angular.module('templateApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller('templateController',function($scope,$http) {
    $http.get("http://localhost:8000/json/templates")
        .then(function(response) {
            $scope.templates = response.data.templates;
        });
    $scope.column = 'Name';
    $scope.reverse = false;
    $scope.search = '';
    $scope.buttonSearch = '';

    $scope.sortColumn = function(col) {
        $scope.column = col;
        if($scope.reverse) {
            $scope.reverse = false;
        } else {
            $scope.reverse = true;
            $scope.reverseclass = 'arrow-down';
        }
    };

    $scope.sortClass = function(col) {
        if($scope.column == col) {
            if($scope.reverse) {
                return 'arrow-down';
            } else {
                return 'arrow-up';
            }
        } else {
            return '';
        }
    };

    $scope.buttonFilter = function(query) {
        $scope.buttonSearch = query;
    };

    $scope.exceptEmpty = function(actual, expected) {
        if(!expected) {
            return true;
        }
        return angular.equals(expected, actual);
    };

    $scope.alertTest = function(object) {
        window.alert(object.FileName);
    };
});