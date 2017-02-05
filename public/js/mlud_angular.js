var app = angular.module('mludApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller('mludController',function($scope,$http) {
    $http.get("http://localhost:8000/json/mlud")
        .then(function(response) {
            $scope.mlud = response.data.mlud;
        });
    $scope.column = 'Department';
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