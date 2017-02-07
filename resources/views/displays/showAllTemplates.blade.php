@extends('masters.basemaster')
@section('title')
    Show All Templates
@stop
@section('scripts')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="/js/templates_angular.js"></script>
@stop
@section('stylesheets')
    <link href="/css/tables.css" rel="stylesheet" type="text/css" />
@stop
@section('bodyContent')
    <label>Filters: </label>
    <div ng-app="templateApp" ng-controller="templateController">
        <button ng-click='buttonFilter("phishing")'>Phishing</button>
        <button ng-click='buttonFilter("educational")'>Educational</button>
        <button ng-click='buttonFilter("")'>All</button>
        <br />
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-search"></i>
                    <input type="text" class="form-control" placeholder="Filter" ng-model="search" />
                </div>
            </div>
        </div>
        <table>
            <th ng-click='sortColumn("Name")' ng-class='sortClass("Name")'>Name</th>
            <th ng-click='sortColumn("EmailType")' ng-class='sortClass("EmailType")'>Email Type</th>
            <th ng-click='sortColumn("Created")' ng-class='sortClass("Created")'>Created</th>
            <th ng-click='sortColumn("Updated")' ng-class='sortClass("Updated")'>Updated</th>
            <tr ng-repeat="x in templates | orderBy:column:reverse | filter:search | filter:buttonSearch:exceptEmpty">
                <td>[[ x.PublicName ]]</td>
                <td>[[ x.EmailType ]]</td>
                <td>[[ x.created_at ]]</td>
                <td>[[ x.updated_at ]]</td>
                <td><a ng-href='/templates/[[ x.FileName ]]'>View</a></td>
            </tr>
        </table>
    </div>
@stop