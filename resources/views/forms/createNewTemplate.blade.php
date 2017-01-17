@extends('masters.basemaster')
@section('title')
    Create New Template
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')
    <script type="text/javascript" src="/js/createNewTemplate.js"></script>
@stop
@section('formcss')
    <link rel="stylesheet" type="text/css" href="/css/baseformstyles.css" />
    <link rel="stylesheet" type="text/css" href="/css/templatecreaterstyles.css" />
@stop
@section('templatesClassDefault')
    activeNavButton tempActiveNavButton
@stop
@section('contentViewer')
    <div id="templateContentDiv"></div>
@stop
@section('bodyContent')
    {!! Form::open(array('action'=>'GUIController@createNewPhishTemplate')) !!}
    <p>{!! Form::label('fileNameText','Template Name: ') !!}
        {!! Form::text('fileNameText',null,array('name'=>'templateName','placeholder'=>'e.g. advT10, bscG5')) !!}
        <button id="checkNameButton">Check Availability</button></p>
    {!! Form::textarea('contentTextArea',null,array('id'=>'contentTextArea','rows'=>'30','cols'=>'60','name'=>'templateContent')) !!}<br />
    <button id="firstNameButton">First Name</button>
    <button id="lastNameButton">Last Name</button>
    <button id="usernameButton">Username</button>
    <button id="uniqueURLButton">Unique URL ID</button>
    <button id="emailSubjectButton">Email Subject</button>
    <button id="emailToButton">To Email Address</button>
    <button id="emailFromButton">From Email Address</button>
    <button id="companyNameButton">Company Name</button>
    <button id="projectNameButton">Project Name</button>
    <button id="imageButton">Image</button><br /><br />
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop