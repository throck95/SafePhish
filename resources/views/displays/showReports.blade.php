@extends('masters.basemaster')
@section('title')
    Show All Projects
@stop
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc.5/angular-material.min.js"></script>
    <script type="text/javascript" src="/js/showReports.js"></script>
    <link rel="stylesheet" href="/css/jquery-ui.css" />
@stop
@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="/css/resultsStyles.css" />
    <link rel="stylesheet" type="text/css" href="/css/resultsTableStructure.css" />
@stop
@section('resultsClassDefault')
    activeNavButton tempActiveNavButton
@stop
@section('bodyContent')
    <section ng-app="resultsApp" ng-controller="resultsController">
        <h4>Website Results</h4>
        <table>
            <tr>
                <th class="WBS_Ip">
                    <a ng-click="websiteSortType = 'WBS_Ip'; websiteSortReverse = !websiteSortReverse">
                        IP
                        <span ng-show="websiteSortType == 'WBS_Ip' && !websiteSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="websiteSortType == 'WBS_Ip' && websiteSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="WBS_Host">
                    <a ng-click="websiteSortType = 'WBS_Host'; websiteSortReverse = !websiteSortReverse">
                        Host
                        <span ng-show="websiteSortType == 'WBS_Host' && !websiteSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="websiteSortType == 'WBS_Host' && websiteSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="WBS_ReqPath">
                    <a ng-click="websiteSortType = 'WBS_ReqPath'; websiteSortReverse = !websiteSortReverse">
                        Request Path
                        <span ng-show="websiteSortType == 'WBS_ReqPath' && !websiteSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="websiteSortType == 'WBS_ReqPath' && websiteSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="WBS_Username">
                    <a ng-click="websiteSortType = 'WBS_Username'; websiteSortReverse = !websiteSortReverse">
                        Username
                        <span ng-show="websiteSortType == 'WBS_Username' && !websiteSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="websiteSortType == 'WBS_Username' && websiteSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="WBS_ProjectName">
                    <a ng-click="websiteSortType = 'WBS_ProjectName'; websiteSortReverse = !websiteSortReverse">
                        Project Name
                        <span ng-show="websiteSortType == 'WBS_ProjectName' && !websiteSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="websiteSortType == 'WBS_ProjectName' && websiteSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="WBS_Access">
                    <a ng-click="websiteSortType = 'WBS_AccessDate'; websiteSortReverse = !websiteSortReverse">
                        Timestamp
                        <span ng-show="websiteSortType == 'WBS_AccessDate' && !websiteSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="websiteSortType == 'WBS_AccessDate' && websiteSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
            </tr>
            <tr ng-repeat="data in websiteData | orderBy:websiteSortType:websiteSortReverse">
                <td class="WBS_Ip">[[ data.WBS_Ip ]]</td>
                <td class="WBS_Host">[[ data.WBS_Host ]]</td>
                <td class="WBS_ReqPath">[[ data.WBS_ReqPath ]]</td>
                <td class="WBS_Username">[[ data.WBS_Username ]]</td>
                <td class="WBS_ProjectName">[[ data.WBS_ProjectName ]]</td>
                <td class="WBS_Access">[[ data.WBS_AccessDate ]] [[ data.WBS_AccessTime ]]</td>
            </tr>
        </table>
        <h4>Email Results</h4>
        <table>
            <tr>
                <th class="EML_Ip">
                    <a ng-click="emailSortType = 'EML_Ip'; emailSortReverse = !emailSortReverse">
                        IP
                        <span ng-show="emailSortType == 'EML_Ip' && !emailSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="emailSortType == 'EML_Ip' && emailSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="EML_Host">
                    <a ng-click="emailSortType = 'EML_Host'; emailSortReverse = !emailSortReverse">
                        Host
                        <span ng-show="emailSortType == 'EML_Host' && !emailSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="emailSortType == 'EML_Host' && emailSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="EML_Username">
                    <a ng-click="emailSortType = 'EML_Username'; emailSortReverse = !emailSortReverse">
                        Username
                        <span ng-show="emailSortType == 'EML_Username' && !emailSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="emailSortType == 'EML_Username' && emailSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="EML_ProjectName">
                    <a ng-click="emailSortType = 'EML_ProjectName'; emailSortReverse = !emailSortReverse">
                        Project Name
                        <span ng-show="emailSortType == 'EML_ProjectName' && !emailSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="emailSortType == 'EML_ProjectName' && emailSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="EML_Access">
                    <a ng-click="emailSortType = 'EML_AccessDate'; emailSortReverse = !emailSortReverse">
                        Timestamp
                        <span ng-show="emailSortType == 'EML_AccessDate' && !emailSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="emailSortType == 'EML_AccessDate' && emailSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
            </tr>
            <tr ng-repeat="data in emailData | orderBy:emailSortType:emailSortReverse | limitTo:emailQuantity">
                <td class="EML_Ip">[[ data.EML_Ip ]]</td>
                <td class="EML_Host">[[ data.EML_Host ]]</td>
                <td class="EML_Username">[[ data.EML_Username ]]</td>
                <td class="EML_ProjectName">[[ data.EML_ProjectName ]]</td>
                <td class="EML_Access">[[ data.EML_AccessDate ]] [[ data.EML_AccessTime ]]</td>
            </tr>
        </table>
        <h4>Report Results</h4>
        <table>
            <tr>
                <th class="RPT_EmailSubject">
                    <a ng-click="reportsSortType = 'RPT_EmailSubject'; reportsSortReverse = !reportsSortReverse">
                        Subject
                        <span ng-show="reportsSortType == 'RPT_EmailSubject' && !reportsSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="reportsSortType == 'RPT_EmailSubject' && reportsSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="RPT_UserEmail">
                    <a ng-click="reportsSortType = 'RPT_UserEmail'; reportsSortReverse = !reportsSortReverse">
                        User
                        <span ng-show="reportsSortType == 'RPT_UserEmail' && !reportsSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="reportsSortType == 'RPT_UserEmail' && reportsSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="RPT_OriginalFrom">
                    <a ng-click="reportsSortType = 'RPT_OriginalFrom'; reportsSortReverse = !reportsSortReverse">
                        Sender
                        <span ng-show="reportsSortType == 'RPT_OriginalFrom' && !reportsSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="reportsSortType == 'RPT_OriginalFrom' && reportsSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
                <th class="RPT_ReportDate">
                    <a ng-click="reportsSortType = 'RPT_ReportDate'; reportsSortReverse = !reportsSortReverse">
                        Report Date
                        <span ng-show="reportsSortType == 'RPT_ReportDate' && !reportsSortReverse" class="fa fa-caret-down"></span>
                        <span ng-show="reportsSortType == 'RPT_ReportDate' && reportsSortReverse" class="fa fa-caret-up"></span>
                    </a>
                </th>
            </tr>
            <tr ng-repeat="data in reportsData | orderBy:reportsSortType:reportsSortReverse | limitTo:reportsQuantity">
                <td class="RPT_EmailSubject">[[ data.RPT_EmailSubject ]]</td>
                <td class="RPT_UserEmail">[[ data.RPT_UserEmail ]]</td>
                <td class="RPT_OriginalFrom">[[ data.RPT_OriginalFrom ]]</td>
                <td class="RPT_ReportDate">[[ data.RPT_ReportDate ]]</td>
            </tr>
        </table>
        <p>Website Filter: <input type="text" id="websiteDatepicker" /></p>
    </section>
@stop
@section('footer')
    <p></p>
@stop