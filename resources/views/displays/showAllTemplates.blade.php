@extends('masters.basemaster')
@section('title')
    Show All Templates
@stop
@section('scripts')
    <script type="text/javascript" src="/js/showTemplates.js"></script>
    <link rel="stylesheet" href="/css/jquery-ui.css" />
@stop
@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="/css/showallstyles.css" />
@stop
@section('templatesClassDefault')
    activeNavButton tempActiveNavButton
@stop
@section('contentViewer')
    <div id="templateContentDiv"></div>
@stop
@section('bodyContent')
    <label>Filters: </label>
    <button id="advShowButton">Advanced</button>
    <button id="bscShowButton">Basic</button>
    <button id="eduShowButton">Education</button>
    <button id="genShowButton">General</button>
    <button id="tarShowButton">Targeted</button>
    <button id="showAllButton">All</button>
    <p><label for="emailTemplateSelect">Email Templates: </label>
    <select id='emailTemplateSelect' name='emailTemplate' onchange="getTemplateData(this);" size="{{ $templateSize }}">
        @for ($i = 0; $i < $templateSize; $i++)
            <option class="{{ $filePrefaces[$i] }}Template {{ $fileTypes[$i] }}Template" value="{{ $fileNames[$i] }}">{{ $fileNames[$i] }}</option>
        @endfor
    </select></p>
@stop
@section('footer')
    <p></p>
@stop