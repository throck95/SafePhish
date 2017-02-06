@extends('masters.basemaster')
@section('title')
    Show All Campaigns
@stop
@section('scripts')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="/js/users_angular.js"></script>
@stop
@section('stylesheets')
    <link href="/css/tables.css" rel="stylesheet" type="text/css" />
@stop
@section('bodyContent')
    <label>Filters: </label>
    <div ng-app="usersApp" ng-controller="usersController">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-search"></i>
                    <input type="text" class="form-control" placeholder="Filter" ng-model="search" />
                </div>
            </div>
        </div>
        <table>
            <th ng-click='sortColumn("Username")' ng-class='sortClass("Username")'>Username</th>
            <th ng-click='sortColumn("FirstName")' ng-class='sortClass("FirstName")'>First Name</th>
            <th ng-click='sortColumn("LastName")' ng-class='sortClass("LastName")'>Last Name</th>
            <th ng-click='sortColumn("Email")' ng-class='sortClass("Email")'>Email</th>
            <th ng-click='sortColumn("UserType")' ng-class='sortClass("UserType")'>User Type</th>
            <tr ng-repeat="x in users | orderBy:column:reverse | filter:search">
                <td><a ng-href='/user/update/[[ x.Id ]]'>[[ x.Username ]]</a></td>
                <td>[[ x.FirstName ]] [[ x.MiddleInitial ]]</td>
                <td>[[ x.LastName ]]</td>
                <td>[[ x.Email ]]</td>
                <td>[[ x.UserType ]]</td>
            </tr>
        </table>
    </div>
@stop