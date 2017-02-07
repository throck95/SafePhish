var app = angular.module('usersApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller('usersController',function($scope,$http) {
    $http.get("http://localhost:8000/json/users")
        .then(function(response) {
            $scope.users = response.data.users;
        });
    $scope.column = 'Username';
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
});