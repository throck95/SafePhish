@extends('masters.basemaster')
@section('title')
    Create New Project
@stop
@section('csrf_token')
    <meta name="_token" content="{{ csrf_token() }}" />
@stop
@section('scripts')
    <script type="text/javascript" src="/js/createNewProject.js"></script>
@stop
@section('formcss')
    <link rel="stylesheet" type="text/css" href="/css/baseformstyles.css" />
@stop
@section('projectsClassDefault')
    activeNavButton tempActiveNavButton
@stop
@section('bodyContent')
    {!! Form::open(array('action'=>'PhishingController@createNewProject')) !!}
    <p>{!! Form::label('projectNameText','Project Name: ') !!}
        {!! Form::text('projectNameText',null,array('name'=>'projectNameText')) !!}</p>
    <p>{!! Form::label('projectAssigneeText','Project Assignee: ') !!}
        {!! Form::text('projectAssigneeText',null,array('name'=>'projectAssigneeText')) !!}</p>
    <p>{!! Form::label('projectComplexityType','Project Complexity: ') !!}
        <select id="projectComplexityType" name="projectComplexityType">
            <option value="adv">Advanced</option>
            <option value="gen">Basic</option>
        </select></p>
    <p>{!! Form::label('projectTargetType','Project Target: ') !!}
        <select id="projectTargetType" name="projectTargetType">
            <option value="T">Targeted</option>
            <option value="G">Generic</option>
        </select></p>
    {!! Form::submit('Submit',array('id'=>'submitButton')) !!}
    {!! Form::close() !!}
@stop