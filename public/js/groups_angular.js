var app = angular.module('groupsApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller('groupsController',function($scope,$http) {
    $http.get("/json/groups")
        .then(function(response) {
            $scope.groups = response.data.groups;
        });
    $scope.column = 'Name';
    $scope.reverse = false;
    $scope.search = '';

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
});