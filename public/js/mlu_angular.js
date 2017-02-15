var app = angular.module('mluApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller('mluController',function($scope,$http) {
    $http.get("/json/mlu")
        .then(function(response) {
            $scope.mlu = response.data.mlu;
        });
    $scope.column = 'FirstName';
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