@extends('masters.basemaster')
@section('title')
    Show All Projects
@stop
@section('scripts')
    <script type="text/javascript" src="/js/showProjects.js"></script>
    <link rel="stylesheet" href="/css/jquery-ui.css" />
@stop
@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="/css/showallstyles.css" />
@stop
@section('projectsClassDefault')
    activeNavButton tempActiveNavButton
@stop
@section('bodyContent')
    <label>Filters: </label>
    <button id="activeShowButton">Active</button>
    <button id="inactiveShowButton">Inactive</button>
    <button id="showAllButton">All</button>
    <p>
        <label for="projectNameSelect">Email Projects: </label>
        <select id='projectNameSelect' name='projectName' onchange="getProject(this)" size="{{ $projectSize }}">
            @for ($i = 0; $i < $projectSize; $i++)
                <option class="{{ $projects[$i]['PRJ_ProjectStatus'] }}Project" value="{{ $projects[$i]['PRJ_ProjectName'] }}">
                    {{ $projects[$i]['PRJ_ProjectName'] }} ({{ $projects[$i]['PRJ_ProjectStatus'] }})</option>
            @endfor
        </select>
    </p>
@stop
@section('footer')
    <p></p>
@stop